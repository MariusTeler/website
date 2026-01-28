<form id="<?= $formName ?>"
      method="POST"
      class="frm formContact hide"
      data-event-action="click"
      data-event-category="Formular contact"
      data-event-label="Formular"
      data-event-fbq="Formular contact"
>
    <div class="row g-3">
        <? if ($contact['title']) : ?>
            <h2 class="h4"><?= $contact['title'] ?></h2>
        <? endif; ?>
        <?= $contact['text'] ?>

        <input type="hidden" id="formId" name="formId" value="<?= $formName ?>">
        <div id="<?= $formName ?>_errors_top" class="text-danger hide">
            Va rugam sa completati campurile necesare.
            <ul></ul>
        </div>

        <div class="col-12">
            <label for="name" class="form-label">Nume</label>
            <input type="text" id="name" name="name" class="form-control" autocomplete="name" />
        </div>

        <div class="col-12">
            <label for="phone" class="form-label">Telefon</label>
            <input type="text" id="phone" name="phone" class="form-control" />
        </div>

        <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="text" id="email" name="email" class="form-control" autocapitalize="off" />
        </div>

        <div class="col-12">
            <label for="message" class="form-label">Mesaj</label>
            <textarea id="message" name="message" rows="3" class="form-control"></textarea>
        </div>

        <div class="form-check">
            <input type="checkbox" id="gdpr" name="gdpr" class="form-check-input">
            <label for="gdpr" class="form-check-label">Accept termenii si conditiile</label>
        </div>

        <input type="submit"
               id="<?= $formName ?>_submit"
               class="btn btn-primary btn-lg"
               data-message-loading="SE TRIMITE..."
               data-message-normal="TRIMITE"
               value="TRIMITE" />
    </div>
</form>