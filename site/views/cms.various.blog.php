<? if ($blogList) : ?>
    <div class="container container-image-fluid mt-n4 mt-lg-n5 mb-4 fw-light fs-5">
        <h2 class="ls-wide"><?= $various['title'] ?: 'Postări recomandate' ?></h2>
        <?= $various['text'] ?>
    </div>

    <div class="container mb-5">
        <div class="row d-flex mb-2 g-4">
            <? foreach ($blogList as $row) : ?>
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="g-0 overflow-hidden d-flex flex-column mb-4 position-relative">
                        <div>
                            <img src="<?= imageLink(IMAGES_BLOG, THUMB_MEDIUM, $row['image']) ?>" alt="<?= $row['title'] ?>" class="mw-100" />
                        </div>
                        <div class="pt-4">
                            <a href="<?= blogLink(LINK_RELATIVE, $row) ?>" class="stretched-link text-decoration-none">
                                <h3 class="h3 fw-light"><?= $row['title'] ?></h3>
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
    </div>
<? endif; ?>
