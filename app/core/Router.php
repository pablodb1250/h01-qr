<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Routing;

use Altum\Database\Database;
use Altum\Language;

class Router {
    public static $params = [];
    public static $original_request = '';
    public static $language_code = '';
    public static $path = '';
    public static $controller_key = 'index';
    public static $controller = 'Index';
    public static $controller_settings = [
        'wrapper' => 'wrapper',
        'no_authentication_check' => false,

        /* Enable / disable browser language detection & redirection */
        'no_browser_language_detection' => false,

        /* Should we see a view for the controller? */
        'has_view' => true,

        /* If set on yes, ads won't show on these pages at all */
        'ads' => false,

        /* Authentication guard check (potential values: null, 'guest', 'user', 'admin') */
        'authentication' => null
    ];
    public static $method = 'index';
    public static $data = [];

    public static $routes = [
        'l' => [
            'link' => [
                'controller' => 'Link',
                'settings' => [
                    'no_authentication_check' => true,
                    'no_browser_language_detection' => true,
                    'ads' => true,
                ]
            ]
        ],

        '' => [
            'qr' => [
                'controller' => 'Qr',
                'settings' => [
                    'ads' => true,
                ],
            ],

            'dashboard' => [
                'controller' => 'Dashboard',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'qr-codes' => [
                'controller' => 'QrCodes',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'qr-code-create' => [
                'controller' => 'QrCodeCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'qr-code-update' => [
                'controller' => 'QrCodeUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'qr-code-generator' => [
                'controller' => 'QrCodeGenerator',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'projects' => [
                'controller' => 'Projects',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'project-create' => [
                'controller' => 'ProjectCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'project-update' => [
                'controller' => 'ProjectUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'pixels' => [
                'controller' => 'Pixels',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'pixel-update' => [
                'controller' => 'PixelUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'pixel-create' => [
                'controller' => 'PixelCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'domains' => [
                'controller' => 'Domains',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'domain-create' => [
                'controller' => 'DomainCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'domain-update' => [
                'controller' => 'DomainUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'links' => [
                'controller' => 'Links',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'link-create' => [
                'controller' => 'LinkCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'link-update' => [
                'controller' => 'LinkUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'link-redirect' => [
                'controller' => 'LinkRedirect',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'link-statistics' => [
                'controller' => 'LinkStatistics',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            /* Common routes */
            'index' => [
                'controller' => 'Index'
            ],

            'login' => [
                'controller' => 'Login',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],

            'register' => [
                'controller' => 'Register',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],

            'affiliate' => [
                'controller' => 'Affiliate'
            ],

            'pages' => [
                'controller' => 'Pages'
            ],

            'page' => [
                'controller' => 'Page'
            ],

            'api-documentation' => [
                'controller' => 'ApiDocumentation',
            ],

            'contact' => [
                'controller' => 'Contact',
            ],

            'activate-user' => [
                'controller' => 'ActivateUser'
            ],

            'lost-password' => [
                'controller' => 'LostPassword',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                ]
            ],

            'reset-password' => [
                'controller' => 'ResetPassword',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                ]
            ],

            'resend-activation' => [
                'controller' => 'ResendActivation',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                ]
            ],

            'logout' => [
                'controller' => 'Logout'
            ],

            'notfound' => [
                'controller' => 'NotFound'
            ],

            'account' => [
                'controller' => 'Account',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'account-plan' => [
                'controller' => 'AccountPlan',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'account-payments' => [
                'controller' => 'AccountPayments',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'account-logs' => [
                'controller' => 'AccountLogs',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'account-api' => [
                'controller' => 'AccountApi',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'account-delete' => [
                'controller' => 'AccountDelete',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'referrals' => [
                'controller' => 'Referrals',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'refer' => [
                'controller' => 'Refer',
                'settings' => [
                    'has_view' => false
                ]
            ],

            'invoice' => [
                'controller' => 'Invoice',
                'settings' => [
                    'wrapper' => 'invoice/invoice_wrapper',
                ]
            ],

            'plan' => [
                'controller' => 'Plan',
            ],

            'pay' => [
                'controller' => 'Pay',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'pay-billing' => [
                'controller' => 'PayBilling',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'pay-thank-you' => [
                'controller' => 'PayThankYou',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            /* Webhooks */
            'webhook-paypal' => [
                'controller' => 'WebhookPaypal',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-stripe' => [
                'controller' => 'WebhookStripe',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-coinbase' => [
                'controller' => 'WebhookCoinbase',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-payu' => [
                'controller' => 'WebhookPayu',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-paystack' => [
                'controller' => 'WebhookPaystack',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-razorpay' => [
                'controller' => 'WebhookRazorpay',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-mollie' => [
                'controller' => 'WebhookMollie',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-yookassa' => [
                'controller' => 'WebhookYookassa',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-crypto-com' => [
                'controller' => 'WebhookCryptoCom',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            /* Others */
            'sitemap' => [
                'controller' => 'Sitemap',
                'settings' => [
                    'no_authentication_check' => true,
                    'no_browser_language_detection' => true,
                ]
            ],

            'cron' => [
                'controller' => 'Cron',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

        ],

        'api' => [
            'qr-codes' => [
                'controller' => 'ApiQrCodes',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'statistics' => [
                'controller' => 'ApiStatistics',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'links' => [
                'controller' => 'ApiLinks',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'projects' => [
                'controller' => 'ApiProjects',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'pixels' => [
                'controller' => 'ApiPixels',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'domains' => [
                'controller' => 'ApiDomains',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],

            /* Common routes */
            'user' => [
                'controller' => 'ApiUser',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'payments' => [
                'controller' => 'ApiPayments',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'logs' => [
                'controller' => 'ApiLogs',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
        ],

        /* Admin Panel */
        /* Authentication is set by default to 'admin' */
        'admin' => [
            'qr-codes' => [
                'controller' => 'AdminQrCodes',
            ],

            'links' => [
                'controller' => 'AdminLinks',
            ],

            'projects' => [
                'controller' => 'AdminProjects',
            ],

            'pixels' => [
                'controller' => 'AdminPixels'
            ],

            'domains' => [
                'controller' => 'AdminDomains',
            ],

            'domain-create' => [
                'controller' => 'AdminDomainCreate',
            ],

            'domain-update' => [
                'controller' => 'AdminDomainUpdate',
            ],

            /* Common routes */
            'index' => [
                'controller' => 'AdminIndex',
            ],

            'users' => [
                'controller' => 'AdminUsers',
            ],

            'user-create' => [
                'controller' => 'AdminUserCreate',
            ],

            'user-view' => [
                'controller' => 'AdminUserView',
            ],

            'user-update' => [
                'controller' => 'AdminUserUpdate',
            ],

            'users-logs' => [
                'controller' => 'AdminUsersLogs',
            ],

            'redeemed-codes' => [
                'controller' => 'AdminRedeemedCodes',
            ],

            'pages-categories' => [
                'controller' => 'AdminPagesCategories',
            ],

            'pages-category-create' => [
                'controller' => 'AdminPagesCategoryCreate',
            ],

            'pages-category-update' => [
                'controller' => 'AdminPagesCategoryUpdate',
            ],

            'pages' => [
                'controller' => 'AdminPages',
            ],

            'page-create' => [
                'controller' => 'AdminPageCreate',
            ],

            'page-update' => [
                'controller' => 'AdminPageUpdate',
            ],

            'plans' => [
                'controller' => 'AdminPlans',
            ],

            'plan-create' => [
                'controller' => 'AdminPlanCreate',
            ],

            'plan-update' => [
                'controller' => 'AdminPlanUpdate',
            ],

            'codes' => [
                'controller' => 'AdminCodes',
            ],

            'code-create' => [
                'controller' => 'AdminCodeCreate',
            ],

            'code-update' => [
                'controller' => 'AdminCodeUpdate',
            ],

            'taxes' => [
                'controller' => 'AdminTaxes',
            ],

            'tax-create' => [
                'controller' => 'AdminTaxCreate',
            ],

            'tax-update' => [
                'controller' => 'AdminTaxUpdate',
            ],

            'affiliates-withdrawals' => [
                'controller' => 'AdminAffiliatesWithdrawals',
            ],

            'payments' => [
                'controller' => 'AdminPayments',
            ],

            'statistics' => [
                'controller' => 'AdminStatistics',
            ],

            'plugins' => [
                'controller' => 'AdminPlugins',
            ],

            'languages' => [
                'controller' => 'AdminLanguages'
            ],

            'language-create' => [
                'controller' => 'AdminLanguageCreate'
            ],

            'language-update' => [
                'controller' => 'AdminLanguageUpdate'
            ],

            'settings' => [
                'controller' => 'AdminSettings',
            ],

            'api-documentation' => [
                'controller' => 'AdminApiDocumentation',
            ],
        ],

        'admin-api' => [
            'users' => [
                'controller' => 'AdminApiUsers',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],

            'plans' => [
                'controller' => 'AdminApiPlans',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
        ],
    ];


    public static function parse_url() {

        $params = self::$params;

        if(isset($_GET['altum'])) {
            $params = explode('/', filter_var(rtrim($_GET['altum'], '/'), FILTER_SANITIZE_STRING));
        }

        self::$params = $params;

        return $params;

    }

    public static function get_params() {

        return self::$params = array_values(self::$params);
    }

    public static function parse_language() {

        /* Check for potential language set in the first parameter */
        if(!empty(self::$params[0]) && in_array(self::$params[0], Language::$active_languages)) {

            /* Set the language */
            $language_code = filter_var(self::$params[0], FILTER_SANITIZE_STRING);
            Language::set_by_code($language_code);
            self::$language_code = $language_code;

            /* Unset the parameter so that it wont be used further */
            unset(self::$params[0]);
            self::$params = array_values(self::$params);

        }

    }

    public static function parse_controller() {

        self::$original_request = filter_var(implode('/', self::$params), FILTER_SANITIZE_STRING);

        /* Check if the current link accessed is actually the original url or not (multi domain use) */
        $original_url_host = parse_url(url(), PHP_URL_HOST);
        $request_url_host = filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_STRING);

        if($original_url_host != $request_url_host) {
            /* Make sure the custom domain is attached */
            $domain = (new \Altum\Models\Domain())->get_domain_by_host($request_url_host);

            if($domain && $domain->is_enabled) {
                self::$path = 'l';

                /* Set some route data */
                self::$data['domain'] = $domain;
            }
        }

        /* Check for potential other paths than the default one (admin panel) */
        if(!empty(self::$params[0])) {

            if(in_array(self::$params[0], ['admin', 'v', 'admin-api', 'api'])) {
                self::$path = self::$params[0];

                unset(self::$params[0]);

                self::$params = array_values(self::$params);
            }

        }

        /* Check for potential link */
        if(self::$path == 'l') {
            self::$controller_key = 'link';
            self::$controller = 'Link';
        }

        if(!empty(self::$params[0])) {

            if(array_key_exists(self::$params[0], self::$routes[self::$path]) && file_exists(APP_PATH . 'controllers/' . (self::$path != '' ? self::$path . '/' : null) . self::$routes[self::$path][self::$params[0]]['controller'] . '.php')) {

                self::$controller_key = self::$params[0];

                unset(self::$params[0]);

            } else {

                /* Try to check if the link exists via the cache */
                $cache_instance = \Altum\Cache::$adapter->getItem('l_link?url=' . md5(self::$params[0]) . (isset(self::$data['domain']) ? '&domain_id=' . self::$data['domain']->domain_id : null));

                /* Set cache if not existing */
                if(!$cache_instance->get()) {

                    /* Get data from the database */
                    if(isset(self::$data['domain'])) {
                        $link = db()->where('url', self::$params[0])->where('domain_id', self::$data['domain']->domain_id)->getOne('links');
                        if($link) $link->full_url = self::$data['domain']->scheme . self::$data['domain']->host . '/' . self::$params[0] . '/';
                    } else {
                        $link = db()->where('url', self::$params[0])->where('domain_id', NULL, 'IS')->getOne('links');
                        if($link) $link->full_url = SITE_URL . self::$params[0] . '/';
                    }

                    /* Save cache */
                    if($link) {
                        \Altum\Cache::$adapter->save($cache_instance->set($link)->expiresAfter(CACHE_DEFAULT_SECONDS)->addTag('link_id=' . $link->link_id));

                        /* Set some route data */
                        self::$data['link'] = $link;
                    }
                } else {
                    /* Get cache */
                    $link = $cache_instance->get();

                    /* Set some route data */
                    self::$data['link'] = $link;
                }

                /* Check if there is any link available in the database */
                if($link) {
                    self::$controller_key = 'link';
                    self::$controller = 'Link';
                    self::$path = 'l';
                } else {

                    /* Check for a custom domain 404 redirect */
                    if(isset(self::$data['domain']) && self::$data['domain']->custom_not_found_url) {
                        header('Location: ' . self::$data['domain']->custom_not_found_url);
                        die();
                    }

                    else {
                        /* Not found controller */
                        self::$path = '';
                        self::$controller_key = 'notfound';
                    }

                }

            }

        }

        /* Save the current controller */
        self::$controller = self::$routes[self::$path][self::$controller_key]['controller'];

        /* Admin path authentication force check */
        if(self::$path == 'admin' && !isset(self::$routes[self::$path][self::$controller_key]['settings'])) {
            self::$routes[self::$path][self::$controller_key]['settings'] = ['authentication' => 'admin'];
        }

        /* Make sure we also save the controller specific settings */
        if(isset(self::$routes[self::$path][self::$controller_key]['settings'])) {
            self::$controller_settings = array_merge(self::$controller_settings, self::$routes[self::$path][self::$controller_key]['settings']);
        }

        return self::$controller;

    }

    public static function get_controller($controller_ame, $path = '') {

        require_once APP_PATH . 'controllers/' . ($path != '' ? $path . '/' : null) . $controller_ame . '.php';

        /* Create a new instance of the controller */
        $class = 'Altum\\Controllers\\' . $controller_ame;

        /* Instantiate the controller class */
        $controller = new $class;

        return $controller;
    }

    public static function parse_method($controller) {

        $method = self::$method;

        /* Make sure to check the class method if set in the url */
        if(isset(self::get_params()[0]) && method_exists($controller, self::get_params()[0])) {

            /* Make sure the method is not private */
            $reflection = new \ReflectionMethod($controller, self::get_params()[0]);
            if($reflection->isPublic()) {
                $method = self::get_params()[0];

                unset(self::$params[0]);
            }

        }

        return self::$method = $method;

    }

}
