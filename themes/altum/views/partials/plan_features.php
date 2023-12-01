<?php defined('ALTUMCODE') || die() ?>

<ul class="list-style-none m-0">

    <?php $enabled_qr_codes = array_filter((array) $data->plan_settings->enabled_qr_codes) ?>
    <?php $enabled_qr_codes_count = count($enabled_qr_codes) ?>
    <?php
    $enabled_qr_codes_string = implode(', ', array_map(function($key) {
        return l('qr_codes.type.' . mb_strtolower($key));
    }, array_keys($enabled_qr_codes)));
    ?>

    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $enabled_qr_codes_count ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $enabled_qr_codes_count ? null : 'text-muted' ?>">
            <?= sprintf(l('global.plan_settings.enabled_qr_codes'), '<strong>' . nr($enabled_qr_codes_count) . '</strong>') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= $enabled_qr_codes_string ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>
    </li>

    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->qr_codes_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->qr_codes_limit ? null : 'text-muted' ?>">
            <?= sprintf(l('global.plan_settings.qr_codes_limit'), '<strong>' . ($data->plan_settings->qr_codes_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->qr_codes_limit)) . '</strong>') ?>
        </div>
    </li>

    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->projects_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->projects_limit ? null : 'text-muted' ?>">
            <?= sprintf(l('global.plan_settings.projects_limit'), '<strong>' . ($data->plan_settings->projects_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->projects_limit)) . '</strong>') ?>
        </div>
    </li>

    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->pixels_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->pixels_limit ? null : 'text-muted' ?>">
            <?= sprintf(l('global.plan_settings.pixels_limit'), '<strong>' . ($data->plan_settings->pixels_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->pixels_limit)) . '</strong>') ?>
        </div>
    </li>

    <?php if(settings()->links->domains_is_enabled): ?>
    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->domains_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->domains_limit ? null : 'text-muted' ?>">
            <?= sprintf(l('global.plan_settings.domains_limit'), '<strong>' . ($data->plan_settings->domains_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->domains_limit)) . '</strong>') ?>
        </div>
    </li>
    <?php endif ?>

    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->statistics_retention ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->statistics_retention ? null : 'text-muted' ?>">
            <?= sprintf(l('global.plan_settings.statistics_retention'), '<strong>' . ($data->plan_settings->statistics_retention == -1 ? l('global.unlimited') : nr($data->plan_settings->statistics_retention)) . '</strong>') ?>
        </div>
    </li>

    <?php if(settings()->links->additional_domains_is_enabled): ?>
    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->additional_domains_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->additional_domains_is_enabled ? null : 'text-muted' ?>">
            <?= l('global.plan_settings.additional_domains_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.additional_domains_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>
    </li>
    <?php endif ?>

    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->analytics_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->analytics_is_enabled ? null : 'text-muted' ?>">
            <?= l('global.plan_settings.analytics_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.analytics_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>
    </li>

    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->password_protection_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->password_protection_is_enabled ? null : 'text-muted' ?>">
            <?= l('global.plan_settings.password_protection_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.password_protection_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>
    </li>

    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->custom_url_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->custom_url_is_enabled ? null : 'text-muted' ?>">
            <?= l('global.plan_settings.custom_url_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.custom_url_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>
    </li>

    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->api_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->api_is_enabled ? null : 'text-muted' ?>">
            <?= l('global.plan_settings.api_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.api_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>
    </li>

    <?php if(\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled): ?>
    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->affiliate_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->affiliate_is_enabled ? null : 'text-muted' ?>">
            <?= l('global.plan_settings.affiliate_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.affiliate_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>
    </li>
    <?php endif ?>

    <li class="d-flex align-items-baseline mb-2">
        <i class="fa fa-fw fa-sm mr-3 <?= $data->plan_settings->no_ads ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        <div class="<?= $data->plan_settings->no_ads ? null : 'text-muted' ?>">
            <?= l('global.plan_settings.no_ads') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.no_ads_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>
    </li>
</ul>
