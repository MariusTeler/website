<!-- Box - Newsletter -->
<div class="container my-4 my-lg-5 py-4 fw-light fs-5">
    <div class="row mt-4 mt-lg-5 pt-5">
        <div class="col-md-6 col-lg-7 mt-auto">
            <h5 class="h2 ls-wide fw-bold">AFLĂ NOUTATILE DSC</h5>
            <p class="mb-md-0 fs-5 fw-light">Fii la curent cu noutățile DSC, si abonează-te la newsletterul nostru.</p>
        </div>
        <div class="col-md-6 col-lg-4 offset-lg-1 mt-2">
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
                <input type="hidden" name="isHeader" value="1">
                <div id="<?= $formName ?>_errors_top" class="text-danger small hide">
                    Va rugam sa completati campurile necesare.
                    <ul></ul>
                </div>
                <div class="d-flex position-relative w-100 border border-1 border-white rounded-5">
                    <label for="newsletter_header" class="visually-hidden">Introdu emailul tău</label>
                    <input id="newsletter_header"
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
    <hr class="mt-5 opacity-100" />
</div>
<? captureJavaScriptStart(); ?>
<style>
    em[for="newsletter_header"] {
        position: absolute;
        left: 0;
        bottom: -2rem;
        font-size: 0.875rem;
    }
</style>
<? captureJavaScriptEnd(); ?>