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
use Altum\Date;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;
use Altum\Routing\Router;
use Altum\Title;
use Altum\Uploads;

class LinkUpdate extends Controller {

    public function index() {

        Authentication::guard();

        $link_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        if(!$link = db()->where('link_id', $link_id)->where('user_id', $this->user->user_id)->getOne('links')) {
            redirect('links');
        }

        /* Genereate the link full URL base */
        $link->full_url = (new \Altum\Models\Link())->get_link_full_url($link, $this->user);

        /* Parse some details */
        foreach(['settings', 'pixels_ids'] as $key) {
            $link->{$key} = json_decode($link->{$key});
        }

        /* Get available custom domains */
        $domains = (new \Altum\Models\Domain())->get_available_domains_by_user($this->user);

        /* Get available projects */
        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($this->user->user_id);

        /* Get available pixels */
        $pixels = (new \Altum\Models\Pixel())->get_pixels($this->user->user_id);

        /* Get the amount of QR codes linked */
        $linked_qr_codes = db()->where('link_id', $link->link_id)->getValue('qr_codes', 'count(`qr_code_id`)');

        if(!empty($_POST)) {
            $_POST['url'] = !empty($_POST['url']) ? get_slug(Database::clean_string($_POST['url'])) : null;
            $_POST['location_url'] = mb_substr(trim(Database::clean_string($_POST['location_url'])), 0, 2048);
            $_POST['domain_id'] = isset($_POST['domain_id']) && isset($domains[$_POST['domain_id']]) ? (!empty($_POST['domain_id']) ? (int) $_POST['domain_id'] : null) : null;
            $_POST['is_enabled'] = (int) (bool) isset($_POST['is_enabled']);

            /* Pixels */
            $_POST['pixels_ids'] = isset($_POST['pixels_ids']) ? array_map(
                function($pixel_id) {
                    return (int) $pixel_id;
                },
                array_filter($_POST['pixels_ids'], function($pixel_id) use($pixels) {
                    return array_key_exists($pixel_id, $pixels);
                })
            ) : [];
            $_POST['pixels_ids'] = json_encode($_POST['pixels_ids']);

            /* Temporary URL */
            if(isset($_POST['schedule']) && !empty($_POST['start_date']) && !empty($_POST['end_date']) && Date::validate($_POST['start_date'], 'Y-m-d H:i:s') && Date::validate($_POST['end_date'], 'Y-m-d H:i:s')) {
                $_POST['start_date'] = (new \DateTime($_POST['start_date'], new \DateTimeZone($this->user->timezone)))->setTimezone(new \DateTimeZone(\Altum\Date::$default_timezone))->format('Y-m-d H:i:s');
                $_POST['end_date'] = (new \DateTime($_POST['end_date'], new \DateTimeZone($this->user->timezone)))->setTimezone(new \DateTimeZone(\Altum\Date::$default_timezone))->format('Y-m-d H:i:s');
            } else {
                $_POST['start_date'] = $_POST['end_date'] = null;
            }
            $_POST['expiration_url'] = mb_substr(trim(Database::clean_string($_POST['expiration_url'] ?? null)), 0, 2048);
            $_POST['clicks_limit'] = empty($_POST['clicks_limit']) ? null : (int) $_POST['clicks_limit'];

            /* Advanced */
            $_POST['project_id'] = !empty($_POST['project_id']) && array_key_exists($_POST['project_id'], $projects) ? (int) $_POST['project_id'] : null;
            $_POST['password'] = !empty($_POST['password']) ?
                ($_POST['password'] != $link->password ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $link->password)
                : null;

            /* Targeting */
            $targeting_types = ['country_code', 'device_type', 'browser_language', 'rotation', 'os_name'];
            $_POST['targeting_type'] = in_array($_POST['targeting_type'], array_merge(['false'], $targeting_types)) ? Database::clean_string($_POST['targeting_type']) : 'false';

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
            if(
                ($_POST['url'] && $this->user->plan_settings->custom_url_is_enabled && $_POST['url'] != $link->url)
                || ($link->domain_id != $_POST['domain_id'])
            ) {
                $domain_id_where = $_POST['domain_id'] ? "AND `domain_id` = {$_POST['domain_id']}" : "AND `domain_id` IS NULL";
                $is_existing_link = database()->query("SELECT `link_id` FROM `links` WHERE `url` = '{$_POST['url']}' {$domain_id_where}")->num_rows;

                if(array_key_exists($_POST['url'], Router::$routes[''])) {
                    Alerts::add_field_error('url', l('links.error_message.blacklisted_url'));
                }

                if(in_array($_POST['url'], explode(',', settings()->links->blacklisted_keywords))) {
                    Alerts::add_field_error('url', l('links.error_message.blacklisted_keyword'));
                }

                if($is_existing_link) {
                    Alerts::add_field_error('url', l('links.error_message.url_exists'));
                }
            }

            $this->check_location_url('location_url', $_POST['location_url']);
            $this->check_location_url('expiration_url', $_POST['expiration_url'], true);

            $settings = [
                'schedule' => $_POST['schedule'] ?? null,
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'pageviews_limit' => $_POST['pageviews_limit'],
                'expiration_url' => $_POST['expiration_url'],
                'targeting_type' => $_POST['targeting_type'],
            ];

            /* Process the targeting */
            foreach($targeting_types as $targeting_type) {
                ${'targeting_' . $targeting_type} = [];

                if(isset($_POST['targeting_' . $targeting_type . '_key'])) {
                    foreach ($_POST['targeting_' . $targeting_type . '_key'] as $key => $value) {
                        if(empty(trim($value))) continue;

                        $this->check_location_url('targeting_' . $targeting_type . '_value[' . $key . ']', $_POST['targeting_' . $targeting_type . '_value'][$key]);

                        ${'targeting_' . $targeting_type}[] = [
                            'key' => trim(Database::clean_string($value)),
                            'value' => mb_substr(trim(Database::clean_string($_POST['targeting_' . $targeting_type . '_value'][$key])), 0, 2048),
                        ];
                    }

                    $settings['targeting_' . $targeting_type] = ${'targeting_' . $targeting_type};
                }
            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                $settings = json_encode($settings);

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
                db()->where('link_id', $link->link_id)->update('links', [
                    'domain_id' => $_POST['domain_id'],
                    'project_id' => $_POST['project_id'],
                    'pixels_ids' => $_POST['pixels_ids'],
                    'url' => $_POST['url'],
                    'location_url' => $_POST['location_url'],
                    'settings' => $settings,
                    'password' => $_POST['password'],
                    'is_enabled' => $_POST['is_enabled'],
                    'last_datetime' => \Altum\Date::$date,
                ]);

                /* Clear the cache */
                \Altum\Cache::$adapter->deleteItemsByTag('link_id=' . $link_id);
                \Altum\Cache::$adapter->deleteItem('links?user_id=' . $link->user_id);

                /* Set a nice success message */
                Alerts::add_success(sprintf(l('global.success_message.update1'), '<strong>' . filter_var($_POST['url'], FILTER_SANITIZE_STRING) . '</strong>'));

                redirect('link-update/' . $link->link_id);
            }

        }

        /* Set a custom title */
        Title::set(sprintf(l('link_update.title'), $link->url));

        /* Prepare the View */
        $data = [
            'linked_qr_codes' => $linked_qr_codes,
            'pixels' => $pixels,
            'domains' => $domains,
            'projects' => $projects,
            'link' => $link
        ];

        $view = new \Altum\Views\View('link-update/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

        /* Clear out pending alerts */
        Alerts::clear_field_errors();
    }

    /* Function to bundle together all the checks of an url */
    private function check_location_url($key, $url, $can_be_empty = false) {

        if(empty(trim($url)) && $can_be_empty) {
            return;
        }

        if(empty(trim($url))) {
            Alerts::add_field_error($key, l('global.error_message.empty_fields'));
        }

        $url_details = parse_url($url);

        if(!isset($url_details['scheme'])) {
            Alerts::add_field_error($key, l('links.error_message.invalid_location_url'));
        }

        /* Make sure the domain is not blacklisted */
        $domain = get_domain_from_url($url);

        if($domain && in_array($domain, explode(',', settings()->links->blacklisted_domains))) {
            Alerts::add_field_error($key, l('links.error_message.blacklisted_domain'));
        }

        /* Check the url with google safe browsing to make sure it is a safe website */
        if(settings()->links->google_safe_browsing_is_enabled) {
            if(google_safe_browsing_check($url, settings()->links->google_safe_browsing_api_key)) {
                Alerts::add_field_error($key, l('links.error_message.blacklisted_location_url'));
            }
        }
    }

}
