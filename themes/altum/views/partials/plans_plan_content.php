<?php defined('ALTUMCODE') || die() ?>

<div class="">
    <?php $enabled_qr_codes = array_filter((array) $data->plan_settings->enabled_qr_codes) ?>
    <?php $enabled_qr_codes_count = count($enabled_qr_codes) ?>
    <?php
    $enabled_qr_codes_string = implode(', ', array_map(function($key) {
        return l('qr_codes.type.' . mb_strtolower($key));
    }, array_keys($enabled_qr_codes)));
    ?>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.plan_settings.enabled_qr_codes'), '<strong>' . nr($enabled_qr_codes_count) . '</strong>') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= $enabled_qr_codes_string ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $enabled_qr_codes_count ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.plan_settings.qr_codes_limit'), '<strong>' . ($data->plan_settings->qr_codes_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->qr_codes_limit)) . '</strong>') ?>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->plan_settings->qr_codes_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.plan_settings.projects_limit'), '<strong>' . ($data->plan_settings->projects_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->projects_limit)) . '</strong>') ?>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->plan_settings->projects_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.plan_settings.pixels_limit'), '<strong>' . ($data->plan_settings->pixels_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->pixels_limit)) . '</strong>') ?>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->plan_settings->pixels_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <?php if(settings()->links->domains_is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.domains_limit'), '<strong>' . ($data->plan_settings->domains_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->domains_limit)) . '</strong>') ?>
            </div>

            <i class="fa fa-fw fa-sm <?= $data->plan_settings->domains_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.plan_settings.statistics_retention'), '<strong>' . ($data->plan_settings->statistics_retention == -1 ? l('global.unlimited') : nr($data->plan_settings->statistics_retention)) . '</strong>') ?>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->plan_settings->statistics_retention ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <?php if(settings()->links->additional_domains_is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->additional_domains_is_enabled ? null : 'text-muted' ?>">
            <div>
                <?= l('global.plan_settings.additional_domains_is_enabled') ?>
                <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.additional_domains_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
            </div>

            <i class="fa fa-fw fa-sm <?= $data->plan_settings->additional_domains_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->analytics_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.plan_settings.analytics_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.analytics_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->plan_settings->analytics_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->password_protection_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.plan_settings.password_protection_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.password_protection_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->plan_settings->password_protection_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->custom_url_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.plan_settings.custom_url_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.custom_url_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->plan_settings->custom_url_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->api_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.plan_settings.api_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.api_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->plan_settings->api_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <?php if(\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled): ?>
    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->affiliate_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.plan_settings.affiliate_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.affiliate_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->plan_settings->affiliate_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>
    <?php endif ?>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->no_ads ? null : 'text-muted' ?>">
        <div>
            <?= l('global.plan_settings.no_ads') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.plan_settings.no_ads_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->plan_settings->no_ads ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>
</div>
