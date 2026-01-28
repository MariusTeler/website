<div class="row">
    <div class="col-md-12">
        <div class="card my-0">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Linie : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?> Statistici</h4>
                </div>
                <button type="button" class="float-right btn-close close close-ajax"
                        data-dismiss="modal"
                        href="#">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <div class="card-body px-3">
                <div class="clear"></div>
                <form method="POST" action="" id="<?= $formName ?>" enctype="multipart/form-data" class="form-horizontal my-4">
                    <input type="hidden" name="formId" value="<?= $formName ?>" />
                    <input type="hidden" name="formRedirect" value="0" />
                    <input type="hidden" name="id" value="<?= $_GET['edit'] ?>" />
                    <div class="row">
                        <div id="<?= $formName ?>_errors_top" class="col-sm-10 offset-sm-2 text-danger <?= $eClass ?>">
                            Va rugam sa completati toate campurile necesare.
                            <ul></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <div id="ajaxAlerts"><?= parseBlock('site.alerts') ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="title-row">Cantitate:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="title-row" name="title" value="<?= $_POST['title'] ?>" class="form-control" />
                                [ Ex: 100, 100M, 100K, etc. ]
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="subtitle-row">Unitate masura:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="subtitle-row" name="metadata[subtitle]" value="<?= $_POST['metadata']['subtitle'] ?>" class="form-control" />
                                [ Ex: Pachete trimise, Acoperire, Curieri, etc. ]
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="icon-row">Icon:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="icon-row" name="metadata[icon]" class="custom-select custom-select-filter">
                                    <?= formSelectOptions($icons, '', 'icon', true) ?>
                                </select>
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
                        <label class="col-sm-2 col-form-label" for="is_home">Home:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="is_home" name="is_home" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(['Nu', 'Da'], '', 'is_home', true, false) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-group">
                                <input type="submit"
                                       class="btn btn-fill btn-success"
                                       id="<?= $formName ?>_submit"
                                       data-message-loading="Se incarca..."
                                       data-message-normal="Salveaza"
                                       value="Salveaza" />
                                <button type="button"
                                        class="btn btn-fill btn-outline-secondary close-ajax" href="#"
                                        data-dismiss="modal">
                                    Inchide
                                </button>
                            </div>
                        </div>
                    </div>
                    <? parseVar('entityId', $_GET['edit'], 'user.actions') ?>
                    <? parseVar('entityType', ENTITY_LIST_ROW, 'user.actions') ?>
                    <?= parseBlock('user.actions') ?>
                </form>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<?= parseView('@init.form') ?>
<?= parseView('@init.uploadify') ?>
<?= parseView('@init.jcrop') ?>
<?= parseView('@init.jquery') ?>
<?= parseJavaScript() ?>
<script>
    unLoadHelpEditor('text-row');
    loadHelpEditor('text-row');
    ajaxRequest('<?= $curPage . returnVar() ?>');

    $('#myModal').animate({
        scrollTop: 0
    }, 500);
</script>