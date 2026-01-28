<? if ($banner) : ?>
    <div class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 hide" id="popoverOverlay"></div>
    <div class="position-fixed top-50 start-50 translate-middle border border-5 border-danger rounded-3 z-index-2 hide" id="popover">
        <button type="button" class="btn-close btn-close-white position-absolute start-100 bottom-100 p-2 close"></button>
        <div>
            <? if ($banner['link']) : ?>
                <a class="d-inline-block text-decoration-none" href="<?= $banner['link'] ?>">
            <? endif; ?>
                <img src="<?= imageLink(IMAGES_BANNER_MOBILE, THUMB_MEDIUM, $banner['image_mobile']) ?>?v=<?= date('YmdH') ?>"
                     class="d-md-none max-vw-80 max-vh-80"
                     alt="" />
                <img src="<?= imageLink(IMAGES_BANNER_DESKTOP, THUMB_MEDIUM, $banner['image']) ?>?v=<?= date('YmdH') ?>"
                     class="d-none d-md-inline-block max-vw-80"
                     alt="" />
            <? if ($banner['link']) : ?>
                </a>
            <? endif; ?>
        </div>
    </div>

    <div class="fixed-bottom start-50 translate-middle-x w-100 w-md-auto hide" id="popoverMobile">
        <div class="px-3 py-4 p-md-4 text-white text-center bg-dark rounded-3 shadow">
            <button type="button" class="btn-close btn-close-white position-absolute end-0 top-0 p-2 close"></button>
            <p class="h4 text-white"><?= $banner['title'] ?></p>
            <button class="btn btn-lg btn-light w-75 mt-2 text-uppercase button event-track"
                    type="button"
                    data-event-action="click"
                    data-event-category="Banner"
                    data-event-label="Button"
            ><?= $banner['button_text'] ?></button>
        </div>
    </div>
<? endif; ?>