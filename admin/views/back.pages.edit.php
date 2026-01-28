<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Administrare > Pagini : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?></h4>
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
                        <label class="col-sm-2 col-form-label" for="id_parent">Categorie:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="id_parent" id="id_parent" class="custom-select custom-select-filter">
                                    <?= formSelectOptions($options, 'name', 'id_parent', true) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="name">Nume:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="name" name="name" value="<?= $_POST['name'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="page">Pagina:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="page" name="page" value="<?= $_POST['page'] ?>" class="form-control" /> .php
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="icon">Icon:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="icon" name="icon" value="<?= $_POST['icon'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="status">Status:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select id="status" name="status" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(STATUS_TYPES, '', 'status', true, false) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="is_rights">Acces granular:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select id="is_rights" name="is_rights" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(['Nu', 'Da'], '', 'is_rights', true, false) ?>
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
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Nota:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                Categorie meniu: se completeaza doar campul "Nume" dar nu se selecteaza nici o categorie.<br />
                                Subcategorie meniu: se selecteaza Categoria din care face parte, se completeaza campurile "Nume" si "Pagina" php asociata.<br />
                                Pagini suplimentare: nu apar in meniu, dar pot fi asociate utilizatorilor. Se completeaza doar campurile "Nume" si "Pagina" php asociata fara "Categorie".
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
