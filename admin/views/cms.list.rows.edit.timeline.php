<div class="row">
    <div class="col-md-12">
        <div class="card my-0">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Linie : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?> Cronologie</h4>
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
                        <label class="col-sm-2 col-form-label" for="title-row">Titlu:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="title-row" name="title" value="<?= $_POST['title'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="month-row">Luna:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="month-row" name="metadata[month]" value="<?= $_POST['metadata']['month'] ?>" class="form-control" />
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label" for="year-row">Anul:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="year-row" name="metadata[year]" value="<?= $_POST['metadata']['year'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="text-row">Text:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea id="text-row" name="text" class="form-control"><?= $_POST['text'] ?></textarea>
                            </div>
                        </div>
                    </div>

                    <? parseVar('title', '', '@init.form.button') ?>
                    <? parseVar('prefix', 'button_', '@init.form.button') ?>
                    <? parseVar('pages', $pages, '@init.form.button') ?>
                    <? parseVar('pagesChildren', $pagesChildren, '@init.form.button') ?>
                    <?= parseView('@init.form.button') ?>

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

    $('input[name="metadata[button_type]"]').on('click', function () {
        let type = $(this).attr('value');
        $('input[name="metadata[button_type]"]').each(function () {
            if ($(this).attr('value') != type) {
                $('#' + $(this).attr('value') + '-row').
                    val('').
                    trigger('change').
                    parents('.type-container').
                    addClass('d-none');
            }
        });

        $('#' + type + '-row').parents('.type-container').removeClass('d-none');
    });
</script>