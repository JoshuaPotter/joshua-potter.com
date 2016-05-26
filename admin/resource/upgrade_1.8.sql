INSERT IGNORE `fx_config` (`config_key`, `value`) VALUES
('billing_email',''),
('billing_email_name',''),
('support_email',''),
('support_email_name',''),
('disable_emails', 'FALSE'),
('show_time_ago','TRUE'),
('use_alternate_emails','FALSE'),
('notify_project_opened','TRUE'),
('notify_bug_reporter','TRUE'),
('notify_task_created','TRUE'),
('notify_ticket_reply','TRUE'),
('notify_ticket_closed','TRUE'),
('notify_ticket_reopened', 'TRUE'),
('estimate_start_no','1'),
('ticket_start_no','1'),
('ticket_default_department','1'),
('notify_task_comments','TRUE'),
('bitcoin_api_key', ''),
('braintee_live', 'TRUE'),
('braintree_merchant_id', ''),
('braintree_private_key', ''),
('braintree_public_key', ''),
('estimate_to_project', 'FALSE'),
('hourly_rate', '0.00'),
('stop_timer_logout', 'FALSE'),
('mail_flags', '/novalidate-cert'),
('mail_imap', 'TRUE'),
('mail_port', '993'),
('mail_ssl', 'TRUE'),
('mail_search', 'UNSEEN'),
('smtp_encryption', ''),
('mailbox', 'INBOX'),
('xrates_app_id', '');



DROP TABLE `fx_un_sessions`;

CREATE TABLE `fx_un_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_expenses'
        AND table_schema = DATABASE()
        AND column_name = 'show_client'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_expenses ADD `show_client` ENUM('Yes','No')  NULL  DEFAULT 'Yes'  AFTER `invoiced_id`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_invoices'
        AND table_schema = DATABASE()
        AND column_name = 'extra_fee'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_invoices ADD `extra_fee` DECIMAL(10,2)  NULL  DEFAULT '0.00'  AFTER `alert_overdue`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_invoices'
        AND table_schema = DATABASE()
        AND column_name = 'allow_braintree'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_invoices ADD `allow_braintree` ENUM('Yes','No')  NULL  DEFAULT 'Yes'  AFTER `allow_paypal`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_invoices'
        AND table_schema = DATABASE()
        AND column_name = 'braintree_merchant_ac'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_invoices ADD `braintree_merchant_ac` VARCHAR(150)  NULL  DEFAULT NULL  AFTER `allow_braintree`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_payments'
        AND table_schema = DATABASE()
        AND column_name = 'refunded'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_payments ADD `refunded` ENUM('Yes','No')  NULL  DEFAULT 'No'  AFTER `inv_deleted`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_tasks'
        AND table_schema = DATABASE()
        AND column_name = 'start_date'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_tasks ADD `start_date` VARCHAR(32)  NULL  DEFAULT NULL  AFTER `auto_progress`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_comments'
        AND table_schema = DATABASE()
        AND column_name = 'task_id'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_comments ADD `task_id` INT  NULL  DEFAULT NULL  AFTER `project`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
 
ALTER TABLE `fx_tickets` ADD UNIQUE INDEX (`ticket_code`);
INSERT INTO `fx_permissions` (`permission_id`, `name`, `description`, `status`) VALUES (NULL, 'view_all_payments', 'Allow staff to view all payments', 'active');
INSERT INTO `fx_permissions` (`permission_id`, `name`, `description`, `status`) VALUES (NULL, 'edit_payments', 'Allow staff to edit payments', 'active');
ALTER TABLE `fx_account_details` CHANGE `avatar` `avatar` MEDIUMTEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;


ALTER TABLE `fx_bugs` CHANGE `bug_status` `bug_status` ENUM('Unconfirmed','Confirmed','Pending','Resolved','Verified')  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT 'Pending';
UPDATE `fx_bugs` SET `bug_status` = 'Pending' WHERE `bug_status` = '';


ALTER TABLE `fx_bug_comments` CHANGE `comment` `comment` LONGTEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;

INSERT INTO `fx_priorities` (`priority`) VALUES ('Urgent');

UPDATE `fx_tickets` SET `status` = 'pending' WHERE `status` = 'in progress';
UPDATE `fx_tickets` SET `status` = 'pending' WHERE `status` = 'answered';

ALTER TABLE `fx_payments` CHANGE `amount` `amount` DECIMAL(10,2)  NULL  DEFAULT '0.00';
ALTER TABLE `fx_estimates` CHANGE `discount` `discount` DECIMAL(10,2)  NOT NULL  DEFAULT '0.00';
ALTER TABLE `fx_estimates` CHANGE `tax` `tax` DECIMAL(10,2)  NOT NULL  DEFAULT '0.00';



CREATE TABLE IF NOT EXISTS `fx_todo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project` int(11) DEFAULT NULL,
  `list_name` varchar(255) DEFAULT NULL,
  `status` enum('pending','done') DEFAULT 'pending',
  `saved_by` int(11) DEFAULT NULL,
  `visible` enum('Yes','No') DEFAULT 'No',
  `date_saved` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT IGNORE INTO `fx_email_templates` (`email_group`, `subject`, `template_body`)
VALUES
  ('project_created', 'Project Created', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"backgroundTable\">\n  <tbody>\n   <tr>\n      <td valign=\"top\">     <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n       <tbody>\n         <tr>\n            <td height=\"50\" width=\"600\">&nbsp;</td>\n         </tr>\n         <tr>\n            <td height=\"90\" style=\"color:#999999\" width=\"600\">{INVOICE_LOGO}</td>\n         </tr>\n         <tr>\n            <td bgcolor=\"whitesmoke\" height=\"200\" style=\"background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif\" valign=\"top\" width=\"600\">           <table align=\"center\" style=\"margin-left:15px;\">\n              <tbody>\n               <tr>\n                  <td height=\"10\" width=\"560\">&nbsp;</td>\n               </tr>\n               <tr>\n                  <td width=\"560\">                  <h4>Project Updated</h4>\n                  <p style=\"font-size:12px; font-family:Helvetica,Arial,sans-serif\">Hi {CREATOR},</p>\n               <p style=\"font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif\">      <strong>{PROJECT_TITLE}</strong> has been opened. You can view this project by logging in to the portal using the link below:<br><a href=\"{PROJECT_URL}\" style=\"color: #11A7DB; text-decoration: none;\"><strong>View Dashboard</strong></a><br><br><br>                 Best Regards,                 <br>                                    {SITE_NAME}</p>\n                 </td>\n               </tr>\n               <tr>\n                  <td height=\"10\" width=\"560\">&nbsp;</td>\n               </tr>\n             </tbody>\n            </table>\n            </td>\n         </tr>\n         <tr>\n            <td height=\"10\" width=\"600\">&nbsp;</td>\n         </tr>\n         <tr>\n            <td align=\"right\"><span style=\"font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif\">{SIGNATURE}</span></td>\n         </tr>\n       </tbody>\n      </table>\n      </td>\n   </tr>\n </tbody>\n</table>');

INSERT IGNORE INTO `fx_email_templates` (`email_group`, `subject`, `template_body`)
VALUES
  ('task_created', 'Task Created', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"backgroundTable\">\n  <tbody>\n   <tr>\n      <td valign=\"top\">     <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n       <tbody>\n         <tr>\n            <td height=\"50\" width=\"600\">&nbsp;</td>\n         </tr>\n         <tr>\n            <td height=\"90\" style=\"color:#999999\" width=\"600\">{INVOICE_LOGO}</td>\n         </tr>\n         <tr>\n            <td bgcolor=\"whitesmoke\" height=\"200\" style=\"background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif\" valign=\"top\" width=\"600\">           <table align=\"center\" style=\"margin-left:15px;\">\n              <tbody>\n               <tr>\n                  <td height=\"10\" width=\"560\">&nbsp;</td>\n               </tr>\n               <tr>\n                  <td width=\"560\">                  <h4>Project Opened</h4>\n                 <p style=\"font-size:12px; font-family:Helvetica,Arial,sans-serif\">Hi {CREATOR},</p>\n               <p style=\"font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif\">      <strong>{PROJECT_TITLE}</strong> has been opened. You can view this project by logging in to the portal using the link below:<br><a href=\"{PROJECT_URL}\" style=\"color: #11A7DB; text-decoration: none;\"><strong>View Dashboard</strong></a><br><br><br>                 Best Regards,                 <br>                                    {SITE_NAME}</p>\n                 </td>\n               </tr>\n               <tr>\n                  <td height=\"10\" width=\"560\">&nbsp;</td>\n               </tr>\n             </tbody>\n            </table>\n            </td>\n         </tr>\n         <tr>\n            <td height=\"10\" width=\"600\">&nbsp;</td>\n         </tr>\n         <tr>\n            <td align=\"right\"><span style=\"font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif\">{SIGNATURE}</span></td>\n         </tr>\n       </tbody>\n      </table>\n      </td>\n   </tr>\n </tbody>\n</table>');

INSERT INTO `fx_email_templates` (`email_group`, `subject`, `template_body`)
VALUES
  ('task_comment', 'Task Comment', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"backgroundTable\">\r\n  <tbody>\r\n   <tr>\r\n      <td valign=\"top\">     <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n       <tbody>\r\n         <tr>\r\n            <td height=\"50\" width=\"600\">&nbsp;</td>\r\n         </tr>\r\n         <tr>\r\n            <td height=\"90\" style=\"color:#999999\" width=\"600\">{INVOICE_LOGO}</td>\r\n         </tr>\r\n         <tr>\r\n            <td bgcolor=\"whitesmoke\" height=\"200\" style=\"background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif\" valign=\"top\" width=\"600\">           <table align=\"center\" style=\"margin-left:15px;\">\r\n              <tbody>\r\n               <tr>\r\n                  <td height=\"10\" width=\"560\">&nbsp;</td>\r\n               </tr>\r\n               <tr>\r\n                  <td width=\"560\">                  <h4>New comment received</h4>\r\n                 <p style=\"font-size:12px; font-family:Helvetica,Arial,sans-serif\">Hello,</p>\r\n                <p style=\"font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif\">      A new comment has been posted by <strong>{POSTED_BY}</strong> to task&nbsp;<strong>{TASK_NAME}</strong>.You can view the comment using the link below:<br><a href=\"{COMMENT_URL}\" style=\"color: #11A7DB; text-decoration: none;\"><strong>View Dashboard</strong></a><br><br><span style=\"font-style:italic;\">{COMMENT_MESSAGE}</span><br><br>                 Best Regards,                 <br>                                    {SITE_NAME}</p>\r\n                 </td>\r\n               </tr>\r\n               <tr>\r\n                  <td height=\"10\" width=\"560\">&nbsp;</td>\r\n               </tr>\r\n             </tbody>\r\n            </table>\r\n            </td>\r\n         </tr>\r\n         <tr>\r\n            <td height=\"10\" width=\"600\">&nbsp;</td>\r\n         </tr>\r\n         <tr>\r\n            <td align=\"right\"><span style=\"font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif\">{SIGNATURE}</span></td>\r\n         </tr>\r\n       </tbody>\r\n      </table>\r\n      </td>\r\n   </tr>\r\n </tbody>\r\n</table>');




INSERT INTO `fx_email_templates` (`email_group`, `subject`, `template_body`)
VALUES
  ('ticket_reopened_email', 'Ticket [SUBJECT] reopened', '                                                            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"backgroundTable\">\r\n  <tbody>\r\n   <tr>\r\n      <td valign=\"top\">     <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n       <tbody>\r\n         <tr>\r\n            <td height=\"50\" width=\"600\">&nbsp;</td>\r\n         </tr>\r\n         <tr>\r\n            <td height=\"90\" style=\"color:#999999\" width=\"600\">{INVOICE_LOGO}</td>\r\n         </tr>\r\n         <tr>\r\n            <td bgcolor=\"whitesmoke\" height=\"200\" style=\"background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif\" valign=\"top\" width=\"600\">           <table align=\"center\" style=\"margin-left:15px;\">\r\n              <tbody>\r\n               <tr>\r\n                  <td height=\"10\" width=\"560\">&nbsp;</td>\r\n               </tr>\r\n               <tr>\r\n                  <td width=\"560\">                  <h4>Ticket re-opened</h4>\r\n                 <p style=\"font-size:12px; font-family:Helvetica,Arial,sans-serif\">Hi {RECIPIENT},</p>\r\n               <p style=\"font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif\">      Ticket <b>{SUBJECT}</b> was re-opened by <b>{USER}</b>.<br>Status : Open<br>Click on the below link to see the ticket details and post replies: <br><a href=\"{TICKET_LINK}\" style=\"color: #11A7DB; text-decoration: none;\"><strong>View Ticket</strong></a><br><br><br>                 Best Regards,                 <br>                                    {SITE_NAME}</p>\r\n                 </td>\r\n               </tr>\r\n               <tr>\r\n                  <td height=\"10\" width=\"560\">&nbsp;</td>\r\n               </tr>\r\n             </tbody>\r\n            </table>\r\n            </td>\r\n         </tr>\r\n         <tr>\r\n            <td height=\"10\" width=\"600\">&nbsp;</td>\r\n         </tr>\r\n         <tr>\r\n            <td align=\"right\"><span style=\"font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif\">{SIGNATURE}</span></td>\r\n         </tr>\r\n       </tbody>\r\n      </table>\r\n      </td>\r\n   </tr>\r\n </tbody>\r\n</table>');


CREATE TABLE IF NOT EXISTS `fx_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `description` longtext CHARACTER SET latin1,
  `date` bigint(13) DEFAULT '0',
  `owner` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `fx_hooks` (
  `module` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `parent` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hook` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `icon` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `access` int(2) NOT NULL,
  `core` int(2) DEFAULT NULL,
  `visible` int(2) DEFAULT '1',
  `permission` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` int(2) NOT NULL DEFAULT '1',
  `last_run` datetime DEFAULT NULL,
  PRIMARY KEY (`module`,`hook`,`access`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT IGNORE INTO `fx_hooks` (`module`, `parent`, `hook`, `icon`, `name`, `route`, `order`, `access`, `core`, `visible`, `permission`, `enabled`, `last_run`)
VALUES
  ('cron_backup_db', '', 'cron_job_admin', 'fa-database', 'auto_backup_database', 'crons/backup_db', 7, 1, 1, 1, '', 1, '2016-03-09 22:23:24'),
  ('cron_close_tickets', '', 'cron_job_admin', 'fa-ticket', 'auto_close_tickets', 'crons/close_tickets', 5, 1, 1, 1, '', 1, '2016-03-09 22:23:23'),
  ('cron_fetch_tickets', '', 'cron_job_admin', 'fa-ticket', 'fetch_ticket_emails', 'crons/fetch_tickets', 6, 1, 1, 1, '', 1, '2016-03-09 22:23:23'),
  ('cron_invoices', '', 'cron_job_admin', 'fa-clock-o', 'overdue_invoices', 'crons/invoices', 3, 1, 1, 1, '', 1, '2016-03-09 22:23:23'),
  ('cron_outgoing', '', 'cron_job_admin', 'fa-envelope-o', 'pending_emails', 'crons/outgoing_emails', 4, 1, 1, 1, '', 1, '2016-03-09 22:23:23'),
  ('cron_projects', '', 'cron_job_admin', 'fa-clock-o', 'overdue_projects', 'crons/projects', 2, 1, 1, 1, '', 1, '2016-03-09 22:23:23'),
  ('cron_recurring', '', 'cron_job_admin', 'fa-retweet', 'recurring_invoices', 'crons/recur', 1, 1, 1, 1, '', 1, '2016-03-09 22:23:23'),
  ('cron_xrates', '', 'cron_job_admin', 'fa-money', 'open_exchange_rates', 'crons/xrates', 8, 1, 1, 1, '', 1, '2016-03-09 22:23:24'),
  ('cron_xrates_settings', 'cron_xrates', 'cron_job_settings', '', 'open_exchange_rates', 'settings/xrates', 9, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_calendar', '', 'main_menu_admin', 'fa-calendar', 'calendar', 'calendar', 2, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_clients', '', 'main_menu_admin', 'fa-group', 'clients', 'companies', 3, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_estimates', 'menu_sales', 'main_menu_admin', 'fa-angle-right', 'estimates', 'estimates', 2, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_estimates', '', 'main_menu_client', 'fa-list-alt', 'estimates', 'estimates', 5, 2, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_estimates', '', 'main_menu_staff', 'fa-list-alt', 'estimates', 'estimates', 5, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_expenses', 'menu_sales', 'main_menu_admin', 'fa-angle-right', 'expenses', 'expenses', 3, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_expenses', '', 'main_menu_client', 'fa-list-alt', 'expenses', 'expenses', 7, 2, 1, 1, 'show_project_cost', 1, '0000-00-00 00:00:00'),
  ('menu_expenses', '', 'main_menu_staff', 'fa-list-alt', 'expenses', 'expenses', 7, 3, 1, 1, 'view_project_expenses', 1, '0000-00-00 00:00:00'),
  ('menu_home', '', 'main_menu_admin', 'fa-tachometer', 'home', '', 1, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_home', '', 'main_menu_client', 'fa-dashboard', 'home', 'clients', 1, 2, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_home', '', 'main_menu_staff', 'fa-dashboard', 'home', 'collaborator', 1, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_invoices', 'menu_sales', 'main_menu_admin', 'fa-angle-right', 'invoices', 'invoices', 1, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_invoices', '', 'main_menu_client', 'fa-list', 'invoices', 'invoices', 4, 2, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_invoices', '', 'main_menu_staff', 'fa-list', 'invoices', 'invoices', 4, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_items', '', 'main_menu_admin', 'fa-list', 'items', 'items', 8, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_messages', '', 'main_menu_admin', 'fa-envelope', 'messages', 'messages', 6, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_messages', '', 'main_menu_client', 'fa-envelope-o', 'messages', 'messages', 3, 2, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_messages', '', 'main_menu_staff', 'fa-envelope-o', 'messages', 'messages', 3, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_notes', '', 'main_menu_admin', 'fa-sticky-note-o', 'notes', 'notebook', 11, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_notes', '', 'main_menu_client', 'fa-sticky-note-o', 'notes', 'notebook', 11, 2, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_notes', '', 'main_menu_staff', 'fa-sticky-note-o', 'notes', 'notebook', 11, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_payments', 'menu_sales', 'main_menu_admin', 'fa-angle-right', 'payments', 'payments', 3, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_payments', '', 'main_menu_client', 'fa-money', 'payments', 'payments', 6, 2, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_payments', '', 'main_menu_staff', 'fa-money', 'payments', 'payments', 6, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_projects', '', 'main_menu_admin', 'fa-coffee', 'projects', 'projects', 5, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_projects', '', 'main_menu_client', 'fa-coffee', 'projects', 'projects', 2, 2, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_projects', '', 'main_menu_staff', 'fa-coffee', 'projects', 'projects', 2, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_sales', '', 'main_menu_admin', 'fa-shopping-cart', 'sales', '#', 4, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_settings', '', 'main_menu_admin', 'fa-cogs', 'settings', 'settings', 9, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_tax_rates', 'menu_sales', 'main_menu_admin', 'fa-angle-right', 'tax_rates', 'invoices/tax_rates', 4, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_tickets', '', 'main_menu_admin', 'fa-ticket', 'tickets', 'tickets', 7, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_tickets', '', 'main_menu_client', 'fa-ticket', 'tickets', 'tickets', 8, 2, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_tickets', '', 'main_menu_staff', 'fa-ticket', 'tickets', 'tickets', 8, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('menu_users', '', 'main_menu_admin', 'fa-lock', 'users', 'users/account', 10, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_bugs', '', 'projects_menu_admin', 'fa-bug', 'project_bugs', 'bugs', 7, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_bugs', '', 'projects_menu_client', 'fa-bug', 'project_bugs', 'bugs', 7, 2, 1, 1, 'show_project_bugs', 1, '0000-00-00 00:00:00'),
  ('project_bugs', '', 'projects_menu_staff', 'fa-bug', 'project_bugs', 'bugs', 7, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_calendar', '', 'projects_menu_admin', 'fa-calendar', 'project_calendar', 'calendar', 3, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_calendar', '', 'projects_menu_client', 'fa-calendar', 'project_calendar', 'calendar', 3, 2, 1, 1, 'show_project_calendar', 1, '0000-00-00 00:00:00'),
  ('project_calendar', '', 'projects_menu_staff', 'fa-calendar', 'project_calendar', 'calendar', 3, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_comments', '', 'projects_menu_admin', 'fa-comments-o', 'project_comments', 'comments', 10, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_comments', '', 'projects_menu_client', 'fa-comments-o', 'project_comments', 'comments', 10, 2, 1, 1, 'show_project_comments', 1, '0000-00-00 00:00:00'),
  ('project_comments', '', 'projects_menu_staff', 'fa-comments-o', 'project_comments', 'comments', 10, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_dashboard', '', 'projects_menu_admin', 'fa-dashboard', 'project_dashboard', 'dashboard', 1, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_dashboard', '', 'projects_menu_client', 'fa-dashboard', 'project_dashboard', 'dashboard', 1, 2, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_dashboard', '', 'projects_menu_staff', 'fa-dashboard', 'project_dashboard', 'dashboard', 1, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_files', '', 'projects_menu_admin', 'fa-folder-open', 'project_files', 'files', 8, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_files', '', 'projects_menu_client', 'fa-folder-open', 'project_files', 'files', 8, 2, 1, 1, 'show_project_files', 1, '0000-00-00 00:00:00'),
  ('project_files', '', 'projects_menu_staff', 'fa-folder-open', 'project_files', 'files', 8, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_gantt', '', 'projects_menu_admin', 'fa-road', 'project_gantt', 'gantt', 2, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_gantt', '', 'projects_menu_client', 'fa-road', 'project_gantt', 'gantt', 2, 2, 1, 1, 'show_project_gantt', 1, '0000-00-00 00:00:00'),
  ('project_gantt', '', 'projects_menu_staff', 'fa-road', 'project_gantt', 'gantt', 2, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_links', '', 'projects_menu_admin', 'fa-globe', 'project_links', 'links', 9, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_links', '', 'projects_menu_client', 'fa-globe', 'project_links', 'links', 9, 2, 1, 1, 'show_project_links', 1, '0000-00-00 00:00:00'),
  ('project_links', '', 'projects_menu_staff', 'fa-globe', 'project_links', 'links', 9, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_milestones', '', 'projects_menu_admin', 'fa-rocket', 'milestones', 'milestones', 5, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_milestones', '', 'projects_menu_client', 'fa-rocket', 'milestones', 'milestones', 5, 2, 1, 1, 'show_milestones', 1, '0000-00-00 00:00:00'),
  ('project_milestones', '', 'projects_menu_staff', 'fa-rocket', 'milestones', 'milestones', 5, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_notes', '', 'projects_menu_admin', 'fa-pencil', 'project_notes', 'notes', 11, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_notes', '', 'projects_menu_client', 'fa-pencil', 'project_notes', 'notes', 11, 2, 1, 1, 'view_project_notes', 1, '0000-00-00 00:00:00'),
  ('project_notes', '', 'projects_menu_staff', 'fa-pencil', 'project_notes', 'notes', 11, 3, 1, 1, 'view_project_notes', 1, '0000-00-00 00:00:00'),
  ('project_settings', '', 'projects_menu_admin', 'fa-cog', 'project_settings', 'settings', 13, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_tasks', '', 'projects_menu_admin', 'fa-tasks', 'project_tasks', 'tasks', 6, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_tasks', '', 'projects_menu_client', 'fa-tasks', 'project_tasks', 'tasks', 6, 2, 1, 1, 'show_project_tasks', 1, '0000-00-00 00:00:00'),
  ('project_tasks', '', 'projects_menu_staff', 'fa-tasks', 'project_tasks', 'tasks', 6, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_team_members', '', 'projects_menu_admin', 'fa-group', 'team_members', 'teams', 4, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_team_members', '', 'projects_menu_client', 'fa-group', 'team_members', 'teams', 4, 2, 1, 1, 'show_team_members', 1, '0000-00-00 00:00:00'),
  ('project_team_members', '', 'projects_menu_staff', 'fa-group', 'team_members', 'teams', 4, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_timesheets', '', 'projects_menu_admin', 'fa-clock-o', 'timesheets', 'timesheets', 12, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('project_timesheets', '', 'projects_menu_client', 'fa-clock-o', 'timesheets', 'timesheets', 12, 2, 1, 1, 'show_timesheets', 1, '0000-00-00 00:00:00'),
  ('project_timesheets', '', 'projects_menu_staff', 'fa-clock-o', 'timesheets', 'timesheets', 12, 3, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_cron', '', 'settings_menu_admin', 'fa-rocket', 'cron_settings', 'crons', 13, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_custom_fields', '', 'settings_menu_admin', 'fa-star-o', 'custom_fields', 'fields', 11, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_departments', '', 'settings_menu_admin', 'fa-sitemap', 'departments', 'departments', 9, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_email', '', 'settings_menu_admin', 'fa-envelope-o', 'email_settings', 'email', 3, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_email_templates', '', 'settings_menu_admin', 'fa-pencil-square', 'email_templates', 'templates', 5, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_estimate', '', 'settings_menu_admin', 'fa-file-o', 'estimate_settings', 'estimate', 8, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_general', '', 'settings_menu_admin', 'fa-info-circle', 'general_settings', 'general', 1, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_invoice', '', 'settings_menu_admin', 'fa-money', 'invoice_settings', 'invoice', 7, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_menu', '', 'settings_menu_admin', 'fa-list-alt', 'menu_settings', 'menu', 10, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_payment', '', 'settings_menu_admin', 'fa-dollar', 'payment_settings', 'payments', 4, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_system', '', 'settings_menu_admin', 'fa-desktop', 'system_settings', 'system', 2, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_theme', '', 'settings_menu_admin', 'fa-code', 'theme_settings', 'theme', 9, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('settings_translations', '', 'settings_menu_admin', 'fa-globe', 'translations', 'translations', 12, 1, 1, 1, '', 1, '0000-00-00 00:00:00'),
  ('user_menu_plugins', '', 'user_menu_admin', '', 'plugins', 'updates/plugins', 1, 1, 1, 1, '', 1, '0000-00-00 00:00:00');





UPDATE `fx_status` SET `status` = 'resolved' WHERE `id` = '1';
UPDATE `fx_status` SET `status` = 'pending' WHERE `id` = '5';

UPDATE  `fx_email_templates` SET  `subject` =  'Ticket [SUBJECT]' WHERE  email_group = 'ticket_staff_email';
UPDATE  `fx_email_templates` SET  `subject` =  'Ticket [SUBJECT]' WHERE  email_group = 'ticket_client_email';
UPDATE  `fx_email_templates` SET  `subject` =  'Ticket [SUBJECT] response' WHERE  email_group = 'ticket_reply_email';
UPDATE  `fx_email_templates` SET  `subject` =  'Ticket [SUBJECT] closed' WHERE  email_group = 'ticket_closed_email';


ALTER TABLE `fx_comments` CHANGE `message` `message` LONGTEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;
ALTER TABLE `fx_ticketreplies` CHANGE `body` `body` LONGTEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;
ALTER TABLE `fx_tickets` CHANGE `body` `body` LONGTEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;
ALTER TABLE `fx_invoices` CHANGE `notes` `notes` MEDIUMTEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;
ALTER TABLE `fx_estimates` CHANGE `notes` `notes` MEDIUMTEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;

CREATE TABLE IF NOT EXISTS `fx_plugins` (
  `id` varchar(255) NOT NULL,
  `route` varchar(155) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` longtext,
  `version` varchar(45) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `plugin_uri` varchar(255) DEFAULT NULL,
  `update_uri` varchar(255) DEFAULT NULL,
  `image_uri` varchar(255) DEFAULT NULL,
  `installed` int(1) DEFAULT NULL,
  `licence` varchar(256) DEFAULT NULL,
  `has_update` int(1) DEFAULT '0',
  `update_version` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `fx_expenses` MODIFY id INT NOT NULL AUTO_INCREMENT,DROP PRIMARY KEY, ADD PRIMARY KEY (id);
ALTER TABLE `fx_categories` MODIFY id INT NOT NULL AUTO_INCREMENT,DROP PRIMARY KEY, ADD PRIMARY KEY (id);
ALTER TABLE `fx_outgoing_emails` MODIFY id INT NOT NULL AUTO_INCREMENT,DROP PRIMARY KEY, ADD PRIMARY KEY (id);