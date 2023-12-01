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

class PixelUpdate extends Controller {

    public function index() {

        Authentication::guard();

        $pixel_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        if(!$pixel = db()->where('pixel_id', $pixel_id)->where('user_id', $this->user->user_id)->getOne('pixels')) {
            redirect('pixels');
        }

        if(!empty($_POST)) {
            $_POST['name'] = trim(Database::clean_string($_POST['name']));
            $_POST['type'] = array_key_exists($_POST['type'], require APP_PATH . 'includes/l/pixels.php') ? $_POST['type'] : '';
            $_POST['pixel'] = trim(Database::clean_string($_POST['pixel']));

            //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Alerts::add_error('Please create an account on the demo to test out this function.');

            /* Check for any errors */
            $required_fields = ['name', 'type', 'pixel'];
            foreach($required_fields as $field) {
                if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if(!Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                /* Database query */
                db()->where('pixel_id', $pixel->pixel_id)->update('pixels', [
                    'type' => $_POST['type'],
                    'name' => $_POST['name'],
                    'pixel' => $_POST['pixel'],
                    'last_datetime' => Date::$date,
                ]);

                /* Set a nice success message */
                Alerts::add_success(sprintf(l('global.success_message.update1'), '<strong>' . filter_var($_POST['name'], FILTER_SANITIZE_STRING) . '</strong>'));

                /* Clear the cache */
                \Altum\Cache::$adapter->deleteItemsByTag('pixels?user_id=' . $this->user->user_id);

                redirect('pixel-update/' . $pixel_id);
            }
        }

        /* Prepare the View */
        $data = [
            'pixel' => $pixel
        ];

        $view = new \Altum\Views\View('pixel-update/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
