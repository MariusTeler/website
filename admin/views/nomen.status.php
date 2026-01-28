<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Nomenclatoare > Status Contact</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-no table-hover">
                    <div class="clear"></div>
                    <?= listPages() ?>
                    <?= listAdd() ?>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th>Ordonare</th>
                                <th>Nume</th>
                                <th>Culoare</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <? foreach($list AS $row) : ?>
                                <tr id="sort_<?= $row['id'] ?>">
                                    <td>
                                        <?= listOrder($row, true, false) ?>
                                    </td>
                                    <td><?= $row['name'] ?></td>
                                    <td class="<?= COLOR_CLASSES[$row['color']] ?>"><?= COLOR_TYPES[$row['color']] ?></td>
                                    <td class="td-actions text-right">
                                        <?= listEdit($row) ?>
                                        <?= listDelete($row) ?>
                                    </td>
                                </tr>
                            <? endforeach ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                    <?= listPages() ?>
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