<?php defined('ALTUMCODE') || die() ?>

<div>
    <div class="form-group">
        <label for="domains_is_enabled"><?= l('admin_settings.links.domains_is_enabled') ?></label>
        <select id="domains_is_enabled" name="domains_is_enabled" class="form-control form-control-lg">
            <option value="1" <?= settings()->links->domains_is_enabled ? 'selected="selected"' : null ?>><?= l('global.yes') ?></option>
            <option value="0" <?= !settings()->links->domains_is_enabled ? 'selected="selected"' : null ?>><?= l('global.no') ?></option>
        </select>
        <small class="form-text text-muted"><?= l('admin_settings.links.domains_is_enabled_help') ?></small>
    </div>

    <div class="form-group">
        <label for="additional_domains_is_enabled"><?= l('admin_settings.links.additional_domains_is_enabled') ?></label>
        <select id="additional_domains_is_enabled" name="additional_domains_is_enabled" class="form-control form-control-lg">
            <option value="1" <?= settings()->links->additional_domains_is_enabled ? 'selected="selected"' : null ?>><?= l('global.yes') ?></option>
            <option value="0" <?= !settings()->links->additional_domains_is_enabled ? 'selected="selected"' : null ?>><?= l('global.no') ?></option>
        </select>
        <small class="form-text text-muted"><?= l('admin_settings.links.additional_domains_is_enabled_help') ?></small>
    </div>

    <div class="form-group">
        <label for="main_domain_is_enabled"><?= l('admin_settings.links.main_domain_is_enabled') ?></label>
        <select id="main_domain_is_enabled" name="main_domain_is_enabled" class="form-control form-control-lg">
            <option value="1" <?= settings()->links->main_domain_is_enabled ? 'selected="selected"' : null ?>><?= l('global.yes') ?></option>
            <option value="0" <?= !settings()->links->main_domain_is_enabled ? 'selected="selected"' : null ?>><?= l('global.no') ?></option>
        </select>
        <small class="form-text text-muted"><?= l('admin_settings.links.main_domain_is_enabled_help') ?></small>
    </div>

    <div class="form-group">
        <label for="blacklisted_domains"><?= l('admin_settings.links.blacklisted_domains') ?></label>
        <textarea id="blacklisted_domains" class="form-control form-control-lg" name="blacklisted_domains"><?= settings()->links->blacklisted_domains ?></textarea>
        <small class="form-text text-muted"><?= l('admin_settings.links.blacklisted_domains_help') ?></small>
    </div>

    <div class="form-group">
        <label for="blacklisted_keywords"><?= l('admin_settings.links.blacklisted_keywords') ?></label>
        <textarea id="blacklisted_keywords" class="form-control form-control-lg" name="blacklisted_keywords"><?= settings()->links->blacklisted_keywords ?></textarea>
        <small class="form-text text-muted"><?= l('admin_settings.links.blacklisted_keywords_help') ?></small>
    </div>

    <div class="form-group">
        <label for="google_safe_browsing_is_enabled"><?= l('admin_settings.links.google_safe_browsing_is_enabled') ?></label>
        <select id="google_safe_browsing_is_enabled" name="google_safe_browsing_is_enabled" class="form-control form-control-lg">
            <option value="1" <?= settings()->links->google_safe_browsing_is_enabled ? 'selected="selected"' : null ?>><?= l('global.yes') ?></option>
            <option value="0" <?= !settings()->links->google_safe_browsing_is_enabled ? 'selected="selected"' : null ?>><?= l('global.no') ?></option>
        </select>
        <small class="form-text text-muted"><?= l('admin_settings.links.google_safe_browsing_is_enabled_help') ?></small>
    </div>

    <div class="form-group">
        <label for="google_safe_browsing_api_key"><?= l('admin_settings.links.google_safe_browsing_api_key') ?></label>
        <input id="google_safe_browsing_api_key" type="text" name="google_safe_browsing_api_key" class="form-control form-control-lg" value="<?= settings()->links->google_safe_browsing_api_key ?>" />
    </div>
</div>

<button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
