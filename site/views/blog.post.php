<!-- Breadcrumbs -->
<div class="container mt-5 pt-5">
    <nav aria-label="breadcrumb" class="mt-lg-5 pt-lg-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= makeLink(LINK_RELATIVE, $id_page) ?>"
                   title="<?= $id_page['link_name'] ?>"
                   class="text-decoration-none"><?= $id_page['link_name'] ?></a>
            </li>
            <? if($id_subpage) : ?>
                <li class="breadcrumb-item">
                    <a href="<?= makeLink(LINK_RELATIVE, $id_page, $id_subpage) ?>"
                       title="<?= $id_subpage['link_name'] ?>"
                       class="text-decoration-none"><?= $id_subpage['link_name'] ?></a>
                </li>
            <? endif; ?>
        </ol>
    </nav>
    <hr class="opacity-50" />
</div>
<!-- Breadcrumbs (end) -->

<div class="container container-image-fluid mt-0 mb-4 mb-lg-5 pb-4 fw-light fs-5">
    <!-- Title & Image -->
    <h1><?= $id_blog['title'] ?></h1>
    <p><?= $id_blog['text_intro'] ?></p>
    <? if ($id_blog['metadata']['video_intro']) : ?>
        <div class="video-container ratio ratio-16x9">
            <?= htmlspecialchars_decode($id_blog['metadata']['video_intro']) ?>
        </div>
    <? else : ?>
        <div class="corner">
            <img src="<?= imageLink(IMAGES_BLOG, THUMB_MEDIUM, $id_blog['image'], LINK_RELATIVE, $id_blog['image_timestamp']) ?>"
                 alt="<?= $id_blog['title'] ?>"
                 class="w-100" />
        </div>
    <? endif; ?>

    <!-- Table of contents -->
    <? if ($id_blog['title_links'] && is_array($id_blog['title_links'])) : ?>
        <h2 class="mt-5">Curpins</h2>
        <ul>
            <?= implode('', $id_blog['title_links']) ?>
        </ul>
        <hr class="mt-5 opacity-50" />
    <? endif; ?>

    <? foreach ($contentBlocks as $block) : ?>
        <? if ($block['html']) : ?>
            <div class="container container-image-fluid my-4 my-lg-5 py-4 fw-light fs-5">
                <?= $block['html'] ?>
            </div>
        <? elseif ($block['type'] == ENTITY_LIST) : ?>
            <!-- List -->
            <? parseVar('isHome', $isHome, '@init.list') ?>
            <? parseVar('blockId', $block['id'], '@init.list') ?>
            <?= parseBlock('@init.list') ?>
        <? elseif ($block['type'] == ENTITY_VARIOUS) : ?>
            <!-- Various -->
            <? parseVar('isHome', $isHome, '@init.various') ?>
            <? parseVar('blockId', $block['id'], '@init.various') ?>
            <?= parseBlock('@init.various') ?>
        <? endif; ?>
    <? endforeach; ?>

    <!-- Author -->
    <div class="d-flex flex-wrap align-items-center mb-4">
        <? if ($author['image']) : ?>
            <img src="<?= imageLink(IMAGES_AUTHOR, THUMB_SMALL, $author['image']) ?>"
                 alt="<?= $author['name'] ?>, <?= $author['profile_title'] ?>"
                 width="75"
                 class="me-3 rounded-circle">
        <? endif; ?>
        <span class="d-inline-block small">
            <? if ($author['status']) : ?>
                <a href="#" class="text-decoration-none fw-bold"><?= $author['name'] ?></a>
            <? else : ?>
                <?= $author['name'] ?>
            <? endif; ?>
            <br />
            <?= $author['profile_title'] ?>
        </span>
        <span class="d-inline-block mt-3 mt-md-0 ms-md-auto text-center text-md-end w-100 w-md-auto small">
            <?= ucfirst(strftime('%A', $id_blog['date_publish'])) ?>, <?= date('d.m.Y', $id_blog['date_publish']) ?><br />
            <? if ($id_blog['date_update']) : ?>
                Actualizat <?= ucfirst(strftime('%A', $id_blog['date_update'])) ?>, <?= date('d.m.Y', $id_blog['date_update']) ?>
            <? endif; ?>
        </span>
    </div>
    <hr class="opacity-100" />
</div>

<!-- Recommended posts -->
<?= parseBlock('cms.various.blog') ?>

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
        <? if($id_subpage) : ?>
        {
            "@type": "ListItem",
            "position": <?= ++$i ?>,
            "name": "<?= $id_subpage['link_name'] ?>",
            "item": "<?= makeLink(LINK_ABSOLUTE, $id_page, $id_subpage) ?>"
        },
        <? endif; ?>
        {
            "@type": "ListItem",
            "position": <?= ++$i ?>,
            "name": "<?= $id_blog['title'] ?>"
        }]
    }
</script>
<!-- Breadcrumbs (end) -->

<!-- Article -->
<script type="application/ld+json">
    {
        "@context": "http://schema.org/",
        "@type": "Article",
        "headLine": "<?= $id_blog['title'] ?>",
        "datePublished": "<?= date('c', $id_blog['date_publish']) ?>",
        <? if ($id_blog['date_update']) : ?>
            "dateModified": "<?= date('c', $id_blog['date_update']) ?>",
        <? endif; ?>
        "author": {
            "@type": "<?= strtolower($author['name']) != settingsGet('email-from-name') ? 'Person' : 'Organization' ?>",
            <? if ($author['status']) : ?>
                "url": "<?= makeLink(LINK_ABSOLUTE, $authorPage, $author) ?>",
            <? endif; ?>
            "name": "<?= $author['name'] ?>"
        },
        "publisher": {
            "@type": "Organization",
            "name": "<?= settingsGet('email-from-name') ?>",
            "logo": {
                "@type": "ImageObject",
                "url": "<?= $websiteURL ?>public/project/images/logo.jpg",
                "width": 279,
                "height": 104
            }
        },
        "image": [
            "<?= imageLink(IMAGES_BLOG, THUMB_MEDIUM, $id_blog['image'], LINK_ABSOLUTE) ?>",
            "<?= imageLink(IMAGES_BLOG, THUMB_FACEBOOK, $id_blog['image'], LINK_ABSOLUTE) ?>"
        ],
        "articleBody": "<?= htmlspecialchars(strip_tags($id_blog['text']), ENT_COMPAT, 'UTF-8', false) ?>"
    }
</script>
<!-- Article (end) -->
<? captureJavaScriptEnd(); ?>