<? $carousel = $galleryList[$blockId]; ?>
<? if (
    ($carousel['type'] == GALLERY_CAROUSEL_MOBILE && isMobile() && !isMobile(true))
    || ($carousel['type'] == GALLERY_CAROUSEL_DESKTOP && (!isMobile() || isMobile(true)))
) : ?>
    <div class="home-images-container">
        <div id="home-images-<?= $blockId ?>">
            <? foreach ($carousel['images'] AS $row) : ?>
                <div class="item" style="background-image: url('<?= imageLink(IMAGES_GALLERY, THUMB_LARGE, $row['image']) ?>'); background-size: cover;">
                    <div class="info">
                        <? if ($row['title']) : ?>
                            <span><?= $row['title'] ?></span>
                            <?= $row['text'] ?>
                        <? endif; ?>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
        <div class="scroll hide-mobile">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <span class="prev-arrow" id="prevArrow"></span>
        <span class="next-arrow" id="nextArrow"></span>
    </div>

    <? captureJavaScriptStart(); ?>
    <!--<script src="/public/site/js/vendor/slick/slick.min.js"></script>-->
    <script>
        $(document).ready(function() {
            $('#home-images-<?= $blockId ?>').slick({
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: true,
                dots: false,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear',
                prevArrow: $('#prevArrow'),
                nextArrow: $('#nextArrow')
            });
        });
    </script>
    <? captureJavaScriptEnd(); ?>
<? endif; ?>
