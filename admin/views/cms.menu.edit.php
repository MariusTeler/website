<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">General > Meniu : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?></h4>
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
                        <label class="col-sm-2 col-form-label" for="parent_id">Meniu principal:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="parent_id" id="parent_id" class="custom-select">
                                    <?= formSelectOptions($menu, 'link_name', 'parent_id', true) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="type">Tip meniu:</label>
                        <div class="col-sm-10">
                            <div class="form-group pt-1">
                                <div class="form-check form-check-radio form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" id="type" name="type" value="page_id" <?= $_POST['page_id'] ? 'checked' : '' ?>> Pagina
                                        <span class="circle">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check form-check-radio form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="type" value="link" <?= $_POST['link'] ? 'checked' : '' ?>> Link
                                        <span class="circle">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row type-container <?= !$_POST['page_id'] ? 'd-none' : '' ?>">
                        <label class="col-sm-2 col-form-label" for="page_id">Pagina:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="page_id" id="page_id" class="custom-select">
                                    <?= formSelectOptions($pages, 'link_name', 'page_id', true, true, $pagesChildren) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row type-container <?= !$_POST['link'] ? 'd-none' : '' ?>">
                        <label class="col-sm-2 col-form-label" for="link">Link:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="link" name="link" value="<?= $_POST['link'] ?>" class="form-control" /> [ Ex: https://www.google.com , /contact , # , javascript: void(0); , etc. ]
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="link_name">Nume:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="link_name" name="link_name" value="<?= $_POST['link_name'] ?>" class="form-control" />
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label" for="is_popup">Popup:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="is_popup" name="is_popup" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(['Nu', 'Da'], '', 'is_popup', true, false) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <? if ($icons) : ?>
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="icon">Icon:</label>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select id="icon" name="icon" class="custom-select custom-select-filter">
                                        <?= formSelectOptions($icons, '', 'icon', true) ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-fill btn-success" value="Salveaza" />
                            </div>
                        </div>
                    </div>
                    <? parseVar('entityId', $_GET['edit'], 'user.actions') ?>
                    <? parseVar('entityType', ENTITY_MENU, 'user.actions') ?>
                    <?= parseBlock('user.actions') ?>
                </form>
                <div class="clear"></div>
                <?= formReturn() ?>
            </div>
        </div>
    </div>
</div>
<? captureJavaScriptStart(); ?>
<script>
    $(document).ready(function() {
        $('input[name="type"]').on('click', function () {
            let type = $(this).attr('value');

            $('input[name="type"]').each(function () {
                if ($(this).attr('value') != type) {
                    $('#' + $(this).attr('value')).
                        val('').
                        trigger('change').
                        parents('.type-container').
                        addClass('d-none');
                }
            });

            $('#' + type).parents('.type-container').removeClass('d-none');
        });
    })
</script>
<? captureJavaScriptEnd(); ?>
