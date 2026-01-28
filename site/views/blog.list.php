<? parseVar('isHeader', true, 'cms.newsletter'); ?>
<?= parseBlock('cms.newsletter') ?>

<div class="container container-image-fluid mt-n4 mt-lg-n5 mb-4 fw-light fs-5">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb fs-6">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none">Home</a>
            </li>
            <? if($id_subpage) : ?>
                <li class="breadcrumb-item">
                    <a href="<?= makeLink(LINK_RELATIVE, $id_page) ?>"
                       title="<?= $id_page['link_name'] ?>"
                       class="text-decoration-none"><?= $id_page['link_name'] ?></a>
                </li>
            <? endif; ?>
            <? if($page_nr > 1) : ?>
                <li class="breadcrumb-item">
                    <a href="<?= $pageLink ?>"
                       title="<?= $cms['link_name'] ?>"
                       class="text-decoration-none"><?= $cms['link_name'] ?></a>
                </li>
                <li class="breadcrumb-item">
                    Pagina <?= $page_nr ?>
                </li>
            <? else : ?>
                <li class="breadcrumb-item">
                    <?= $cms['link_name'] ?: $cms['titlu'] ?>
                </li>
            <? endif; ?>
        </ol>
    </nav>
    <!-- Breadcrumbs (end) -->

    <h1 class="h2 ls-wide"><?= $cms['title'] ?: $cms['link_name'] ?></h1>
    <?= $cms['text'] ?>
</div>

<div class="container mb-5">
    <div class="row d-flex mb-2 g-4">
        <? foreach ($blogList as $row) : ?>
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="g-0 overflow-hidden d-flex flex-column mb-4 position-relative">
                    <div>
                        <img src="<?= imageLink(IMAGES_BLOG, THUMB_MEDIUM, $row['image'], LINK_RELATIVE, $row['image_timestamp']) ?>"
                             alt="<?= $row['title'] ?>"
                             class="mw-100" />
                    </div>
                    <div class="pt-4">
                        <a href="<?= blogLink(LINK_RELATIVE, $row) ?>" class="stretched-link text-decoration-none">
                            <h2 class="h3 fw-light"><?= $row['title'] ?></h2>
                        </a>
                        <p class="card-text mb-auto fw-light"><?= $row['text_intro'] ?></p>
                    </div>
                    <div class="mt-auto">
                        <hr class="my-3 opacity-50" />
                        <div class="fw-light"><?= $row['author'] ?> &nbsp;•&nbsp; <?= date('d.m.Y', $row['date_publish']) ?></div>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
    </div>
    <?
        parseVar('pages', $pages, 'blog.pagination');
        parseVar('page_nr', $page_nr, 'blog.pagination');
        parseVar('pageLink', $pageLink, 'blog.pagination');
    ?>
    <?= parseView('blog.pagination') ?>
</div>