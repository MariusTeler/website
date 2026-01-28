<!-- Box - Gallery -->
<div class="bg-primary py-4 py-md-5">
    <div class="container position-relative overflow-hidden overflow-lg-visible">
        <div class="pt-5">
            <div class="row">
                <div class="col-xl-11 offset-xl-1">
                    <h2 class="mb-4 ls-wider"><?= $listInfo['title'] ?></h2>
                </div>
                <div class="col-lg-10 col-xl-7 offset-lg-1 offset-xl-3 fw-light">
                    <h3 class="mb-4 fw-normal">
                        <?= $listInfo['text'] ?>
                    </h3>

                    <div class="home-images-container">
                        <div class="home-images" id="list-gallery-<?= $blockId ?>">
                            <? foreach($listInfo['rows'] AS $i => $image) : ?>
                                <div class="item">
                                    <img class="w-100 object-fit-cover"
                                         src="<?= imageLink(IMAGES_LIST, THUMB_LARGE, $image['image'], LINK_RELATIVE, $image['image_timestamp']) ?>"
                                         alt="<?= $image['title'] ?>"
                                         type="image/jpeg" />
                                </div>
                            <? endforeach; ?>
                        </div>
                        <span class="icon icon-minus fs-1 cursor-default"
                              style="cursor: pointer;"
                              id="prevArrow-list-gallery-<?= $blockId ?>"></span>
                        <span class="icon icon-plus fs-1 cursor-default float-end"
                              style="cursor: pointer;"
                              id="nextArrow-list-gallery-<?= $blockId ?>"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<? captureJavaScriptStart(); ?>
<script src="/public/site/js/vendor/slick/slick.min.js"></script>
<script>
    $(document).ready(function() {
        $('#list-gallery-<?= $blockId ?>').slick({
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            dots: false,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            prevArrow: $('#prevArrow-list-gallery-<?= $blockId ?>'),
            nextArrow: $('#nextArrow-list-gallery-<?= $blockId ?>')
        });
    });
</script>
<? captureJavaScriptEnd(); ?>