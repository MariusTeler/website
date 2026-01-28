<?
    $activeMenu = activeMenu();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?= getLang() ?: LANG_DEFAULT ?>">
    <head>
        <?= parseBlock('site.head'); ?>
    </head>
    <body class="<?= in_array(-1, $activeMenu) === TRUE ? 'sidebar-mini' : '' ?>">
        <div class="wrapper">
            <?= parseBlock('site.left') ?>
            <div class="main-panel">
                <?= parseBlock('site.header') ?>
                <div class="content">
                    <div class="container-fluid">
                        <div id="boxHelp" class="hidden"></div>
                        <?= parseBlock('site.alerts') ?>
                        <?= parseView(getPage()) ?>
                    </div>
                </div>
                <?//= parseView('site.footer') ?>
            </div>
        </div>
        <div id="ajaxAlert"></div>
        <?= parseView('site.js') ?>
        <?= parseView('@init.form') ?>
        <?= parseView('@init.editor') ?>
        <?= parseView('@init.uploadify') ?>
        <?= parseView('@init.jcrop') ?>
        <?= parseView('@init.jquery') ?>
        <?= parseView('@init.tables.pagination') ?>
        <?= parseJavaScript() ?>
    </body>
</html>