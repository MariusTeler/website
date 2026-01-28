<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Continut > Blog : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?></h4>
                </div>
            </div>
            <div class="card-body px-3">
                <?= formReturn() ?>
                <?= formPreview($previewLink, $_GET['edit'], 'Previzualizare', 'desktop_windows') ?>
                <a class="showMobilePreview btn btn-info btn-sm text-white"
                   target="mobilePreviewFrame"
                   data-href="<?= $previewLink ?>&mobilePreview=1"
                >
                    <i class="material-icons">phone_iphone</i> Previzualizare
                </a>
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
                        <label class="col-sm-2 col-form-label" for="page_id">Categorie:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select name="page_id" id="page_id" class="custom-select">
                                    <?= formSelectOptions($pages, 'link_name', 'page_id', true, true, $pagesChildren) ?>
                                </select>
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label" for="author_id">Autor:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select name="author_id" id="author_id" class="custom-select">
                                    <?= formSelectOptions($authors, 'name', 'author_id', true) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="title">Titlu:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="title" name="title" value="<?= $_POST['title'] ?>" class="form-control" />
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
                        <label class="col-sm-2 col-form-label" for="title_facebook">Titlu Facebook:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="title_facebook" name="title_facebook" value="<?= $_POST['title_facebook'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="date_publish">Data publicarii:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="date_publish" name="date_publish" value="<?= date('d.m.Y H:i', $_POST['date_publish']) ?>" class="form-control" autocomplete="off" readonly <?= $_GET['edit'] ? 'disabled' : '' ?> />
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label" for="date_update">Data actualizarii:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="date_update" name="date_update" value="<?= $_POST['date_update'] ? date('d.m.Y H:i', $_POST['date_update']) : '' ?>" class="form-control" disabled />
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox"
                                               id="is_date_update"
                                               name="is_date_update"
                                               value="1"
                                               class="form-check-input"
                                        />
                                        Actualizeaza data
                                        <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="is_home">Home:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="is_home" name="is_home" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(['Nu', 'Da'], '', 'is_home', true, false) ?>
                                </select>
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label" for="is_evergreen">Evergreen:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="is_evergreen" name="is_evergreen" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(['Nu', 'Da'], '', 'is_evergreen', true, false) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="status">Status:</label>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="status" name="status" class="custom-select custom-select-filter">
                                    <option value="0">Inactiv</option>
                                    <option value="1"<?= ($_POST['status']) ? 'selected' : '' ?>>Activ</option>
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
                                        <label class="col-sm-2 col-form-label" for="text_intro">Text Intro:</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <textarea id="text_intro"
                                                          name="text_intro"
                                                          class="char-limit form-control"
                                                          data-limit="200"
                                                          data-limit-counter="#textIntroCounter"
                                                ><?= $_POST['text_intro'] ?></textarea>
                                                [ <span id="textIntroCounter"></span> caractere ramase ]
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label" for="metadata[video_intro]">Video Intro:</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <textarea id="metadata[video_intro]"
                                                          name="metadata[video_intro]"
                                                          class="form-control"
                                                ><?= $_POST['metadata']['video_intro'] ?></textarea>
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
                                        <label class="col-sm-2 col-form-label" for="image_source">Surse foto:</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <textarea id="image_source"
                                                          name="image_source"
                                                          class="char-limit form-control"
                                                          data-limit="255"
                                                          data-limit-counter="#imageSourceCounter"
                                                ><?= $_POST['image_source'] ?></textarea>
                                                [ <span id="imageSourceCounter"></span> caractere ramase ]
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
                                        <label class="col-sm-2 col-form-label" for="is_toc">Cuprins autogenerat:</label>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select id="is_toc" name="is_toc" class="custom-select custom-select-filter">
                                                    <?= formSelectOptions(['Nu', 'Da'], '', 'is_toc', true, false) ?>
                                                </select>
                                            </div>
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="is_noindex">Noindex:</label>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select id="is_noindex" name="is_noindex" class="custom-select custom-select-filter">
                                                    <option value="0">Nu</option>
                                                    <option value="1"<?= ($_POST['is_noindex']) ? 'selected' : '' ?>>Da</option>
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
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label" for="site_canonical">SEO Canonical:</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <input type="text" id="site_canonical" name="site_canonical" value="<?= $_POST['site_canonical'] ?>" class="form-control" />
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
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-fill btn-success" value="Salveaza" />
                            </div>
                        </div>
                    </div>
                    <? parseVar('entityId', $_GET['edit'], 'user.actions') ?>
                    <? parseVar('entityType', ENTITY_BLOG, 'user.actions') ?>
                    <?= parseBlock('user.actions') ?>
                </form>
                <div class="clear"></div>
                <?= formReturn() ?>
            </div>
        </div>
    </div>
</div>
<? captureJavaScriptStart(); ?>
<link rel="stylesheet" href="/public/site/js/vendor/jquery_ui_timepicker-1.6.3/jquery-ui-timepicker-addon.min.css" type="text/css" />
<script src="/public/site/js/vendor/jquery_ui_timepicker-1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<script src="/public/site/js/vendor/jquery_ui_timepicker-1.6.3/i18n/jquery-ui-timepicker-ro.js"></script>
<script>
    $(document).ready(function() {
        $('#date_publish').datetimepicker({
            controlType: 'select',
            oneLine: true
        });

        <? if($_GET['edit'] && $_POST['status']) : ?>
            var $title = $('#title')
                title = $title.val(),
                $parentId = $('#page_id'),
                parentId = $parentId.val(),
                $redirect = $('#is_redirect'),
                $redirectPlaceholder = $('#isRedirectHolder');

            $title.on('keyup', function() {
                if ($(this).val() !== title) {
                    toggleRedirect(true);
                } else {
                    if ($parentId.val() === parentId) {
                        toggleRedirect(false);
                    }
                }
            });

            $parentId.on('change', function() {
                if ($(this).val() !== parentId) {
                    toggleRedirect(true);
                } else {
                    if ($title.val() === title) {
                        toggleRedirect(false);
                    }
                }
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