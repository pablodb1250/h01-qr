<?php defined('ALTUMCODE') || die() ?>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-gray-200 <?= \Altum\Routing\Router::$controller_key == 'index' ? null : 'mb-6' ?>">
    <div class="container">
        <a class="navbar-brand" href="<?= url() ?>">
            <?php if(settings()->logo != ''): ?>
                <img src="<?= UPLOADS_FULL_URL . 'logo/' . settings()->logo ?>" class="img-fluid navbar-logo" alt="<?= l('global.accessibility.logo_alt') ?>" />
            <?php else: ?>
                <?= settings()->main->title ?>
            <?php endif ?>
        </a>

        <button class="btn navbar-custom-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#main_navbar" aria-controls="main_navbar" aria-expanded="false" aria-label="<?= l('global.accessibility.toggle_navigation') ?>">
            <i class="fa fa-fw fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="main_navbar">
            <ul class="navbar-nav">

                <?php if(\Altum\Middlewares\Authentication::check() || (!\Altum\Middlewares\Authentication::check() && settings()->plan_guest->status)): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('qr') ?>"><?= l('qr.menu') ?></a></li>
                <?php endif ?>

                <?php foreach($data->pages as $data): ?>
                <li class="nav-item"><a class="nav-link" href="<?= $data->url ?>" target="<?= $data->target ?>"><?= $data->title ?></a></li>
                <?php endforeach ?>

                <?php if(settings()->payment->is_enabled): ?>
                <li class="nav-item"><a class="nav-link" href="<?= url('plan') ?>"> <?= l('plan.menu') ?></a></li>

                    <?php if(\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= url('affiliate') ?>"> <?= l('affiliate.menu') ?></a></li>
                    <?php endif ?>
                <?php endif ?>

                <?php if(\Altum\Middlewares\Authentication::check()): ?>

                    <li class="nav-item"><a class="nav-link font-wi" href="<?= url('dashboard') ?>"> <?= l('dashboard.menu') ?></a></li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                            <img src="<?= get_gravatar($this->user->email, 80, 'identicon') ?>" class="navbar-avatar mr-1" loading="lazy" />
                            <span class="align-middle"><?= $this->user->name ?></span>
                            <span class="align-middle"><i class="fa fa-fw fa-sm fa-caret-down"></i></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <?php if(\Altum\Middlewares\Authentication::is_admin()): ?>
                                <a class="dropdown-item" href="<?= url('admin') ?>"><i class="fa fa-fw fa-sm fa-fingerprint mr-2"></i> <?= l('global.menu.admin') ?></a>
                                <div class="dropdown-divider"></div>
                            <?php endif ?>

                            <a class="dropdown-item" href="<?= url('account') ?>"><i class="fa fa-fw fa-sm fa-wrench mr-2"></i> <?= l('account.menu') ?></a>

                            <a class="dropdown-item" href="<?= url('account-plan') ?>"><i class="fa fa-fw fa-sm fa-box-open mr-2"></i> <?= l('account_plan.menu') ?></a>
                            <?php if(settings()->payment->is_enabled): ?>
                                <a class="dropdown-item" href="<?= url('account-payments') ?>"><i class="fa fa-fw fa-sm fa-dollar-sign mr-2"></i> <?= l('account_payments.menu') ?></a>

                                <?php if(\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled): ?>
                                    <a class="dropdown-item" href="<?= url('referrals') ?>"><i class="fa fa-fw fa-sm fa-wallet mr-2"></i> <?= l('referrals.menu') ?></a>
                                <?php endif ?>
                            <?php endif ?>
                            <a class="dropdown-item" href="<?= url('account-api') ?>"><i class="fa fa-fw fa-sm fa-code mr-2"></i> <?= l('account_api.menu') ?></a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= url('logout') ?>"><i class="fa fa-fw fa-sm fa-sign-out-alt mr-2"></i> <?= l('global.menu.logout') ?></a>
                        </div>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link text-primary" href="<?= url('login') ?>">
                            <i class="fa fa-sign-in-alt fa-fw fa-sm mr-2"></i>
                            <?= l('login.menu') ?>
                        </a>
                    </li>

                    <?php if(settings()->users->register_is_enabled): ?>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="<?= url('register') ?>">
                            <i class="fa fa-user-plus fa-fw fa-sm mr-2"></i>
                            <?= l('register.menu') ?>
                        </a>
                    </li>
                    <?php endif ?>

                <?php endif ?>

            </ul>
        </div>
    </div>
</nav>
