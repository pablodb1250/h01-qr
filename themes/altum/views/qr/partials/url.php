<?php defined('ALTUMCODE') || die() ?>

<div>
    <div class="form-group" data-type="url" data-url>
        <label for="url"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.url') ?></label>
        <input type="url" id="url" name="url" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['url']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="url" data-link-id>
        <div class="d-flex justify-content-between">
            <label for="link_id"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.link_id') ?></label>
            <a href="<?= url('link-create') ?>" target="_blank" class="ml-3 small"><?= l('global.create') ?></a>
        </div>
        <select id="link_id" name="link_id" class="form-control" required="required" data-reload-qr-code>
            <?php foreach($data->links as $row): ?>
                <option value="<?= $row->link_id ?>"><?= $row->full_url ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="form-group" data-type="url">
        <div <?= \Altum\Middlewares\Authentication::check() ? null : 'data-toggle="tooltip" title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
            <div class="<?= \Altum\Middlewares\Authentication::check() ? null : 'container-disabled' ?>">
                <div class="custom-control custom-checkbox">
                    <input id="url_dynamic" name="url_dynamic" type="checkbox" class="custom-control-input" data-reload-qr-code />
                    <label class="custom-control-label" for="url_dynamic"><?= l('qr_codes.input.url_dynamic') ?></label>
                    <small class="form-text text-muted"><?= l('qr_codes.input.url_dynamic_help') ?></small>
                </div>
            </div>
        </div>
    </div>
</div>
