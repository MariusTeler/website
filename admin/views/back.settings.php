<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Administrare > Setari</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-hover">
                    [ Inregistrari: <span class="text-success"><?= count($list) ?></span> |
                    <?= listAdd() ?>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Identificator</th>
                                <th class="not-mobile">Valoare</th>
                                <th>Descriere</th>
                                <th data-priority="1"></th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                        <? foreach($list AS $row) : ?>
                            <tr id="sort_<?= $row['id'] ?>">
                                <td><?= $row['name'] ?></td>
                                <td class="w-50">
                                    <div class="row-404">
                                        <?= nl2br(htmlspecialchars($row['value'])) ?>
                                    </div>
                                </td>
                                <td><?= $row['description'] ?></td>
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
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<? parseVar('isSearch', true, '@init.tables.mobile') ?>
<? parseVar('preserveFilters', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>