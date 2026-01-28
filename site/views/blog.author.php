<!-- Breadcrumbs -->
<div class="container mt-4 clearfix">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= makeLink(LINK_RELATIVE, $id_page) ?>" title="<?= $id_page['link_name'] ?>"><?= $id_page['link_name'] ?></a>
            </li>
            <li class="breadcrumb-item">
                <span><?= $id_author['name'] ?></span>
            </li>
        </ol>
    </nav>
</div>
<!-- Breadcrumbs (end) -->

<div class="container mt-4 clearfix">
    <!-- Title & Image -->
    <img src="<?= imageLink(IMAGES_AUTHOR, THUMB_SMALL, $id_author['image']) ?>"
         alt="<?= $id_author['name'] ?>"
         width="175"
         class="float-start img-thumbnail me-2" />
    <h1><?= $id_author['name'] ?></h1>
    <? if ($id_author['profile_title']) : ?>
        <span class="text-muted"><?= $id_author['profile_title'] ?></span>
    <? endif; ?>

    <!-- Content -->
    <div class="clearfix">
        <?= $id_author['text'] ?>
    </div>

    <!-- Blog posts -->
    <h2 class="mt-4">Postari redactate de <?= $id_author['name'] ?></h2>
    <ul>
    <? foreach($blogList AS $row) : ?>
        <li>
            <a href="<?= blogLink(LINK_RELATIVE, $row) ?>"><?= $row['title'] ?></a> - <?= date('d.m.Y', $row['date_publish']) ?>
        </li>
    <? endforeach; ?>
    </ul>
</div>

<? captureJavaScriptStart(); ?>
<!-- Breadcrumbs -->
<? $i = 0; ?>
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
            "@type": "ListItem",
            "position": <?= ++$i ?>,
            "name": "<?= $id_page['link_name'] ?>",
            "item": "<?= makeLink(LINK_ABSOLUTE, $id_page) ?>"
        },
        {
            "@type": "ListItem",
            "position": <?= ++$i ?>,
            "name": "<?= $id_author['name'] ?>"
        }]
    }
</script>
<!-- Breadcrumbs (end) -->

<!-- Author -->
<script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "<?= strtolower($id_author['name']) != settingsGet('email-from-name') ? 'Person' : 'Organization' ?>",
            "gender": "<?= (in_array($id_author['profile_gender'], ['Female', 'Male']) ? "http://schema.org/" : '') . $id_author['profile_gender'] ?>",
            "name": "<?= $id_author['name'] ?>",
            "sameAs": [
                <? foreach (['profile_facebook', 'profile_linkedin', 'profile_instagram', 'profile_twitter'] AS $i => $key) : ?>
                    <? if ($id_author[$key]) : ?>
                        <?= $isPrev ? ',' : '' ?>
                        "<?= $id_author[$key] ?>"
                        <? $isPrev = 1; ?>
                    <? endif; ?>
                <? endforeach; ?>
        ],
        <? if ($id_author['image']) : ?>
            "image": "<?= imageLink(IMAGES_AUTHOR, THUMB_SMALL, $id_author['image'], LINK_ABSOLUTE) ?>",
        <? endif; ?>
        "jobTitle": "<?= $id_author['profile_title'] ?>",
        "email": "<?= $id_author['profile_email'] ?>"
    }
    </script>
<!-- Author (end) -->
<? captureJavaScriptEnd(); ?>