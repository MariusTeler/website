<!-- Box - CTA Background Image -->
<div class="position-relative py-5 text-center">
    <? if ($various['image']) : ?>
        <img class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover <?= $various['metadata']['cta_bg_position'] ?> <?= $various['metadata']['cta_bg_opacity'] ?> z-n1"
             src="<?= imageLink(IMAGES_VARIOUS, THUMB_LARGE, $various['image']) ?>"
             alt="" />
    <? endif; ?>
    <div class="container py-4 pt-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 fw-light">
                <h2 class="mb-4 ls-wider"><?= $various['title'] ?></h2>
                <?= $various['text'] ?>
                <? if ($various['metadata']['button_text']) : ?>
                    <a href="<?= buttonLink($various['metadata']) ?>"
                       <?= menuPopup(['is_popup' => $various['metadata']['button_is_popup']]) ?>
                       class="btn btn-danger py-3 px-5 mt-4 rounded-5">
                        <?= $various['metadata']['button_text'] ?>
                    </a>
                <? endif; ?>
                <? if ($various['metadata']['button2_text']) : ?>
                    <a href="<?= buttonLink($various['metadata'], 'button2_') ?>"
                       <?= menuPopup(['is_popup' => $various['metadata']['button2_is_popup']]) ?>
                       class="btn btn-outline-light py-3 px-5 mt-4 ms-md-2 rounded-5">
                        <?= $various['metadata']['button2_text'] ?>
                    </a>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>