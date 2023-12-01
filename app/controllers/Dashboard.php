<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Middlewares\Authentication;

class Dashboard extends Controller {

    public function index() {

        Authentication::guard();

        /* Get some stats */
        $total_qr_codes = db()->where('user_id', $this->user->user_id)->getValue('qr_codes', 'count(`qr_code_id`)');
        $total_links = db()->where('user_id', $this->user->user_id)->getValue('links', 'count(`link_id`)');
        $total_pixels = db()->where('user_id', $this->user->user_id)->getValue('pixels', 'count(`pixel_id`)');
        $total_projects = db()->where('user_id', $this->user->user_id)->getValue('projects', 'count(`project_id`)');
        $total_domains = db()->where('user_id', $this->user->user_id)->getValue('domains', 'count(`domain_id`)');

        /* Get available projects */
        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($this->user->user_id);

        /* Get the QR codes */
        $qr_codes = [];
        $qr_codes_result = database()->query("SELECT * FROM `qr_codes` WHERE `user_id` = {$this->user->user_id} ORDER BY `qr_code_id` DESC LIMIT 5");
        while($row = $qr_codes_result->fetch_object()) {
            $row->settings = json_decode($row->settings);
            $qr_codes[] = $row;
        }

        $qr_code_settings = require APP_PATH . 'includes/qr_code.php';

        /* Prepare the View */
        $data = [
            'qr_codes' => $qr_codes,
            'projects' => $projects,
            'total_qr_codes' => $total_qr_codes,
            'total_links' => $total_links,
            'total_pixels' => $total_pixels,
            'total_projects' => $total_projects,
            'total_domains' => $total_domains,
            'qr_code_settings'    => $qr_code_settings,
        ];

        $view = new \Altum\Views\View('dashboard/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
