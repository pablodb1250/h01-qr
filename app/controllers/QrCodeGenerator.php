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
use Altum\Response;
use Altum\Uploads;
use SimpleSoftwareIO\QrCode\Generator;
use SVG\Nodes\Embedded\SVGImage;
use SVG\SVG;

class QrCodeGenerator extends Controller {

    public function index() {

        if(empty($_POST)) {
            redirect();
        }

        /* :) */
        $qr_code_settings = require APP_PATH . 'includes/qr_code.php';
        $_POST['type'] = isset($_POST['type']) && array_key_exists($_POST['type'], $qr_code_settings['type']) ? $_POST['type'] : 'text';

        /* Check for the API Key if needed */
        if(!isset($_POST['api_key']) || (isset($_POST['api_key']) && empty($_POST['api_key']))) {
            /* Check the guest plan */
            if(!$this->user->plan_settings->enabled_qr_codes->{$_POST['type']}) {
                die();
            }
        } else {
            $user = db()->where('api_key', $_POST['api_key'])->where('status', 1)->getOne('users');

            if(!$user) {
                die();
            }
        }

        /* Process variables */
        $_POST['foreground_type'] = isset($_POST['foreground_type']) && in_array($_POST['foreground_type'], ['color', 'gradient']) ? $_POST['foreground_type'] : 'color';
        $_POST['background_color'] = !preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['background_color']) ? '#ffffff' : $_POST['background_color'];
        $_POST['background_color_transparency'] = isset($_POST['background_color_transparency']) && in_array($_POST['background_color_transparency'], range(0, 100)) ? (int) $_POST['background_color_transparency'] : 0;
        $_POST['custom_eyes_color'] = (bool) (int) $_POST['custom_eyes_color'];
        if($_POST['custom_eyes_color']) {
            $_POST['eyes_inner_color'] = !preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['eyes_inner_color']) ? null : $_POST['eyes_inner_color'];
            $_POST['eyes_outer_color'] = !preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['eyes_outer_color']) ? null : $_POST['eyes_outer_color'];
        }
        $qr_code_logo = !empty($_FILES['qr_code_logo']['name']) && !isset($_POST['qr_code_logo_remove']);
        $_POST['qr_code_logo'] = $_POST['qr_code_logo'] ?? null;
        $_POST['qr_code_logo_size'] = isset($_POST['qr_code_logo_size']) && in_array($_POST['qr_code_logo_size'], range(5, 35)) ? (int) $_POST['qr_code_logo_size'] : 25;
        $_POST['size'] = isset($_POST['size']) && in_array($_POST['size'], range(50, 2000)) ? (int) $_POST['size'] : 500;
        $_POST['margin'] = isset($_POST['margin']) && in_array($_POST['margin'], range(0, 25)) ? (int) $_POST['margin'] : 0;
        $_POST['ecc'] = isset($_POST['ecc']) && in_array($_POST['ecc'], ['L', 'M', 'Q', 'H']) ? $_POST['ecc'] : 'M';

        switch($_POST['type']) {
            case 'text':
                $_POST['text'] = filter_var($_POST['text'], FILTER_SANITIZE_STRING);
                $data = $_POST['text'];
                break;

                case 'pdf':
                    // $_POST['archivo'] = filter_var($_POST['archivo'], FILTER_SANITIZE_STRING);
                    $_POST['pdf'] = filter_var($_POST['pdf'], FILTER_SANITIZE_URL);
                    $data = $_POST['pdf'];
                    break;
    
    
            case 'url':
                $_POST['url'] = filter_var($_POST['url'] ?? null, FILTER_SANITIZE_URL);
                $data = $_POST['url'];
                break;

            case 'phone':
                $_POST['phone'] = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
                $data = 'tel:' . $_POST['phone'];
                break;

            case 'sms':
                $_POST['sms'] = filter_var($_POST['sms'], FILTER_SANITIZE_STRING);
                $_POST['sms_body'] = filter_var($_POST['sms_body'], FILTER_SANITIZE_STRING);
                $data = 'SMSTO:' . $_POST['sms'] . ':' . $_POST['sms_body'];
                break;

            case 'email':
                $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                $_POST['email_subject'] = filter_var($_POST['email_subject'], FILTER_SANITIZE_STRING);
                $_POST['email_body'] = filter_var($_POST['email_body'], FILTER_SANITIZE_STRING);
                $data = 'MATMSG:TO:' . $_POST['email'] . ';SUB:' . $_POST['email_subject'] . ';BODY:' . $_POST['email_body'] . ';;';
                break;

            case 'whatsapp':
                $_POST['whatsapp'] = filter_var($_POST['whatsapp'], FILTER_SANITIZE_STRING);
                $_POST['whatsapp_body'] = filter_var($_POST['whatsapp_body'], FILTER_SANITIZE_STRING);
                $data = 'https://api.whatsapp.com/send?phone=' . $_POST['whatsapp'] . '&text=' . urlencode($_POST['whatsapp_body']);
                break;

            case 'facetime':
                $_POST['facetime'] = filter_var($_POST['facetime'], FILTER_SANITIZE_STRING);
                $data = 'facetime:' . $_POST['facetime'];
                break;

            case 'location':
                $_POST['location_latitude'] = (float) filter_var($_POST['location_latitude'], FILTER_SANITIZE_STRING);
                $_POST['location_longitude'] = (float) filter_var($_POST['location_longitude'], FILTER_SANITIZE_STRING);
                $data = 'geo:' . $_POST['location_latitude'] . ',' . $_POST['location_longitude'] . '?q=' . $_POST['location_latitude'] . ',' . $_POST['location_longitude'];
                break;

            case 'wifi':
                $_POST['wifi_ssid'] = filter_var($_POST['wifi_ssid'], FILTER_SANITIZE_STRING);
                $_POST['wifi_encryption'] = isset($_POST['wifi_encryption']) && in_array($_POST['wifi_encryption'], ['nopass', 'WEP', 'WPA/WPA2']) ? $_POST['wifi_encryption'] : 'nopass';
                if($_POST['wifi_encryption'] == 'WPA/WPA2') $_POST['wifi_encryption'] = 'WPA';
                $_POST['wifi_password'] = filter_var($_POST['wifi_password'], FILTER_SANITIZE_STRING);
                $_POST['wifi_is_hidden'] = (int) $_POST['wifi_is_hidden'];

                $data_to_be_rendered = 'WIFI:S:' . $_POST['wifi_ssid'] . ';';
                $data_to_be_rendered .= 'T:' . $_POST['wifi_encryption'] . ';';
                if($_POST['wifi_password']) $data_to_be_rendered .= 'P:' . $_POST['wifi_password'] . ';';
                if($_POST['wifi_is_hidden']) $data_to_be_rendered .= 'H:' . (bool) $_POST['wifi_is_hidden'] . ';';
                $data_to_be_rendered .= ';';

                $data = $data_to_be_rendered;
                break;

            case 'event':
                $_POST['event'] = filter_var($_POST['event'], FILTER_SANITIZE_STRING);
                $_POST['event_location'] = filter_var($_POST['event_location'], FILTER_SANITIZE_STRING);
                $_POST['event_url'] = filter_var($_POST['event_url'], FILTER_SANITIZE_URL);
                $_POST['event_note'] = filter_var($_POST['event_note'], FILTER_SANITIZE_STRING);
                $_POST['event_timezone'] = filter_var($_POST['event_timezone'], FILTER_SANITIZE_STRING);
                $_POST['event_start_datetime'] = (new \DateTime($_POST['event_start_datetime']))->format('Ymd\THis\Z');
                $_POST['event_end_datetime'] = empty($_POST['event_end_datetime']) ? null : (new \DateTime($_POST['event_end_datetime']))->format('Ymd\THis\Z');

                $data_to_be_rendered = 'BEGIN:VEVENT' . "\n";
                $data_to_be_rendered .= 'SUMMARY:' . $_POST['event'] . "\n";
                $data_to_be_rendered .= 'LOCATION:' . $_POST['event_location'] . "\n";
                $data_to_be_rendered .= 'URL:' . $_POST['event_url'] . "\n";
                $data_to_be_rendered .= 'DESCRIPTION:' . $_POST['event_note'] . "\n";
                $data_to_be_rendered .= 'DTSTART;TZID=' . $_POST['event_timezone'] . ':' . $_POST['event_start_datetime'] . "\n";
                if($_POST['event_end_datetime']) $data_to_be_rendered .= 'DTEND;TZID=' . $_POST['event_timezone'] . ':' . $_POST['event_end_datetime'] . "\n";
                $data_to_be_rendered .= 'END:VEVENT';

                $data = $data_to_be_rendered;
                break;

            case 'crypto':
                $_POST['crypto_coin'] = isset($_POST['crypto_coin']) && array_key_exists($_POST['crypto_coin'], $qr_code_settings['type']['crypto']['coins']) ? $_POST['crypto_coin'] : array_key_first($qr_code_settings['type']['crypto']['coins']);;
                $_POST['crypto_address'] = filter_var($_POST['crypto_address'], FILTER_SANITIZE_STRING);
                $data = $_POST['crypto_coin'] . ':' . $_POST['crypto_address'];
                break;

            case 'vcard':
                $_POST['vcard_first_name'] = filter_var($_POST['vcard_first_name'], FILTER_SANITIZE_STRING);
                $_POST['vcard_last_name'] = filter_var($_POST['vcard_last_name'], FILTER_SANITIZE_STRING);
                $_POST['vcard_phone'] = filter_var($_POST['vcard_phone'], FILTER_SANITIZE_STRING);
                $_POST['vcard_email'] = filter_var($_POST['vcard_email'], FILTER_SANITIZE_EMAIL);
                $_POST['vcard_url'] = filter_var($_POST['vcard_url'], FILTER_SANITIZE_URL);
                $_POST['vcard_company'] = filter_var($_POST['vcard_company'], FILTER_SANITIZE_STRING);
                $_POST['vcard_job_title'] = filter_var($_POST['vcard_job_title'], FILTER_SANITIZE_STRING);
                $_POST['vcard_birthday'] = filter_var($_POST['vcard_birthday'], FILTER_SANITIZE_STRING);
                $_POST['vcard_street'] = filter_var($_POST['vcard_street'], FILTER_SANITIZE_STRING);
                $_POST['vcard_city'] = filter_var($_POST['vcard_city'], FILTER_SANITIZE_STRING);
                $_POST['vcard_zip'] = filter_var($_POST['vcard_zip'], FILTER_SANITIZE_STRING);
                $_POST['vcard_region'] = filter_var($_POST['vcard_region'], FILTER_SANITIZE_STRING);
                $_POST['vcard_country'] = filter_var($_POST['vcard_country'], FILTER_SANITIZE_STRING);
                $_POST['vcard_note'] = filter_var($_POST['vcard_note'], FILTER_SANITIZE_STRING);

                if(!isset($_POST['vcard_social_label'])) {
                    $_POST['vcard_social_label'] = [];
                    $_POST['vcard_social_value'] = [];
                }

                $vcard = new \JeroenDesloovere\VCard\VCard();
                $vcard->addName($_POST['vcard_last_name'], $_POST['vcard_first_name']);
                $vcard->addAddress(null, null, $_POST['vcard_street'], $_POST['vcard_city'], $_POST['vcard_region'], $_POST['vcard_zip'], $_POST['vcard_country']);
                if($_POST['vcard_phone']) $vcard->addPhoneNumber($_POST['vcard_phone']);
                if($_POST['vcard_email']) $vcard->addEmail($_POST['vcard_email']);
                if($_POST['vcard_url']) $vcard->addURL($_POST['vcard_url']);
                if($_POST['vcard_company']) $vcard->addCompany($_POST['vcard_company']);
                if($_POST['vcard_job_title']) $vcard->addJobtitle($_POST['vcard_job_title']);
                if($_POST['vcard_birthday']) $vcard->addBirthday($_POST['vcard_birthday']);
                if($_POST['vcard_note']) $vcard->addNote($_POST['vcard_note']);

                foreach($_POST['vcard_social_label'] as $key => $value) {
                    if(empty(trim($value))) continue;
                    if($key >= 20) continue;

                    $label = mb_substr(trim(filter_var($value, FILTER_SANITIZE_STRING)), 0, $qr_code_settings['type']['vcard']['social_value']['max_length']);
                    $value = mb_substr(trim(filter_var($_POST['vcard_social_value'][$key], FILTER_SANITIZE_STRING)), 0, $qr_code_settings['type']['vcard']['social_value']['max_length']);

                    $vcard->addURL(
                        $value,
                        'TYPE=' . $label
                    );
                }

                $data = $vcard->buildVCard();
                break;

            case 'paypal':
                $_POST['paypal_type'] = isset($_POST['paypal_type']) && array_key_exists($_POST['paypal_type'], $qr_code_settings['type']['paypal']['type']) ? $_POST['paypal_type'] : array_key_first($qr_code_settings['type']['paypal']['type']);;
                $_POST['paypal_email'] = filter_var($_POST['paypal_email'], FILTER_SANITIZE_EMAIL);
                $_POST['paypal_title'] = filter_var($_POST['paypal_title'], FILTER_SANITIZE_STRING);
                $_POST['paypal_currency'] = filter_var($_POST['paypal_currency'], FILTER_SANITIZE_STRING);
                $_POST['paypal_price'] = (float) $_POST['paypal_price'];
                $_POST['paypal_thank_you_url'] = filter_var($_POST['paypal_thank_you_url'], FILTER_SANITIZE_URL);
                $_POST['paypal_cancel_url'] = filter_var($_POST['paypal_cancel_url'], FILTER_SANITIZE_URL);

                if($_POST['paypal_type'] == 'add_to_cart') {
                    $data = sprintf('https://www.paypal.com/cgi-bin/webscr?business=%s&cmd=%s&currency_code=%s&amount=%s&item_name=%s&button_subtype=products&add=1&return=%s&cancel_return=%s', $_POST['paypal_email'], $qr_code_settings['type']['paypal']['type'][$_POST['paypal_type']], $_POST['paypal_currency'], $_POST['paypal_price'], $_POST['paypal_title'], $_POST['paypal_thank_you_url'], $_POST['paypal_cancel_url']);
                } else {
                    $data = sprintf('https://www.paypal.com/cgi-bin/webscr?business=%s&cmd=%s&currency_code=%s&amount=%s&item_name=%s&return=%s&cancel_return=%s', $_POST['paypal_email'], $qr_code_settings['type']['paypal']['type'][$_POST['paypal_type']], $_POST['paypal_currency'], $_POST['paypal_price'], $_POST['paypal_title'], $_POST['paypal_thank_you_url'], $_POST['paypal_cancel_url']);
                }

                break;
        }

        /* :) */
        $qr = new Generator;
        $qr->size($_POST['size']);
        $qr->errorCorrection($_POST['ecc']);
        $qr->encoding('UTF-8');
        $qr->margin($_POST['margin']);
//        $qr->style('dot');
//        $qr->eye('circle');

        /* Colors */
        $background_color = hex_to_rgb($_POST['background_color']);
        $qr->backgroundColor($background_color['r'], $background_color['g'], $background_color['b'], 100 - $_POST['background_color_transparency']);

        /* Eyes */
        if($_POST['custom_eyes_color']) {
            $eyes_inner_color = hex_to_rgb($_POST['eyes_inner_color']);
            $eyes_outer_color = hex_to_rgb($_POST['eyes_outer_color']);

            $qr->eyeColor(0, $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b'], $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b']);
            $qr->eyeColor(1, $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b'], $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b']);
            $qr->eyeColor(2, $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b'], $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b']);
        }

        /* Foreground */
        switch($_POST['foreground_type']) {
            case 'color':
                $_POST['foreground_color'] = !preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['foreground_color']) ? '#000000' : $_POST['foreground_color'];
                $foreground_color = hex_to_rgb($_POST['foreground_color']);
                $qr->color($foreground_color['r'], $foreground_color['g'], $foreground_color['b']);
                break;

            case 'gradient':
                $_POST['foreground_gradient_style'] = isset($_POST['foreground_gradient_style']) && in_array($_POST['foreground_gradient_style'], ['vertical', 'horizontal', 'diagonal', 'inverse_diagonal', 'radial']) ? $_POST['foreground_gradient_style'] : 'horizontal';
                $foreground_gradient_one = hex_to_rgb($_POST['foreground_gradient_one']);
                $foreground_gradient_two = hex_to_rgb($_POST['foreground_gradient_two']);
                $qr->gradient($foreground_gradient_one['r'], $foreground_gradient_one['g'], $foreground_gradient_one['b'], $foreground_gradient_two['r'], $foreground_gradient_two['g'], $foreground_gradient_two['b'], $_POST['foreground_gradient_style']);
                break;
        }

        /* Generate the first SVG */
        try {
            $svg = $qr->generate($data);
        } catch (\Exception $exception) {
            Response::json($exception->getMessage(), 'error');
        }

        if(($_POST['qr_code_logo'] || $qr_code_logo) && !isset($_POST['qr_code_logo_remove'])) {
            $logo_width_percentage = $_POST['qr_code_logo_size'];

            /* Start doing custom changes to the output SVG */
            $custom_svg_object = SVG::fromString($svg);
            $custom_svg_doc = $custom_svg_object->getDocument();

            /* Already existing QR code logo */
            if($_POST['qr_code_logo']) {
                $qr_code_logo_name = $_POST['qr_code_logo'];
                $qr_code_logo_link = $_POST['qr_code_logo'];
            }

            /* Freshly uploaded QR code logo */
            if($qr_code_logo) {
                $qr_code_logo_name = $_FILES['qr_code_logo']['name'];
                $file_extension = explode('.', $qr_code_logo_name);
                $file_extension = mb_strtolower(end($file_extension));
                $qr_code_logo_link = $_FILES['qr_code_logo']['tmp_name'];

                if($_FILES['qr_code_logo']['error'] == UPLOAD_ERR_INI_SIZE) {
                    Alerts::add_error(sprintf(l('global.error_message.file_size_limit'), $qr_code_settings['qr_code_logo_size_limit']));
                }

                if($_FILES['qr_code_logo']['error'] && $_FILES['qr_code_logo']['error'] != UPLOAD_ERR_INI_SIZE) {
                    Alerts::add_error(l('global.error_message.file_upload'));
                }

                if(!in_array($file_extension, Uploads::get_whitelisted_file_extensions('qr_codes/logo'))) {
                    Alerts::add_error(l('global.error_message.invalid_file_type'));
                }

                if(!\Altum\Plugin::is_active('offload') || (\Altum\Plugin::is_active('offload') && !settings()->offload->uploads_url)) {
                    if(!is_writable(UPLOADS_PATH . 'qr_codes/logo' . '/')) {
                        Response::json(sprintf(l('global.error_message.directory_not_writable'), UPLOADS_PATH . 'qr_codes/logo' . '/'), 'error');
                    }
                }

                if($_FILES['qr_code_logo']['size'] > $qr_code_settings['qr_code_logo_size_limit'] * 1000000) {
                    Response::json(sprintf(l('global.error_message.file_size_limit'), $qr_code_settings['qr_code_logo_size_limit']), 'error');
                }
            }

            /* Process uploaded logo image */
            $qr_code_logo_extension = explode('.', $qr_code_logo_name);
            $qr_code_logo_extension = mb_strtolower(end($qr_code_logo_extension));
            $logo = file_get_contents($qr_code_logo_link);
            $logo_base64 = 'data:image/' . $qr_code_logo_extension . ';base64,' . base64_encode($logo);

            /* Size of the logo */
            list($logo_width, $logo_height) = getimagesize($qr_code_logo_link);
            $logo_ratio = $logo_height / $logo_width;
            $logo_new_width = $_POST['size'] * $logo_width_percentage / 100;
            $logo_new_height = $logo_new_width * $logo_ratio;

            /* Calculate center of the QR code */
            $logo_x = $_POST['size'] / 2 - $logo_new_width / 2;
            $logo_y = $_POST['size'] / 2 - $logo_new_height / 2;

            /* Add the logo to the QR code */
            $logo = new SVGImage($logo_base64, $logo_x, $logo_y, $logo_new_width, $logo_new_height);
            $custom_svg_doc->addChild($logo);

            /* Export the QR code with the logo on top */
            $svg = $custom_svg_object->toXMLString();
        }

        $data = 'data:image/svg+xml;base64,' . base64_encode($svg);

        Response::json('', 'success', ['data' => $data]);

    }

}
