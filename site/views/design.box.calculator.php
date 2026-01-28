<div class="container my-5">
    <h3 class="h1 mb-5 fw-light ls-wider">FORMULAR ESTIMARE PREȚ</h3>

    <? $formName = 'formContact' ?>
    <form id="<?= $formName ?>"
          method="POST"
          class="frm formContact"
          data-event-action="click"
          data-event-category="Formular contact"
          data-event-label="Formular"
          data-event-fbq="Formular contact"
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
                    <input type="radio" id="type-envelope" name="type" value="plic" class="form-check-input">
                    <label for="type-envelope" class="form-check-label">Plic</label>
                </div>
                <div class="form-check form-check-inline mb-2 pt-2 fs-5">
                    <input type="radio" id="type-package" name="type" value="colet" class="form-check-input">
                    <label for="type-package" class="form-check-label">Colet</label>
                </div>
                <div class="form-check form-check-inline mb-2 pt-2 fs-5">
                    <input type="radio" id="type-pallet" name="type" value="palet" class="form-check-input">
                    <label for="type-pallet" class="form-check-label">Palet</label>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="h3 fw-light">Conținut</div>
                <div class="form-floating mb-2 fs-5">
                    <input type="text" inputmode="numeric" class="form-control border-top-0 border-start-0 border-end-0" id="cnt" name="cnt" placeholder="Număr colete">
                    <label for="cnt">Număr colete</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="h3 fw-light">Opțiuni</div>
            </div>
            <div class="col-md-6 pt-md-4 mt-2 mt-md-1">
                <div class="form-check form-check-inline fs-5 fw-light">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">Deschidere Colet</label>
                </div>
                <div class="form-check form-check-inline fs-5 fw-light">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                    <label class="form-check-label" for="inlineCheckbox2">Livrare Sambata</label>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="from_county" name="from_county">
                        <option></option>
                        <option value="1">Colet</option>
                        <option value="2">Document</option>
                    </select>
                    <label for="from_county">Livrare la schimb</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="h3 fw-light">Detalii plata</div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="from_county" name="from_county">
                        <option></option>
                        <option value="1" selected>Expeditor</option>
                        <option value="2">Destinatar</option>
                    </select>
                    <label for="from_county">Plătitor</label>
                </div>
                <div class="form-floating mb-2 fs-5">
                    <input type="text" inputmode="numeric" class="form-control border-top-0 border-start-0 border-end-0" id="cnt" name="cnt" placeholder="Valoare declarata">
                    <label for="cnt">Valoare declarata</label>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="form-floating mb-2 fs-5">
                    <input type="text" inputmode="numeric" class="form-control border-top-0 border-start-0 border-end-0" id="cnt" name="cnt" placeholder="Ramburs">
                    <label for="cnt">Ramburs</label>
                </div>
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="from_county" name="from_county">
                        <option></option>
                        <option value="1" selected>Cash</option>
                        <option value="2">Instrumente plata</option>
                    </select>
                    <label for="from_county">Tip Ramburs</label>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="h3 fw-light">Detalii expeditor</div>
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="from_county" name="county">
                        <option></option>
                        <option value="1">București</option>
                        <option value="2">Cluj</option>
                        <option value="3">Harghita</option>
                    </select>
                    <label for="from_county">Județ expediție</label>
                </div>
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="from_city" name="city">
                        <option></option>
                        <option value="1">București</option>
                        <option value="2">Cluj</option>
                        <option value="3">Harghita</option>
                    </select>
                    <label for="from_city">Localitate expediție</label>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="h3 fw-light">Detalii destinatar</div>
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="to_county" name="county">
                        <option></option>
                        <option value="1">București</option>
                        <option value="2">Cluj</option>
                        <option value="3">Harghita</option>
                    </select>
                    <label for="to_county">Județ expediție</label>
                </div>
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="to_city" name="city">
                        <option></option>
                        <option value="1">București</option>
                        <option value="2">Cluj</option>
                        <option value="3">Harghita</option>
                    </select>
                    <label for="to_city">Localitate expediție</label>
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
                    <input type="text" inputmode="decimal" class="form-control border-top-0 border-start-0 border-end-0" id="weight" name="weight" placeholder="Greutate totală (kg)">
                    <label for="weight">Greutate totală (kg)</label>
                </div>
            </div>
        </div>
        <input type="submit"
               id="<?= $formName ?>_submit"
               class="btn btn-danger py-3 px-5 rounded-5"
               data-message-loading="Se trimite..."
               data-message-normal="Estimează preț"
               value="Estimează preț" />
    </form>
</div>