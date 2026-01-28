<!-- Box - CTA Simple -->
<div class="container my-5 py-4 py-lg-5">
    <div class="position-relative my-lg-4 mx-4 mx-lg-0 py-5 py-lg-0 px-4 px-lg-0 corner clip-path-lg-none"
         style="--background-color: var(--bs-body-bg); --border-color: var(--bs-light);">
        <div class="row justify-content-center">
            <div class="col-lg-7 fw-light text-center">
                <h2 class="mb-4 mb-lg-1 ls-wider"><?= $various['title'] ?></h2>
                <?= $various['text'] ?>
            </div>
            <? if ($various['metadata']['button_text']) : ?>
                <div class="col-lg-4 mt-5 mt-lg-0 text-center text-lg-start">
                    <a href="<?= buttonLink($various['metadata']) ?>"
                       <?= menuPopup(['is_popup' => $various['metadata']['button_is_popup']]) ?>
                       class="btn btn-danger py-3 px-5 rounded-5">
                        <?= $various['metadata']['button_text'] ?>
                    </a>
                </div>
            <? endif; ?>
        </div>
    </div>
</div>