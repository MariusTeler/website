<!-- Box - Services > Dark -->
<div class="container position-relative overflow-hidden overflow-lg-visible">
    <div class="mt-5 pt-md-5 pb-4 pb-md-5">
        <div class="row mb-5">
            <div class="col-xl-11 offset-xl-1">
                <h2 class="mb-4 ls-wider"><?= $listInfo['title'] ?></h2>
            </div>
            <div class="col-lg-10 col-xl-7 offset-lg-1 offset-xl-3 fw-light">
                <h3 class="mb-4 fw-normal">
                    <?= $listInfo['text'] ?>
                </h3>
                <div class="row justify-content-center g-md-5">
                    <? foreach ($listInfo['rows'] as $row) : ?>
                        <div class="col-8 col-sm-4 col-md-4 mb-4">
                            <div class="d-flex flex-column h-100 px-4 py-4 corner"
                                 style="--background-color: var(--bs-primary-rgb); --border-color: var(--bs-white);">
                                <img class="mt-2 px-4"
                                     src="<?= imageLink(IMAGES_LIST, THUMB_ORIGINAL, $row['image'], LINK_RELATIVE, $row['image_timestamp']) ?>"
                                     alt="<?= $row['title'] ?>" />
                                <div class="mt-3 mb-3 flex-grow-1 flex-shrink-1 text-center text-secondary">
                                    <div class="mb-3 text-black fw-bold"><?= $row['title'] ?></div>
                                    <div class="small fw-bolder">
                                        <?= $row['text'] ?>
                                    </div>
                                </div>
                                <? if ($row['metadata']['button_text']) : ?>
                                    <a href="<?= buttonLink($row['metadata']) ?>"
                                       <?= menuPopup(['is_popup' => $row['metadata']['button_is_popup']]) ?>
                                       class="btn btn-sm btn-link text-primary fw-bold align-self-end mb-n3">
                                        <?= $row['metadata']['button_text'] ?> >
                                    </a>
                                <? endif; ?>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <img class="d-lg-none position-absolute top-0 start-100 translate-middle-x w-100 mt-5 opacity-50 z-n1"
         style="filter: invert(32%) sepia(45%) saturate(6682%) hue-rotate(230deg) brightness(93%) contrast(92%);"
         src="/public/<?= ASSETS_PATH ?>/images/design/pyramid.svg"
         alt="" />
    <img class="d-none d-lg-block position-absolute bottom-0 start-0 w-lg-35 ms-4 opacity-50 z-n1"
         style="filter: invert(32%) sepia(45%) saturate(6682%) hue-rotate(230deg) brightness(93%) contrast(92%);"
         src="/public/<?= ASSETS_PATH ?>/images/design/pyramid.svg"
         alt="" />
</div>