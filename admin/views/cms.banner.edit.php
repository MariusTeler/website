<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Continut > Banner Promotii : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?></h4>
                </div>
            </div>
            <div class="card-body px-3">
                <?= formReturn() ?>
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
                        <label class="col-sm-2 col-form-label" for="title">Titlu:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="title" name="title" value="<?= $_POST['title'] ?>" class="form-control char-limit" data-limit="30" data-limit-counter="#titleCounter" />
                                [ <span id="titleCounter"></span> caractere ramase ]
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label" for="button_text">Text buton:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="button_text" name="button_text" value="<?= $_POST['button_text'] ?>" class="form-control char-limit" data-limit="30" data-limit-counter="#buttonTextCounter" />
                                [ <span id="buttonTextCounter"></span> caractere ramase ]
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="link">Link:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="link" name="link" value="<?= $_POST['link'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="date_start">Data inceput:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="date_start" name="date_start" value="<?= $_POST['date_start'] ? date('d.m.Y H:i', $_POST['date_start']) : '' ?>" class="form-control" autocomplete="off" readonly />
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label" for="date_end">Data sfarsit:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="date_end" name="date_end" value="<?= $_POST['date_end'] ? date('d.m.Y H:i', $_POST['date_end']) : '' ?>" class="form-control" autocomplete="off" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="status">Status:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="status" name="status" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(STATUS_TYPES, '', 'status', true, false) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?= formUploadFile() ?>
                    <?= formUploadFile('image_mobile') ?>
                    <div class="row">
                        <div id="editForm_errors_bottom" class="col-sm-10 offset-sm-2 text-danger <?= $eClass ?>">
                            Va rugam sa completati toate campurile necesare.
                            <ul></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-fill btn-success" value="Salveaza" />
                            </div>
                        </div>
                    </div>
                </form>
                <div class="clear"></div>
                <?= formReturn() ?>
            </div>
        </div>
    </div>
</div>