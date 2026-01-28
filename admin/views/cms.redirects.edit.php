<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">General > Redirect: <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?></h4>
                </div>
            </div>
            <div class="card-body px-3">
                <?= formReturn() ?>
                <div class="clear"></div>
                <form method="POST" action="" id="editForm" enctype="multipart/form-data" class="form-horizontal my-4">
                    <input type="hidden" name="formId" value="editForm" />
                    <input type="hidden" name="formRedirect" value="0" />
                    <input type="hidden" name="id" value="<?= $_GET['edit'] ?>" />
                    <div class="row">
                        <div id="editForm_errors_top" class="col-sm-10 offset-sm-2 text-danger <?= $eClass ?>">
                            Va rugam sa completati toate campurile necesare.
                            <ul></ul>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="url_from">De la:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="url_from" name="url_from" value="<?= $_POST['url_from'] ?>" class="form-control" />
                                [ Ex: /categorie/subcategorie sau /categorie/# ]
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="url_to">Catre:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="url_to" name="url_to" value="<?= $_POST['url_to'] ?>" class="form-control" />
                                [ Ex: /categorie/subcategorie_noua sau /categorie_noua/# ]
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="status">Status:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select id="status" name="status" class="custom-select custom-select-filter">
                                    <option value="0">Inactiv</option>
                                    <option value="1"<?= ($_POST['status']) ? 'selected' : '' ?>>Activ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="redirect_type">Tip:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select id="redirect_type" name="redirect_type" class="custom-select custom-select-filter">
                                    <? foreach($types AS $type) : ?>
                                        <option value="<?= $type ?>"<?= ($_POST['redirect_type'] == $type) ? 'selected' : '' ?>><?= $type ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-fill btn-success" value="Salveaza" />
                            </div>
                        </div>
                    </div>
                    <? parseVar('entityId', $_GET['edit'], 'user.actions') ?>
                    <? parseVar('entityType', ENTITY_REDIRECT, 'user.actions') ?>
                    <?= parseBlock('user.actions') ?>
                </form>
                <div class="clear"></div>
                <?= formReturn() ?>
            </div>
        </div>
    </div>
</div>
