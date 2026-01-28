<!-- Box - Address -->
<div class="container my-4 py-4">
    <div class="position-relative fw-light">
        <div class="mb-4 pb-3 border-bottom border-white border-2">
            <div class="h3 ps-5 position-relative fw-light">
                <span class="position-absolute top-0 start-0 mt-2 icon icon-phone fs-5"></span>
                <?= $various['title'] ?>
            </div>
            <div class="h3 ps-5 fw-bold text-danger">
                <?= $various['text'] ?>
            </div>
        </div>
        <div class="h3 ps-5 position-relative fw-light">
            <span class="position-absolute top-0 start-0 mt-2 icon icon-map-pin fs-5"></span>
            <?= $various['metadata']['address_title'] ?> <br class="d-md-none" />
            <div class="d-inline-block fw-bold"><?= nl2br($various['metadata']['address_text']) ?></div>
        </div>
    </div>
</div>