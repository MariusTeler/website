<!-- Box - Contact > Text left -->
<? $anchor = 'form-' . $various['id']; ?>
<div class="py-4" id="<?= $anchor ?>">
    <div class="container position-relative py-4 overflow-hidden">
        <div class="row g-md-5">
            <div class="col-lg-12">
                <h2 class="mb-4 ls-wider"><?= $various['title'] ?></h2>
            </div>
            <div class="col-lg-6 mt-0">
                <div class="mt-md-3 mb-4 me-md-3 fs-2 fw-light">
                    <div class="mb-5">
                        <?= $various['text'] ?>
                    </div>
                    <? if ($various['metadata']['button_text']) : ?>
                        <div class="w-sm-50 w-lg-75 px-5 pe-4 pt-4 pb-4 corner fs-5"
                             style="--background-color: var(--bs-body-bg); --border-color: var(--bs-light);">
                            <div class="d-flex align-items-center mb-3">
                                <div class="pe-3">
                                    <a href="<?= buttonLink($various['metadata']) ?>"
                                       <?= menuPopup(['is_popup' => $various['metadata']['button_is_popup']]) ?>
                                       class="text-decoration-none">
                                        <?= $various['metadata']['button_text'] ?>
                                    </a>
                                </div>
                                <span class="icon icon-contract display-1 lh-1"></span>
                            </div>
                        </div>
                    <? endif; ?>
                </div>
            </div>
            <div class="col-lg-6 mt-0 mb-4">
                <form id="<?= $formName ?>"
                      method="POST"
                      class="frm formContact ms-md-3"
                      data-event-action="<?= $various['metadata']['analytics_action'] ?: 'click' ?>"
                      data-event-category="<?= $various['metadata']['analytics_category'] ?: 'Formular contact' ?>"
                      data-event-label="<?= $various['metadata']['analytics_label'] ?: 'Formular' ?>"
                      data-event-fbq="<?= $various['metadata']['analytics_facebook'] ?: 'Formular contact' ?>"
                >
                    <input type="hidden" id="formId" name="formId" value="<?= $formName ?>">
                    <input type="hidden" id="formBlock" name="formBlock" value="<?= $various['id'] ?>">
                    <div id="<?= $formName ?>_errors_top" class="text-danger hide">
                        Va rugam sa completati campurile necesare.
                        <ul></ul>
                    </div>

                    <div class="form-floating fs-5">
                        <input type="text"
                               class="form-control border-top-0 border-start-0 border-end-0"
                               id="name-<?= $formName ?>"
                               name="name"
                               placeholder="Nume">
                        <label for="name-<?= $formName ?>">Nume</label>
                    </div>
                    <div class="form-floating mb-2 fs-5">
                        <input type="email"
                               class="form-control border-top-0 border-start-0 border-end-0"
                               id="email-<?= $formName ?>"
                               name="email"
                               placeholder="Email">
                        <label for="email-<?= $formName ?>">Email</label>
                    </div>
                    <div class="form-floating mb-2 fs-5">
                        <input type="tel"
                               class="form-control border-top-0 border-start-0 border-end-0"
                               id="phone-<?= $formName ?>"
                               name="phone"
                               placeholder="Telefon">
                        <label for="phone-<?= $formName ?>">Telefon</label>
                    </div>
                    <div class="form-floating mb-2 fs-5">
                        <input type="text"
                               class="form-control border-top-0 border-start-0 border-end-0"
                               id="volume-<?= $formName ?>"
                               name="volume"
                               placeholder="Volum zilnic de transport">
                        <label for="volume-<?= $formName ?>">Volum zilnic de transport</label>
                    </div>
                    <div class="form-floating mb-2 fs-5">
                        <textarea class="form-control border-top-0 border-start-0 border-end-0"
                                  id="message-<?= $formName ?>"
                                  name="message"
                                  placeholder="Mesaj"
                                  rows="5"
                                  style="height: 115px"></textarea>
                        <label for="message-<?= $formName ?>">Mesaj</label>
                    </div>
                    <div class="form-check mb-2 pt-2">
                        <input type="checkbox"
                               class="form-check-input"
                               id="gdpr-<?= $formName ?>"
                               name="gdpr">
                        <label for="gdpr-<?= $formName ?>" class="form-check-label">Accept <a href="#">termenii si conditiile</a></label>
                    </div>
                    <input type="submit"
                           id="<?= $formName ?>_submit"
                           class="btn btn-danger py-3 px-5 mt-4 rounded-5"
                           data-message-loading="Se trimite..."
                           data-message-normal="Trimite"
                           value="Trimite" />
                </form>
            </div>
        </div>
    </div>
</div>