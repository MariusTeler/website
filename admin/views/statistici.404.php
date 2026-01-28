<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Statistici > 404</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-no table-hover">
                    <div class="clear"></div>
                    <form method="GET" action="index.php" class="form-horizontal my-2">
                        <input type="hidden" name="page" value="<?= $_GET['page'] ?>" />
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="data" class="bmd-label-floating">Data:</label>
                                    <input type="text" id="data" name="data" value="<?= $_GET['data'] ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-fill btn-success btn-sm" value="Filtreaza" />
                                    [ Inregistrari: <span class="text-success"><?= $listRows ?></span> | Total 404: <span class="text-warning"><?= number_format($listTotal, 0, ',', '.') ?></span> ]
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clear"></div>
                    <?= listPages() ?>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Link</th>
                                <th data-priority="1">Hit-uri</th>
                                <th class="not-mobile">Data</th>
                                <th class="not-mobile">IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach($list AS $row) : ?>
                                <tr>
                                    <td><div class="row-404"><?= $row['link'] ?></div></td>
                                    <td><?= $row['nr'] ?></td>
                                    <td><?= date('d.m.Y', $row['data']) ?></td>
                                    <td><?= $row['ip'] ?></td>
                                </tr>
                            <? endforeach ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                    <?= listPages() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<? parseVar('isSearch', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>
