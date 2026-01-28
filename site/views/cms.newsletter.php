<!-- Box - Newsletter -->
<div class="bg-primary py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <h5 class="h2 fw-bold">Primește noutățile DSC</h5>
                <p class="fs-5 fw-light">Te asigurăm că produsele tale sunt livrate in cel mai sigur mod posibil</p>
            </div>
            <div class="col-md-6 col-lg-5 offset-lg-3">
                <h5 class="mb-3 d-none d-md-block">ÎNSCRIE-TE LA NEWSLETTER</h5>
                <form id="<?= $formName ?>"
                      method="POST"
                      class="frm formContact"
                      data-event-action="click"
                      data-event-category="Formular newsletter"
                      data-event-label="Formular"
                      data-event-fbq="Formular newsletter"
                >
                    <input type="hidden" id="formId" name="formId" value="<?= $formName ?>">
                    <div id="<?= $formName ?>_errors_top" class="text-danger hide">
                        Va rugam sa completati campurile necesare.
                        <ul></ul>
                    </div>
                    <div class="d-flex position-relative w-100 border border-1 border-white rounded-5">
                        <label for="newsletter_footer" class="visually-hidden">Introdu emailul tău</label>
                        <input id="newsletter_footer"
                               name="email"
                               type="text"
                               inputmode="email"
                               class="form-control ms-4 px-2 py-3 border-0"
                               placeholder="Introdu emailul tău">
                        <input type="submit"
                               id="<?= $formName ?>_submit"
                               class="btn btn-danger px-5 rounded-5"
                               data-message-loading="SE TRIMITE..."
                               data-message-normal="TRIMITE"
                               value="TRIMITE" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<? captureJavaScriptStart(); ?>
<style>
    em[for="newsletter_footer"] {
        position: absolute;
        left: 0;
        bottom: -2rem;
    }
</style>
<? captureJavaScriptEnd(); ?>
