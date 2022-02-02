<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131003010 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agent_activity CHANGE agent_name agent_name VARCHAR(255) DEFAULT NULL, CHANGE customer_name customer_name VARCHAR(255) DEFAULT NULL, CHANGE thread_type thread_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE announcement CHANGE tag_color tag_color VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE recaptcha CHANGE site_key site_key VARCHAR(255) DEFAULT NULL, CHANGE secret_key secret_key VARCHAR(255) DEFAULT NULL, CHANGE is_active is_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_article CHANGE slug slug VARCHAR(255) DEFAULT NULL, CHANGE keywords keywords VARCHAR(255) DEFAULT NULL, CHANGE viewed viewed INT DEFAULT NULL, CHANGE stared stared INT DEFAULT NULL, CHANGE meta_title meta_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_article_feedback CHANGE article_id article_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_article_view_log CHANGE user_id user_id INT DEFAULT NULL, CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_email_templates CHANGE user_id user_id INT DEFAULT NULL, CHANGE template_type template_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_prepared_responses CHANGE user_id user_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT \'public\'');
        $this->addSql('ALTER TABLE uv_saved_filters CHANGE user_id user_id INT DEFAULT NULL, CHANGE route route VARCHAR(190) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_saved_replies CHANGE user_id user_id INT DEFAULT NULL, CHANGE subject subject VARCHAR(255) DEFAULT NULL, CHANGE template_id template_id INT DEFAULT NULL, CHANGE template_for template_for VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_solution_category CHANGE description description VARCHAR(100) DEFAULT NULL, CHANGE sorting sorting VARCHAR(255) DEFAULT \'ascending\'');
        $this->addSql('ALTER TABLE uv_solutions CHANGE solution_image solution_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_support_label CHANGE user_id user_id INT DEFAULT NULL, CHANGE color_code color_code VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_support_privilege CHANGE privileges privileges LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_support_role CHANGE description description VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_thread CHANGE ticket_id ticket_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE cc cc LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE bcc bcc LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE reply_to reply_to LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE delivery_status delivery_status VARCHAR(255) DEFAULT NULL, CHANGE agent_viewed_at agent_viewed_at DATETIME DEFAULT NULL, CHANGE customer_viewed_at customer_viewed_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket CHANGE status_id status_id INT DEFAULT NULL, CHANGE priority_id priority_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE agent_id agent_id INT DEFAULT NULL, CHANGE group_id group_id INT DEFAULT NULL, CHANGE mailbox_email mailbox_email VARCHAR(191) DEFAULT NULL, CHANGE subGroup_id subGroup_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7D6BF700BD FOREIGN KEY (status_id) REFERENCES uv_ticket_status (id)');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7D497B19F9 FOREIGN KEY (priority_id) REFERENCES uv_ticket_priority (id)');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7DC54C8C93 FOREIGN KEY (type_id) REFERENCES uv_ticket_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7D9395C3F3 FOREIGN KEY (customer_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7D3414710B FOREIGN KEY (agent_id) REFERENCES uv_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7DFE54D947 FOREIGN KEY (group_id) REFERENCES uv_support_group (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7DCB20698 FOREIGN KEY (subGroup_id) REFERENCES uv_support_team (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE uv_tickets_collaborators ADD CONSTRAINT FK_20764CBA700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_tickets_collaborators ADD CONSTRAINT FK_20764CBAA76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_tickets_tags ADD CONSTRAINT FK_CF4DF9E3700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_tickets_tags ADD CONSTRAINT FK_CF4DF9E3BAD26311 FOREIGN KEY (tag_id) REFERENCES uv_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_tickets_labels ADD CONSTRAINT FK_305F9C0E700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_tickets_labels ADD CONSTRAINT FK_305F9C0E33B92F39 FOREIGN KEY (label_id) REFERENCES uv_support_label (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_ticket_attachments CHANGE thread_id thread_id INT DEFAULT NULL, CHANGE content_type content_type VARCHAR(255) DEFAULT NULL, CHANGE size size INT DEFAULT NULL, CHANGE content_id content_id VARCHAR(255) DEFAULT NULL, CHANGE file_system file_system VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_attachments ADD CONSTRAINT FK_FE918C8EE2904019 FOREIGN KEY (thread_id) REFERENCES uv_thread (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_ticket_priority CHANGE color_code color_code VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_rating CHANGE ticket_id ticket_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_rating ADD CONSTRAINT FK_B1025E04700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_ticket_rating ADD CONSTRAINT FK_B1025E04A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_ticket_status CHANGE color_code color_code VARCHAR(191) DEFAULT NULL, CHANGE sort_order sort_order INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_user CHANGE email email VARCHAR(191) DEFAULT NULL, CHANGE proxy_id proxy_id VARCHAR(191) DEFAULT NULL, CHANGE password password VARCHAR(191) DEFAULT NULL, CHANGE last_name last_name VARCHAR(191) DEFAULT NULL, CHANGE programme programme VARCHAR(191) DEFAULT NULL, CHANGE faculty faculty VARCHAR(191) DEFAULT NULL, CHANGE department department VARCHAR(191) DEFAULT NULL, CHANGE matric_number matric_number VARCHAR(191) DEFAULT NULL, CHANGE verification_code verification_code VARCHAR(191) DEFAULT NULL, CHANGE timezone timezone VARCHAR(191) DEFAULT NULL, CHANGE timeformat timeformat VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_user_instance CHANGE user_id user_id INT DEFAULT NULL, CHANGE skype_id skype_id VARCHAR(191) DEFAULT NULL, CHANGE contact_number contact_number VARCHAR(191) DEFAULT NULL, CHANGE designation designation VARCHAR(191) DEFAULT NULL, CHANGE ticket_access_level ticket_access_level VARCHAR(32) DEFAULT NULL, CHANGE supportRole_id supportRole_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_user_instance ADD CONSTRAINT FK_B1744733A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_instance ADD CONSTRAINT FK_B174473368771C43 FOREIGN KEY (supportRole_id) REFERENCES uv_support_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_privileges ADD CONSTRAINT FK_9550EDB28B414560 FOREIGN KEY (userInstanceId) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_privileges ADD CONSTRAINT FK_9550EDB289C60B89 FOREIGN KEY (supportPrivilegeId) REFERENCES uv_support_privilege (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_teams ADD CONSTRAINT FK_5F33E9F78B414560 FOREIGN KEY (userInstanceId) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_teams ADD CONSTRAINT FK_5F33E9F7A77C7023 FOREIGN KEY (supportTeamId) REFERENCES uv_support_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_groups ADD CONSTRAINT FK_B6CD76C28B414560 FOREIGN KEY (userInstanceId) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_groups ADD CONSTRAINT FK_B6CD76C253F5B65F FOREIGN KEY (supportGroupId) REFERENCES uv_support_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_website CHANGE logo logo VARCHAR(191) DEFAULT NULL, CHANGE favicon favicon VARCHAR(191) DEFAULT NULL, CHANGE timezone timezone VARCHAR(191) DEFAULT NULL, CHANGE timeformat timeformat VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_website_knowledgebase CHANGE website website INT DEFAULT NULL, CHANGE header_background_color header_background_color VARCHAR(255) DEFAULT NULL, CHANGE link_color link_color VARCHAR(255) DEFAULT NULL, CHANGE article_text_color article_text_color VARCHAR(255) DEFAULT NULL, CHANGE site_description site_description VARCHAR(1000) DEFAULT NULL, CHANGE homepage_content homepage_content VARCHAR(255) DEFAULT NULL, CHANGE header_links header_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE footer_links footer_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE banner_background_color banner_background_color VARCHAR(255) DEFAULT NULL, CHANGE link_hover_color link_hover_color VARCHAR(255) DEFAULT NULL, CHANGE login_required_to_create login_required_to_create TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_website_knowledgebase ADD CONSTRAINT FK_DFF10F0B476F5DE7 FOREIGN KEY (website) REFERENCES uv_website (id)');
        $this->addSql('ALTER TABLE uv_workflow CHANGE sort_order sort_order INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_workflow_events CHANGE workflow_id workflow_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_workflow_events ADD CONSTRAINT FK_6AEB02A92C7C2CBA FOREIGN KEY (workflow_id) REFERENCES uv_workflow (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agent_activity CHANGE agent_name agent_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE customer_name customer_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE thread_type thread_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE announcement CHANGE tag_color tag_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE recaptcha CHANGE site_key site_key VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE secret_key secret_key VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE is_active is_active TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE uv_article CHANGE slug slug VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE keywords keywords VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE viewed viewed INT DEFAULT NULL, CHANGE stared stared INT DEFAULT NULL, CHANGE meta_title meta_title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_article_feedback CHANGE article_id article_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_article_view_log CHANGE user_id user_id INT DEFAULT NULL, CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_email_templates CHANGE user_id user_id INT DEFAULT NULL, CHANGE template_type template_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_prepared_responses CHANGE user_id user_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'public\'\'\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_saved_filters CHANGE user_id user_id INT DEFAULT NULL, CHANGE route route VARCHAR(190) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_saved_replies CHANGE user_id user_id INT DEFAULT NULL, CHANGE subject subject VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE template_id template_id INT DEFAULT NULL, CHANGE template_for template_for VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_solution_category CHANGE description description VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE sorting sorting VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'ascending\'\'\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_solutions CHANGE solution_image solution_image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_support_label CHANGE user_id user_id INT DEFAULT NULL, CHANGE color_code color_code VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_support_privilege CHANGE privileges privileges LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE uv_support_role CHANGE description description VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_thread CHANGE ticket_id ticket_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE cc cc LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE bcc bcc LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE reply_to reply_to LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE delivery_status delivery_status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE agent_viewed_at agent_viewed_at DATETIME DEFAULT \'NULL\', CHANGE customer_viewed_at customer_viewed_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7D6BF700BD');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7D497B19F9');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7DC54C8C93');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7D9395C3F3');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7D3414710B');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7DFE54D947');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7DCB20698');
        $this->addSql('ALTER TABLE uv_ticket CHANGE status_id status_id INT DEFAULT NULL, CHANGE priority_id priority_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE agent_id agent_id INT DEFAULT NULL, CHANGE group_id group_id INT DEFAULT NULL, CHANGE mailbox_email mailbox_email VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE subGroup_id subGroup_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_attachments DROP FOREIGN KEY FK_FE918C8EE2904019');
        $this->addSql('ALTER TABLE uv_ticket_attachments CHANGE thread_id thread_id INT DEFAULT NULL, CHANGE content_type content_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE size size INT DEFAULT NULL, CHANGE content_id content_id VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE file_system file_system VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_ticket_priority CHANGE color_code color_code VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_ticket_rating DROP FOREIGN KEY FK_B1025E04700047D2');
        $this->addSql('ALTER TABLE uv_ticket_rating DROP FOREIGN KEY FK_B1025E04A76ED395');
        $this->addSql('ALTER TABLE uv_ticket_rating CHANGE ticket_id ticket_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_status CHANGE color_code color_code VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE sort_order sort_order INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_tickets_collaborators DROP FOREIGN KEY FK_20764CBA700047D2');
        $this->addSql('ALTER TABLE uv_tickets_collaborators DROP FOREIGN KEY FK_20764CBAA76ED395');
        $this->addSql('ALTER TABLE uv_tickets_labels DROP FOREIGN KEY FK_305F9C0E700047D2');
        $this->addSql('ALTER TABLE uv_tickets_labels DROP FOREIGN KEY FK_305F9C0E33B92F39');
        $this->addSql('ALTER TABLE uv_tickets_tags DROP FOREIGN KEY FK_CF4DF9E3700047D2');
        $this->addSql('ALTER TABLE uv_tickets_tags DROP FOREIGN KEY FK_CF4DF9E3BAD26311');
        $this->addSql('ALTER TABLE uv_user CHANGE email email VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE proxy_id proxy_id VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE programme programme VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE faculty faculty VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE department department VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE matric_number matric_number VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE verification_code verification_code VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE timezone timezone VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE timeformat timeformat VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_user_instance DROP FOREIGN KEY FK_B1744733A76ED395');
        $this->addSql('ALTER TABLE uv_user_instance DROP FOREIGN KEY FK_B174473368771C43');
        $this->addSql('ALTER TABLE uv_user_instance CHANGE user_id user_id INT DEFAULT NULL, CHANGE skype_id skype_id VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE contact_number contact_number VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE designation designation VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE ticket_access_level ticket_access_level VARCHAR(32) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE supportRole_id supportRole_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_user_support_groups DROP FOREIGN KEY FK_B6CD76C28B414560');
        $this->addSql('ALTER TABLE uv_user_support_groups DROP FOREIGN KEY FK_B6CD76C253F5B65F');
        $this->addSql('ALTER TABLE uv_user_support_privileges DROP FOREIGN KEY FK_9550EDB28B414560');
        $this->addSql('ALTER TABLE uv_user_support_privileges DROP FOREIGN KEY FK_9550EDB289C60B89');
        $this->addSql('ALTER TABLE uv_user_support_teams DROP FOREIGN KEY FK_5F33E9F78B414560');
        $this->addSql('ALTER TABLE uv_user_support_teams DROP FOREIGN KEY FK_5F33E9F7A77C7023');
        $this->addSql('ALTER TABLE uv_website CHANGE logo logo VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE favicon favicon VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE timezone timezone VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE timeformat timeformat VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_website_knowledgebase DROP FOREIGN KEY FK_DFF10F0B476F5DE7');
        $this->addSql('ALTER TABLE uv_website_knowledgebase CHANGE website website INT DEFAULT NULL, CHANGE header_background_color header_background_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE link_color link_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE article_text_color article_text_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE site_description site_description VARCHAR(1000) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE homepage_content homepage_content VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE header_links header_links LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE footer_links footer_links LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE banner_background_color banner_background_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE link_hover_color link_hover_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE login_required_to_create login_required_to_create TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE uv_workflow CHANGE sort_order sort_order INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_workflow_events DROP FOREIGN KEY FK_6AEB02A92C7C2CBA');
        $this->addSql('ALTER TABLE uv_workflow_events CHANGE workflow_id workflow_id INT DEFAULT NULL');
    }
}
