<!-- Hero -->
<div class="bg-primary d-flex flex-column d-md-block vh-lg-100 max-vh-md-90 position-relative pt-5 js-hero-fix">
    <div class="container position-relative h-md-100 pt-5 z-1 js-boxes-fix">
        <div class="row h-100 mb-5 pt-5 pt-md-0">
            <div class="col-md-9 d-flex flex-column justify-content-center">
                <h1 class="mb-2 mb-md-5 fw-bold display-2">
                    <?= nl2br($various['title']) ?>
                </h1>
                <div class="fs-2 fw-lighter">
                    <?= $various['text'] ?>
                </div>
                <div>
                    <? if ($various['metadata']['button_text']) : ?>
                        <a href="<?= buttonLink($various['metadata']) ?>"
                           <?= menuPopup(['is_popup' => $various['metadata']['button_is_popup']]) ?>
                           class="btn btn-sm btn-danger py-3 px-5 rounded-5">
                            <?= $various['metadata']['button_text'] ?>
                        </a>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="position-absolute top-0 end-0 w-100 h-100">
        <img class="w-100 h-100 object-fit-cover object-position-right-70 object-position-md-top opacity-50"
             src="<?= imageLink(IMAGES_VARIOUS, THUMB_LARGE, $various['image'], LINK_RELATIVE, $various['image_timestamp']) ?>"
             alt="<?= $various['title'] ?>" />
    </div>

    <div class="container position-relative mt-2 mt-sm-5 mt-md-3 mt-xl-n4 translate-middle-lg-y js-boxes-fix">
        <div class="row justify-content-md-end">
            <? if ($various['metadata']['hero_home_awb_title']) : ?>
                <div class="offset-sm-2 offset-md-0 offset-xl-4 col-sm-8 col-md-6 col-xl-4 mb-4 mb-md-0">
                    <div class="d-flex flex-column h-100 ps-5 px-4 py-3 corner"
                         style="--background-color: var(--bs-primary-rgb); --border-color: var(--bs-white);">
                        <div class="ms-2 mb-3 flex-grow-1 flex-shrink-1 text-secondary">
                            <div class="text-black fs-3 fw-bold"><?= $various['metadata']['hero_home_awb_title'] ?></div>
                            <div class="small fw-light">
                                <p><?= $various['metadata']['hero_home_awb_text'] ?></p>
                            </div>
                        </div>
                        <form method="get" action="<?= buttonLink($various['metadata'], 'hero_tracking_') ?>">
                            <div class="d-flex w-100 ms-2 border border-secondary border-opacity-50 rounded-5">
                                <label for="box-awb-tracking" class="visually-hidden">Codul AWB</label>
                                <input id="box-awb-tracking" name="awb" type="text" class="form-control form-white ms-4 px-2 py-2 text-dark border-0" placeholder="Codul AWB" autocomplete="off" style="--bs-secondary-color: var(--bs-gray);">
                                <button class="btn btn-sm btn-danger px-4 px-md-5 rounded-5" type="submit">CAUTĂ</button>
                            </div>
                        </form>
                    </div>
                </div>
            <? endif; ?>
            <? if ($various['metadata']['hero_home_secondary_title']) : ?>
                <div class="offset-sm-2 offset-md-0 col-sm-8 col-md-6 col-xl-4">
                    <div class="d-flex flex-column h-100 ps-5 px-4 py-3 corner"
                         style="--background-color: var(--bs-primary-rgb); --border-color: var(--bs-white);">
                        <div class="ms-2 mb-3 flex-grow-1 flex-shrink-1 text-secondary">
                            <div class="text-black fs-3 fw-bold"><?= $various['metadata']['hero_home_secondary_title'] ?></div>
                            <div class="small fw-light">
                                <p><?= $various['metadata']['hero_home_secondary_text'] ?></p>
                            </div>
                        </div>
                        <div class="text-end">
                            <? if ($various['metadata']['button_text']) : ?>
                                <a href="<?= buttonLink($various['metadata'], 'button2_') ?>"
                                   <?= menuPopup(['is_popup' => $various['metadata']['button2_is_popup']]) ?>
                                   class="btn btn-sm btn-primary py-2 px-4 rounded-5">
                                    <?= $various['metadata']['button2_text'] ?>
                                </a>
                            <? endif; ?>
                        </div>
                    </div>
                </div>
            <? endif; ?>
        </div>
    </div>
</div>

<? captureJavaScriptStart() ?>
<script>
    $(document).ready(function() {
        let $homeHero = $('.js-hero-fix'),
            heroHeight = $homeHero.outerHeight(true),
            heroOverflowHeight = $homeHero[0].scrollHeight;


        if (heroOverflowHeight > heroHeight) {
            $homeHero.css({
                'margin-bottom': (heroOverflowHeight - heroHeight) + 'px'
            })
        }
    });
</script>
<? captureJavaScriptEnd() ?>