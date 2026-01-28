<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Administrare > Pagini</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-no table-hover">
                    <?= listAdd() ?>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Ordonare</th>
                                <th class="w-25" data-priority="1">Nume</th>
                                <th class="not-mobile">PHP</th>
                                <th class="w-25_">Subpagini</th>
                                <th class="text-center">Status</th>
                                <th data-priority="1"></th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <? foreach($list AS $row) : ?>
                            <tr id="sort_<?= $row['id'] ?>">
                                <td>
                                    <?= listOrder($row, true, false) ?>
                                </td>
                                <td><?= $row['name'] ?></td>
                                <td><?= (($row['page']) ? $row['page'] . '.php' : '') ?></td>
                                <td>
                                    <table class="table">
                                        <tbody id="sortable-<?= $row['id'] ?>">
                                            <? listSortable($row['id']) ?>
                                            <? foreach($row['subpages'] AS $row2) : ?>
                                                <tr data-id="sort_<?= $row2['id'] ?>">
                                                    <td><?= listOrder($row2, true, false, 'drag-' . $row['id']) ?></td>
                                                    <td class="w-75 <?= ($row2['status']) ? 'text-success' : 'text-danger' ?>"><?= $row2['name'] ?> - <?= $row2['page'] ?>.php</td>
                                                    <td class="w-25 td-actions text-right">
                                                        <?= listEdit($row2) ?>
                                                        <?= listDelete($row2) ?>
                                                    </td>
                                                </tr>
                                            <? endforeach ?>
                                    </table>
                                </td>
                                <td class="td-actions text-center">
                                    <?= listStatus($row, 'status') ?>
                                </td>
                                <td class="td-actions text-right">
                                    <?= listEdit($row) ?>
                                    <?= listDelete($row) ?>
                                </td>
                            </tr>
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