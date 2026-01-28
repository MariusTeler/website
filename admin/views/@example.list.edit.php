<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Module > Section : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?></h4>
                </div>
            </div>
            <div class="card-body px-3">
                <?= formReturn() ?>
                <?= formPreview($previewLink, $_GET['edit']) ?>
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
                        <label class="col-sm-2 col-form-label" for="parent_id">Parent:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="parent_id" id="parent_id" class="custom-select custom-select-filter">
                                    <?= formSelectOptions($parents, 'name', 'parent_id', true) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="id_parent">Categorie:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="id_parent"
                                        id="id_parent2"
                                        class="custom-select custom-select-filter"
                                        data-fields="<?= implode(':::', ['field1', 'field2', 'field3']) ?>"
                                        data-fields-selection="<?= implode(':::', ['field1', 'field2']) ?>"
                                        data-field1="Field 1"
                                        data-field2="Field 2"
                                        data-field3="Field 3"
                                >
                                    <?= formSelectOptions(
                                            $options,
                                            'name',
                                            'parent_id',
                                            true,
                                            true,
                                            [],
                                            'dummy',
                                            ['field1', 'field2', 'field3'],
                                            [1, 2, 3]
                                    ) ?>
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
                        <label class="col-sm-2 col-form-label" for="date">Data:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="date" name="date" value="<?= date('d.m.Y H:i', $_POST['date']) ?>" class="form-control" autocomplete="off" readonly <?= $_GET['edit'] ? 'disabled' : '' ?> />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="status">Status:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select id="status" name="status" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(STATUS_TYPES, '', 'status', true) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="text">Text:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea id="text" name="text" class="form-control"><?= $_POST['text'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="site_title">SEO Title:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea id="site_title"
                                      name="site_title"
                                      class="char-limit form-control"
                                      data-limit="80"
                                      data-limit-counter="#siteTitleCounter"><?= $_POST['site_title'] ?></textarea>
                            [ <span id="siteTitleCounter"></span> caractere ramase ]
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="site_description">SEO Description:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea id="site_description"
                                      name="site_description"
                                      class="char-limit form-control"
                                      data-limit="160"
                                      data-limit-counter="#siteDescriptionCounter"><?= $_POST['site_description'] ?></textarea>
                            [ <span id="siteDescriptionCounter"></span> caractere ramase ]
                            </div>
                        </div>
                    </div>
                    <?= formUploadFile() ?>
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

<? captureJavaScriptStart() ?>
<script>
    $(document).ready(function() {
        // Your JS here...
    });
</script>
<? captureJavaScriptEnd() ?>