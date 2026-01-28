<? if ($banner) : ?>
    <div class="container mt-4 clearfix">
        <div class="px-3 py-4 p-md-4 text-white text-center bg-dark rounded-3 shadow">
            <p class="h4 text-white"><?= $banner['title'] ?></p>
            <button class="btn btn-lg btn-light w-75 mt-2 text-uppercase event-track"
                    type="button"
                    data-event-action="click"
                    data-event-category="Banner"
                    data-event-label="Button"
                    id="popoverButton"
            ><?= $banner['button_text'] ?></button>
        </div>
    </div>
    <? parseVar('banner', $banner, 'box.banner'); ?>
<? endif; ?>