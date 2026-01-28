<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Nomenclatoare > Judete</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-no table-hover">
                    <?= listAdd() ?>
                    <div class="d-md-none clear"></div>
                    <div class="dropdown-divider d-md-none"></div>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Nume</th>
                                <th data-priority="2" class="text-center">Cod</th>
                                <th data-priority="3"></th>
                            </tr>
                            <tr>
                                <td colspan="3" class="d-md-none"></td>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <? foreach($list AS $row) : ?>
                                <tr id="sort_<?= $row['id'] ?>">
                                    <td><?= $row['name'] ?></td>
                                    <td class="text-center"><?= $row['code'] ?></td>
                                    <td class="td-actions text-right">
                                        <?= listEdit($row) ?>
                                        <? if(dbCheckDelete('nomen_city', 'county_id', $row['id'])) : ?>
                                            <?= listDelete($row) ?>
                                        <? endif ?>
                                    </td>
                                </tr>
                            <? endforeach ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                    <div class="dropdown-divider d-md-none"></div>
                    <?= listAdd() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<? parseVar('isSearch', true, '@init.tables.mobile') ?>
<? parseVar('preserveFilters', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>