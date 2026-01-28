<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Continut > Liste</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-no table-hover">
                    [ Inregistrari: <span class="text-success"><?= count($list) ?></span> ]
                    <?= listAdd() ?>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Ordonare</th>
                                <th data-priority="1">Titlu</th>
                                <th>Tip</th>
                                <th class="text-center">Linii</th>
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
                                    <td><?= $row['title'] ?></td>
                                    <td>
                                        <?= LIST_TYPES[$row['type']] ?>
                                    </td>
                                    <td class="td-actions text-center">
                                        <?= $row['row_count'] ?>
                                    </td>
                                    <td class="td-actions text-center">
                                        <?= listStatus($row, 'status') ?>
                                    </td>
                                    <td class="td-actions text-center">
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