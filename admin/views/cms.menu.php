<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">General > Meniu</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-no table-hover">
                    [ Meniu: <span class="text-success"><?= $countMenu ?></span> |
                    Submeniu: <span class="text-success"><?= $countSubmenu ?></span> ]
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
                                    <label for="status" class="col-form-label col-sm-3 mt-0 mt-md-1">Tip:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="identifier" name="identifier" class="custom-select custom-select-filter">
                                            <?= formSelectOptions(MENU_TYPES, '', 'identifier', false, false) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
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
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Ordonare</th>
                                <th class="w-25" data-priority="1">Meniu principal</th>
                                <th class="w-50">Submeniu</th>
                                <th data-priority="1"></th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <? foreach($list AS $row) : ?>
                                <? if (!$row['parent_id']) : ?>
                                    <tr id="sort_<?= $row['id'] ?>">
                                        <td>
                                            <?= listOrder($row, true, false) ?>
                                        </td>
                                        <td>
                                            <a href="<?= $row['link'] ?>"
                                               target="_blank"
                                               class="<?= ($row['page_id'] && !$row['status']) ? 'text-danger' : 'text-success' ?>"
                                            >
                                                <?= $row['link_name'] ?: $row['p_link_name'] ?>
                                            </a>
                                        </td>
                                        <td>
                                            <? if ($listChildren[$row['id']]) : ?>
                                                <? parseVar('parentId', $row['id'], 'cms.menu.children') ?>
                                                <?= parseView('cms.menu.children') ?>
                                            <? endif; ?>
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
                    <?= listAdd() ?>
                    <?= parseView('@list.sortable.init') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<? parseVar('isSearch', true, '@init.tables.mobile') ?>
<? parseVar('preserveFilters', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>