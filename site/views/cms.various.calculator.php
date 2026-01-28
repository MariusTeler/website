<div class="container my-5">
    <div class="mb-5">
        <h3 class="h1 fw-light ls-wider"><?= $various['title'] ?></h3>
        <div class="mb-4 fs-5 fw-light">
            <?= $various['text'] ?>
        </div>
    </div>

    <form id="<?= $formName ?>"
          method="POST"
          class="frm formContact"
          data-event-action="<?= $various['metadata']['analytics_action'] ?: 'click' ?>"
          data-event-category="<?= $various['metadata']['analytics_category'] ?: 'Formular pret' ?>"
          data-event-label="<?= $various['metadata']['analytics_label'] ?: 'Formular' ?>"
          data-event-fbq="<?= $various['metadata']['analytics_facebook'] ?: 'Formular pret' ?>"
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
            </div>
            <div class="col-md-12">
                <div class="h3 fw-light">Detalii plata</div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <input type="text" inputmode="decimal" class="form-control border-top-0 border-start-0 border-end-0" id="valoareAsigurare" name="valoareAsigurare" placeholder="Valoare declarata">
                    <label for="valoareAsigurare">Valoare declarata</label>
                </div>
                <div class="form-floating mb-2 fs-5">
                    <input type="text" inputmode="decimal" class="form-control border-top-0 border-start-0 border-end-0" id="valoareRamburs" name="valoareRamburs" placeholder="Ramburs">
                    <label for="valoareRamburs">Ramburs</label>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="tipPlata" name="tipPlata">
                        <option value="cash" selected>Cash</option>
                        <option value="bo">Instrumente plata</option>
                    </select>
                    <label for="tipPlata">Tip Ramburs</label>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="h3 fw-light">Detalii expeditor</div>
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="from_county" name="from_county">
                        <?= formSelectOptions($counties, 'name', '') ?>
                    </select>
                    <label for="from_county">Județ expediție <small>*</small></label>
                </div>
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="from_city" name="from_city">
                        <option></option>
                    </select>
                    <label for="from_city">Localitate expediție <small>*</small></label>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="h3 fw-light">Detalii destinatar</div>
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="to_county" name="to_county">
                        <?= formSelectOptions($counties, 'name', '') ?>
                    </select>
                    <label for="to_county">Județ destinație <small>*</small></label>
                </div>
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="to_city" name="to_city">
                        <option></option>
                    </select>
                    <label for="to_city">Localitate destinație <small>*</small></label>
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
                <div id="<?= $formName ?>_errors_bottom" class="text-danger hide">
                    Va rugam sa completati campurile necesare.
                    <ul></ul>
                </div>
            </div>
            <div id="tarifWrapper"></div>
        </div>
        <input type="submit"
               id="<?= $formName ?>_submit"
               class="btn btn-danger py-3 px-5 rounded-5"
               data-message-loading="Se trimite..."
               data-message-normal="Estimează preț"
               value="Estimează preț" />
    </form>
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
    });
</script>
<? captureJavaScriptEnd(); ?>
