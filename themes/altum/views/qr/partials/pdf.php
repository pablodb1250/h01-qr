<?php defined('ALTUMCODE') || die() ?>

<script type="text/javascript" src="<?= SITE_URL .'\themes\altum\assets\js\pdf.js' ?>"></script>

<div>
    <div class="form-group" data-type="pdf">
        <label for="archivo"><i class="fa fa-fw fa-file fa-sm mr-1"></i> <?= l('qr_codes.input.pdf') ?></label>
        <input onchange="adjunta();" type="file" id="archivo" name="archivo" class="form-control <?= \Altum\Alerts::has_field_errors('pdf') ? 'is-invalid' : null ?>" value="" required="required" />
        <input type="hidden" id="pdf" name="pdf" class="form-control <?= \Altum\Alerts::has_field_errors('pdf') ? 'is-invalid' : null ?>" maxlength="<?= $data->qr_code_settings['type']['pdf']['max_length'] ?>" required="required" data-reload-qr-code />
        <?= \Altum\Alerts::output_field_error('pdf') ?>
    </div>
</div>