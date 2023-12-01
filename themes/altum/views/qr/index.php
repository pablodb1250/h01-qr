<?php defined('ALTUMCODE') || die() ?>

<div class="container text-center d-print-none">
    <?= \Altum\Alerts::output_alerts() ?>

    <h1 class="index-header mb-2"><?= $data->type ? sprintf(l('qr.header_dynamic'), l('qr_codes.type.' . $data->type)) : l('qr.header') ?></h1>
    <p class="index-subheader mb-5"><?= $data->type ? sprintf(l('qr.subheader_dynamic'), l('qr_codes.type.' . $data->type)) : l('qr.subheader') ?></p>

    <div class="d-flex flex-wrap justify-content-center">
    <?php foreach($data->qr_code_settings['type'] as $key => $value): ?>
        <div class="mr-3 mb-3" data-toggle="tooltip" <?= $this->user->plan_settings->enabled_qr_codes->{$key} ? 'title="' . l('qr_codes.type.' . $key . '_description') . '"' : 'title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
            <a
                    href="<?= url('qr/' . $key) ?>"
                    class="btn <?= $data->type == $key ? 'btn-primary' : 'btn-outline-secondary' ?> <?= $this->user->plan_settings->enabled_qr_codes->{$key} ? null : 'disabled' ?>"
            >
                <i class="<?= $value['icon'] ?> fa-fw fa-sm mr-1"></i> <?= l('qr_codes.type.' . $key) ?>
            </a>
        </div>
    <?php endforeach ?>
    </div>
</div>

<?php if($data->type): ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-lg-7 d-print-none mb-5 mb-lg-0">
            <div class="card">
                <div class="card-body">
                    <form action="<?= url('qr-code-create') ?>" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
                        <input type="hidden" name="api_key" value="<?= $this->user->api_key ?? null ?>" />
                        <input type="hidden" name="type" value="<?= $data->type ?>" />
                        <input type="hidden" name="reload" value="" data-reload-qr-code />
                        <?php if(\Altum\Middlewares\Authentication::check()): ?>
                            <input type="hidden" name="qr_code" value="" />
                            <input type="hidden" name="name" value="<?= $this->user->name ?>" />
                        <?php endif ?>

                        <div class="notification-container"></div>

                        <?= $this->views['qr'] ?>

                        <button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#colors_container" aria-expanded="false" aria-controls="colors_container">
                            <i class="fa fa-fw fa-palette fa-sm mr-1"></i> <?= l('qr_codes.input.colors') ?>
                        </button>

                        <div class="collapse" id="colors_container">
                            <div class="form-group">
                                <label for="foreground_type"><i class="fa fa-fw fa-paint-roller fa-sm mr-1"></i> <?= l('qr_codes.input.foreground_type') ?></label>
                                <select id="foreground_type" name="foreground_type" class="form-control" data-reload-qr-code>
                                    <option value="color"><?= l('qr_codes.input.foreground_type_color') ?></option>
                                    <option value="gradient"><?= l('qr_codes.input.foreground_type_gradient') ?></option>
                                </select>
                            </div>

                            <div class="form-group" data-foreground-type="color">
                                <label for="foreground_color"><i class="fa fa-fw fa-paint-brush fa-sm mr-1"></i> <?= l('qr_codes.input.foreground_color') ?></label>
                                <input type="color" id="foreground_color" name="foreground_color" class="form-control" value="<?= '#000000' ?>" data-reload-qr-code />
                            </div>

                            <div class="form-group" data-foreground-type="gradient">
                                <label for="foreground_gradient_style"><i class="fa fa-fw fa-brush fa-sm mr-1"></i> <?= l('qr_codes.input.foreground_gradient_style') ?></label>
                                <select id="foreground_gradient_style" name="foreground_gradient_style" class="form-control" data-reload-qr-code>
                                    <?php foreach(['vertical', 'horizontal', 'diagonal', 'inverse_diagonal', 'radial'] as $style): ?>
                                        <option value="<?= $style ?>"><?= l('qr_codes.input.foreground_gradient_style_' . $style) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group" data-foreground-type="gradient">
                                <label for="foreground_gradient_one"><?= l('qr_codes.input.foreground_gradient_one') ?></label>
                                <input type="color" id="foreground_gradient_one" name="foreground_gradient_one" class="form-control" value="<?= '#000000' ?>" data-reload-qr-code />
                            </div>

                            <div class="form-group" data-foreground-type="gradient">
                                <label for="foreground_gradient_two"><?= l('qr_codes.input.foreground_gradient_two') ?></label>
                                <input type="color" id="foreground_gradient_two" name="foreground_gradient_two" class="form-control" value="<?= '#000000' ?>" data-reload-qr-code />
                            </div>

                            <div class="form-group">
                                <label for="background_color"><?= l('qr_codes.input.background_color') ?></label>
                                <input type="color" id="background_color" name="background_color" class="form-control" value="<?= '#ffffff' ?>" data-reload-qr-code />
                            </div>

                            <div class="form-group">
                                <label for="background_color_transparency"><?= l('qr_codes.input.background_color_transparency') ?></label>
                                <input id="background_color_transparency" type="range" min="0" max="100" step="10" name="background_color_transparency" value="<?= 0 ?>" class="form-control" data-reload-qr-code />
                            </div>

                            <div class="form-group">
                                <label for="custom_eyes_color"><i class="fa fa-fw fa-eye fa-sm mr-1"></i> <?= l('qr_codes.input.custom_eyes_color') ?></label>
                                <select id="custom_eyes_color" name="custom_eyes_color" class="form-control" data-reload-qr-code>
                                    <option value="1"><?= l('global.yes') ?></option>
                                    <option value="0"><?= l('global.no') ?></option>
                                </select>
                            </div>

                            <div class="form-group" data-custom-eyes-color="1">
                                <label for="eyes_inner_color"><?= l('qr_codes.input.eyes_inner_color') ?></label>
                                <input type="color" id="eyes_inner_color" name="eyes_inner_color" class="form-control" value="<?= '#000000' ?>" data-reload-qr-code />
                            </div>

                            <div class="form-group" data-custom-eyes-color="1">
                                <label for="eyes_outer_color"><?= l('qr_codes.input.eyes_outer_color') ?></label>
                                <input type="color" id="eyes_outer_color" name="eyes_outer_color" class="form-control" value="<?= '#000000' ?>" data-reload-qr-code />
                            </div>
                        </div>

                        <button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#branding_container" aria-expanded="false" aria-controls="branding_container">
                            <i class="fa fa-fw fa-copyright fa-sm mr-1"></i> <?= l('qr_codes.input.branding') ?>
                        </button>

                        <div class="collapse" id="branding_container">
                            <div class="form-group">
                                <label for="qr_code_logo"><i class="fa fa-fw fa-sm fa-eye mr-1"></i> <?= l('qr_codes.input.qr_code_logo') ?></label>
                                <?php if(!empty($data->values['qr_code_logo'])): ?>
                                    <input type="hidden" name="qr_code_logo" value="<?= UPLOADS_FULL_URL . 'qr_codes/logo/' . $data->values['qr_code_logo'] ?>" />
                                    <div class="m-1">
                                        <img src="<?= UPLOADS_FULL_URL . 'qr_codes/logo/' . $data->values['qr_code_logo'] ?>" class="img-fluid" style="max-height: 2.5rem;height: 2.5rem;" />
                                    </div>
                                    <div class="custom-control custom-checkbox my-2">
                                        <input id="qr_code_logo_remove" name="qr_code_logo_remove" type="checkbox" class="custom-control-input" onchange="this.checked ? document.querySelector('#qr_code_logo').classList.add('d-none') : document.querySelector('#qr_code_logo').classList.remove('d-none')" data-reload-qr-code>
                                        <label class="custom-control-label" for="qr_code_logo_remove">
                                            <span class="text-muted"><?= l('global.delete_file') ?></span>
                                        </label>
                                    </div>
                                <?php endif ?>
                                <input id="qr_code_logo" type="file" name="qr_code_logo" accept="<?= \Altum\Uploads::get_whitelisted_file_extensions_accept('qr_codes/logo') ?>" class="form-control-file" data-reload-qr-code />
                                <small class="form-text text-muted"><?= sprintf(l('global.accessibility.whitelisted_file_extensions'), \Altum\Uploads::get_whitelisted_file_extensions_accept('qr_codes/logo')) ?></small>
                            </div>

                            <div class="form-group">
                                <label for="qr_code_logo_size"><i class="fa fa-fw fa-expand-alt fa-sm mr-1"></i> <?= l('qr_codes.input.qr_code_logo_size') ?></label>
                                <input id="qr_code_logo_size" type="range" min="5" max="35" name="qr_code_logo_size" value="<?= $data->values['qr_code_logo_size'] ?? 25 ?>" class="form-control" data-reload-qr-code />
                            </div>
                        </div>

                        <button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#options_container" aria-expanded="false" aria-controls="options_container">
                            <i class="fa fa-fw fa-wrench fa-sm mr-1"></i> <?= l('qr_codes.input.options') ?>
                        </button>

                        <div class="collapse" id="options_container">
                            <div class="form-group">
                                <label for="size"><i class="fa fa-fw fa-expand-arrows-alt fa-sm mr-1"></i> <?= l('qr_codes.input.size') ?></label>
                                <div class="input-group">
                                    <input id="size" type="number" min="50" max="2000" name="size" class="form-control" value="<?= 500 ?>" data-reload-qr-code />
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="margin"><i class="fa fa-fw fa-expand fa-sm mr-1"></i> <?= l('qr_codes.input.margin') ?></label>
                                <input id="margin" type="number" min="0" max="25" name="margin" class="form-control" value="<?= 0 ?>" data-reload-qr-code />
                            </div>

                            <div class="form-group">
                                <label for="ecc"><i class="fa fa-fw fa-check fa-sm mr-1"></i> <?= l('qr_codes.input.ecc') ?></label>
                                <select id="ecc" name="ecc" class="form-control" data-reload-qr-code>
                                    <?php foreach(['L', 'M', 'Q', 'H'] as $level): ?>
                                        <option value="<?= $level ?>"><?= l('qr_codes.input.ecc_' . mb_strtolower($level)) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <?php if(\Altum\Middlewares\Authentication::check()): ?>
                        <button type="submit" name="submit" class="btn btn-block btn-primary mt-4"><?= l('global.create') ?></button>
                        <?php else: ?>
                        <a href="<?= url('register') ?>" class="btn btn-block btn-outline-primary mt-4"><i class="fa fa-fw fa-xs fa-plus mr-1"></i> <?= l('qr.register') ?></a>
                        <?php endif ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="mb-4">
                <div class="card">
                    <div class="card-body">
                        <img id="qr_code" src="<?= ASSETS_FULL_URL . 'images/qr_code.svg' ?>" class="img-fluid qr-code" loading="lazy" />
                    </div>
                </div>
            </div>

            <div class="row mb-4 d-print-none">
                <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                    <button type="button" onclick="window.print()" class="btn btn-block btn-outline-secondary d-print-none">
                        <i class="fa fa-fw fa-sm fa-file-pdf"></i> <?= l('qr_codes.print') ?>
                    </button>
                </div>

                <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                    <button type="button" class="btn btn-block btn-primary d-print-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-fw fa-sm fa-download"></i> <?= l('qr_codes.download') ?>
                    </button>

                    <div class="dropdown-menu">
                        <a href="<?= ASSETS_FULL_URL . 'images/qr_code.svg' ?>" id="download_svg" class="dropdown-item" download="<?= settings()->main->title . '.svg' ?>"><?= l('qr_codes.download_svg') ?></a>
                        <button type="button" class="dropdown-item" onclick="convert_svg_to_others(null, 'png', '<?= settings()->main->title . '.png' ?>');"><?= l('qr_codes.download_png') ?></button>
                        <button type="button" class="dropdown-item" onclick="convert_svg_to_others(null, 'jpg', '<?= settings()->main->title . '.jpg' ?>');"><?= l('qr_codes.download_jpg') ?></button>
                        <button type="button" class="dropdown-item" onclick="convert_svg_to_others(null, 'webp', '<?= settings()->main->title . '.webp' ?>');"><?= l('qr_codes.download_webp') ?></button>
                    </div>
                </div>
            </div>

            <div class="mb-4 text-center d-print-none">
                <small>
                    <i class="fa fa-fw fa-info-circle text-muted mr-1"></i> <span class="text-muted"><?= l('qr_codes.info') ?></span>
                </small>
            </div>
        </div>
    </div>
</div>

<?php require THEME_PATH . 'views/qr-codes/js_qr_code.php' ?>
<?php endif ?>
