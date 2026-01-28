<!-- Box - CTA Phone -->
<div class="container position-relative my-5 py-5 bg-primary bg-opacity-25 fw-light">
    <div class="d-none d-xl-block position-absolute top-0 start-0 h-100 ms-n5 ps-5 bg-primary bg-opacity-25"></div>
    <div class="d-none d-xl-block position-absolute top-0 start-100 h-100 me-n5 ps-5 bg-primary bg-opacity-25"></div>

    <h2 class="fw-light ls-wide"><?= $various['title'] ?></h2>
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-baseline fs-5">
        <div>
            <?= $various['text'] ?>
        </div>
        <div class="flex-grow-1 text-center">
            <? if ($various['metadata']['button_text']) : ?>
                <a href="<?= buttonLink($various['metadata']) ?>"
                   <?= menuPopup(['is_popup' => $various['metadata']['button_is_popup']]) ?>
                   class="text-danger fs-1 fw-bold text-decoration-none">
                    <?= $various['metadata']['button_text'] ?>
                </a>
            <? endif; ?>
        </div>
    </div>
</div>