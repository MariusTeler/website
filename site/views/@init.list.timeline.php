<!-- Box - Timeline -->
<div class="position-relative py-5">
    <img class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover object-position-center opacity-25 z-n1"
         src="/public/<?= ASSETS_PATH ?>/images/design/box-timeline.jpg"
         alt="" />
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12 fw-light">
                <h2 class="mb-0_ ls-wider"><?= $listInfo['title'] ?></h2>
                <h3 class="mb-5 fw-normal">
                    <?= $listInfo['text'] ?>
                </h3>
                <div class="d-flex vh-70 vh-md-60 max-vh-70 max-vh-md-60 overflow-x-auto no-scrollbar"
                     style="padding-bottom: 4rem;">
                    <? foreach ($listInfo['rows'] as $row) : ?>
                        <? if ($row['text'] || $row['metadata']['button_text']) : ?>
                            <div class="position-relative d-flex flex-column justify-content-end min-w-80 min-w-md-50 min-w-lg-30 px-3 px-lg-5 border-bottom border-3 border-white">
                                <div class="w-100 mh-90 overflow-y-auto no-scrollbar mb-5 py-4 px-4 bg-white text-secondary">
                                    <div class="mb-3 text-black fw-bold"><?= $row['title'] ?></div>
                                    <?= $row['text'] ?>
                                    <? if ($row['metadata']['button_text']) : ?>
                                        <a href="<?= buttonLink($row['metadata']) ?>"
                                           <?= menuPopup(['is_popup' => $row['metadata']['button_is_popup']]) ?>
                                           class="btn btn-sm btn-danger py-2 px-4 rounded-5">
                                            <?= $row['metadata']['button_text'] ?>
                                        </a>
                                    <? endif; ?>
                                </div>
                                <div class="position-absolute bottom-0 top-100 mt-3 ms-4">
                                    <span class="small"><?= $row['metadata']['month'] ?></span><br />
                                    <span class="fw-bold"><?= $row['metadata']['year'] ?></span>
                                </div>
                                <div class="position-absolute bottom-0 top-100 mt-n5 ms-4 border-top border-start border-end w-0 h-0"
                                     style="--bs-border-width: 10px;
                                        --bs-border-color: transparent;
                                        border-top-color: var(--bs-white) !important;"></div>
                                <div class="position-absolute bottom-0 top-100 translate-middle-y ms-4 rounded-circle bg-white"
                                     style="width: 15px; height: 15px;"></div>
                            </div>
                        <? else : ?>
                            <div class="position-relative d-flex flex-column justify-content-end px-5 border-bottom border-3 border-white">
                                <div class="position-relative w-100 mh-90 mb-5 py-4 px-4"
                                     style="transform: rotate(-90deg) translateY(100%); transform-origin: bottom left;">
                                    &nbsp;
                                    <div class="position-absolute top-0 left-0 ms-n4 py-4 px-4 bg-primary text-nowrap"><?= $row['title'] ?></div>
                                </div>
                                <div class="position-absolute bottom-0 top-100 mt-3 ms-4">
                                    <span class="small"><?= $row['metadata']['month'] ?></span><br />
                                    <span class="fw-bold"><?= $row['metadata']['year'] ?></span>
                                </div>
                                <div class="position-absolute bottom-0 top-100 mt-n5 ms-4 border-top border-start border-end w-0 h-0"
                                     style="--bs-border-width: 10px;
                                        --bs-border-color: transparent;
                                        border-top-color: var(--bs-primary) !important;"></div>
                                <div class="position-absolute bottom-0 top-100 translate-middle-y ms-4 rounded-circle bg-white"
                                     style="width: 15px; height: 15px;"></div>
                            </div>
                        <? endif; ?>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>