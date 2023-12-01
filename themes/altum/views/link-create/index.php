<?php defined('ALTUMCODE') || die() ?>


<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <nav aria-label="breadcrumb">
        <ol class="custom-breadcrumbs small">
            <li>
                <a href="<?= url('links') ?>"><?= l('links.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
            </li>
            <li class="active" aria-current="page"><?= l('link_create.breadcrumb') ?></li>
        </ol>
    </nav>

    <h1 class="h4 text-truncate"><?= l('link_create.header') ?></h1>
    <p></p>

    <div class="card">
        <div class="card-body">

            <form action="" method="post" role="form">
                <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />

                <div class="form-group">
                    <label for="location_url"><i class="fa fa-fw fa-sm fa-link mr-1"></i> <?= l('links.input.location_url') ?></label>
                    <input type="url" id="location_url" name="location_url" class="form-control <?= \Altum\Alerts::has_field_errors('location_url') ? 'is-invalid' : null ?>" value="<?= $data->values['location_url'] ?>" maxlength="2048" required="required" />
                    <?= \Altum\Alerts::output_field_error('location_url') ?>
                </div>

                <?php if(count($data->domains) && (settings()->links->domains_is_enabled || settings()->links->additional_domains_is_enabled)): ?>
                    <div class="form-group">
                        <label for="domain_id"><i class="fa fa-fw fa-sm fa-globe mr-1"></i> <?= l('links.input.domain_id') ?></label>
                        <select id="domain_id" name="domain_id" class="form-control">
                            <?php if(settings()->links->main_domain_is_enabled || \Altum\Middlewares\Authentication::is_admin()): ?>
                                <option value=""><?= SITE_URL ?></option>
                            <?php endif ?>

                            <?php foreach($data->domains as $row): ?>
                                <option value="<?= $row->domain_id ?>" data-type="<?= $row->type ?>" <?= $data->values['domain_id'] && $data->values['domain_id'] == $row->domain_id ? 'selected="selected"' : null ?>><?= $row->url ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div <?= $this->user->plan_settings->custom_url_is_enabled ? null : 'data-toggle="tooltip" title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
                        <div class="<?= $this->user->plan_settings->custom_url_is_enabled ? null : 'container-disabled' ?>">
                            <div class="form-group">
                                <label for="url"><i class="fa fa-fw fa-sm fa-anchor mr-1"></i> <?= l('links.input.url') ?></label>
                                <input type="text" id="url" name="url" class="form-control <?= \Altum\Alerts::has_field_errors('url') ? 'is-invalid' : null ?>" value="<?= $data->values['url'] ?>" onchange="update_this_value(this, get_slug)" onkeyup="update_this_value(this, get_slug)" placeholder="<?= l('links.input.url_placeholder') ?>" />
                                <?= \Altum\Alerts::output_field_error('url') ?>
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
                                    <input type="text" id="url" name="url" class="form-control <?= \Altum\Alerts::has_field_errors('url') ? 'is-invalid' : null ?>" value="<?= $data->values['url'] ?>" onchange="update_this_value(this, get_slug)" onkeyup="update_this_value(this, get_slug)" placeholder="<?= l('links.input.url_placeholder') ?>" />
                                    <?= \Altum\Alerts::output_field_error('url') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <p><small class="form-text text-muted"><i class="fa fa-fw fa-sm fa-info-circle"></i> <?= l('link_create.info') ?></small></p>

                <button type="submit" name="submit" class="btn btn-block btn-primary mt-4"><?= l('global.create') ?></button>
            </form>

        </div>
    </div>
</div>


<?php ob_start() ?>
<script>
    'use strict';
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
