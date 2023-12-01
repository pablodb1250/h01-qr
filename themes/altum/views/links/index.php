<?php defined('ALTUMCODE') || die() ?>


<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="row mb-4">
        <div class="col-12 col-xl d-flex align-items-center mb-3 mb-xl-0">
            <h1 class="h4 m-0"><?= l('links.header') ?></h1>

            <div class="ml-2">
                <span data-toggle="tooltip" title="<?= l('links.subheader') ?>">
                    <i class="fa fa-fw fa-info-circle text-muted"></i>
                </span>
            </div>
        </div>

        <div class="col-12 col-xl-auto d-flex">
            <div>
                <?php if($this->user->plan_settings->links_limit != -1 && $data->total_links >= $this->user->plan_settings->links_limit): ?>
                    <button type="button" class="btn btn-outline-primary disabled" data-toggle="tooltip" title="<?= l('links.error_message.links_limit') ?>">
                        <i class="fa fa-fw fa-sm fa-plus"></i> <?= l('links.create') ?>
                    </button>
                <?php else: ?>
                    <a href="<?= url('link-create') ?>" class="btn btn-outline-primary">
                        <i class="fa fa-fw fa-sm fa-plus"></i> <?= l('links.create') ?>
                    </a>
                <?php endif ?>
            </div>

            <div class="ml-3">
                <div class="dropdown">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport" title="<?= l('global.export') ?>">
                        <i class="fa fa-fw fa-sm fa-download"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right d-print-none">
                        <a href="<?= url('links?' . $data->filters->get_get() . '&export=csv')  ?>" target="_blank" class="dropdown-item">
                            <i class="fa fa-fw fa-sm fa-file-csv mr-1"></i> <?= l('global.export_csv') ?>
                        </a>
                        <a href="<?= url('links?' . $data->filters->get_get() . '&export=json') ?>" target="_blank" class="dropdown-item">
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
                                <a href="<?= url('links') ?>" class="text-muted"><?= l('global.filters.reset') ?></a>
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
                                    <option value="url" <?= $data->filters->search_by == 'url' ? 'selected="selected"' : null ?>><?= l('links.filters.search_by_url') ?></option>
                                    <option value="location_url" <?= $data->filters->search_by == 'location_url' ? 'selected="selected"' : null ?>><?= l('links.filters.search_by_location_url') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_is_enabled" class="small"><?= l('global.filters.status') ?></label>
                                <select name="is_enabled" id="filters_is_enabled" class="form-control form-control-sm">
                                    <option value=""><?= l('global.filters.all') ?></option>
                                    <option value="1" <?= isset($data->filters->filters['is_enabled']) && $data->filters->filters['is_enabled'] == '1' ? 'selected="selected"' : null ?>><?= l('global.active') ?></option>
                                    <option value="0" <?= isset($data->filters->filters['is_enabled']) && $data->filters->filters['is_enabled'] == '0' ? 'selected="selected"' : null ?>><?= l('global.disabled') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <div class="d-flex justify-content-between">
                                    <label for="filters_project_id" class="small"><?= l('projects.project_id') ?></label>
                                    <a href="<?= url('project-create') ?>" target="_blank" class="small"><i class="fa fa-fw fa-sm fa-plus mr-1"></i> <?= l('global.create') ?></a>
                                </div>
                                <select name="project_id" id="filters_project_id" class="form-control form-control-sm">
                                    <option value=""><?= l('global.filters.all') ?></option>
                                    <?php foreach($data->projects as $project_id => $project): ?>
                                        <option value="<?= $project_id ?>" <?= isset($data->filters->filters['project_id']) && $data->filters->filters['project_id'] == $project_id ? 'selected="selected"' : null ?>><?= $project->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_order_by" class="small"><?= l('global.filters.order_by') ?></label>
                                <select name="order_by" id="filters_order_by" class="form-control form-control-sm">
                                    <option value="datetime" <?= $data->filters->order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                                    <option value="url" <?= $data->filters->order_by == 'url' ? 'selected="selected"' : null ?>><?= l('links.filters.order_by_url') ?></option>
                                    <option value="location_url" <?= $data->filters->order_by == 'location_url' ? 'selected="selected"' : null ?>><?= l('links.filters.order_by_location_url') ?></option>
                                    <option value="pageviews" <?= $data->filters->order_by == 'pageviews' ? 'selected="selected"' : null ?>><?= l('links.filters.order_by_pageviews') ?></option>
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

    <?php if(count($data->links)): ?>
        <div class="table-responsive table-custom-container">
            <table class="table table-custom">
                <thead>
                <tr>
                    <th><?= l('links.table.link_id') ?></th>
                    <th><?= l('projects.project_id') ?></th>
                    <th><?= l('links.table.stats') ?></th>
                    <th><?= l('links.table.datetime') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($data->links as $row): ?>

                    <tr>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <div><a href="<?= url('link-update/' . $row->link_id) ?>"><?= $row->url ?></a></div>
                                <div class="small">
                                    <i class="fa fa-fw fa-sm fa-external-link-alt text-muted mr-1"></i>
                                    <a href="<?= $row->full_url ?>" class="text-muted" target="_blank" rel="noreferrer"><?= $row->full_url ?></a>
                                </div>
                            </div>
                        </td>

                        <td class="text-nowrap">
                            <?php if($row->project_id): ?>
                                <a href="<?= url('links?project_id=' . $row->project_id) ?>" class="small text-decoration-none">
                                    <span class="py-1 px-2 border rounded text-muted small" style="border-color: <?= $data->projects[$row->project_id]->color ?> !important;">
                                        <?= $data->projects[$row->project_id]->name ?>
                                    </span>
                                </a>
                            <?php endif ?>
                        </td>

                        <td class="text-nowrap">
                            <a href="<?= url('link-statistics/' . $row->link_id) ?>" class="btn btn-link text-decoration-none" data-toggle="tooltip" title="<?= l('link_statistics.pageviews') ?>">
                                <i class="fa fa-fw fa-chart-line mr-1"></i> <?= nr($row->pageviews) ?>
                            </a>
                        </td>

                        <td class="text-nowrap text-muted">
                            <span data-toggle="tooltip" title="<?= \Altum\Date::get($row->datetime, 1) ?>"><?= \Altum\Date::get($row->datetime, 2) ?></span>
                        </td>

                        <td>
                            <div class="d-flex justify-content-end">
                                <button
                                        id="url_copy"
                                        type="button"
                                        class="btn btn-link text-muted"
                                        data-toggle="tooltip"
                                        title="<?= l('global.clipboard_copy') ?>"
                                        aria-label="<?= l('global.clipboard_copy') ?>"
                                        data-copy="<?= l('global.clipboard_copy') ?>"
                                        data-copied="<?= l('global.clipboard_copied') ?>"
                                        data-clipboard-text="<?= $row->full_url ?>"
                                >
                                    <i class="fa fa-fw fa-sm fa-copy"></i>
                                </button>

                                <?= include_view(THEME_PATH . 'views/links/link_dropdown_button.php', ['id' => $row->link_id]) ?>
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
                    <img src="<?= ASSETS_FULL_URL . 'images/no_rows.svg' ?>" class="col-10 col-md-7 col-lg-5 mb-3" alt="<?= l('links.no_data') ?>" />
                    <h2 class="h4 text-muted mt-3"><?= l('links.no_data') ?></h2>
                    <p class="text-muted"><?= l('links.no_data_help') ?></p>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/links/link_delete_modal.php'), 'modals'); ?>
<?php include_view(THEME_PATH . 'views/partials/clipboard_js.php') ?>
