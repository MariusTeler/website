<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Continut > Pagini : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?></h4>
                </div>
            </div>
            <div class="card-body px-3">
                <?= formReturn() ?>
                <?= formPreview(makeLink(LINK_RELATIVE, $authorPage, $_POST) . '?preview=1', $_GET['edit']) ?>
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
                        <label class="col-sm-2 col-form-label" for="name">Nume:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="name" name="name" value="<?= $_POST['name'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="profile_title">Ocupatia:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="profile_title" name="profile_title" value="<?= $_POST['profile_title'] ?>" class="form-control" />
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label" for="profile_gender">Sex:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select name="profile_gender" id="profile_gender" class="custom-select custom-select-filter">
                                    <?= formSelectOptions($sex, '', 'profile_gender', true) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="profile_facebook">Facebook:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="profile_facebook" name="profile_facebook" value="<?= $_POST['profile_facebook'] ?>" class="form-control" />
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label" for="profile_linkedin">LinekdIn:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="profile_linkedin" name="profile_linkedin" value="<?= $_POST['profile_linkedin'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="profile_instagram">Instagram:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="profile_insta" name="profile_instagram" value="<?= $_POST['profile_instagram'] ?>" class="form-control" />
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label" for="profile_twitter">Twitter:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="profile_twitter" name="profile_twitter" value="<?= $_POST['profile_twitter'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="status">Pagina autor:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="status" name="status" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(['Nu', 'Da'], '', 'status', true, false) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="text">Descriere:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea id="text" name="text" class="form-control"><?= $_POST['text'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <?= formUploadFile() ?>
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-fill btn-success" value="Salveaza" />
                            </div>
                        </div>
                    </div>
                    <? parseVar('entityId', $_GET['edit'], 'user.actions') ?>
                    <? parseVar('entityType', ENTITY_AUTHOR, 'user.actions') ?>
                    <?= parseBlock('user.actions') ?>
                </form>
                <div class="clear"></div>
                <?= formReturn() ?>
            </div>
        </div>
    </div>
</div>