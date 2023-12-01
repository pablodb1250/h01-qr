<?php defined('ALTUMCODE') || die() ?>

<div>
    <div class="form-group" data-type="crypto">
        <label for="crypto_coin"><i class="fab fa-fw fa-bitcoin fa-sm mr-1"></i> <?= l('qr_codes.input.crypto_coin') ?></label>
        <select id="crypto_coin" name="crypto_coin" class="form-control" data-reload-qr-code>
            <?php foreach($data->qr_code_settings['type']['crypto']['coins'] as $coin => $coin_name): ?>
                <option value="<?= $coin ?>"><?= $coin_name ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="form-group" data-type="crypto">
        <label for="crypto_address"><i class="fa fa-fw fa-coins fa-sm mr-1"></i> <?= l('qr_codes.input.crypto_address') ?></label>
        <input type="text" id="crypto_address" name="crypto_address" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['crypto']['address']['max_length'] ?>" data-reload-qr-code />
    </div>
</div>
