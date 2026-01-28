<!-- Step 1 -->
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
            <div class="col-md-12">
                <div class="h3 fw-light">Dimensiuni colet <span class="fs-5">(se completează cu dimensiunile celui mai mare colet)</span></div>
            </div>
            <div class="col-md-6">
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
            <div class="col-md-12">
                <div class="h3 fw-light">Mențiuni</div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <textarea class="form-control border-top-0 border-start-0 border-end-0" id="comments" name="comments" placeholder="Conținut" rows="5" style="height: 135px"></textarea>
                    <label for="comments">Conținut</label>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="form-floating mb-2 fs-5">
                    <textarea class="form-control border-top-0 border-start-0 border-end-0" id="comments" name="comments" placeholder="Observații" rows="5" style="height: 135px"></textarea>
                    <label for="comments">Observații</label>
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

<!-- Step 2 -->
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

    <? $formName = 'formContact' ?>
    <form id="<?= $formName ?>"
          method="POST"
          class="frm formContact"
          data-event-action="click"
          data-event-category="Formular contact"
          data-event-label="Formular"
          data-event-fbq="Formular contact"
    >
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
                    <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="from_name" name="from_name" placeholder="Nume si prenume">
                    <label for="from_name">Nume si Prenume</label>
                </div>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <input type="email" class="form-control border-top-0 border-start-0 border-end-0" id="from_email" name="from_email" placeholder="Email">
                    <label for="from_email">Email</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <input type="tel" class="form-control border-top-0 border-start-0 border-end-0" id="from_phone" name="from_phone" placeholder="Telefon">
                    <label for="from_phone">Telefon</label>
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
                        <option></option>
                        <option value="1">București</option>
                        <option value="2">Cluj</option>
                        <option value="3">Harghita</option>
                    </select>
                    <label for="from_county">Județ</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="from_city" name="from_city">
                        <option></option>
                        <option value="1">București</option>
                        <option value="2">Cluj</option>
                        <option value="3">Harghita</option>
                    </select>
                    <label for="from_city">Localitate</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="from_address" name="from_address" placeholder="Nume si prenume">
                    <label for="from_address">Adresă (stradă, număr, bloc, etc.)</label>
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
                <button class="btn btn-link px-0 fs-4 text-decoration-none">
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

<!-- Step 3 -->
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

    <? $formName = 'formContact' ?>
    <form id="<?= $formName ?>"
          method="POST"
          class="frm formContact"
          data-event-action="click"
          data-event-category="Formular contact"
          data-event-label="Formular"
          data-event-fbq="Formular contact"
    >
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
                    <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="from_name" name="from_name" placeholder="Nume si prenume">
                    <label for="from_name">Nume si Prenume</label>
                </div>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <input type="email" class="form-control border-top-0 border-start-0 border-end-0" id="from_email" name="from_email" placeholder="Email">
                    <label for="from_email">Email</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <input type="tel" class="form-control border-top-0 border-start-0 border-end-0" id="from_phone" name="from_phone" placeholder="Telefon">
                    <label for="from_phone">Telefon</label>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="h3 fw-light">Adresă livrare colet</div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="from_county" name="from_county">
                        <option></option>
                        <option value="1">București</option>
                        <option value="2">Cluj</option>
                        <option value="3">Harghita</option>
                    </select>
                    <label for="from_county">Județ</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <select class="form-select border-top-0 border-start-0 border-end-0" id="from_city" name="from_city">
                        <option></option>
                        <option value="1">București</option>
                        <option value="2">Cluj</option>
                        <option value="3">Harghita</option>
                    </select>
                    <label for="from_city">Localitate</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2 fs-5">
                    <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="from_address" name="from_address" placeholder="Nume si prenume">
                    <label for="from_address">Adresă (stradă, număr, bloc, etc.)</label>
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
                <button class="btn btn-link px-0 fs-4 text-decoration-none">
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

<!-- Step 4 -->
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
        <h3 class="h1 mb-5 fw-light ls-wide">4. PREȚ (RON)</h3>
        <div class="d-none d-md-block">
            <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
            <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
            <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle"></span>
            <span class="d-inline-block mx-1 px-2 py-2 border border-white rounded-circle bg-white"></span>
        </div>
    </div>

    <? $formName = 'formContact' ?>
    <form id="<?= $formName ?>"
          method="POST"
          class="frm formContact"
          data-event-action="click"
          data-event-category="Formular contact"
          data-event-label="Formular"
          data-event-fbq="Formular contact"
    >
        <div class="row mb-5">
            <div class="col-md-12">
                <input type="hidden" id="formId" name="formId" value="<?= $formName ?>">
                <div id="<?= $formName ?>_errors_top" class="text-danger hide">
                    Va rugam sa completati campurile necesare.
                    <ul></ul>
                </div>
            </div>
            <div class="col-md-12">
                <div class="h3">TOTAL: 555.00 RON (fară TVA)</div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between">
                <button class="btn btn-link px-0 fs-4 text-decoration-none">
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