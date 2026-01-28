<!-- Box - Contact > Text right -->
<div class="py-4">
    <div class="container position-relative py-4">
        <div class="row">
            <div class="col-xl-11 offset-xl-1">
                <h2 class="mb-4 ls-wider">CONTACT</h2>
            </div>
            <div class="col-md-10 col-xl-9 offset-xl-3 fw-light overflow-hidden">
                <div class="row g-md-5">
                    <div class="col-md-8">
                        <h3 class="mb-4 fw-light">
                            Suntem pregătiți să livrăm coletele dumneavoastră rapid și în siguranță.
                        </h3>
                    </div>
                    <div class="col-sm-6 col-md-6 mt-0 mb-4">
                        <? $formName = 'formContact' ?>
                        <form id="<?= $formName ?>"
                              method="POST"
                              class="frm formContact"
                              data-event-action="click"
                              data-event-category="Formular contact"
                              data-event-label="Formular"
                              data-event-fbq="Formular contact"
                        >
                            <input type="hidden" id="formId" name="formId" value="<?= $formName ?>">
                            <div id="<?= $formName ?>_errors_top" class="text-danger hide">
                                Va rugam sa completati campurile necesare.
                                <ul></ul>
                            </div>

                            <div class="form-floating fs-5">
                                <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="name" name="name" placeholder="Nume">
                                <label for="name">Nume</label>
                            </div>
                            <div class="form-floating mb-2 fs-5">
                                <input type="email" class="form-control border-top-0 border-start-0 border-end-0" id="email" name="email" placeholder="Email">
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-2 fs-5">
                                <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="subject" name="subject" placeholder="Subiect">
                                <label for="subject">Subiect</label>
                            </div>
                            <div class="form-floating mb-2 fs-5">
                                <textarea class="form-control border-top-0 border-start-0 border-end-0" placeholder="Mesaj" id="message" name="message" rows="5" style="height: 115px"></textarea>
                                <label for="message">Mesaj</label>
                            </div>
                            <div class="form-check mb-2 pt-2">
                                <input type="checkbox" id="gdpr" name="gdpr" class="form-check-input">
                                <label for="gdpr" class="form-check-label">Accept <a href="#">termenii si conditiile</a></label>
                            </div>
                            <input type="submit"
                                   id="<?= $formName ?>_submit"
                                   class="btn btn-danger py-3 px-5 mt-4 rounded-5"
                                   data-message-loading="Se trimite..."
                                   data-message-normal="Trimite"
                                   value="Trimite" />
                        </form>
                    </div>
                    <div class="col-sm-6 col-md-6 mt-0 pt-5 mb-4 fs-5">
                        <p>Nisl mi commodo enim nisl curabitur in massa id orci. Ut pellentesque se donec aliquet pellentesque duis est sollicitudin.</p>
                        <p>TELEFON: 0219501<br />
                            EMAIL: numeprenume@dsc.ro<br />
                            ADRESA: Calea Bucurestilor nr 1, Otopeni</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>