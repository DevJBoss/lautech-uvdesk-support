<?php

namespace Webkul\UVDesk\ApiBundle\API;

use Webkul\TicketBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Agents extends Controller
{
    /**
     * Return agents.
     *
     * @param Request $request
     */
    public function fetchAgents(Request $request)
    {
        $json = [];
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository('UVDeskCoreFrameworkBundle:User');

        if ($request->query->get('actAsType')) {    
            switch($request->query->get('actAsType')) {
                case 'agent':
                    $email = $request->query->get('actAsEmail');
                    $user = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneByEmail($email);
                    
                    if ($user) {
                        $request->query->set('agent', $user->getId());
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

        $json = $userRepository->getAllAgents($request->query, $this->container);

        return new JsonResponse($json);
    }
}
