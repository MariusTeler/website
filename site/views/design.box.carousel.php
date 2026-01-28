<!-- Box - Carousel -->
<div class="bg-primary py-4 py-md-5">
    <div class="container position-relative overflow-hidden overflow-lg-visible">
        <div class="pt-5">
            <div class="row">
                <div class="col-xl-11 offset-xl-1">
                    <h2 class="mb-4 ls-wider">DESPRE NOI</h2>
                </div>
                <div class="col-lg-10 col-xl-7 offset-lg-1 offset-xl-3 fw-light">
                    <h3 class="mb-4 fw-normal">
                        About odales dolor de art sagittis ultrices felis faucibus tortor sed in tristique ipsum ermen
                    </h3>

                    <div class="home-images-container">
                        <div class="home-images" id="home-images-design">
                            <div class="item">
                                <img class="w-100 object-fit-cover"
                                     src="/public/<?= ASSETS_PATH ?>/images/design/carousel-1.jpg"
                                     alt=""
                                     type="image/jpeg" />
                            </div>
                            <div class="item">
                                <img class="w-100 object-fit-cover"
                                     src="/public/<?= ASSETS_PATH ?>/images/design/carousel-2.jpg"
                                     alt=""
                                     type="image/jpeg" />
                            </div>
                        </div>
                        <span class="icon icon-minus fs-1 cursor-default" style="cursor: pointer;" id="prevArrow"></span>
                        <span class="icon icon-plus fs-1 cursor-default float-end" style="cursor: pointer;" id="nextArrow"></span>
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
        $('#home-images-design').slick({
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