<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Continut > Blog</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-no table-hover">
                    <?= parseView('@init.filters.mobile') ?>
                    <form method="GET"
                          action="index.php"
                          class="form-horizontal my-2 hidden d-md-block form-filters-mobile"
                          data-summary="#form-filters-summary"
                          id="form-filters-mobile"
                    >
                        <input type="hidden" name="page" value="<?= $_GET['page'] ?>" />
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="page_id" class="col-form-label col-sm-3 mt-0 mt-md-1">Categorie:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="page_id" name="page_id" class="custom-select custom-select-filter">
                                            <?= formSelectOptions($pagesById, 'link_name', 'page_id', false, true, $pagesChildren) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="author_id" class="col-form-label col-sm-3 mt-0 mt-md-1">Autor:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="author_id" name="author_id" class="custom-select custom-select-filter">
                                            <?= formSelectOptions($authors, 'name', 'author_id') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="status" class="col-form-label col-sm-3 mt-0 mt-md-1">Status:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="status" name="status" class="custom-select custom-select-filter">
                                            <?= formSelectOptions(STATUS_TYPES, '', 'status') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="sort" class="col-form-label col-sm-3 mt-0 mt-md-1 text-dark">Ordonare:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="sort" name="sort" class="custom-select custom-select-filter">
                                            <?= formSelectOptions(array_column($sort, 'key'), '', 'sort') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="seo" class="col-form-label col-sm-3 mt-0 mt-md-1">SEO:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="seo" name="seo" class="custom-select custom-select-filter">
                                            <?= formSelectOptions($seo, '', 'seo') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="outbound" class="col-form-label col-sm-3 mt-0 mt-md-1">Link-uri ext.:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="outbound" name="outbound" class="custom-select custom-select-filter">
                                            <?= formSelectOptions(['Nu', 'Da'], '', 'outbound') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-3 mt-md-2">
                                <div class="form-group">
                                    <label for="text" class="bmd-label-floating">Titlu / Titlu Facebook:</label>
                                    <input type="text" id="text" name="text" value="<?= htmlspecialchars(stripslashes($_GET['text'])) ?>" autocomplete="off" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4 mt-3 mt-md-2">
                                <div class="form-group">
                                    <label for="date_start" class="bmd-label-floating">Data inceput:</label>
                                    <input type="text" id="date_start" name="date_start" value="<?= $_GET['date_start'] ?>" class="form-control" autocomplete="off" readonly />
                                </div>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="form-group">
                                    <label for="date_end" class="bmd-label-floating">Data sfarsit:</label>
                                    <input type="text" id="date_end" name="date_end" value="<?= $_GET['date_end'] ?>" class="form-control" autocomplete="off" readonly />
                                </div>
                            </div>
                            <div class="col-sm-4 offset-md-8">
                                <div class="form-group">
                                    <div class="row">
                                        <!--<div class="col-sm-3"></div>-->
                                        <div class="col-sm-9">
                                            <input type="submit" class="btn btn-fill btn-success btn-sm" value="Filtreaza" />
                                            [ Inregistrari: <span class="text-success"><?= $listRows ?></span> ]
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clear"></div>
                    <?= listAdd() ?>
                    <div class="d-md-none clear"></div>
                    <div class="dropdown-divider d-md-none"></div>
                    <?= listPages() ?>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Categorie</th>
                                <th data-priority="1">Titlu</th>
                                <th class="text-center not-mobile">Afisari</th>
                                <th class="text-center not-mobile">Caractere</th>
                                <th class="text-center not-mobile">Link-uri externe</th>
                                <th class="text-center not-mobile">Data publicarii</th>
                                <th class="text-center not-mobile">Noindex</th>
                                <th class="text-center not-mobile">Home</th>
                                <th class="text-center not-mobile">Status</th>
                                <th data-priority="1"></th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <? foreach($list AS $row) : ?>
                                <? if (!$row['parent_id']) : ?>
                                    <tr id="sort_<?= $row['id'] ?>">
                                        <td>
                                            <? if ($row['page_parent_id']) : ?>
                                                <?= $pagesById[$row['page_parent_id']]['link_name'] ?>
                                                <br />
                                            <? endif; ?>
                                            <?= $pagesById[$row['page_id']]['link_name'] ?>
                                        </td>
                                        <td>
                                            <a href="<?= blogLink(LINK_RELATIVE, $row) ?>?preview=1" target="_blank">
                                                <?= $row['title'] ?>
                                                <span class="btn btn-sm btn-link btn-primary my-0 py-0 px-0">
                                                    <i class="material-icons">desktop_windows</i>
                                                </span>
                                            </a>
                                            <a class="showMobilePreview btn btn-sm btn-link btn-primary my-0 py-0 px-0"
                                               target="mobilePreviewFrame"
                                               data-href="<?= blogLink(LINK_RELATIVE, $row) ?>?preview=1&mobilePreview=1">
                                                <i class="material-icons">phone_iphone</i>
                                            </a>
                                            <?= listSEO($row) ?>
                                        </td>
                                        <td class="text-center"><?= (int)$row['visits'] ?></td>
                                        <td class="text-center">
                                            <a href="javascript: void(0);"
                                               rel="tooltip"
                                               data-html="true"
                                               title="Caractere fara spatii: <?= countCharsDisplay($row['text'], 'chars_nospaces') ?><br />Cuvinte: <?= countCharsDisplay($row['text'], 'words') ?>"
                                            >
                                                <?= countCharsDisplay($row['text']) ?>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <? parseVar('outboundLinks', $row['metadata']['outbound_links'], 'cms.blog.outbound') ?>
                                            <a href="javascript: void(0);"
                                               rel="tooltip"
                                               data-trigger="click"
                                               data-html="true"
                                               title="<?= parseView('cms.blog.outbound') ?>"
                                            >
                                                <?= $row['outbound'] ?>
                                            </a>
                                        </td>
                                        <td class="text-center"><?= date('d.m.Y H:i', $row['date_publish']) ?></td>
                                        <td class="td-actions text-center">
                                            <?= listStatus($row, 'is_noindex', $statusYesNo) ?>
                                        </td>
                                        <td class="td-actions text-center">
                                            <?= listStatus($row, 'is_home', $statusYesNo) ?>
                                        </td>
                                        <td class="td-actions text-center">
                                            <?= listStatus($row, 'status') ?>
                                        </td>
                                        <td class="td-actions text-right">
                                            <?= listEdit($row) ?>
                                            <?= listDelete($row) ?>
                                        </td>
                                    </tr>
                                <? endif; ?>
                            <? endforeach ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                    <?= listPages() ?>
                    <div class="clear d-md-none"></div>
                    <div class="dropdown-divider d-md-none"></div>
                    <?= listAdd() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>
<?= parseView('@init.mobile.preview') ?>