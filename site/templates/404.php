<!doctype html>
<head>
    <?= parseBlock('site.head'); ?>
</head>
<body>
<?= parseBlock('site.header') ?>
<a name="main"></a>
<div class="content <?= getPage() == 'home' ? 'alternate' : '' ?> <?= $contentClass ?>">
    <div class="con404">
        <?= parseView(getPage()) ?>
    </div>
</div><!-- content -->
<?= parseBlock('site.footer') ?>

<?= parseView('site.js') ?>
<?= parseBlock('@form.init') ?>
<?= parseJavaScript() ?>
</body>
</html>