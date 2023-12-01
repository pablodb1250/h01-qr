<?php defined('ALTUMCODE') || die() ?>

<div class="dropdown">
    <button type="button" class="btn btn-link text-secondary dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport">
        <i class="fa fa-fw fa-ellipsis-v"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-right">
        <a href="<?= url('qr-code-update/' . $data->id) ?>" class="dropdown-item"><i class="fa fa-fw fa-pencil-alt"></i> <?= l('global.edit') ?></a>
        <a href="#" data-toggle="modal" data-target="#qr_code_delete_modal" data-qr-code-id="<?= $data->id ?>" class="dropdown-item"><i class="fa fa-fw fa-times"></i> <?= l('global.delete') ?></a>
    </div>
</div>
