<?php

namespace Webkul\UVDesk\ApiBundle\API;

use Webkul\TicketBundle\Entity\Ticket;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\GenericEvent;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class Customers extends Controller
{
    private const CUSTOMER_ROLE = 4;

    // protected $container;

    protected $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Return customers.
     *
     * @param Request $request
     */
    public function fetchCustomers(Request $request)
    {
        $json = [];
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository('UVDeskCoreFrameworkBundle:User');

        if ($request->query->get('actAsType')) {
            switch ($request->query->get('actAsType')) {
                case 'customer':
                    $email = $request->query->get('actAsEmail');
                    $user = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneByEmail($email);

                    if ($user) {
                        $request->query->set('customer', $user->getId());
                    } else {
                        $json['error'] = $this->get('translator')->trans('Error! Resource not found.');
                        return new JsonResponse($json, Response::HTTP_NOT_FOUND);
                    }
                    break;
                default:
                    $json['error'] = $this->get('translator')->trans('Error! invalid actAs details.');
                    return new JsonResponse($json, Response::HTTP_BAD_REQUEST);
            }
        }

        $json = $userRepository->getAllCustomer($request->query, $this->container);

        return new JsonResponse($json);
    }

    /**
     * Fetch customers by email.
     *
     * @param Request $request
     */
    public function fetchCustomerByEmail(Request $request)
    {
        $email = $request->query->get('email');
        $userRepository = $this->getDoctrine()->getRepository('UVDeskCoreFrameworkBundle:User');
        $json = $userRepository->getCustomerByEmail($email);

        return new JsonResponse($json, 200, [], false);
    }

    /**
     * Register new customer
     * 
     * @param Request $request
     */
    public function registerCustomer(Request $request)
    {
        // Set request customer data
        $data = $request->request->all() ?: json_decode($request->getContent(), true);
        $firstName = $data['first_name'];
        $lastName = $data['last_name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $programme = $data['programme'];
        $faculty = $data['faculty'];
        $department = $data['department'];
        $isActive = 1;
        $matricNumber = $data['matric_number'];
        $role = Customers::CUSTOMER_ROLE;

        // Request ticket data
        $type = $data['type'];
        $subject = $data['subject'];
        $message = $data['message'];
        $attachments = $request->files->get('attachments');
        $threadType = 'create';
        $source = 'api';

        $entityManager = $this->getDoctrine()->getManager();

        $customer = null;
        $customer = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneByEmail($email);
        if (!$customer) {
            $user = new User();
            $user->setEmail($email);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setProgramme($programme ?? null);
            $user->setFaculty($faculty ?? null);
            $user->setDepartment($department ?? null);
            $user->setMatricNumber($matricNumber ?? null);

            $user->setIsEnabled($isActive);
            $entityManager->persist($user);
            $role = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportRole')->find($role);
            $encodedPassword = $this->passwordEncoder->encodePassword($user, \strtoupper($lastName));
            $user->setPassword($encodedPassword);
            $userInstance = new UserInstance();
            $userInstance->setSupportRole($role);
            $userInstance->setUser($user);
            $userInstance->setIsActive($isActive);
            $userInstance->setIsVerified(0);
            $userInstance->setSource('api');
            if (isset($phone)) {
                $userInstance->setContactNumber($phone);
            }
            $entityManager->persist($userInstance);
            $entityManager->flush();

            $user->addUserInstance($userInstance);
            $entityManager->persist($user);
            $entityManager->flush();

            $customer = $user;
        }

        if (!empty($attachments)) {
            $attachments = is_array($attachments) ? $attachments : [$attachments];
        }

        // Set ticket data
        $ticketData['type'] = $type;
        $ticketData['subject'] = $subject;
        $ticketData['message'] = $message;
        $ticketData['attachments'] = $attachments;
        $ticketData['threadType'] = $threadType;
        $ticketData['source'] = $source;
        $ticketData['customer'] = $customer;
        $ticketData['user'] = $customer;
        $ticketData['createdBy'] = 'customer';

        $extraKeys = ['tags', 'group', 'priority', 'status', 'agent', 'createdAt', 'updatedAt'];

        if (array_key_exists('type', $data)) {
            $ticketType = $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketType')->findOneByCode($data['type']);
            $ticketData['type'] = $ticketType;
        }

        foreach ($extraKeys as $key) {
            if (isset($ticketData[$key])) {
                unset($ticketData[$key]);
            }
        }

        $thread = $this->get('ticket.service')->createTicketBase($ticketData);
        // Trigger ticket created event
        try {
            $event = new GenericEvent(CoreWorkflowEvents\Ticket\Create::getId(), [
                'entity' =>  $thread->getTicket(),
            ]);
            $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);
        } catch (\Exception $e) {
            //
        }

        $json['message'] = $this->get('translator')->trans('Success ! Ticket has been created successfully.');
        $json['ticketId'] = $thread->getTicket()->getId();

        return new JsonResponse($json, Response::HTTP_CREATED);
    }

    public function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    public function authenticateCutomer(Request $request)
    {
    }
}
