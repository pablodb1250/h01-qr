<?php defined('ALTUMCODE') || die() ?>

<div class="index-background py-5">
<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="row justify-content-center">
        <div class="col-11 col-md-10 col-lg-7">
            <h1 class="index-header text-center mb-2"><?= l('index.header') ?></h1>
        </div>

        <div class="col-10 col-sm-8 col-lg-6">
            <p class="index-subheader text-center mb-5"><?= l('index.subheader') ?></p>
        </div>
    </div>

    <div class="d-flex flex-column flex-lg-row justify-content-center">
        <a href="<?= url('qr/text') ?>" class="btn btn-primary index-button mb-3 mb-lg-0 mr-lg-3">
            <i class="fa fa-fw fa-xs fa-plus-circle mr-1"></i> <?= l('index.qr') ?>
        </a>
        <a href="<?= url('register') ?>" target="_blank" class="btn btn-gray-100 index-button mb-3 mb-lg-0">
            <i class="fa fa-fw fa-xs fa-user-plus mr-1"></i> <?= l('index.register') ?>
        </a>
    </div>

    <div class="row justify-content-center mt-8">
        <div class="col-12">
            <img src="<?= ASSETS_FULL_URL . 'images/index/hero.png' ?>" class="img-fluid shadow-lg" loading="lazy" />
        </div>
    </div>
</div>
</div>

<div class="my-5">&nbsp;</div>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-4 mb-5">
            <div class="card d-flex flex-column justify-content-between h-100">
                <img src="<?= ASSETS_FULL_URL . 'images/index/qr_templates.png' ?>" class="index-card-image mb-2 " loading="lazy" />

                <div class="card-body">
                    <div class="mb-2">
                        <span class="h5"><?= l('index.qr_templates.header') ?></span>
                    </div>
                    <span class="text-muted"><?= sprintf(l('index.qr_templates.subheader'), count($data->qr_code_settings['type'])) ?></span>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mb-5">
            <div class="card d-flex flex-column justify-content-between h-100">
                <img src="<?= ASSETS_FULL_URL . 'images/index/privacy.png' ?>" class="index-card-image mb-2" loading="lazy" />

                <div class="card-body">
                    <div class="mb-2">
                        <span class="h5"><?= l('index.privacy.header') ?></span>
                    </div>
                    <span class="text-muted"><?= l('index.privacy.subheader') ?></span>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mb-5">
            <div class="card d-flex flex-column justify-content-between h-100">
                <img src="<?= ASSETS_FULL_URL . 'images/index/customization.png' ?>" class="index-card-image mb-2" loading="lazy" />

                <div class="card-body">
                    <div class="mb-2">
                        <span class="h5"><?= l('index.customization.header') ?></span>
                    </div>
                    <span class="text-muted"><?= l('index.customization.subheader') ?></span>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mb-5">
            <div class="card d-flex flex-column justify-content-between h-100">
                <img src="<?= ASSETS_FULL_URL . 'images/index/pixels.png' ?>" class="index-card-image mb-2" loading="lazy" />

                <div class="card-body">
                    <div class="mb-2">
                        <span class="h5"><?= l('index.pixels.header') ?></span>
                    </div>
                    <span class="text-muted"><?= sprintf(l('index.pixels.subheader'), implode(', ',  array_map(function($item) {return $item['name'];}, require APP_PATH . 'includes/l/pixels.php'))) ?></span>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mb-5">
            <div class="card d-flex flex-column justify-content-between h-100">
                <img src="<?= ASSETS_FULL_URL . 'images/index/projects.png' ?>" class="index-card-image mb-2" loading="lazy" />

                <div class="card-body">
                    <div class="mb-2">
                        <span class="h5"><?= l('index.projects.header') ?></span>
                    </div>
                    <span class="text-muted"><?= l('index.projects.subheader') ?></span>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mb-5">
            <div class="card d-flex flex-column justify-content-between h-100">
                <img src="<?= ASSETS_FULL_URL . 'images/index/domains.png' ?>" class="index-card-image mb-2" loading="lazy" />

                <div class="card-body">
                    <div class="mb-2">
                        <span class="h5"><?= l('index.domains.header') ?></span>
                    </div>
                    <span class="text-muted"><?= l('index.domains.subheader') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="my-5">&nbsp;</div>

<div class="container">
    <div class="row">
        <div class="col-lg-7 mb-5">
            <img src="<?= ASSETS_FULL_URL . 'images/index/static.png' ?>" class="img-fluid shadow" loading="lazy" />
        </div>

        <div class="col-lg-5 mb-5 d-flex align-items-center">
            <div>
                <span class="p-3 bg-gray-200">
                    <i class="fa fa-fw fa-lg fa-qrcode text-primary"></i>
                </span>

                <h2 class="mt-4"><?= l('index.static.header') ?></h2>
                <p class="text-muted mt-3"><?= l('index.static.subheader') ?></p>

                <ul class="list-style-none mt-4">
                    <li class="d-flex align-items-center mb-2">
                        <i class="fa fa-fw fa-sm fa-check-circle text-success mr-3"></i>
                        <div><?= l('index.static.feature1') ?></div>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="fa fa-fw fa-sm fa-check-circle text-success mr-3"></i>
                        <div><?= l('index.static.feature2') ?></div>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="fa fa-fw fa-sm fa-check-circle text-success mr-3"></i>
                        <div><?= l('index.static.feature3') ?></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="my-5">&nbsp;</div>

<div class="container">
    <div class="row">
        <div class="col-lg-5 mb-5 d-flex align-items-center order-1 order-lg-0">
            <div>
                <span class="p-3 bg-gray-200">
                    <i class="fa fa-fw fa-lg fa-link text-primary"></i>
                </span>

                <h2 class="mt-4"><?= l('index.dynamic.header') ?></h2>
                <p class="text-muted mt-3"><?= l('index.dynamic.subheader') ?></p>

                <ul class="list-style-none mt-4">
                    <li class="d-flex align-items-center mb-2">
                        <i class="fa fa-fw fa-sm fa-check-circle text-success mr-3"></i>
                        <div><?= l('index.dynamic.feature1') ?></div>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="fa fa-fw fa-sm fa-check-circle text-success mr-3"></i>
                        <div><?= l('index.dynamic.feature2') ?></div>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="fa fa-fw fa-sm fa-check-circle text-success mr-3"></i>
                        <div><?= l('index.dynamic.feature3') ?></div>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="fa fa-fw fa-sm fa-check-circle text-success mr-3"></i>
                        <div><?= l('index.dynamic.feature4') ?></div>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="fa fa-fw fa-sm fa-check-circle text-success mr-3"></i>
                        <div><?= l('index.dynamic.feature5') ?></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-7 mb-5 order-0 order-lg-1">
            <img src="<?= ASSETS_FULL_URL . 'images/index/dynamic.png' ?>" class="img-fluid shadow" loading="lazy" />
        </div>
    </div>
</div>

<div class="my-5">&nbsp;</div>

<div class="container">
    <div class="text-center mb-5">
        <h2><?= l('index.qr_codes.header') ?></h2>
        <p class="text-muted"><?= l('index.qr_codes.subheader') ?></p>
    </div>

    <div class="row">
        <?php foreach($data->qr_code_settings['type'] as $key => $value): ?>
        <div class="col-12 col-lg-6 mb-4">
            <div class="card position-relative">
                <div class="card-body bg-gray-50 text-center d-flex flex-column">
                    <div class="mb-4"><i class="<?= $value['icon'] ?> fa-fw fa-2x"></i></div>
                    <h3 class="h4"><?= l('qr_codes.type.' . $key) ?></h3>
                    <p class="text-muted"><?= l('qr_codes.type.' . $key . '_description') ?></p>

                    <a href="<?= url('qr/' . $key) ?>" class="btn btn-block btn-sm btn-gray-200 mt-4 stretched-link">
                        <?= sprintf(l('index.qr_codes.choose'), l('qr_codes.type.' . $key)) ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>


<div class="my-5">&nbsp;</div>

<div class="container">
    <div class="text-center mb-5">
        <h2><?= l('index.pricing.header') ?></h2>
        <p class="text-muted"><?= l('index.pricing.header_help') ?></p>
    </div>

    <?= $this->views['plans'] ?>
</div>

<div class="my-5">&nbsp;</div>

<?php if(settings()->users->register_is_enabled): ?>
    <div class="bg-gray-100 py-6">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row justify-content-around align-items-lg-center">
                <div>
                    <h2 class="text-gray-900"><?= l('index.cta.header') ?></h2>
                    <p class="text-gray-800"><?= l('index.cta.subheader') ?></p>
                </div>

                <div>
                    <a href="<?= url('register') ?>" class="btn btn-primary index-button"><?= l('index.cta.register') ?></a>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>


