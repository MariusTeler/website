<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?= getLang() ?: LANG_DEFAULT ?>">
<html data-bs-theme="dark">
    <head>
        <?= parseBlock('site.head'); ?>
        <?= settingsGet('analytics-codes-head') ?>
    </head>
    <body class="ls-normal">
        <?= settingsGet('analytics-codes-header') ?>
        <div class="header">
            <?= parseBlock('site.header') ?>
        </div>
        <div class="clear"></div>

        <div class="content">
            <?= parseView(getPage()) ?>
            <? parseVar('isInline', true, 'box.banner') ?>
            <?= parseBlock('box.banner') ?>
        </div>
        <div class="clear"></div>

        <div class="footer">
            <?= parseBlock('site.footer') ?>
        </div>
        <div class="clear"></div>

        <?//= parseBlock('cms.contact') ?>
        <?//= parseView('box.banner') ?>
        <?= parseView('cms.cookies') ?>
        <?= parseView('box.phone.floating') ?>
        <?= parseView('site.js') ?>
        <?= parseView('@form.init') ?>
        <?= parseView('@init.select2') ?>
        <?= parseJavaScript() ?>
        <?= settingsGet('analytics-codes-footer') ?>
    </body>
</html>