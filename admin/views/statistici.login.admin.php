<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Statistici > Login Administratori</h4>
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
                                    <label for="id_user" class="col-form-label col-sm-3 mt-1">Utilizator:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="id_user" name="id_user" class="custom-select">
                                            <option value=""></option>
                                            <? foreach($users AS $i => $row) : ?>
                                                <option value="<?= $row['id'] ?>" <?= ($row['id'] == $_GET['id_user']) ? ' selected="selected"' : '' ?>><?= $row['name'] . ' (' . $row['email'] . ')' ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-3 mt-md-2">
                                <div class="form-group">
                                    <label for="user" class="bmd-label-floating">Email:</label>
                                    <input type="text" id="user" name="user" value="<?= $_GET['user'] ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="form-group">
                                    <label for="ip" class="bmd-label-floating">IP:</label>
                                    <input type="text" id="ip" name="ip" value="<?= $_GET['ip'] ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="status" class="col-form-label col-sm-3 mt-1">Rezultat:</label>
                                    <div class="col-sm-9 pt-0 pb-0 pt-md-3 pb-md-3">
                                        <select name="status" id="status" class="custom-select custom-select-filter">
                                            <option></option>
                                            <? foreach($status AS $i => $s) : ?>
                                            <option value="<?= $i ?>" <?= ($i == $_GET['status'] && strlen($_GET['status'])) ? ' selected="selected"' : '' ?>><?= $s ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-3 mt-md-2">
                                <div class="form-group">
                                    <label for="data_start" class="bmd-label-floating">Data inceput:</label>
                                    <input type="text" id="data_start" name="data_start" value="<?= $_GET['data_start'] ?>" class="form-control" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="form-group">
                                    <label for="data_end" class="bmd-label-floating">Data sfarsit:</label>
                                    <input type="text" id="data_end" name="data_end" value="<?= $_GET['data_end'] ?>" class="form-control" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-sm-4 offset-md-8">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-fill btn-success btn-sm" value="Filtreaza" />
                                    [ Inregistrari: <span class="text-success"><?= $listRows ?></span> ]
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clear"></div>
                    <div class="d-md-none clear"></div>
                    <?= listPages() ?>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Admin</th>
                                <th data-priority="2">Email</th>
                                <th>Cont Social</th>
                                <th data-priority="3">Rezultat</th>
                                <th>Data</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                        <? foreach ($list AS $row) : ?>
                            <tr>
                                <td>
                                    <? if ($row['admin_email']) : ?>
                                        <?= $row['admin_name'] ?><br />
                                        <?= $row['admin_email'] ?>
                                    <? else : ?>
                                        -
                                    <? endif; ?>
                                </td>
                                <td><?= $row['user'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td class="<?= $row['success'] ? 'text-success' : 'text-danger' ?>">
                                    <?= $row['success'] ? 'Succes' : $cfg__['login']['errorCode'][$row['error_code']] ?><br />
                                    <? if ($row['suspended_until_by_ip'] > time()) : ?>
                                        IP: Suspendat pana la <?= date('d.m.Y H:i', $row['suspended_until_by_ip']) ?>
                                    <? endif; ?>
                                    <? if ($row['suspended_until_by_user'] > time()) : ?>
                                        User: Suspendat pana la <?= date('d.m.Y H:i', $row['suspended_until_by_user']) ?>
                                    <? endif; ?>
                                </td>
                                <td><?= date('d.m.Y H:i', $row['date']) ?></td>
                                <td><?= $row['ip'] ?></td>
                            </tr>
                        <? endforeach; ?>
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
<?= parseView('@init.tables.mobile') ?>