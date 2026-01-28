<!-- Breadcrumbs -->
<div class="container mt-4 clearfix">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item">
                <?= $cms['link_name'] ?: $cms['titlu'] ?>
            </li>
        </ol>
    </nav>
</div>
<!-- Breadcrumbs (end) -->

<div class="container mt-4 clearfix">
    <h1><?= $cms['title'] ?: $cms['link_name'] ?></h1>
    <?= $cms['text'] ?>
</div>

<? foreach ($authorsList AS $row) : ?>
    <div class="container mt-4 clearfix">
        <a href="<?= makeLink(LINK_RELATIVE, $cms, $row) ?>">
            <img src="<?= $row['image'] ? imageLink(IMAGES_AUTHOR, THUMB_SMALL, $row['image']) : '/public/project/images/author-placeholder.png' ?>"
                 alt="<?= $row['name'] ?>"
                 width="175"
                 class="float-start img-thumbnail me-2"
            >
        </a>
        <a class="h2 text-decoration-none" href="<?= makeLink(LINK_RELATIVE, $cms, $row) ?>"><?= $row['name'] ?></a>
        <p><?= shortText($row['text'], 250, true) ?></p>
    </div>
<? endforeach; ?>