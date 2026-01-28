<div class="row">
    <div class="col-md-12">
        <a class="btn btn-link btn-sm float-right" id="help-close-button" href="#"><i class="material-icons">close</i></a>
        <? if(userGetAccess(ADMIN_SUPERADMIN)) : ?>
            <? if($_GET['edit']) : ?>
                <a class="btn btn-link btn-sm btn-success float-right" id="help-save-button" href="#"><i class="material-icons">check_circle</i></a>
            <? else : ?>
                <a class="btn btn-link btn-sm btn-success float-right d-none d-md-block" id="help-edit-button" href="#"><i class="material-icons">edit</i></a>
            <? endif; ?>
        <? endif; ?>
        <div class="card ">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">info</i>
                </div>
                <h3 class="card-title"><?= $_POST['name'] ?></h3>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-sm-12 help-content">
                        <div class="help-content my-2">
                            <? if($_GET['edit'] && userGetAccess(ADMIN_SUPERADMIN)) : ?>
                                <form action="index.php?page=ajax.help&pg=<?= $_GET['pg'] ?>" method="post" id="helpData">
                                    <input type="hidden" name="formId" value="editForm" />
                                    <input type="hidden" name="pg" value="<?= $_GET['pg'] ?>" />
                                    <input type="hidden" name="id" value="<?= $_POST['id'] ?>" />
                                    <textarea name="helpCms" rows="4" cols="1" class="helpEditor" id="helpEditor">
                                        <?= substr($_GET['pg'], -5) == '.edit' ? $_POST['help_edit'] : $_POST['help_list'] ?>
                                    </textarea>
                                </form>
                            <? else : ?>
                                <?= substr($_GET['pg'], -5) == '.edit' ? $_POST['help_edit'] : $_POST['help_list'] ?>
                            <? endif; ?>
                        </div>
                        <div class="bg-light">
                            <a class="btn btn-link btn-sm btn-primary btn-help-more d-none d-md-inline-block" id="help-more-button" href="#"><i class="material-icons">expand_more</i> Mai mult</a>
                            <span class="pl-4">Legenda:</span>
                            <a class="btn btn-link btn-sm btn-primary btn-help-more d-inline-block d-md-none toggle-view" data-target="#legend-more" href="#"><i class="material-icons">expand_more</i> Mai mult</a>
                            <br class="d-block d-md-none" />
                            <div class="d-md-inline hidden" id="legend-more">
                                <a href="#" class="text-secondary btn-sm btn-link"><i class="material-icons">swap_vert</i></a> Ordonează
                                <br class="d-block d-md-none" />
                                <a href="#" class="btn btn-success btn-sm btn-link"><i class="material-icons">edit</i></a>Editează / Modifică
                                <br class="d-block d-md-none" />
                                <a href="#" class="btn btn-danger btn-sm btn-link"><i class="material-icons">close</i></a>Șterge
                            </div>
                        </div>
                        <div id="legend-details" class="hidden my-2 border-bottom">
                            <h4>Editorul de continut HTML</h4>
                            <img src="/public/admin/images/tinymce.help.jpg" alt="" title="" class="mw-100" /><br /><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>