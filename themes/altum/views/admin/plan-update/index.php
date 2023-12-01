<?php defined('ALTUMCODE') || die() ?>

<nav aria-label="breadcrumb">
    <ol class="custom-breadcrumbs small">
        <li>
            <a href="<?= url('admin/plans') ?>"><?= l('admin_plans.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
        </li>
        <li class="active" aria-current="page"><?= l('admin_plan_update.breadcrumb') ?></li>
    </ol>
</nav>

<div class="d-flex justify-content-between mb-4">
    <h1 class="h3 mb-0 text-truncate"><i class="fa fa-fw fa-xs fa-box-open text-primary-900 mr-2"></i> <?= sprintf(l('admin_plan_update.header'), $data->plan->name) ?></h1>

    <?= include_view(THEME_PATH . 'views/admin/plans/admin_plan_dropdown_button.php', ['id' => $data->plan->plan_id]) ?>
</div>

<?= \Altum\Alerts::output_alerts() ?>

<div class="card">
    <div class="card-body">

        <form action="" method="post" role="form">
            <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
            <input type="hidden" name="type" value="update" />

            <div class="form-group">
                <label for="name"><?= l('admin_plans.main.name') ?></label>
                <input type="text" id="name" name="name" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('name') ? 'is-invalid' : null ?>" value="<?= $data->plan->name ?>" required="required" />
                <?= \Altum\Alerts::output_field_error('name') ?>
            </div>

            <div class="form-group">
                <label for="description"><?= l('admin_plans.main.description') ?></label>
                <input type="text" id="description" name="description" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('description') ? 'is-invalid' : null ?>" value="<?= $data->plan->description ?>" />
                <?= \Altum\Alerts::output_field_error('description') ?>
            </div>

            <?php if(in_array($data->plan_id, ['guest', 'free', 'custom'])): ?>
                <div class="form-group">
                    <label for="price"><?= l('admin_plans.main.price') ?></label>
                    <input type="text" id="price" name="price" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('price') ? 'is-invalid' : null ?>" value="<?= $data->plan->price ?>" required="required" />
                    <?= \Altum\Alerts::output_field_error('price') ?>
                </div>
            <?php endif ?>

            <?php if($data->plan_id == 'custom'): ?>
                <div class="form-group">
                    <label for="custom_button_url"><?= l('admin_plans.main.custom_button_url') ?></label>
                    <input type="text" id="custom_button_url" name="custom_button_url" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('custom_button_url') ? 'is-invalid' : null ?>" value="<?= $data->plan->custom_button_url ?>" required="required" />
                    <?= \Altum\Alerts::output_field_error('custom_button_url') ?>
                </div>
            <?php endif ?>

            <?php if(is_numeric($data->plan_id)): ?>
                <div class="form-group">
                    <label for="order"><?= l('admin_plans.main.order') ?></label>
                    <input id="order" type="number" min="0"  name="order" class="form-control form-control-lg" value="<?= $data->plan->order ?>" />
                </div>

                <div class="form-group">
                    <label for="trial_days"><?= l('admin_plans.main.trial_days') ?></label>
                    <input id="trial_days" type="number" min="0" name="trial_days" class="form-control form-control-lg" value="<?= $data->plan->trial_days ?>" />
                    <div><small class="form-text text-muted"><?= l('admin_plans.main.trial_days_help') ?></small></div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="monthly_price"><?= l('admin_plans.main.monthly_price') ?> <small class="form-text text-muted"><?= settings()->payment->currency ?></small></label>
                                <input type="text" id="monthly_price" name="monthly_price" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('monthly_price') ? 'is-invalid' : null ?>" value="<?= $data->plan->monthly_price ?>" required="required" />
                                <?= \Altum\Alerts::output_field_error('monthly_price') ?>
                                <small class="form-text text-muted"><?= sprintf(l('admin_plans.main.price_help'), l('admin_plans.main.monthly_price')) ?></small>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group">
                            <label for="annual_price"><?= l('admin_plans.main.annual_price') ?> <small class="form-text text-muted"><?= settings()->payment->currency ?></small></label>
                            <input type="text" id="annual_price" name="annual_price" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('annual_price') ? 'is-invalid' : null ?>" value="<?= $data->plan->annual_price ?>" required="required" />
                            <?= \Altum\Alerts::output_field_error('annual_price') ?>
                            <small class="form-text text-muted"><?= sprintf(l('admin_plans.main.price_help'), l('admin_plans.main.annual_price')) ?></small>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group">
                            <label for="lifetime_price"><?= l('admin_plans.main.lifetime_price') ?> <small class="form-text text-muted"><?= settings()->payment->currency ?></small></label>
                            <input type="text" id="lifetime_price" name="lifetime_price" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('lifetime_price') ? 'is-invalid' : null ?>" value="<?= $data->plan->lifetime_price ?>" required="required" />
                            <?= \Altum\Alerts::output_field_error('lifetime_price') ?>
                            <small class="form-text text-muted"><?= sprintf(l('admin_plans.main.price_help'), l('admin_plans.main.lifetime_price')) ?></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="taxes_ids"><?= l('admin_plans.main.taxes_ids') ?></label>
                    <select id="taxes_ids" name="taxes_ids[]" class="form-control form-control-lg" multiple="multiple">
                        <?php if($data->taxes): ?>
                            <?php foreach($data->taxes as $tax): ?>
                                <option value="<?= $tax->tax_id ?>" <?= in_array($tax->tax_id, $data->plan->taxes_ids)  ? 'selected="selected"' : null ?>>
                                    <?= $tax->name . ' - ' . $tax->description ?>
                                </option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                    <small class="form-text text-muted"><?= sprintf(l('admin_plans.main.taxes_ids_help'), '<a href="' . url('admin/taxes') .'">', '</a>') ?></small>
                </div>

                <div class="form-group">
                    <label for="codes_ids"><?= l('admin_plans.main.codes_ids') ?></label>
                    <select id="codes_ids" name="codes_ids[]" class="form-control form-control-lg" multiple="multiple">
                        <?php if($data->codes): ?>
                            <?php foreach($data->codes as $code): ?>
                                <option value="<?= $code->code_id ?>" <?= in_array($code->code_id, $data->plan->codes_ids)  ? 'selected="selected"' : null ?>>
                                    <?= $code->name . ' - ' . $code->code ?>
                                </option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                    <small class="form-text text-muted"><?= sprintf(l('admin_plans.main.codes_ids_help'), '<a href="' . url('admin/codes') .'">', '</a>') ?></small>
                </div>

            <?php endif ?>

            <div class="form-group">
                <label for="color"><?= l('admin_plans.main.color') ?></label>
                <input type="text" id="color" name="color" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('color') ? 'is-invalid' : null ?>" value="<?= $data->plan->color ?>" />
                <?= \Altum\Alerts::output_field_error('color') ?>
                <small class="form-text text-muted"><?= l('admin_plans.main.color_help') ?></small>
            </div>

            <div class="form-group">
                <label for="status"><?= l('admin_plans.main.status') ?></label>
                <select id="status" name="status" class="form-control form-control-lg">
                    <option value="1" <?= $data->plan->status == 1 ? 'selected="selected"' : null ?>><?= l('global.active') ?></option>
                    <option value="0" <?= $data->plan->status == 0 ? 'selected="selected"' : null ?> <?= $data->plan->plan_id == 'custom' ? 'disabled="disabled"' : null ?>><?= l('global.disabled') ?></option>
                    <option value="2" <?= $data->plan->status == 2 ? 'selected="selected"' : null ?>><?= l('global.hidden') ?></option>
                </select>
            </div>

            <div class="mt-5"></div>

            <h2 class="h4"><?= l('admin_plans.plan.header') ?></h2>

            <div>
                <div class="form-group">
                    <label for="qr_codes_limit"><?= l('admin_plans.plan.qr_codes_limit') ?></label>
                    <input type="number" id="qr_codes_limit" name="qr_codes_limit" min="-1" class="form-control form-control-lg" value="<?= $data->plan->settings->qr_codes_limit ?>" <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?> />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.qr_codes_limit_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="links_limit"><?= l('admin_plans.plan.links_limit') ?></label>
                    <input type="number" id="links_limit" name="links_limit" min="-1" class="form-control form-control-lg" value="<?= $data->plan->settings->links_limit ?>" <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?> />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.links_limit_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="projects_limit"><?= l('admin_plans.plan.projects_limit') ?></label>
                    <input type="number" id="projects_limit" name="projects_limit" min="-1" class="form-control form-control-lg" value="<?= $data->plan->settings->projects_limit ?>" <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?> />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.projects_limit_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="pixels_limit"><?= l('admin_plans.plan.pixels_limit') ?></label>
                    <input type="number" id="pixels_limit" name="pixels_limit" min="-1" class="form-control form-control-lg" value="<?= $data->plan->settings->pixels_limit ?>" <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?> />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.pixels_limit_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="domains_limit"><?= l('admin_plans.plan.domains_limit') ?></label>
                    <input type="number" id="domains_limit" name="domains_limit" min="-1" class="form-control form-control-lg" value="<?= $data->plan->settings->domains_limit ?>" <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?> />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.domains_limit_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="statistics_retention"><?= l('admin_plans.plan.statistics_retention') ?> <small class="form-text text-muted"><?= l('global.date.days') ?></small></label>
                    <input type="number" id="statistics_retention" name="statistics_retention" min="-1" class="form-control form-control-lg" value="<?= $data->plan->settings->statistics_retention ?>" <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?> />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.statistics_retention_help') ?></small>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="additional_domains_is_enabled" name="additional_domains_is_enabled" type="checkbox" class="custom-control-input" <?= $data->plan->settings->additional_domains_is_enabled ? 'checked="checked"' : null ?> <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?>>
                    <label class="custom-control-label" for="additional_domains_is_enabled"><?= l('admin_plans.plan.additional_domains_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.additional_domains_is_enabled_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="no_ads" name="no_ads" type="checkbox" class="custom-control-input" <?= $data->plan->settings->no_ads ? 'checked="checked"' : null ?>>
                    <label class="custom-control-label" for="no_ads"><?= l('admin_plans.plan.no_ads') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.no_ads_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="analytics_is_enabled" name="analytics_is_enabled" type="checkbox" class="custom-control-input" <?= $data->plan->settings->analytics_is_enabled ? 'checked="checked"' : null ?> <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?>>
                    <label class="custom-control-label" for="analytics_is_enabled"><?= l('admin_plans.plan.analytics_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.analytics_is_enabled_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="custom_url_is_enabled" name="custom_url_is_enabled" type="checkbox" class="custom-control-input" <?= $data->plan->settings->custom_url_is_enabled ? 'checked="checked"' : null ?> <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?>>
                    <label class="custom-control-label" for="custom_url_is_enabled"><?= l('admin_plans.plan.custom_url_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.custom_url_is_enabled_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="password_protection_is_enabled" name="password_protection_is_enabled" type="checkbox" class="custom-control-input" <?= $data->plan->settings->password_protection_is_enabled ? 'checked="checked"' : null ?> <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?>>
                    <label class="custom-control-label" for="password_protection_is_enabled"><?= l('admin_plans.plan.password_protection_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.password_protection_is_enabled_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch mb-3">
                    <input id="api_is_enabled" name="api_is_enabled" type="checkbox" class="custom-control-input" <?= $data->plan->settings->api_is_enabled ? 'checked="checked"' : null ?> <?= $data->plan_id == 'guest' ? 'disabled="disabled"' : null ?>>
                    <label class="custom-control-label" for="api_is_enabled"><?= l('admin_plans.plan.api_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.api_is_enabled_help') ?></small></div>
                </div>

                <?php if(\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled): ?>
                    <div class="custom-control custom-switch my-3">
                        <input id="affiliate_is_enabled" name="affiliate_is_enabled" type="checkbox" class="custom-control-input" <?= $data->plan->settings->affiliate_is_enabled ? 'checked="checked"' : null ?>>
                        <label class="custom-control-label" for="affiliate_is_enabled"><?= l('admin_plans.plan.affiliate_is_enabled') ?></label>
                        <div><small class="form-text text-muted"><?= l('admin_plans.plan.affiliate_is_enabled_help') ?></small></div>
                    </div>
                <?php endif ?>

                <h3 class="h5 mt-4"><?= l('admin_plans.plan.enabled_qr_codes') ?></h3>
                <p class="text-muted"><?= l('admin_plans.plan.enabled_qr_codes_help') ?></p>

                <div class="row">
                    <?php foreach(array_keys((require APP_PATH . 'includes/qr_code.php')['type']) as $key): ?>
                        <div class="col-6 mb-3">
                            <div class="custom-control custom-switch">
                                <input id="enabled_qr_codes_<?= $key ?>" name="enabled_qr_codes[]" value="<?= $key ?>" type="checkbox" class="custom-control-input" <?= $data->plan->settings->enabled_qr_codes->{$key} ? 'checked="checked"' : null ?>>
                                <label class="custom-control-label" for="enabled_qr_codes_<?= $key ?>"><?= l('qr_codes.type.' . mb_strtolower($key)) ?></label>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

            <?php if($data->plan_id == 'custom'): ?>
                <div class="alert alert-info" role="alert"><?= l('admin_plans.main.custom_help') ?></div>
                <button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
            <?php elseif($data->plan_id == 'guest'): ?>
                <button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
            <?php else: ?>
                <button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
                <button type="submit" name="submit_update_users_plan_settings" class="btn btn-lg btn-block btn-outline-primary mt-2"><?= l('admin_plan_update.update_users_plan_settings.button') ?></button>
            <?php endif ?>
        </form>

    </div>
</div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/plans/plan_delete_modal.php'), 'modals'); ?>
