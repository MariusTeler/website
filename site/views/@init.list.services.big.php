<!-- Box - Services > Big -->
<div class="py-4 py-md-5">
    <div class="container py-4 py-md-5 pb-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-xl-9 fw-light">
                <h2 class="mb-4 pb-3 ls-wider text-center"><?= $listInfo['title'] ?></h2>
                <h3 class="mb-0 pb-4 fw-normal">
                    <?= $listInfo['text'] ?>
                </h3>
                <div class="row justify-content-center">
                    <? foreach($listInfo['rows'] as $row) : ?>
                        <div class="col-10 col-sm-6 col-lg-4 mb-5">
                            <div class="d-flex flex-column h-100 px-4 py-4 corner"
                                 style="--background-color: var(--bs-primary-rgb); --border-color: var(--bs-white); --edge-size-left: 4.5rem;">
                                <img class="mt-2 px-4"
                                     src="<?= imageLink(IMAGES_LIST, THUMB_ORIGINAL, $row['image'], LINK_RELATIVE, $row['image_timestamp']) ?>"
                                     alt="<?= $row['title'] ?>" />
                                <div class="mt-3 mb-3 ms-5 me-3 flex-grow-1 flex-shrink-1 text-secondary">
                                    <div class="mb-4 text-center text-black fw-bold"><?= $row['title'] ?></div>
                                    <div class="small fw-bolder">
                                        <?= $row['text'] ?>
                                    </div>
                                </div>
                                <div class="mt-2 mb-3 ms-5 text-center">
                                    <? if ($row['metadata']['button_text']) : ?>
                                        <a href="<?= buttonLink($row['metadata']) ?>"
                                           <?= menuPopup(['is_popup' => $row['metadata']['button_is_popup']]) ?>
                                           class="btn btn-sm btn-danger py-2 px-4 rounded-5">
                                            <?= $row['metadata']['button_text'] ?>
                                        </a>
                                    <? endif; ?>
                                </div>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>