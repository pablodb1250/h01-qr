<?php defined('ALTUMCODE') || die() ?>

<div>
    <div class="row">
        <div class="col-6">
            <div class="form-group" data-type="vcard">
                <label for="vcard_first_name"><i class="fa fa-fw fa-signature fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_first_name') ?></label>
                <input type="text" id="vcard_first_name" name="vcard_first_name" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['first_name']['max_length'] ?>" data-reload-qr-code />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group" data-type="vcard">
                <label for="vcard_last_name"><i class="fa fa-fw fa-signature fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_last_name') ?></label>
                <input type="text" id="vcard_last_name" name="vcard_last_name" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['last_name']['max_length'] ?>" data-reload-qr-code />
            </div>
        </div>
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_phone"><i class="fa fa-fw fa-phone-square-alt fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_phone') ?></label>
        <input type="text" id="vcard_phone" name="vcard_phone" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['phone']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_email"><i class="fa fa-fw fa-envelope fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_email') ?></label>
        <input type="email" id="vcard_email" name="vcard_email" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_url"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_url') ?></label>
        <input type="url" id="vcard_url" name="vcard_url" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['url']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_company"><i class="fa fa-fw fa-building fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_company') ?></label>
        <input type="text" id="vcard_company" name="vcard_company" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['company']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_job_title"><i class="fa fa-fw fa-user-tie fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_job_title') ?></label>
        <input type="text" id="vcard_job_title" name="vcard_job_title" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['job_title']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_birthday"><i class="fa fa-fw fa-birthday-cake fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_birthday') ?></label>
        <input type="date" id="vcard_birthday" name="vcard_birthday" class="form-control" value="" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_street"><i class="fa fa-fw fa-road fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_street') ?></label>
        <input type="text" id="vcard_street" name="vcard_street" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['street']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_city"><i class="fa fa-fw fa-city fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_city') ?></label>
        <input type="text" id="vcard_city" name="vcard_city" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['city']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_zip"><i class="fa fa-fw fa-mail-bulk fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_zip') ?></label>
        <input type="text" id="vcard_zip" name="vcard_zip" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['zip']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_region"><i class="fa fa-fw fa-flag fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_region') ?></label>
        <input type="text" id="vcard_region" name="vcard_region" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['region']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_country"><i class="fa fa-fw fa-globe fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_country') ?></label>
        <input type="text" id="vcard_country" name="vcard_country" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['country']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="vcard">
        <label for="vcard_note"><i class="fa fa-fw fa-paragraph fa-sm mr-1"></i> <?= l('qr_codes.input.vcard_note') ?></label>
        <textarea id="vcard_note" name="vcard_note" class="form-control" maxlength="<?= $data->qr_code_settings['type']['vcard']['note']['max_length'] ?>" data-reload-qr-code></textarea>
    </div>

    <button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#vcard_socials_container" aria-expanded="false" aria-controls="vcard_socials_container" data-type="vcard">
        <?= l('qr_codes.input.vcard_socials') ?>
    </button>

    <div class="collapse" id="vcard_socials_container" data-type="vcard">
        <div id="vcard_socials"></div>

        <div class="mb-3">
            <button data-add="vcard_social" type="button" class="btn btn-sm btn-outline-success"><i class="fa fa-fw fa-plus-circle"></i> <?= l('global.create') ?></button>
        </div>
    </div>
</div>


<template id="template_vcard_social">
    <div class="mb-4">
        <div class="form-group">
            <label for=""><?= l('qr_codes.input.vcard_social_label') ?></label>
            <input id="" type="text" name="vcard_social_label[]" class="form-control" maxlength="<?= $data->qr_code_settings['type']['vcard']['social_label']['max_length'] ?>" required="required" data-reload-qr-code />
        </div>

        <div class="form-group">
            <label for=""><?= l('qr_codes.input.vcard_social_value') ?></label>
            <input id="" type="url" name="vcard_social_value[]" class="form-control" maxlength="<?= $data->qr_code_settings['type']['vcard']['social_value']['max_length'] ?>" required="required" data-reload-qr-code />
        </div>

        <button type="button" data-remove="vcard_social" class="btn btn-sm btn-block btn-outline-danger"><i class="fa fa-fw fa-times"></i> <?= l('global.delete') ?></button>
    </div>
</template>
