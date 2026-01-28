<!-- List - Careers -->
<div class="container my-5 py-4 py-lg-5">
    <div class="position-relative my-lg-4 fw-light">
        <h2 class="mb-4 ls-wider"><?= $listInfo['title'] ?></h2>
        <div class="fs-5">
            <?= $listInfo['text'] ?>
        </div>
        <? foreach($listInfo['rows'] AS $i => $row) : ?>
            <? $rId =  $blockId . $i; ?>
            <div class="py-4 py-md-5 border-bottom border-3 border-white">
                <a href="javascript: void(0);"
                   id="job-title-<?= $rId ?>"
                   class="d-block position-relative h2 ms-5 mb-0 fw-light text-decoration-none toggle-view"
                   data-target="#job-desc-<?= $rId ?>,#job-title-<?= $rId ?> .j-open,#job-title-<?= $rId ?> .j-close"
                   data-toggle-target-time="10">
                    <span class="position-absolute start-0 top-0 ms-n5 fs-2 fw-bold"><?= $i + 1 ?>.</span>
                    <span class="position-absolute end-0 top-0 ms-n5 icon icon-arrow-left-bold fs-3 lh-base text-danger j-open"
                          style="transform: rotate(-90deg);"></span>
                    <span class="position-absolute end-0 top-0 ms-n5 icon icon-arrow-left-bold fs-3 lh-base text-danger j-close hide"
                          style="transform: rotate(90deg);"></span>
                    <?= $row['title'] ?>
                </a>
                <div class="mt-5 ms-5 mb-4 fs-5 hide" id="job-desc-<?= $rId ?>">
                    <?= $row['text'] ?>
                    <? if ($row['metadata']['button_text']) : ?>
                        <a href="<?= buttonLink($row['metadata']) ?>"
                           <?= menuPopup(['is_popup' => $row['metadata']['button_is_popup']]) ?>
                           class="btn btn-danger mt-4 py-3 px-5 rounded-5">
                            <?= $row['metadata']['button_text'] ?>
                        </a>
                    <? endif; ?>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>