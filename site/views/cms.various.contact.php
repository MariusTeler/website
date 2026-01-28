<!-- Box - Contact > Text right -->
<? $anchor = 'form-' . $various['id']; ?>
<div class="py-4" id="<?= $anchor ?>">
    <div class="container position-relative py-4">
        <div class="row">
            <div class="col-xl-11 offset-xl-1">
                <h2 class="mb-4 ls-wider"><?= $various['title'] ?></h2>
            </div>
            <div class="col-md-10 col-xl-9 offset-xl-3 fw-light overflow-hidden">
                <div class="row g-md-5">
                    <div class="col-md-8">
                        <h3 class="mb-4 fw-light">
                            <?= $various['metadata']['contact_subtitle'] ?>
                        </h3>
                    </div>
                    <div class="col-sm-6 col-md-6 mt-0 mb-4">
                        <form id="<?= $formName ?>"
                              method="POST"
                              class="frm formContact"
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
                                <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="name-<?= $formName ?>" name="name" placeholder="Nume">
                                <label for="name-<?= $formName ?>">Nume</label>
                            </div>
                            <div class="form-floating mb-2 fs-5">
                                <input type="email" class="form-control border-top-0 border-start-0 border-end-0" id="email-<?= $formName ?>" name="email" placeholder="Email">
                                <label for="email-<?= $formName ?>">Email</label>
                            </div>
                            <div class="form-floating mb-2 fs-5">
                                <input type="tel" class="form-control border-top-0 border-start-0 border-end-0" id="phone-<?= $formName ?>" name="phone" placeholder="Telefon">
                                <label for="phone-<?= $formName ?>">Telefon</label>
                            </div>
                            <div class="form-floating mb-2 fs-5">
                                <input type="text" class="form-control border-top-0 border-start-0 border-end-0" id="subject-<?= $formName ?>" name="subject" placeholder="Subiect">
                                <label for="subject-<?= $formName ?>">Subiect</label>
                            </div>
                            <div class="form-floating mb-2 fs-5">
                                <textarea class="form-control border-top-0 border-start-0 border-end-0" placeholder="Mesaj" id="message-<?= $formName ?>" name="message" rows="5" style="height: 115px"></textarea>
                                <label for="message-<?= $formName ?>">Mesaj</label>
                            </div>
                            <div class="form-check mb-2 pt-2">
                                <input type="checkbox" id="gdpr-<?= $formName ?>" name="gdpr" class="form-check-input">
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
                    <div class="col-sm-6 col-md-6 mt-0 pt-5 mb-4 fs-5">
                        <?= $various['text'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>