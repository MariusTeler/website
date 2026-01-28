<!-- Step 1 -->
<div id="step-1">
    <div class="container d-md-none border border-white">
        <div class="row">
            <div class="col-3 pt-2 border-end border-white bg-white"></div>
            <div class="col-3 pt-2 border-end border-white"></div>
            <div class="col-3 pt-2 border-end border-white"></div>
            <div class="col-3 pt-2"></div>
        </div>
    </div>
    <div class="container my-5">
        <div class="d-flex align-items-baseline justify-content-between">
            <h3 class="h1 mb-5 fw-light ls-wide">1. DETALII EXPEDIERE</h3>
            <div class="d-none d-md-block">
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle bg-white"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
            </div>
        </div>
        <? $formName = $form[FORM_STEP1]['name']; ?>
        <form id="<?= $formName ?>"
              method="POST"
              class="frm formContact"
              data-event-action="<?= $various['metadata']['analytics_action'] ?: 'click' ?>"
              data-event-category="<?= $various['metadata']['analytics_category'] ?: 'Formular self AWB' ?>"
              data-event-label="<?= $various['metadata']['analytics_label'] ?: 'Formular' ?>"
              data-event-fbq="<?= $various['metadata']['analytics_facebook'] ?: 'Formular self AWB' ?>"
        >
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" id="formId" name="formId" value="<?= $formName ?>">
                    <div id="<?= $formName ?>_errors_top" class="text-danger hide">
                        Va rugam sa completati campurile necesare.
                        <ul></ul>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="h3 fw-light">Ce vrei să trimiți?</div>
                    <div class="form-check form-check-inline mb-2 pt-2 fs-5">
                        <input type="radio" id="type-envelope" name="tipExpeditie" value="plic" class="form-check-input">
                        <label for="type-envelope" class="form-check-label">Plic</label>
                    </div>
                    <div class="form-check form-check-inline mb-2 pt-2 fs-5">
                        <input type="radio" id="type-package" name="tipExpeditie" value="colet" class="form-check-input">
                        <label for="type-package" class="form-check-label">Colet</label>
                    </div>
                    <div class="form-check form-check-inline mb-2 pt-2 fs-5">
                        <input type="radio" id="type-pallet" name="tipExpeditie" value="palet" class="form-check-input">
                        <label for="type-pallet" class="form-check-label">Palet</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4 d-none" id="nrColeteWrapper">
                    <div class="h3 fw-light">Conținut</div>
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" inputmode="numeric" class="form-control border-top-0 border-start-0 border-end-0" id="nrColete" name="nrColete" placeholder="Număr colete">
                        <label for="nrColete">Număr colete <small>*</small></label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="h3 fw-light">Opțiuni</div>
                </div>
                <div class="col-md-6 pt-md-4 mt-2 mt-md-1 mb-4">
                    <div class="form-check form-check-inline fs-5 fw-light">
                        <input class="form-check-input" type="checkbox" id="deschidereColet" name="deschidereColet" value="1">
                        <label class="form-check-label" for="deschidereColet">Deschidere Colet</label>
                    </div>
                    <div class="form-check form-check-inline fs-5 fw-light">
                        <input class="form-check-input" type="checkbox" id="tarifSambata" name="tarifSambata" value="1">
                        <label class="form-check-label" for="tarifSambata">Livrare Sambata</label>
                    </div>
                    <div class="form-check form-check-inline fs-5 fw-light">
                        <input class="form-check-input" type="checkbox" id="ret_colet" name="ret_colet" value="1">
                        <label class="form-check-label" for="ret_colet">Livrare la Schimb</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="h3 fw-light">Detalii plata</div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <select class="form-select border-top-0 border-start-0 border-end-0" id="locPlata" name="locPlata">
                            <option value="exp" selected>Expeditor</option>
                            <option value="dest">Destinatar</option>
                        </select>
                        <label for="locPlata">Plătitor <small>*</small></label>
                    </div>
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" inputmode="decimal" class="form-control border-top-0 border-start-0 border-end-0" id="valoareAsigurare" name="valoareAsigurare" placeholder="Valoare declarata">
                        <label for="valoareAsigurare">Valoare declarata</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" inputmode="decimal" class="form-control border-top-0 border-start-0 border-end-0" id="valoareRamburs" name="valoareRamburs" placeholder="Ramburs">
                        <label for="valoareRamburs">Ramburs</label>
                    </div>
                    <div class="form-floating mb-2 fs-5">
                        <select class="form-select border-top-0 border-start-0 border-end-0" id="tipPlata" name="tipPlata">
                            <option value="cash" selected>Cash</option>
                            <option value="bo">Instrumente plata</option>
                        </select>
                        <label for="tipPlata">Tip Ramburs</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="h3 fw-light">Dimensiuni colet <span class="fs-5">(se completează cu dimensiunile celui mai mare colet)</span></div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" inputmode="numeric" class="form-control border-top-0 border-start-0 border-end-0" id="height" name="height" placeholder="Înălțime (cm)">
                        <label for="height">Înălțime (cm)</label>
                    </div>
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" inputmode="numeric" class="form-control border-top-0 border-start-0 border-end-0" id="length" name="length" placeholder="Lungime (cm)">
                        <label for="length">Lungime (cm)</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" inputmode="numeric" class="form-control border-top-0 border-start-0 border-end-0" id="width" name="width" placeholder="Lățime (cm)">
                        <label for="width">Lățime (cm)</label>
                    </div>
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" inputmode="decimal" class="form-control border-top-0 border-start-0 border-end-0" id="greutate" name="greutate" placeholder="Greutate totală (kg)">
                        <label for="greutate">Greutate totală (kg)</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="h3 fw-light">Mențiuni</div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <textarea class="form-control border-top-0 border-start-0 border-end-0" id="continut" name="continut" placeholder="Conținut" rows="5" style="height: 135px"></textarea>
                        <label for="continut">Conținut</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating mb-2 fs-5">
                        <textarea class="form-control border-top-0 border-start-0 border-end-0" id="observatii" name="observatii" placeholder="Observații" rows="5" style="height: 135px"></textarea>
                        <label for="observatii">Observații</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="<?= $formName ?>_errors_bottom" class="text-danger hide">
                        Va rugam sa completati campurile necesare.
                        <ul></ul>
                    </div>
                </div>
                <div class="col-md-6 offset-md-6">
                    <input type="submit"
                           id="<?= $formName ?>_submit"
                           class="btn btn-danger py-3 px-5 rounded-5 float-end"
                           data-message-loading="Se trimite..."
                           data-message-normal="Următorul pas"
                           value="Următorul pas" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Step 2 -->
<div id="step-2" class="hide">
    <div class="container d-md-none border border-white">
        <div class="row">
            <div class="col-3 pt-2 border-end border-white"></div>
            <div class="col-3 pt-2 border-end border-white bg-white"></div>
            <div class="col-3 pt-2 border-end border-white"></div>
            <div class="col-3 pt-2"></div>
        </div>
    </div>
    <div class="container my-5">
        <div class="d-flex align-items-baseline justify-content-between">
            <h3 class="h1 mb-5 fw-light ls-wide">2. DETALII EXPEDITOR</h3>
            <div class="d-none d-md-block">
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle bg-white"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
            </div>
        </div>

        <? $formName = $form[FORM_STEP2]['name']; ?>
        <form id="<?= $formName ?>" method="POST" class="frm formContact">
            <div class="row mb-4">
                <div class="col-md-12">
                    <input type="hidden" id="formId" name="formId" value="<?= $formName ?>">
                    <div id="<?= $formName ?>_errors_top" class="text-danger hide">
                        Va rugam sa completati campurile necesare.
                        <ul></ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="h3 fw-light">Date contact</div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="from_name" name="from_name" placeholder="Nume si prenume" autocomplete="name">
                        <label for="from_name">Nume si Prenume <small>*</small></label>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <input type="email" class="form-control border-top-0 border-start-0 border-end-0" id="from_email" name="from_email" placeholder="Email">
                        <label for="from_email">Email <small>*</small></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <input type="tel" class="form-control border-top-0 border-start-0 border-end-0" id="from_phone" name="from_phone" placeholder="Telefon">
                        <label for="from_phone">Telefon <small>*</small></label>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="h3 fw-light">Adresă preluare colet</div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <select class="form-select border-top-0 border-start-0 border-end-0" id="from_county" name="from_county">
                            <?= formSelectOptions($counties, 'name', '') ?>
                        </select>
                        <label for="from_county">Județ <small>*</small></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <select class="form-select border-top-0 border-start-0 border-end-0" id="from_city" name="from_city">
                            <option></option>
                        </select>
                        <label for="from_city">Localitate <small>*</small></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="from_address" name="from_address" placeholder="Adresă (stradă, număr, bloc, etc.)" autocomplete="address">
                        <label for="from_address">Adresă (stradă, număr, bloc, etc.) <small>*</small></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="from_zipcode" name="from_zipcode" placeholder="Cod poștal">
                        <label for="from_zipcode">Cod poștal</label>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12 d-flex justify-content-between">
                    <button class="btn btn-link px-0 fs-4 text-decoration-none show-prev" type="button" data-step="<?= FORM_STEP2 ?>">
                        <span class="icon icon-arrow-left-light pe-2 fs-5 text-white"></span>
                        Înapoi
                    </button>
                    <input type="submit"
                           id="<?= $formName ?>_submit"
                           class="btn btn-danger py-3 px-5 rounded-5 float-end"
                           data-message-loading="Se trimite..."
                           data-message-normal="Următorul pas"
                           value="Următorul pas" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Step 3 -->
<div id="step-3" class="hide">
    <div class="container d-md-none border border-white">
        <div class="row">
            <div class="col-3 pt-2 border-end border-white"></div>
            <div class="col-3 pt-2 border-end border-white"></div>
            <div class="col-3 pt-2 border-end border-white bg-white"></div>
            <div class="col-3 pt-2"></div>
        </div>
    </div>
    <div class="container my-5">
        <div class="d-flex align-items-baseline justify-content-between">
            <h3 class="h1 mb-5 fw-light ls-wide">3. DETALII DESTINATAR</h3>
            <div class="d-none d-md-block">
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle bg-white"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
            </div>
        </div>

        <? $formName = $form[FORM_STEP3]['name']; ?>
        <form id="<?= $formName ?>" method="POST" class="frm formContact">
            <div class="row mb-4">
                <div class="col-md-12">
                    <input type="hidden" id="formId" name="formId" value="<?= $formName ?>">
                    <div id="<?= $formName ?>_errors_top" class="text-danger hide">
                        Va rugam sa completati campurile necesare.
                        <ul></ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="h3 fw-light">Date contact</div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="to_name" name="to_name" placeholder="Nume si prenume">
                        <label for="to_name">Nume si Prenume <small>*</small></label>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <input type="email" class="form-control border-top-0 border-start-0 border-end-0" id="to_email" name="to_email" placeholder="Email">
                        <label for="to_email">Email</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <input type="tel" class="form-control border-top-0 border-start-0 border-end-0" id="to_phone" name="to_phone" placeholder="Telefon">
                        <label for="to_phone">Telefon <small>*</small></label>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="h3 fw-light">Adresă livrare colet</div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <select class="form-select border-top-0 border-start-0 border-end-0" id="to_county" name="to_county">
                            <?= formSelectOptions($counties, 'name', '') ?>
                        </select>
                        <label for="to_county">Județ <small>*</small></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <select class="form-select border-top-0 border-start-0 border-end-0" id="to_city" name="to_city">
                            <option></option>
                        </select>
                        <label for="to_city">Localitate <small>*</small></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="to_address" name="to_address" placeholder="Adresă (stradă, număr, bloc, etc.)">
                        <label for="to_address">Adresă (stradă, număr, bloc, etc.) <small>*</small></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2 fs-5">
                        <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="to_zipcode" name="to_zipcode" placeholder="Cod poștal">
                        <label for="to_zipcode">Cod poștal</label>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12 d-flex justify-content-between">
                    <button class="btn btn-link px-0 fs-4 text-decoration-none show-prev" type="button" data-step="<?= FORM_STEP3 ?>">
                        <span class="icon icon-arrow-left-light pe-2 fs-5 text-white"></span>
                        Înapoi
                    </button>
                    <input type="submit"
                           id="<?= $formName ?>_submit"
                           class="btn btn-danger py-3 px-5 rounded-5 float-end"
                           data-message-loading="Se trimite..."
                           data-message-normal="Află prețul"
                           value="Află prețul" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Step 4 -->
<div id="step-4" class="hide">
    <div class="container d-md-none border border-white">
        <div class="row">
            <div class="col-3 pt-2 border-end border-white"></div>
            <div class="col-3 pt-2 border-end border-white"></div>
            <div class="col-3 pt-2 border-end border-white"></div>
            <div class="col-3 pt-2 bg-white"></div>
        </div>
    </div>
    <div class="container my-5">
        <div class="d-flex align-items-baseline justify-content-between">
            <h3 class="h1 mb-5 fw-light ls-wide">4. PREȚ</h3>
            <div class="d-none d-md-block">
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle bg-white"></span>
            </div>
        </div>

        <? $formName = $form[FORM_STEP4]['name']; ?>
        <form id="<?= $formName ?>" method="POST" class="frm formContact">
            <div class="row mb-5">
                <div class="col-md-12">
                    <input type="hidden" id="formId" name="formId" value="<?= $formName ?>">
                    <div id="<?= $formName ?>_errors_top" class="text-danger hide">
                        Va rugam sa completati campurile necesare.
                        <ul></ul>
                    </div>
                </div>
                <div class="col-md-12" id="tarifWrapper"></div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12 d-flex justify-content-between">
                    <button class="btn btn-link px-0 fs-4 text-decoration-none show-prev" type="button" data-step="<?= FORM_STEP4 ?>">
                        <span class="icon icon-arrow-left-light pe-2 fs-5 text-white"></span>
                        Înapoi
                    </button>
                    <input type="submit"
                           id="<?= $formName ?>_submit"
                           class="btn btn-danger py-3 px-4 px-md-5 rounded-5 float-end"
                           data-message-loading="Se trimite..."
                           data-message-normal="Trimite comanda"
                           value="Trimite comanda" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Step 5 (final step) -->
<div id="step-5" class="hide">
    <div class="container d-md-none">
        <div class="row">
            <div class="col-3 pt-2 border-end border-primary bg-white"></div>
            <div class="col-3 pt-2 border-end border-primary bg-white"></div>
            <div class="col-3 pt-2 border-end border-primary bg-white"></div>
            <div class="col-3 pt-2 bg-white"></div>
        </div>
    </div>
    <div class="container my-5">
        <div class="d-flex align-items-baseline justify-content-between">
            <h3 class="h1 mb-5 fw-light ls-wide">AWB</h3>
            <div class="d-none d-md-block">
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle bg-white"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle bg-white"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle bg-white"></span>
                <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle bg-white"></span>
            </div>
        </div>
        <div id="awbWrapper"></div>
    </div>
</div>

<? captureJavaScriptStart(); ?>
<link rel="stylesheet" href="/public/<?= ASSETS_PATH ?>/css/select2-bootstrap5-dark.css" />
<script>
    $(document).ready(function() {
        $('input[name="tipExpeditie"]').on('change', function() {
            if ($(this).val() == 'colet') {
                $('#nrColeteWrapper').removeClass('d-none');
            } else {
                $('#nrColeteWrapper').addClass('d-none');
            }
        });

        $('#from_county, #to_county').on('change', function () {
            ajaxRequest('index.php?page=cms.various.calculator', [$(this).attr('id')]);
        });

        $('#valoareAsigurare, #valoareRamburs, #greutate').on('keyup', function () {
            $(this).val($(this).val().replace(',', '.'));
        });

        $('button.show-prev').on('click', function () {
            showNext($(this).data('step'), true);
        });
    });

    function showNext(step, prev = false) {
        let nextStep = parseInt(step) + (prev ? -1 : 1);


        $('#step-' + step).toggle();
        $('#step-' + nextStep).fadeToggle();

        scrollToTarget('#step-' + nextStep);
    }
</script>
<? captureJavaScriptEnd(); ?>