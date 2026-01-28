<!-- Hero -->
<div class="bg-primary d-flex flex-column d-lg-block vh-lg-100 max-vh-lg-80 position-relative pt-5">
    <div class="container position-relative h-lg-100 pt-5">
        <div class="row h-100 pt-5 pt-lg-0">
            <div class="col-lg-5 d-flex flex-column justify-content-center">
                <h1 class="mb-4 fw-bold ls-wider">VERIFICARE AWB</h1>
                <div class="fs-2 fw-lighter">
                    <label for="awb" class="visually-hidden">Introduceţi codul AWB</label>
                    <input id="awb"
                           type="text"
                           class="form-control mb-4 py-2 border-0 border-bottom border-2 border-white fs-3 fw-lighter"
                           placeholder="Introduceţi codul AWB">
                    <button class="btn btn-sm btn-danger mb-4 py-3 px-5 rounded-5" type="button">CAUTĂ</button>
                </div>
            </div>
        </div>
        <img class="d-none d-lg-block position-absolute bottom-0 start-50 w-lg-35 ms-4 opacity-50"
             style="filter: invert(10%) sepia(9%) saturate(7480%) hue-rotate(207deg) brightness(88%) contrast(107%); transform: translateX(-80%)"
             src="/public/<?= ASSETS_PATH ?>/images/design/pyramid.svg"
             alt="" />
    </div>
    <div class="position-lg-absolute top-0 end-0 w-100 w-lg-50 h-100 flex-lg-grow-1">
        <img class="w-100 h-100 object-fit-cover object-position-right"
             src="/public/<?= ASSETS_PATH ?>/images/design/hero-man-01.jpg"
             alt="" />
    </div>
</div>