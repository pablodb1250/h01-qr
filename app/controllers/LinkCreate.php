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
use Altum\Routing\Router;

class LinkCreate extends Controller {

    public function index() {

        Authentication::guard();

        /* Check for the plan limit */
        $total_rows = database()->query("SELECT COUNT(*) AS `total` FROM `links` WHERE `user_id` = {$this->user->user_id}")->fetch_object()->total ?? 0;

        if($this->user->plan_settings->links_limit != -1 && $total_rows >= $this->user->plan_settings->links_limit) {
            Alerts::add_info(l('links.error_message.links_limit'));
            redirect('links');
        }

        /* Get available custom domains */
        $domains = (new \Altum\Models\Domain())->get_available_domains_by_user($this->user);

        if(!empty($_POST)) {
            $_POST['location_url'] = mb_substr(trim(Database::clean_string($_POST['location_url'])), 0, 2048);
            $_POST['url'] = !empty($_POST['url']) && $this->user->plan_settings->custom_url_is_enabled ? get_slug(Database::clean_string($_POST['url'])) : false;
            $_POST['domain_id'] = isset($_POST['domain_id']) && isset($domains[$_POST['domain_id']]) ? (!empty($_POST['domain_id']) ? (int) $_POST['domain_id'] : null) : null;

            //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Alerts::add_error('Please create an account on the demo to test out this function.');

            /* Check for any errors */
            $required_fields = ['location_url'];
            foreach($required_fields as $field) {
                if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if(!Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            /* Check for duplicate url if needed */
            if($_POST['url']) {
                $domain_id_where = $_POST['domain_id'] ? "AND `domain_id` = {$_POST['domain_id']}" : "AND `domain_id` IS NULL";
                $is_existing_link = database()->query("SELECT `link_id` FROM `links` WHERE `url` = '{$_POST['url']}' {$domain_id_where}")->num_rows;

                if($is_existing_link) {
                    Alerts::add_field_error('url', l('links.error_message.url_exists'));
                }

                if(array_key_exists($_POST['url'], Router::$routes[''])) {
                    Alerts::add_field_error('url', l('links.error_message.blacklisted_url'));
                }

                if(in_array($_POST['url'], explode(',', settings()->links->blacklisted_keywords))) {
                    Alerts::add_field_error('url', l('links.error_message.blacklisted_keyword'));
                }
            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {
                $settings = json_encode([
                    'schedule' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'pageviews_limit' => null,
                    'expiration_url' => null,
                    'targeting_type' => null,
                ]);

                if(!$_POST['url']) {
                    $is_existing_link = true;

                    /* Generate random url if not specified */
                    while($is_existing_link) {
                        $_POST['url'] = mb_strtolower(string_generate(10));

                        $domain_id_where = $_POST['domain_id'] ? "AND `domain_id` = {$_POST['domain_id']}" : "AND `domain_id` IS NULL";
                        $is_existing_link = database()->query("SELECT `link_id` FROM `links` WHERE `url` = '{$_POST['url']}' {$domain_id_where}")->num_rows;
                    }
                }

                /* Prepare the statement and execute query */
                $link_id = db()->insert('links', [
                    'user_id' => $this->user->user_id,
                    'domain_id' => $_POST['domain_id'],
                    'pixels_ids' => json_encode([]),
                    'url' => $_POST['url'],
                    'location_url' => $_POST['location_url'],
                    'settings' => $settings,
                    'datetime' => \Altum\Date::$date,
                ]);

                /* Clear the cache */
                \Altum\Cache::$adapter->deleteItem('links?user_id=' . $this->user->user_id);

                /* Set a nice success message */
                Alerts::add_success(sprintf(l('global.success_message.create1'), '<strong>' . filter_var($_POST['url'], FILTER_SANITIZE_STRING) . '</strong>'));

                redirect('link-update/' . $link_id);
            }

        }

        /* Set default values */
        $values = [
            'location_url' => $_POST['location_url'] ?? '',
            'url' => $_POST['url'] ?? '',
            'domain_id' => $_POST['domain_id'] ?? '',
        ];

        /* Prepare the View */
        $data = [
            'domains' => $domains,
            'values' => $values
        ];

        $view = new \Altum\Views\View('link-create/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
