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
                <?= formPreview($previewLink, $_GET['edit']) ?>
                <? if ($_GET['edit']) : ?>
                    <a class="showMobilePreview btn btn-info btn-sm text-white"
                       target="mobilePreviewFrame"
                       data-href="<?= $previewLink ?>&mobilePreview=1"
                    >
                        <i class="material-icons">phone_iphone</i> Previzualizare
                    </a>
                <? endif; ?>
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
                        <label class="col-sm-2 col-form-label" for="parent_id">Parinte:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="parent_id" id="parent_id" class="custom-select">
                                    <?= formSelectOptions($options, 'link_name', 'parent_id', true) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="link_name">Nume pagina:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="link_name" name="link_name" value="<?= $_POST['link_name'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row hidden" id="isRedirectHolder">
                        <label class="col-sm-2 col-form-label" for=""></label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <label class="form-check-label text-success">
                                    <input type="checkbox"
                                           id="is_redirect"
                                           name="is_redirect"
                                           value="1"
                                           class="form-check-input"
                                    />
                                    Creeaza redirect din vechiul link catre noul link
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
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
                        <label class="col-sm-2 col-form-label" for="type">Tip sectiune:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="type" name="type" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(PAGE_TYPES, '', 'type', true) ?>
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

                    <!-- Tabs -->
                    <ul class="nav nav-pills nav-pills-success nav-pills-icons justify-content-center mt-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#content" role="tablist">
                                <i class="material-icons">subject</i> Continut
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#seo" role="tablist">
                                <i class="material-icons">manage_search</i> SEO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#images" role="tablist">
                                <i class="material-icons">insert_photo</i> Imagini
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content tab-space tab-subcategories">
                        <div class="tab-pane active" id="content">
                            <div class="card">
                                <div class="card-header card-header-success card-header-text">
                                    <div class="card-text">
                                        <h4 class="card-title">Continut</h4>
                                    </div>
                                    <label for="categories_table" class="position-relative ml-4">&nbsp;</label>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label" for="title">Titlu:</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <input type="text" id="title" name="title" value="<?= $_POST['title'] ?>" class="form-control" />
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
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="seo">
                            <div class="card">
                                <div class="card-header card-header-success card-header-text">
                                    <div class="card-text">
                                        <h4 class="card-title">SEO</h4>
                                    </div>
                                    <label for="categories_table" class="position-relative ml-4">&nbsp;</label>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label" for="is_noindex">Noindex:</label>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select id="is_noindex" name="is_noindex" class="custom-select custom-select-filter">
                                                    <?= formSelectOptions(['Nu', 'Da'], '', 'is_noindex', true, false) ?>
                                                </select>
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
                                                          data-limit-counter="#siteTitleCounter"
                                                ><?= $_POST['site_title'] ?></textarea>
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
                                                          data-limit-counter="#siteDescriptionCounter"
                                                ><?= $_POST['site_description'] ?></textarea>
                                                [ <span id="siteDescriptionCounter"></span> caractere ramase ]
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="images">
                            <div class="card">
                                <div class="card-header card-header-success card-header-text">
                                    <div class="card-text">
                                        <h4 class="card-title">Imagini</h4>
                                    </div>
                                    <label for="categories_table" class="position-relative ml-4">&nbsp;</label>
                                </div>
                                <div class="card-body">
                                    <?= formUploadFile() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tabs (end) -->

                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="name">Identificator:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="name" name="name" value="<?= $_POST['name'] ?>" class="form-control" /> [ Doar pentru programator ]
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
                    <? parseVar('entityType', ENTITY_PAGE, 'user.actions') ?>
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
        <? if($_GET['edit'] && $_POST['status']) : ?>
            var $title = $('#link_name')
                title = $title.val(),
                $parentId = $('#parent_id'),
                parentId = $parentId.val(),
                $link = $('#link'),
                $redirect = $('#is_redirect'),
                $redirectPlaceholder = $('#isRedirectHolder');

            $title.on('keyup', function() {
                if ($(this).val() !== title && !$link.val()) {
                    toggleRedirect(true);
                } else {
                    if ($parentId.val() === parentId) {
                        toggleRedirect(false);
                    }
                }
            });

            $parentId.on('change', function() {
                if ($(this).val() !== parentId && !$link.val()) {
                    toggleRedirect(true);
                } else {
                    if ($title.val() === title) {
                        toggleRedirect(false);
                    }
                }
            });

            $link.on('keyup', function () {
                toggleRedirect(false);
            });
        <? endif; ?>
    });

    function toggleRedirect(visible) {
        if (visible) {
            $redirectPlaceholder.removeClass('hidden');
        } else {
            $redirect.prop('checked', false);
            $redirectPlaceholder.addClass('hidden');
        }
    }
</script>
<? captureJavaScriptEnd(); ?>

<?= parseView('@init.mobile.preview') ?>
