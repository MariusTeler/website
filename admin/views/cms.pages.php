<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Continut > Pagini</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-hover">
                    [ Pagini: <span class="text-success"><?= $countPages ?></span> |
                    Subpagini: <span class="text-success"><?= $countSubpages ?></span> ]
                    <?= listAdd() ?>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Ordonare</th>
                                <th class="w-25" data-priority="1">Nume</th>
                                <th class="w-50">Subpagini</th>
                                <th class="text-center">Noindex</th>
                                <th class="text-center">Status</th>
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
                                            <a href="<?= makeLink(LINK_RELATIVE, $row) ?>"
                                               target="_blank"
                                               class="<?= ($row['status']) ? 'text-success' : 'text-danger' ?>"
                                            >
                                                <?= $row['link_name'] ?>
                                                <span class="btn btn-sm btn-link btn-primary my-0 py-0 px-0">
                                                    <i class="material-icons">desktop_windows</i>
                                                </span>
                                            </a>
                                            <a class="showMobilePreview btn btn-sm btn-link btn-primary my-0 py-0 px-0"
                                               target="mobilePreviewFrame"
                                               data-href="<?= makeLink(LINK_RELATIVE, $row) . '?preview=1&mobilePreview=1' ?>">
                                                <i class="material-icons">phone_iphone</i>
                                            </a>
                                           <?= listSEO($row) ?>
                                        </td>
                                        <td>
                                            <? if ($listChildren[$row['id']]) : ?>
                                                <? parseVar('parentId', $row['id'], 'cms.pages.children') ?>
                                                <?= parseView('cms.pages.children') ?>
                                            <? endif; ?>
                                        </td>
                                        <td class="td-actions text-center">
                                            <?= listStatus($row, 'is_noindex', $statusYesNo) ?>
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
                    <?= listAdd() ?>
                    <?= parseView('@list.sortable.init') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<? parseVar('isSearch', true, '@init.tables.mobile') ?>
<? //parseVar('preserveFilters', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>

<?= parseView('@init.mobile.preview') ?>
