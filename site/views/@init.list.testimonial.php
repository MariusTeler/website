<? $listCount = count($listInfo['rows']); ?>
<div class="container mt-4 clearfix">
    <h2><?= $listInfo['title'] ?></h2>
    <?= $listInfo['text'] ?>
    <div class="row text-center d-flex justify-content-around">
        <? foreach($listInfo['rows'] as $i2 => $row2) : ?>
            <div class="col-md-4 mb-5 mb-md-0">
                <img class="rounded-circle shadow-1-strong mb-4"
                     src="<?= imageLink(IMAGES_LIST, THUMB_SMALL, $row2['image']) ?>" alt="<?= $row2['title'] ?>"
                     style="width: 150px;" />
                <p class="h5 mb-3"><?= $row2['title'] ?></p>
                <p class="h6 text-primary mb-3""><?= $row2['subtitle'] ?></h6>
                <p class="px-xl-3">
                    <?= nl2br($row2['text']) ?>
                </p>
            </div>
            <? if ($i2 == 2 && $listCount > 3) : $isContainer = true; ?>
                <div class="col-12 mb-5 mb-md-0">
                    <a class="btn btn-outline-primary toggle-view"
                       href="javascript:;"
                       data-target="#testimonial-container-<?= $blockId ?>"
                       data-toggle-self="true"><i class="icon-down"></i> Vezi mai multe testimoniale</a>
                </div>
                <div class="hide" id="testimonial-container-<?= $blockId ?>">
            <? endif; ?>
        <? endforeach; ?>
        <? if ($isContainer) : ?>
            </div>
        <? endif; ?>
    </div>
</div>