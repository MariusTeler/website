<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">General > Redirect</h4>
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
                                <th data-priority="1">De la</th>
                                <th class="not-mobile">Catre</th>
                                <th class="text-center not-mobile">Tip</th>
                                <th class="text-center not-mobile">Status</th>
                                <th data-priority="1"></th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <? foreach($list AS $row) : ?>
                            <tr>
                                <td>
                                    <div class="row-404">
                                        <a href="<?= $row['url_from'] ?>" target="_blank"><?= $row['url_from'] ?></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row-404">
                                        <a href="<?= $row['url_to'] ?>" target="_blank"><?= $row['url_to'] ?></a>
                                    </div>
                                </td>
                                <td class="td-actions text-center"><?= $row['redirect_type'] ?></td>
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
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<? parseVar('isSearch', true, '@init.tables.mobile') ?>
<? parseVar('preserveFilters', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>