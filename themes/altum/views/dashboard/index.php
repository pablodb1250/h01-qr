<?php defined('ALTUMCODE') || die() ?>


<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="mb-3 d-flex justify-content-between">
        <div>
            <h1 class="h4 mb-0 text-truncate"><?= l('dashboard.header') ?></h1>
        </div>
    </div>

    <div class="my-4">
        <div class="row">
            <div class="col-12 col-sm-6 col-xl mb-4 position-relative text-truncate">
                <div class="card d-flex flex-row h-100 overflow-hidden">
                    <div class="border-right border-gray-200 px-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('qr-codes') ?>" class="stretched-link">
                            <i class="fa fa-fw fa-qrcode text-primary-600"></i>
                        </a>
                    </div>

                    <div class="card-body text-truncate">
                        <?= sprintf(l('dashboard.total_qr_codes'), '<span class="h6">' . nr($data->total_qr_codes) . '</span>') ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl mb-4 position-relative text-truncate">
                <div class="card d-flex flex-row h-100 overflow-hidden">
                    <div class="border-right border-gray-200 px-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('links') ?>" class="stretched-link">
                            <i class="fa fa-fw fa-link text-primary-600"></i>
                        </a>
                    </div>

                    <div class="card-body text-truncate">
                        <?= sprintf(l('dashboard.total_links'), '<span class="h6">' . nr($data->total_links) . '</span>') ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl mb-4 position-relative text-truncate">
                <div class="card d-flex flex-row h-100 overflow-hidden">
                    <div class="border-right border-gray-200 px-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('projects') ?>" class="stretched-link">
                            <i class="fa fa-fw fa-project-diagram text-primary-600"></i>
                        </a>
                    </div>

                    <div class="card-body text-truncate">
                        <?= sprintf(l('dashboard.total_projects'), '<span class="h6">' . nr($data->total_projects) . '</span>') ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl mb-4 position-relative text-truncate">
                <div class="card d-flex flex-row h-100 overflow-hidden">
                    <div class="border-right border-gray-200 px-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('pixels') ?>" class="stretched-link">
                            <i class="fa fa-fw fa-adjust text-primary-600"></i>
                        </a>
                    </div>

                    <div class="card-body text-truncate">
                        <?= sprintf(l('dashboard.total_pixels'), '<span class="h6">' . nr($data->total_pixels) . '</span>') ?>
                    </div>
                </div>
            </div>

            <?php if(settings()->links->domains_is_enabled): ?>
            <div class="col-12 col-sm-6 col-xl mb-4 position-relative text-truncate">
                <div class="card d-flex flex-row h-100 overflow-hidden">
                    <div class="border-right border-gray-200 px-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('domains') ?>" class="stretched-link">
                            <i class="fa fa-fw fa-globe text-primary-600"></i>
                        </a>
                    </div>

                    <div class="card-body text-truncate">
                        <?= sprintf(l('dashboard.total_domains'), '<span class="h6">' . nr($data->total_domains) . '</span>') ?>
                    </div>
                </div>
            </div>
            <?php endif ?>
        </div>
    </div>

    <div class="my-4">
        <div class="d-flex align-items-center mb-3">
            <h2 class="small font-weight-bold text-uppercase text-muted mb-0 mr-3"><i class="fa fa-fw fa-sm fa-qrcode mr-1"></i> <?= l('dashboard.qr_codes_header') ?></h2>

            <div class="flex-fill">
                <hr class="border-gray-200" />
            </div>

            <div class="ml-3">
                <a href="<?= url('qr-code-create') ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-fw fa-sm fa-plus"></i> <?= l('qr_codes.create') ?></a>
            </div>
        </div>

        <?php if(count($data->qr_codes)): ?>
            <div class="table-responsive table-custom-container">
                <table class="table table-custom">
                    <thead>
                    <tr>
                        <th><?= l('qr_codes.table.name') ?></th>
                        <th><?= l('qr_codes.table.type') ?></th>
                        <th><?= l('projects.project_id') ?></th>
                        <th><?= l('qr_codes.table.datetime') ?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($data->qr_codes as $row): ?>
                        <tr>
                            <td class="text-nowrap">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <img src="<?= UPLOADS_FULL_URL . 'qr_codes/logo/' . $row->qr_code ?>" class="qr-code-avatar" loading="lazy" />
                                    </div>

                                    <div class="d-flex flex-column ">
                                        <div>
                                            <a href="<?= url('qr-code-update/' . $row->qr_code_id) ?>" class="font-weight-bold text-truncate"><?= $row->name ?></a>
                                        </div>
                                        <?php if($row->type == 'url'): ?>
                                            <div class="d-flex align-items-center">
                                                <small class="d-inline-block text-truncate text-muted">
                                                    <?= $row->settings->url ?>
                                                </small>

                                                <?php if($row->link_id): ?>
                                                    <a href="<?= url('link-update/' . $row->link_id) ?>" class="btn btn-sm btn-link" data-toggle="tooltip" title="<?= l('global.update') ?>"><i class="fa fa-fw fa-pencil-alt"></i></a>
                                                    <a href="<?= url('link-statistics/' . $row->link_id) ?>" class="btn btn-sm btn-link" data-toggle="tooltip" title="<?= l('link_statistics.pageviews') ?>"><i class="fa fa-fw fa-chart-line"></i></a>
                                                <?php endif ?>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </td>

                            <td class="text-nowrap">
                                <i class="<?= $data->qr_code_settings['type'][$row->type]['icon'] ?> fa-fw fa-sm mr-1"></i>
                                <?= l('qr_codes.type.' . $row->type) ?>
                            </td>

                            <td class="text-nowrap">
                                <?php if($row->project_id): ?>
                                    <a href="<?= url('qr-codes?project_id=' . $row->project_id) ?>" class="text-decoration-none">
                                    <span class="py-1 px-2 border rounded text-muted small" style="border-color: <?= $data->projects[$row->project_id]->color ?> !important;">
                                        <?= $data->projects[$row->project_id]->name ?>
                                    </span>
                                    </a>
                                <?php endif ?>
                            </td>

                            <td class="text-nowrap text-muted">
                                <span data-toggle="tooltip" title="<?= \Altum\Date::get($row->datetime, 1) ?>"><?= \Altum\Date::get($row->datetime, 2) ?></span>
                            </td>

                            <td>
                                <div class="d-flex justify-content-end">
                                    <div>
                                        <button type="button" class="btn btn-block btn-link dropdown-toggle dropdown-toggle-simple" title="<?= l('qr_codes.download') ?>" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-fw fa-sm fa-download"></i>
                                        </button>

                                        <div class="dropdown-menu">
                                            <a href="<?= UPLOADS_FULL_URL . 'qr_codes/logo/' . $row->qr_code ?>" id="download_svg" class="dropdown-item" download="<?= $row->name . '.svg' ?>"><?= l('qr_codes.download_svg') ?></a>
                                            <button type="button" class="dropdown-item" onclick="convert_svg_to_others('<?= UPLOADS_FULL_URL . 'qr_codes/logo/' . $row->qr_code ?>', 'png', '<?= $row->name . '.png' ?>');"><?= l('qr_codes.download_png') ?></button>
                                            <button type="button" class="dropdown-item" onclick="convert_svg_to_others('<?= UPLOADS_FULL_URL . 'qr_codes/logo/' . $row->qr_code ?>', 'jpg', '<?= $row->name . '.jpg' ?>');"><?= l('qr_codes.download_jpg') ?></button>
                                            <button type="button" class="dropdown-item" onclick="convert_svg_to_others('<?= UPLOADS_FULL_URL . 'qr_codes/logo/' . $row->qr_code ?>', 'webp', '<?= $row->name . '.webp' ?>');"><?= l('qr_codes.download_webp') ?></button>
                                        </div>
                                    </div>

                                    <?= include_view(THEME_PATH . 'views/qr-codes/qr_code_dropdown_button.php', ['id' => $row->qr_code_id]) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>

                    <tr>
                        <td colspan="5">
                            <a href="<?= url('qr-codes') ?>" class="text-muted">
                                <i class="fa fa-angle-right fa-sm fa-fw mr-1"></i> <?= l('dashboard.view_all') ?>
                            </a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center">
                        <img src="<?= ASSETS_FULL_URL . 'images/no_rows.svg' ?>" class="col-10 col-md-7 col-lg-5 mb-3" alt="<?= l('qr_codes.no_data') ?>" />
                        <h2 class="h4 text-muted mt-3"><?= l('qr_codes.no_data') ?></h2>
                        <p class="text-muted"><?= l('qr_codes.no_data_help') ?></p>
                    </div>
                </div>
            </div>
        <?php endif ?>

    </div>
</div>

<?php require THEME_PATH . 'views/qr-codes/js_qr_code.php' ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/qr-codes/qr_code_delete_modal.php'), 'modals'); ?>
