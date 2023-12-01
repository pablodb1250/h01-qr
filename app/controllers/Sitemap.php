<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

class Sitemap extends Controller {

    public function index() {

        /* Set the header as xml so the browser can read it properly */
        header('Content-Type: text/xml');

        /* How many external users per sitemap page */
        $pagination = 5000;

        $page = isset($this->params[0]) ? $this->params[0] : null;

        /* Different answers for different parts */
        switch($page) {

            /* Sitemap index */
            case null:

                /* Calculate the needed sitemaps */
                $total_sitemaps = 1;

                /* Main View */
                $data = [
                    'total_sitemaps' => $total_sitemaps
                ];

                $view = new \Altum\Views\View('sitemap/sitemap_index', (array) $this);

                break;

            /* Output base pages like the homepage, register..etc*/
            case 1:

                /* Get all custom pages from the database */
                $pages_result = database()->query("SELECT `url` FROM `pages` WHERE `type` = 'internal'");

                /* Main View */
                $data = [
                    'pages_result' => $pages_result
                ];

                $view = new \Altum\Views\View('sitemap/sitemap_1', (array) $this);

                break;

        }


        echo $view->run($data);

        die();
    }

}
