<div class="row">
    <div class="col-md-12">
        <div class="card <?= $modal ? 'my-0' : '' ?>">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Utilizatori > Contact : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?></h4>
                </div>
                <? if ($modal) : ?>
                    <button type="button" class="float-right btn-close close close-ajax"
                            data-dismiss="modal"
                            href="#">
                        <i class="material-icons">close</i>
                    </button>
                <? endif; ?>
            </div>
            <div class="card-body px-3">
                <? if (!$modal) : ?>
                    <?= formReturn() ?>
                <? endif; ?>
                <div class="clear"></div>
                <form method="POST" action="" id="editForm" enctype="multipart/form-data" class="form-horizontal my-4">
                    <input type="hidden" name="formId" value="editForm" />
                    <input type="hidden" name="formRedirect" value="0" />
                    <input type="hidden" id="id" name="id" value="<?= $_GET['edit'] ?>" />
                    <div class="row">
                        <div id="editForm_errors_top" class="col-sm-10 offset-sm-2 text-danger <?= $eClass ?>">
                            Va rugam sa completati toate campurile necesare.
                            <ul></ul>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-4 col-sm-2 col-form-label text-right" for="name">Nume:</label>
                        <div class="col-8 col-sm-10">
                            <label class="col-form-label text-secondary text-left"><?= $_POST['name'] ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-4 col-sm-2 col-form-label text-right" for="email">Email:</label>
                        <div class="col-8 col-sm-4">
                            <label class="col-form-label text-secondary text-left"><?= $_POST['email'] ?></label>
                        </div>
                        <label class="col-4 col-sm-2 col-form-label text-right" for="phone">Telefon:</label>
                        <div class="col-8 col-sm-4">
                            <label class="col-form-label text-secondary text-left"><?= $_POST['phone'] ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <? if ($_POST['type'] == FORM_CONTACT) : ?>
                            <label class="col-4 col-sm-2 col-form-label text-right" for="subject">Subiect:</label>
                            <div class="col-8 col-sm-4">
                                <label class="col-form-label text-secondary text-left"><?= $_POST['metadata']['subject'] ?></label>
                            </div>
                        <? endif; ?>
                        <? if ($_POST['type'] == FORM_CONTACT_BUSINESS) : ?>
                            <label class="col-4 col-sm-2 col-form-label text-right" for="subject">Volum zilnic de transport:</label>
                            <div class="col-8 col-sm-4">
                                <label class="col-form-label text-secondary text-left"><?= $_POST['metadata']['volume'] ?></label>
                            </div>
                        <? endif; ?>
                    </div>
                    <div class="row">
                        <label class="col-4 col-sm-2 col-form-label text-right" for="message">Mesaj:</label>
                        <div class="col-sm-10">
                            <div class="table mb-0">
                                <label class="col-form-label text-secondary text-left row-404 row-404-160"><?= nl2br($_POST['message']) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-4 col-sm-2 col-form-label text-right" for="date_created">Data:</label>
                        <div class="col-8 col-sm-10">
                            <label class="col-form-label text-secondary"><?= date('d.m.Y H:i', $_POST['date']) ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-4 col-sm-2 col-form-label text-right" for="type">Tip:</label>
                        <div class="col-8 col-sm-4">
                            <label class="col-form-label text-secondary"><?= FORM_TYPES[$_POST['type']] ?></label>
                        </div>
                        <label class="col-4 col-sm-2 col-form-label text-right" for="ip">IP:</label>
                        <div class="col-8 col-sm-4">
                            <label class="col-form-label text-secondary"><?= $_POST['ip'] ?></label>
                        </div>
                    </div>
                    <h4 class="offset-md-2 mt-3">Rezolvare</h4>
                    <hr class="mt-0 offset-md-2" />
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <div id="ajaxAlerts"><?= parseBlock('site.alerts') ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="status_id">Status:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="status_id" name="status_id" class="custom-select custom-select-filter">
                                    <?= formSelectOptions($status, 'name', 'status_id', true) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="text">Comentariu:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea id="text"
                                          name="text"
                                          class="form-control char-limit"
                                          data-limit="500"
                                          data-limit-counter="#textCounter"
                                          rows="4"><?= $_POST['text'] ?></textarea>
                                [ <span id="textCounter"></span> caractere ramase ]
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-group">
                                <input type="submit"
                                       id="<?= $formName ?>_submit"
                                       class="btn btn-fill btn-success"
                                       value="Salveaza"
                                       data-message-loading="Se incarca..."
                                       data-message-normal="Salveaza"
                                />
                                <? if ($modal) : ?>
                                    <button type="button"
                                            class="btn btn-fill btn-outline-secondary close-ajax" href="#"
                                            data-dismiss="modal"
                                    >
                                        Inchide
                                    </button>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                    <? parseVar('entityId', $_GET['edit'], 'user.actions') ?>
                    <? parseVar('entityType', ENTITY_CONTACT, 'user.actions') ?>
                    <?= parseBlock('user.actions') ?>
                </form>
                <div class="clear"></div>
                <? if (!$modal) : ?>
                    <?= formReturn() ?>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>

<? if ($modal) : ?>
    <?= parseView('@init.form') ?>
    <?= parseView('@init.jquery') ?>
    <?= parseJavaScript() ?>
    <script>
        addCharLimit();
        ajaxRequest('<?= $retPage ?>');
    </script>
<? endif; ?>