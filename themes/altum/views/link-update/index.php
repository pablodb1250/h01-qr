<?php defined('ALTUMCODE') || die() ?>


<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <nav aria-label="breadcrumb">
        <ol class="custom-breadcrumbs small">
            <li>
                <a href="<?= url('links') ?>"><?= l('links.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
            </li>
            <li class="active" aria-current="page"><?= l('link_update.breadcrumb') ?></li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h4 text-truncate mb-0 mr-2"><?= sprintf(l('link_update.header'), $data->link->url) ?></h1>

        <div class="d-flex align-items-center col-auto p-0">
            <div>
                <button
                        id="url_copy"
                        type="button"
                        class="btn btn-link text-secondary"
                        data-toggle="tooltip"
                        title="<?= l('global.clipboard_copy') ?>"
                        aria-label="<?= l('global.clipboard_copy') ?>"
                        data-copy="<?= l('global.clipboard_copy') ?>"
                        data-copied="<?= l('global.clipboard_copied') ?>"
                        data-clipboard-text="<?= $data->link->full_url ?>"
                >
                    <i class="fa fa-fw fa-sm fa-copy"></i>
                </button>
            </div>

            <?= include_view(THEME_PATH . 'views/links/link_dropdown_button.php', ['id' => $data->link->link_id]) ?>
        </div>
    </div>

    <p>
        <a href="<?= $data->link->full_url ?>" target="_blank">
            <i class="fa fa-fw fa-sm fa-external-link-alt text-muted mr-1"></i> <?= $data->link->full_url ?>
        </a>
    </p>

    <div class="card">
        <div class="card-body">

            <form action="" method="post" role="form" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />

                <div class="form-group">
                    <label for="location_url"><i class="fa fa-fw fa-sm fa-link mr-1"></i> <?= l('links.input.location_url') ?></label>
                    <input type="url" id="location_url" name="location_url" class="form-control <?= \Altum\Alerts::has_field_errors('location_url') ? 'is-invalid' : null ?>" value="<?= $data->link->location_url ?>" maxlength="2048" required="required" />
                    <?= \Altum\Alerts::output_field_error('location_url') ?>
                    <?php if($data->linked_qr_codes): ?>
                        <div><small class="text-warning" role="alert"><i class="fa fa-fw fa-exclamation-triangle mr-1"></i> <?= l('links.input.location_url_warning_linked_qr_code') ?></small></div>
                    <?php endif ?>
                </div>

                <?php if(count($data->domains) && (settings()->links->domains_is_enabled || settings()->links->additional_domains_is_enabled)): ?>
                    <div class="form-group">
                        <label for="domain_id"><i class="fa fa-fw fa-sm fa-globe mr-1"></i> <?= l('links.input.domain_id') ?></label>
                        <select id="domain_id" name="domain_id" class="form-control">
                            <?php if(settings()->links->main_domain_is_enabled || \Altum\Middlewares\Authentication::is_admin()): ?>
                                <option value="" <?= $data->link->domain_id ? null : 'selected="selected"' ?>><?= SITE_URL ?></option>
                            <?php endif ?>

                            <?php foreach($data->domains as $row): ?>
                                <option value="<?= $row->domain_id ?>" data-type="<?= $row->type ?>" <?= $data->link->domain_id && $data->link->domain_id == $row->domain_id ? 'selected="selected"' : null ?>><?= $row->url ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div <?= $this->user->plan_settings->custom_url_is_enabled ? null : 'data-toggle="tooltip" title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
                        <div class="<?= $this->user->plan_settings->custom_url_is_enabled ? null : 'container-disabled' ?>">
                            <div class="form-group">
                                <label for="url"><i class="fa fa-fw fa-sm fa-anchor mr-1"></i> <?= l('links.input.url') ?></label>
                                <input type="text" id="url" name="url" class="form-control <?= \Altum\Alerts::has_field_errors('url') ? 'is-invalid' : null ?>" value="<?= $data->link->url ?>" onchange="update_this_value(this, get_slug)" onkeyup="update_this_value(this, get_slug)" placeholder="<?= l('links.input.url_placeholder') ?>" />
                                <?= \Altum\Alerts::output_field_error('url') ?>
                                <?php if($data->linked_qr_codes): ?>
                                    <div><small class="text-warning" role="alert"><i class="fa fa-fw fa-exclamation-triangle mr-1"></i> <?= l('links.input.url_warning_linked_qr_code') ?></small></div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div <?= $this->user->plan_settings->custom_url_is_enabled ? null : 'data-toggle="tooltip" title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
                        <div class="<?= $this->user->plan_settings->custom_url_is_enabled ? null : 'container-disabled' ?>">
                            <label for="url"><i class="fa fa-fw fa-sm fa-anchor mr-1"></i> <?= l('links.input.url') ?></label>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?= SITE_URL ?></span>
                                    </div>
                                    <input type="text" id="url" name="url" class="form-control <?= \Altum\Alerts::has_field_errors('url') ? 'is-invalid' : null ?>" value="<?= $data->link->url ?>" onchange="update_this_value(this, get_slug)" onkeyup="update_this_value(this, get_slug)" placeholder="<?= l('links.input.url_placeholder') ?>" />
                                    <?= \Altum\Alerts::output_field_error('url') ?>
                                </div>
                                <?php if($data->linked_qr_codes): ?>
                                    <div><small class="text-warning" role="alert"><i class="fa fa-fw fa-exclamation-triangle mr-1"></i> <?= l('links.input.url_warning_linked_qr_code') ?></small></div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <div class="custom-control custom-switch my-3">
                    <input id="is_enabled" name="is_enabled" type="checkbox" class="custom-control-input" <?= $data->link->is_enabled ? 'checked="checked"' : null?>>
                    <label class="custom-control-label" for="is_enabled"><?= l('links.input.is_enabled') ?></label>
                </div>

                <button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#pixels_container" aria-expanded="false" aria-controls="pixels_container">
                    <i class="fa fa-fw fa-adjust fa-sm mr-1"></i> <?= l('links.input.pixels') ?>
                </button>

                <div class="collapse" id="pixels_container">
                    <div class="form-group">
                        <div class="d-flex flex-column flex-xl-row justify-content-between">
                            <label><i class="fa fa-fw fa-sm fa-adjust mr-1"></i> <?= l('links.input.pixels_ids') ?></label>
                            <a href="<?= url('pixel-create') ?>" target="_blank" class="small mb-2"><i class="fa fa-fw fa-sm fa-plus mr-1"></i> <?= l('pixels.create') ?></a>
                        </div>
                        <div class="row">
                            <?php $available_pixels = require APP_PATH . 'includes/l/pixels.php'; ?>
                            <?php foreach($data->pixels as $pixel): ?>
                                <div class="col-12 col-lg-6">
                                    <div class="custom-control custom-checkbox my-2">
                                        <input id="pixel_id_<?= $pixel->pixel_id ?>" name="pixels_ids[]" value="<?= $pixel->pixel_id ?>" type="checkbox" class="custom-control-input" <?= in_array($pixel->pixel_id, $data->link->pixels_ids) ? 'checked="checked"' : null ?>>
                                        <label class="custom-control-label d-flex align-items-center" for="pixel_id_<?= $pixel->pixel_id ?>">
                                            <span class="mr-1"><?= $pixel->name ?></span>
                                            <small class="badge badge-light badge-pill"><?= $available_pixels[$pixel->type]['name'] ?></small>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>

                <button class="btn btn-block btn-gray-200 my-4 <?= \Altum\Alerts::has_field_errors(['expiration_url']) ? 'border-danger' : null ?>" type="button" data-toggle="collapse" data-target="#temporary_url_container" aria-expanded="false" aria-controls="temporary_url_container">
                    <i class="fa fa-fw fa-clock fa-sm mr-1"></i> <?= l('links.input.temporary_url') ?>
                </button>

                <div class="collapse" id="temporary_url_container">
                    <div class="custom-control custom-switch mb-3">
                        <input
                                id="schedule"
                                name="schedule"
                                type="checkbox"
                                class="custom-control-input"
                                <?= !empty($data->link->settings->start_date) && !empty($data->link->settings->end_date) ? 'checked="checked"' : null ?>
                        >
                        <label class="custom-control-label" for="schedule"><?= l('links.input.schedule') ?></label>
                        <small class="form-text text-muted"><?= l('links.input.schedule_help') ?></small>
                    </div>

                    <div id="schedule_container" style="display: none;">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label><i class="fa fa-fw fa-clock fa-sm mr-1"></i> <?= l('links.input.start_date') ?></label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="start_date"
                                            value="<?= \Altum\Date::get($data->link->settings->start_date, 1) ?>"
                                            placeholder="<?= l('links.input.start_date') ?>"
                                            autocomplete="off"
                                            data-daterangepicker
                                    />
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label><i class="fa fa-fw fa-clock fa-sm mr-1"></i> <?= l('links.input.end_date') ?></label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="end_date"
                                            value="<?= \Altum\Date::get($data->link->settings->end_date, 1) ?>"
                                            placeholder="<?= l('links.input.end_date') ?>"
                                            autocomplete="off"
                                            data-daterangepicker
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pageviews_limit"><i class="fa fa-fw fa-mouse fa-sm mr-1"></i> <?= l('links.input.pageviews_limit') ?></label>
                        <input id="pageviews_limit" type="number" class="form-control" name="pageviews_limit" value="<?= $data->link->settings->pageviews_limit ?>" />
                        <small class="form-text text-muted"><?= l('links.input.pageviews_limit_help') ?></small>
                    </div>

                    <div class="form-group">
                        <label for="expiration_url"><i class="fa fa-fw fa-hourglass-end fa-sm mr-1"></i> <?= l('links.input.expiration_url') ?></label>
                        <input id="expiration_url" type="url" class="form-control <?= \Altum\Alerts::has_field_errors('expiration_url') ? 'is-invalid' : null ?>" name="expiration_url" value="<?= $data->link->settings->expiration_url ?>" maxlength="2048" />
                        <?= \Altum\Alerts::output_field_error('expiration_url') ?>
                        <small class="form-text text-muted"><?= l('links.input.expiration_url_help') ?></small>
                    </div>
                </div>

                <button class="btn btn-block btn-gray-200 my-4 <?= \Altum\Alerts::has_field_errors(['targeting_*']) ? 'border-danger' : null ?>" type="button" data-toggle="collapse" data-target="#targeting_container" aria-expanded="false" aria-controls="targeting_container">
                    <i class="fa fa-fw fa-bullseye fa-sm mr-1"></i> <?= l('links.input.targeting') ?>
                </button>

                <div class="collapse" id="targeting_container">
                    <div class="form-group">
                        <label for="targeting_type"><i class="fa fa-fw fa-bullseye fa-sm text-muted mr-1"></i> <?= l('links.input.targeting_type') ?></label>
                        <select id="targeting_type" name="targeting_type" class="form-control">
                            <option value="false" <?= $data->link->settings->targeting_type == 'false' ? 'selected="selected"' : null?>><?= l('links.input.targeting_type_null') ?></option>
                            <option value="country_code" <?= $data->link->settings->targeting_type == 'country_code' ? 'selected="selected"' : null?>><?= l('links.input.targeting_type_country_code') ?></option>
                            <option value="device_type" <?= $data->link->settings->targeting_type == 'device_type' ? 'selected="selected"' : null?>><?= l('links.input.targeting_type_device_type') ?></option>
                            <option value="browser_language" <?= $data->link->settings->targeting_type == 'browser_language' ? 'selected="selected"' : null?>><?= l('links.input.targeting_type_browser_language') ?></option>
                            <option value="rotation" <?= $data->link->settings->targeting_type == 'rotation' ? 'selected="selected"' : null?>><?= l('links.input.targeting_type_rotation') ?></option>
                            <option value="os_name" <?= $data->link->settings->targeting_type == 'os_name' ? 'selected="selected"' : null?>><?= l('links.input.targeting_type_os_name') ?></option>
                        </select>
                    </div>

                    <div data-targeting-type="false" class="d-none"></div>

                    <div data-targeting-type="country_code" class="d-none">
                        <p class="small text-muted"><?= l('links.input.targeting_type_country_code_help') ?></p>

                        <div data-targeting-list="country_code">
                            <?php if(isset($data->link->settings->targeting_country_code) && !empty($data->link->settings->targeting_country_code)): ?>
                                <?php foreach($data->link->settings->targeting_country_code as $key => $targeting): ?>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <select name="targeting_country_code_key[<?= $key ?>]" class="form-control">
                                                <?php foreach(get_countries_array() as $country => $country_name): ?>
                                                    <option value="<?= $country ?>" <?= $targeting->key == $country ? 'selected="selected"' : null ?>><?= $country_name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-5">
                                            <input type="url" name="targeting_country_code_value[<?= $key ?>]" class="form-control <?= \Altum\Alerts::has_field_errors('targeting_country_code_value[' . $key . ']') ? 'is-invalid' : null ?>" value="<?= $targeting->value ?>" maxlength="2048" placeholder="" />
                                            <?= \Altum\Alerts::output_field_error('targeting_country_code_value[' . $key . ']') ?>
                                        </div>

                                        <div class="form-group col-lg-1 text-center">
                                            <button type="button" data-targeting-remove="" class="btn btn-outline-danger" title="<?= l('global.delete') ?>"><i class="fa fa-fw fa-times"></i></button>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <button data-targeting-add="country_code" type="button" class="btn btn-sm btn-outline-success"><i class="fa fa-fw fa-plus-circle"></i> <?= l('global.create') ?></button>
                        </div>
                    </div>

                    <div data-targeting-type="device_type" class="d-none">
                        <p class="small text-muted"><?= l('links.input.targeting_type_device_type_help') ?></p>

                        <div data-targeting-list="device_type">
                            <?php if(isset($data->link->settings->targeting_device_type) && !empty($data->link->settings->targeting_device_type)): ?>
                                <?php foreach($data->link->settings->targeting_device_type as $key => $targeting): ?>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <select name="targeting_device_type_key[<?= $key ?>]" class="form-control">
                                                <?php foreach(['desktop', 'tablet', 'mobile'] as $device_type): ?>
                                                    <option value="<?= $device_type ?>" <?= $targeting->key == $device_type ? 'selected="selected"' : null ?>><?= $device_type ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-5">
                                            <input type="url" name="targeting_device_type_value[<?= $key ?>]" class="form-control <?= \Altum\Alerts::has_field_errors('targeting_device_type_value[' . $key . ']') ? 'is-invalid' : null ?>" value="<?= $targeting->value ?>" maxlength="2048" placeholder="" />
                                            <?= \Altum\Alerts::output_field_error('targeting_device_type_value[' . $key . ']') ?>
                                        </div>

                                        <div class="form-group col-lg-1 text-center">
                                            <button type="button" data-targeting-remove="" class="btn btn-outline-danger" title="<?= l('global.delete') ?>"><i class="fa fa-fw fa-times"></i></button>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <button data-targeting-add="device_type" type="button" class="btn btn-sm btn-outline-success"><i class="fa fa-fw fa-plus-circle"></i> <?= l('global.create') ?></button>
                        </div>
                    </div>

                    <div data-targeting-type="browser_language" class="d-none">
                        <p class="small text-muted"><?= l('links.input.targeting_type_browser_language_help') ?></p>

                        <div data-targeting-list="browser_language">
                            <?php if(isset($data->link->settings->targeting_browser_language) && !empty($data->link->settings->targeting_browser_language)): ?>
                                <?php foreach($data->link->settings->targeting_browser_language as $key => $targeting): ?>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <select name="targeting_browser_language_key[<?= $key ?>]" class="form-control">
                                                <?php foreach(get_locale_languages_array() as $locale => $language): ?>
                                                    <option value="<?= $locale ?>" <?= $targeting->key == $locale ? 'selected="selected"' : null ?>><?= $language ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-5">
                                            <input type="url" name="targeting_browser_language_value[<?= $key ?>]" class="form-control <?= \Altum\Alerts::has_field_errors('targeting_browser_language_value[' . $key . ']') ? 'is-invalid' : null ?>" value="<?= $targeting->value ?>" maxlength="2048" placeholder="" />
                                            <?= \Altum\Alerts::output_field_error('targeting_browser_language_value[' . $key . ']') ?>
                                        </div>

                                        <div class="form-group col-lg-1 text-center">
                                            <button type="button" data-targeting-remove="" class="btn btn-outline-danger" title="<?= l('global.delete') ?>"><i class="fa fa-fw fa-times"></i></button>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <button data-targeting-add="browser_language" type="button" class="btn btn-sm btn-outline-success"><i class="fa fa-fw fa-plus-circle"></i> <?= l('global.create') ?></button>
                        </div>
                    </div>

                    <div data-targeting-type="rotation" class="d-none">
                        <p class="small text-muted"><?= l('links.input.targeting_type_rotation_help') ?></p>

                        <div data-targeting-list="rotation">
                            <?php if(isset($data->link->settings->targeting_rotation) && !empty($data->link->settings->targeting_rotation)): ?>
                                <?php foreach($data->link->settings->targeting_rotation as $key => $targeting): ?>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <input type="number" min="0" max="100" name="targeting_rotation_key[<?= $key ?>]" class="form-control" value="<?= $targeting->key ?>" placeholder="<?= l('links.input.targeting_type_percentage') ?>" />
                                        </div>

                                        <div class="form-group col-lg-5">
                                            <input type="url" name="targeting_rotation_value[<?= $key ?>]" class="form-control <?= \Altum\Alerts::has_field_errors('targeting_rotation_value[' . $key . ']') ? 'is-invalid' : null ?>" value="<?= $targeting->value ?>" maxlength="2048" placeholder="" />
                                            <?= \Altum\Alerts::output_field_error('targeting_rotation_value[' . $key . ']') ?>
                                        </div>

                                        <div class="form-group col-lg-1 text-center">
                                            <button type="button" data-targeting-remove="" class="btn btn-outline-danger" title="<?= l('global.delete') ?>"><i class="fa fa-fw fa-times"></i></button>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <button data-targeting-add="rotation" type="button" class="btn btn-sm btn-outline-success"><i class="fa fa-fw fa-plus-circle"></i> <?= l('global.create') ?></button>
                        </div>
                    </div>

                    <div data-targeting-type="os_name" class="d-none">
                        <p class="small text-muted"><?= l('links.input.targeting_type_os_name_help') ?></p>

                        <div data-targeting-list="os_name">
                            <?php if(isset($data->link->settings->targeting_os_name) && !empty($data->link->settings->targeting_os_name)): ?>
                                <?php foreach($data->link->settings->targeting_os_name as $key => $targeting): ?>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <select name="targeting_os_name_key[<?= $key ?>]" class="form-control">
                                                <?php foreach(['iOS', 'Android', 'Windows', 'OS X', 'Linux', 'Ubuntu', 'Chrome OS'] as $os_name): ?>
                                                    <option value="<?= $os_name ?>" <?= $targeting->key == $os_name ? 'selected="selected"' : null ?>><?= $os_name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-5">
                                            <input type="url" name="targeting_os_name_value[<?= $key ?>]" class="form-control <?= \Altum\Alerts::has_field_errors('targeting_os_name_value[' . $key . ']') ? 'is-invalid' : null ?>" value="<?= $targeting->value ?>" maxlength="2048" placeholder="" />
                                            <?= \Altum\Alerts::output_field_error('targeting_os_name_value[' . $key . ']') ?>
                                        </div>

                                        <div class="form-group col-lg-1 text-center">
                                            <button type="button" data-targeting-remove="" class="btn btn-outline-danger" title="<?= l('global.delete') ?>"><i class="fa fa-fw fa-times"></i></button>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <button data-targeting-add="os_name" type="button" class="btn btn-sm btn-outline-success"><i class="fa fa-fw fa-plus-circle"></i> <?= l('global.create') ?></button>
                        </div>
                    </div>

                </div>

                <button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#advanced_container" aria-expanded="false" aria-controls="advanced_container">
                    <i class="fa fa-fw fa-user-tie fa-sm mr-1"></i> <?= l('links.input.advanced') ?>
                </button>

                <div class="collapse" id="advanced_container">
                    <div class="form-group">
                        <div class="d-flex flex-column flex-xl-row justify-content-between">
                            <label for="project_id"><i class="fa fa-fw fa-sm fa-project-diagram mr-1"></i> <?= l('projects.project_id') ?></label>
                            <a href="<?= url('project-create') ?>" target="_blank" class="small mb-2"><i class="fa fa-fw fa-sm fa-plus mr-1"></i> <?= l('projects.create') ?></a>
                        </div>
                        <select id="project_id" name="project_id" class="form-control">
                            <option value=""><?= l('projects.project_id_null') ?></option>
                            <?php foreach($data->projects as $project_id => $project): ?>
                                <option value="<?= $project_id ?>" <?= $data->link->project_id == $project_id ? 'selected="selected"' : null ?>><?= $project->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <small class="form-text text-muted"><?= l('projects.project_id_help') ?></small>
                    </div>

                    <div <?= $this->user->plan_settings->password_protection_is_enabled ? null : 'data-toggle="tooltip" title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
                        <div class="form-group <?= $this->user->plan_settings->password_protection_is_enabled ? null : 'container-disabled' ?>">
                            <label for="password"><i class="fa fa-fw fa-sm fa-lock mr-1"></i> <?= l('links.input.password') ?></label>
                            <input type="password" id="password" name="password" class="form-control" value="<?= $data->link->password ?>" autocomplete="new-password" />
                        </div>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary mt-4"><?= l('global.update') ?></button>
            </form>

        </div>
    </div>
</div>

<template id="template_targeting_country_code">
    <div class="form-row">
        <div class="form-group col-lg-6">
            <select name="targeting_country_code_key[]" class="form-control">
                <?php foreach(get_countries_array() as $country => $country_name): ?>
                    <option value="<?= $country ?>"><?= $country_name ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group col-lg-5">
            <input type="url" name="targeting_country_code_value[]" class="form-control" value="" maxlength="2048" placeholder="" />
        </div>

        <div class="form-group col-lg-1 text-center">
            <button type="button" data-targeting-remove="" class="btn btn-outline-danger" title="<?= l('global.delete') ?>"><i class="fa fa-fw fa-times"></i></button>
        </div>
    </div>
</template>

<template id="template_targeting_device_type">
    <div class="form-row">
        <div class="form-group col-lg-6">
            <select name="targeting_device_type_key[]" class="form-control">
                <?php foreach(['desktop', 'tablet', 'mobile'] as $device_type): ?>
                    <option value="<?= $device_type ?>"><?= $device_type ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group col-lg-5">
            <input type="url" name="targeting_device_type_value[]" class="form-control" value="" maxlength="2048" placeholder="" />
        </div>

        <div class="form-group col-lg-1 text-center">
            <button type="button" data-targeting-remove="" class="btn btn-outline-danger" title="<?= l('global.delete') ?>"><i class="fa fa-fw fa-times"></i></button>
        </div>
    </div>
</template>

<template id="template_targeting_browser_language">
    <div class="form-row">
        <div class="form-group col-lg-6">
            <select name="targeting_browser_language_key[]" class="form-control">
                <?php foreach(get_locale_languages_array() as $locale => $language): ?>
                    <option value="<?= $locale ?>"><?= $language ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group col-lg-5">
            <input type="url" name="targeting_browser_language_value[]" class="form-control" value="" maxlength="2048" placeholder="" />
        </div>

        <div class="form-group col-lg-1 text-center">
            <button type="button" data-targeting-remove="" class="btn btn-outline-danger" title="<?= l('global.delete') ?>"><i class="fa fa-fw fa-times"></i></button>
        </div>
    </div>
</template>

<template id="template_targeting_rotation">
    <div class="form-row">
        <div class="form-group col-lg-6">
            <input type="number" min="0" max="100" name="targeting_rotation_key[]" class="form-control" value="" placeholder="<?= l('link.settings.targeting_type_percentage') ?>" />
        </div>

        <div class="form-group col-lg-5">
            <input type="url" name="targeting_rotation_value[]" class="form-control" value="" maxlength="2048" placeholder="" />
        </div>

        <div class="form-group col-lg-1 text-center">
            <button type="button" data-targeting-remove="" class="btn btn-outline-danger" title="<?= l('global.delete') ?>"><i class="fa fa-fw fa-times"></i></button>
        </div>
    </div>
</template>

<template id="template_targeting_os_name">
    <div class="form-row">
        <div class="form-group col-lg-6">
            <select name="targeting_os_name_key[]" class="form-control">
                <?php foreach(['iOS', 'Android', 'Windows', 'OS X', 'Linux', 'Ubuntu', 'Chrome OS'] as $os_name): ?>
                    <option value="<?= $os_name ?>"><?= $os_name ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group col-lg-5">
            <input type="url" name="targeting_os_name_value[]" class="form-control" value="" maxlength="2048" placeholder="" />
        </div>

        <div class="form-group col-lg-1 text-center">
            <button type="button" data-targeting-remove="" class="btn btn-outline-danger" title="<?= l('global.delete') ?>"><i class="fa fa-fw fa-times"></i></button>
        </div>
    </div>
</template>

<?php include_view(THEME_PATH . 'views/partials/clipboard_js.php') ?>

<?php ob_start() ?>
<link href="<?= ASSETS_FULL_URL . 'css/daterangepicker.min.css' ?>" rel="stylesheet" media="screen,print">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

<?php ob_start() ?>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/daterangepicker.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment-timezone-with-data-10-year-range.min.js' ?>"></script>

<script>
    'use strict';

    /* Targeting */
    let targeting_type_handler = () => {
        let targeting_type = document.querySelector('#targeting_type').value;

        document.querySelectorAll('[data-targeting-type]').forEach(element => {
            let element_targeting_type = element.getAttribute('data-targeting-type');

            if(element_targeting_type == targeting_type) {
                document.querySelector(`[data-targeting-type="${element_targeting_type}"]`).classList.remove('d-none');
            } else {
                document.querySelector(`[data-targeting-type="${element_targeting_type}"]`).classList.add('d-none');
            }
        })
    }

    targeting_type_handler();
    document.querySelector('#targeting_type').addEventListener('change', targeting_type_handler);

    /* add new request header */
    let targeting_add = event => {
        let type = event.currentTarget.getAttribute('data-targeting-add');

        let clone = document.querySelector(`#template_targeting_${type}`).content.cloneNode(true);

        let request_headers_count = document.querySelectorAll(`[data-targeting-list="${type}"] .form-row`).length;

        clone.querySelector(`[name="targeting_${type}_key[]"`).setAttribute('name', `targeting_${type}_key[${request_headers_count}]`);
        clone.querySelector(`[name="targeting_${type}_value[]"`).setAttribute('name', `targeting_${type}_value[${request_headers_count}]`);

        document.querySelector(`[data-targeting-list="${type}"]`).appendChild(clone);

        targeting_remove_initiator();
    };

    document.querySelectorAll('[data-targeting-add]').forEach(element => {
        element.addEventListener('click', targeting_add);
    })

    /* remove request header */
    let targeting_remove = event => {
        event.currentTarget.closest('.form-row').remove();
    };

    let targeting_remove_initiator = () => {
        document.querySelectorAll('[data-targeting-remove]').forEach(element => {
            element.removeEventListener('click', targeting_remove);
            element.addEventListener('click', targeting_remove)
        })
    };

    targeting_remove_initiator();


    /* Settings Tab */
    let schedule_handler = () => {
        if($('#schedule').is(':checked')) {
            $('#schedule_container').show();
        } else {
            $('#schedule_container').hide();
        }
    };

    $('#schedule').on('change', schedule_handler);

    schedule_handler();

    /* Daterangepicker */
    let locale = <?= json_encode(require APP_PATH . 'includes/daterangepicker_translations.php') ?>;
    $('[data-daterangepicker]').daterangepicker({
        minDate: new Date(),
        alwaysShowCalendars: true,
        singleCalendar: true,
        singleDatePicker: true,
        locale: {...locale, format: 'YYYY-MM-DD HH:mm:ss'},
        timePicker: true,
        timePicker24Hour: true,
        timePickerSeconds: true,
    }, (start, end, label) => {
    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/links/link_delete_modal.php'), 'modals'); ?>
