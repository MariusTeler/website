<title><?= $siteTitle . (settingsGet('seo-title') ? ' - ' . settingsGet('seo-title') : '') ?></title>
<meta name="description" content="<?= $siteDescription ?>" />
<meta http-equiv="Content-language" content="<?= getLang() ?: LANG_DEFAULT ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
<meta name="format-detection" content="telephone=no">
<meta property="og:locale" content="ro_RO" />
<meta property="og:site_name" content="<?= settingsGet('facebook-og-site-name') ?>"/>
<meta property="og:type" content="<?= $fbType ?>" />
<meta property="og:url" content="<?= $fbURL ?>"/>
<meta property="og:title" content="<?= $fbTitle ?>"/>
<meta property="og:description" content="<?= $fbDescription ?>"/>
<meta property="og:image" content="<?= $fbImage?>"/>
<meta property="og:image:width" content="<?= $fbImageWidth ?>" />
<meta property="og:image:height" content="<?= $fbImageHeight ?>" />
<meta property="article:publisher" content="<?= settingsGet('facebook-article-publisher') ?>"/>
<meta property="article:author" content="<?= $fbAuthor ?>"/>
<meta property="article:published_time" content="<?= $fbPublishedTime ?>"/>
<meta property="article:modified_time" content="<?= $fbModifiedTime ?>"/>

<? if ($siteCanonical) : ?>
    <link rel="canonical" href="<?= $siteCanonical ?>" />
<? endif; ?>
<? if ($ampURL) : ?>
    <link rel="amphtml" href="<?= $ampURL ?>" />
<? endif; ?>
<? if ($noIndex) : ?>
    <meta name="robots" content="noindex" />
<? endif; ?>

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

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
<!--<link rel="stylesheet" href="/public/site/js/vendor/jquery_fancybox-v3.0/jquery.fancybox.min.css" type="text/css" media="screen" />-->
<link rel="stylesheet" href="/public/<?= ASSETS_PATH ?>/css/style.min.css?v=<?= settingsGet('version-style.min.css') ?>" type="text/css"/>