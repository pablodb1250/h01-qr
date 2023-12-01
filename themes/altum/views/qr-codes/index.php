<?php defined('ALTUMCODE') || die() ?>


<section class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="row mb-4">
        <div class="col-12 col-xl d-flex align-items-center mb-3 mb-xl-0">
            <h1 class="h4 m-0"><?= l('qr_codes.header') ?></h1>

            <div class="ml-2">
                <span data-toggle="tooltip" title="<?= l('qr_codes.subheader') ?>">
                    <i class="fa fa-fw fa-info-circle text-muted"></i>
                </span>
            </div>
        </div>

        <div class="col-12 col-xl-auto d-flex">
            <div>
                <?php if($this->user->plan_settings->qr_codes_limit != -1 && $data->total_qr_codes >= $this->user->plan_settings->qr_codes_limit): ?>
                    <button type="button" data-toggle="tooltip" title="<?= l('qr_codes.error_message.qr_codes_limit') ?>" class="btn btn-primary disabled">
                        <i class="fa fa-fw fa-plus-circle"></i> <?= l('qr_codes.create') ?>
                    </button>
                <?php else: ?>
                    <a href="<?= url('qr-code-create') ?>" class="btn btn-primary"><i class="fa fa-fw fa-plus-circle"></i> <?= l('qr_codes.create') ?></a>
                <?php endif ?>
            </div>

            <div class="ml-3">
                <div class="dropdown">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport" title="<?= l('global.export') ?>">
                        <i class="fa fa-fw fa-sm fa-download"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right d-print-none">
                        <a href="<?= url('qr-codes?' . $data->filters->get_get() . '&export=csv')  ?>" target="_blank" class="dropdown-item">
                            <i class="fa fa-fw fa-sm fa-file-csv mr-1"></i> <?= l('global.export_csv') ?>
                        </a>
                        <a href="<?= url('qr-codes?' . $data->filters->get_get() . '&export=json') ?>" target="_blank" class="dropdown-item">
                            <i class="fa fa-fw fa-sm fa-file-code mr-1"></i> <?= l('global.export_json') ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="ml-3">
                <div class="dropdown">
                    <button type="button" class="btn <?= count($data->filters->get) ? 'btn-outline-primary' : 'btn-outline-secondary' ?> filters-button dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport" title="<?= l('global.filters.header') ?>">
                        <i class="fa fa-fw fa-sm fa-filter"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right filters-dropdown">
                        <div class="dropdown-header d-flex justify-content-between">
                            <span class="h6 m-0"><?= l('global.filters.header') ?></span>

                            <?php if(count($data->filters->get)): ?>
                                <a href="<?= url('qr-codes') ?>" class="text-muted"><?= l('global.filters.reset') ?></a>
                            <?php endif ?>
                        </div>

                        <div class="dropdown-divider"></div>

                        <form action="" method="get" role="form">
                            <div class="form-group px-4">
                                <label for="filters_search" class="small"><?= l('global.filters.search') ?></label>
                                <input type="search" name="search" id="filters_search" class="form-control form-control-sm" value="<?= $data->filters->search ?>" />
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_search_by" class="small"><?= l('global.filters.search_by') ?></label>
                                <select name="search_by" id="filters_search_by" class="form-control form-control-sm">
                                    <option value="name" <?= $data->filters->search_by == 'name' ? 'selected="selected"' : null ?>><?= l('qr_codes.table.name') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <div class="d-flex justify-content-between">
                                    <label for="filters_project_id" class="small"><?= l('projects.project_id') ?></label>
                                    <a href="<?= url('project-create') ?>" target="_blank" class="small"><i class="fa fa-fw fa-sm fa-plus mr-1"></i> <?= l('global.create') ?></a>
                                </div>
                                <select name="project_id" id="filters_project_id" class="form-control form-control-sm">
                                    <option value=""><?= l('global.filters.all') ?></option>
                                    <?php foreach($data->projects as $row): ?>
                                        <option value="<?= $row->project_id ?>" <?= isset($data->filters->filters['project_id']) && $data->filters->filters['project_id'] == $row->project_id ? 'selected="selected"' : null ?>><?= $row->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_type" class="small"><?= l('qr_codes.table.type') ?></label>
                                <select name="type" id="filters_type" class="form-control form-control-sm">
                                    <option value=""><?= l('global.filters.all') ?></option>
                                    <?php foreach(array_keys((require APP_PATH . 'includes/qr_code.php')['type']) as $type): ?>
                                        <option value="<?= $type ?>" <?= isset($data->filters->filters['type']) && $data->filters->filters['type'] == $type ? 'selected="selected"' : null ?>><?= l('qr_codes.type.' . $type) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_order_by" class="small"><?= l('global.filters.order_by') ?></label>
                                <select name="order_by" id="filters_order_by" class="form-control form-control-sm">
                                    <option value="datetime" <?= $data->filters->order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                                    <option value="name" <?= $data->filters->order_by == 'name' ? 'selected="selected"' : null ?>><?= l('qr_codes.table.name') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_order_type" class="small"><?= l('global.filters.order_type') ?></label>
                                <select name="order_type" id="filters_order_type" class="form-control form-control-sm">
                                    <option value="ASC" <?= $data->filters->order_type == 'ASC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_asc') ?></option>
                                    <option value="DESC" <?= $data->filters->order_type == 'DESC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_desc') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_results_per_page" class="small"><?= l('global.filters.results_per_page') ?></label>
                                <select name="results_per_page" id="filters_results_per_page" class="form-control form-control-sm">
                                    <?php foreach($data->filters->allowed_results_per_page as $key): ?>
                                        <option value="<?= $key ?>" <?= $data->filters->results_per_page == $key ? 'selected="selected"' : null ?>><?= $key ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4 mt-4">
                                <button type="submit" name="submit" class="btn btn-sm btn-primary btn-block"><?= l('global.submit') ?></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
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
                                        <a href="<?= UPLOADS_FULL_URL . 'qr_codes/logo/' . $row->qr_code ?>" class="dropdown-item" download="<?= $row->name . '.svg' ?>"><?= l('qr_codes.download_svg') ?></a>
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

                </tbody>
            </table>
        </div>

        <div class="mt-3"><?= $data->pagination ?></div>
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

</section>

<?php require THEME_PATH . 'views/qr-codes/js_qr_code.php' ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/qr-codes/qr_code_delete_modal.php'), 'modals'); ?>
