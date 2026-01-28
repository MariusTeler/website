<!-- Hero -->
<div class="bg-primary d-flex flex-column d-md-block vh-lg-100 max-vh-md-90 position-relative pt-5 js-hero-fix">
    <div class="container position-relative h-md-100 pt-5 z-1 js-boxes-fix">
        <div class="row h-100 mb-5 pt-5 pt-md-0">
            <div class="col-md-9 d-flex flex-column justify-content-center">
                <h1 class="mb-2 mb-md-5 fw-bold display-2">
                    Clientul,<br /> prietenul nostru.
                </h1>
                <div class="fs-2 fw-lighter">
                    <p>Vrei să trimiți un colet?</p>
                </div>
                <div>
                    <a href="#" class="btn btn-sm btn-danger py-3 px-5 rounded-5">PLASEAZĂ O COMANDĂ</a>
                </div>
            </div>
        </div>
    </div>
    <div class="position-absolute top-0 end-0 w-100 h-100">
        <img class="w-100 h-100 object-fit-cover object-position-right-70 object-position-md-top opacity-50"
             src="/public/<?= ASSETS_PATH ?>/images/design/hero-workers.jpg"
             alt="" />
    </div>

    <div class="container position-relative mt-2 mt-sm-5 mt-md-3 mt-xl-n4 translate-middle-md-y js-boxes-fix">
        <div class="row">
            <div class="offset-sm-2 offset-md-0 offset-xl-4 col-sm-8 col-md-6 col-xl-4 mb-4 mb-md-0">
                <div class="d-flex flex-column h-100 ps-5 px-4 py-3 corner"
                     style="--background-color: var(--bs-primary-rgb); --border-color: var(--bs-white);">
                    <div class="ms-2 mb-3 flex-grow-1 flex-shrink-1 text-secondary">
                        <div class="text-black fs-3 fw-bold">VERIFICARE AWB</div>
                        <div class="small fw-light">
                            <p>Introduceți codul AWB pentru detalii expeditie.</p>
                        </div>
                    </div>
                    <div class="d-flex w-100 ms-2 border border-secondary border-opacity-50 rounded-5">
                        <label for="box-awb-tracking" class="visually-hidden">Codul AWB</label>
                        <input id="box-awb-tracking" type="text" class="form-control form-white ms-4 px-2 py-2 text-dark border-0" placeholder="Codul AWB" style="--bs-secondary-color: var(--bs-gray);">
                        <button class="btn btn-sm btn-danger px-4 px-md-5 rounded-5" type="button">CAUTĂ</button>
                    </div>
                </div>
            </div>
            <div class="offset-sm-2 offset-md-0 col-sm-8 col-md-6 col-xl-4">
                <div class="d-flex flex-column h-100 ps-5 px-4 py-3 corner"
                     style="--background-color: var(--bs-primary-rgb); --border-color: var(--bs-white);">
                    <div class="ms-2 mb-3 flex-grow-1 flex-shrink-1 text-secondary">
                        <div class="text-black fs-3 fw-bold">CALCULATOR DE PREȚ</div>
                        <div class="small fw-light">
                            <p>Calculatorul nostru va ajuta sa determinati greutatea facturabila a coletelor agabaritice si modul de taxare.</p>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="#" class="btn btn-sm btn-primary py-2 px-4 rounded-5">CALCULEAZĂ</a>
                    </div>
                </div>
            </div>
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