<title><?= $siteTitle ?></title>
<meta name="description" content="<?= $siteDescription ?>" />
<meta http-equiv="Content-language" content="<?= getLang() ?: LANG_DEFAULT ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

<!-- Favicons -->
<link rel="apple-touch-icon" sizes="180x180" href="/public/<?= ASSETS_PATH ?>/images/favicon/apple-touch-icon.png?v=1.1">
<link rel="icon" type="image/png" sizes="32x32" href="/public/<?= ASSETS_PATH ?>/images/favicon/favicon-32x32.png?v=1.1">
<link rel="icon" type="image/png" sizes="16x16" href="/public/<?= ASSETS_PATH ?>/images/favicon/favicon-16x16.png?v=1.1">
<link rel="manifest" href="/public/<?= ASSETS_PATH ?>/images/favicon/site.webmanifest">
<link rel="mask-icon" href="/public/<?= ASSETS_PATH ?>/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="/public/<?= ASSETS_PATH ?>/images/favicon/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="/public/<?= ASSETS_PATH ?>/images/favicon/browserconfig.xml">
<meta name="theme-color" content="#ffffff">

<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />-->
<link rel="stylesheet" href="/public/admin/scss/material-dashboard.min.css?v=<?= settingsGet('version-admin-material-dashboard.min.css') ?>" />
<link rel="stylesheet" href="/public/admin/css/platform.min.css?v=<?= settingsGet('version-admin-platform.min.css') ?>" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/public/site/js/vendor/jquery/jquery-3.6.0.min.js"><\/script>')</script>