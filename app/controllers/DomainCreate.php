<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Alerts;
use Altum\Database\Database;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;

class DomainCreate extends Controller {

    public function index() {

        Authentication::guard();

        /* Check for the plan limit */
        $total_rows = database()->query("SELECT COUNT(*) AS `total` FROM `domains` WHERE `user_id` = {$this->user->user_id}")->fetch_object()->total ?? 0;

        if($this->user->plan_settings->domains_limit != -1 && $total_rows >= $this->user->plan_settings->domains_limit) {
            Alerts::add_info(l('domains.error_message.domains_limit'));
            redirect('domains');
        }

        if(!empty($_POST)) {
            $_POST['scheme'] = isset($_POST['scheme']) && in_array($_POST['scheme'], ['http://', 'https://']) ? Database::clean_string($_POST['scheme']) : 'https://';
            $_POST['host'] = mb_strtolower(trim($_POST['host']));
            $_POST['custom_index_url'] = trim(Database::clean_string($_POST['custom_index_url']));
            $_POST['custom_not_found_url'] = trim(Database::clean_string($_POST['custom_not_found_url']));
            $type = 0;

            //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Alerts::add_error('Please create an account on the demo to test out this function.');

            /* Check for any errors */
            $required_fields = ['host'];
            foreach($required_fields as $field) {
                if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if(!Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if(in_array($_POST['host'], explode(',', settings()->links->blacklisted_domains))) {
                Alerts::add_field_error('host', l('vcard.error_message.blacklisted_domain'));
            }

            if(!empty($_POST['custom_index_url']) && in_array(get_domain_from_url($_POST['custom_index_url']), explode(',', settings()->links->blacklisted_domains))) {
                Alerts::add_field_error('custom_index_url', l('vcard.error_message.blacklisted_domain'));
            }

            if(!empty($_POST['custom_not_found_url']) && in_array(get_domain_from_url($_POST['custom_not_found_url']), explode(',', settings()->links->blacklisted_domains))) {
                Alerts::add_field_error('custom_not_found_url', l('vcard.error_message.blacklisted_domain'));
            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                /* Prepare the statement and execute query */
                $domain_id = db()->insert('domains', [
                    'user_id' => $this->user->user_id,
                    'scheme' => $_POST['scheme'],
                    'host' => $_POST['host'],
                    'custom_index_url' => $_POST['custom_index_url'],
                    'custom_not_found_url' => $_POST['custom_not_found_url'],
                    'type' => $type,
                    'datetime' => \Altum\Date::$date,
                ]);

                /* Clear the cache */
                \Altum\Cache::$adapter->deleteItemsByTag('domains?user_id=' . $this->user->user_id);

                /* Set a nice success message */
                Alerts::add_success(l('domain_create.success_message'));

                /* Send notification to admin if needed */
                if(settings()->email_notifications->new_domain && !empty(settings()->email_notifications->emails)) {

                    /* Prepare the email */
                    $email_template = get_email_template(
                        [],
                        l('global.emails.admin_new_domain_notification.subject'),
                        [
                            '{{ADMIN_DOMAIN_UPDATE_LINK}}' => url('admin/domain-update/' . $domain_id),
                            '{{DOMAIN_HOST}}' => $_POST['host'],
                            '{{NAME}}' => $this->user->name,
                            '{{EMAIL}}' => $this->user->email,
                        ],
                        l('global.emails.admin_new_domain_notification.body')
                    );

                    send_mail(explode(',', settings()->email_notifications->emails), $email_template->subject, $email_template->body);

                }

                redirect('domains');
            }
        }

        /* Set default values */
        $values = [
            'host' => $_POST['host'] ?? '',
            'custom_index_url' => $_POST['custom_index_url'] ?? '',
            'custom_not_found_url' => $_POST['custom_not_found_url'] ?? '',
        ];

        /* Prepare the View */
        $data = [
            'values' => $values
        ];

        $view = new \Altum\Views\View('domain-create/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
