<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Utilizatori > Administratori</h4>
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
                            <div class="col-sm-4 mt-3 mt-md-0">
                                <div class="form-group">
                                    <label for="name" class="bmd-label-floating">Nume / Email:</label>
                                    <input type="text" id="name" name="name" value="<?= $_GET['name'] ?>" class="form-control" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="access" class="col-form-label col-sm-2 mt-0 mt-md-1">Tip:</label>
                                    <div class="col-sm-10 pt-0 pb-0 pt-md-3 pb-md-3">
                                        <select name="access" id="access" class="custom-select custom-select-filter">
                                            <?= formSelectOptions(ADMIN_TYPES, '', 'access') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="status" class="col-form-label col-sm-2 mt-0 mt-md-1">Status:</label>
                                    <div class="col-sm-10 pt-0 pb-0 pt-md-3 pb-md-3">
                                        <select name="status" id="status" class="custom-select custom-select-filter">
                                            <option></option>
                                            <? foreach($status AS $i => $s) : ?>
                                                <option value="<?= $i ?>" <?= ($i == $_GET['status'] && strlen($_GET['status'])) ? ' selected="selected"' : '' ?>><?= $s['key'] ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10">
                                        <div class="form-group">
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
                    <div class="d-md-none clear"></div>
                    <div class="dropdown-divider d-md-none"></div>
                    <?= listPages() ?>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Nume</th>
                                <th data-priority="2">Email</th>
                                <th class="text-center text-nowrap">Ultimul login</th>
                                <th class="text-center">Suspendat</th>
                                <th class="text-center">Tip user</th>
                                <th class="text-center">Status</th>
                                <th data-priority="1"></th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <? foreach($list AS $row) : ?>
                                <tr id="sort_<?= $row['id'] ?>">
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td class="td-actions text-center"><?= $row['last_login'] ? date('d.m.Y H:i', $row['last_login']) : '-' ?></td>
                                    <td class="td-actions text-center"><?= $row['suspended_until'] ? date('d.m.Y H:i', $row['suspended_until']) : '-' ?></td>
                                    <td class="td-actions text-center">
                                        <?= ADMIN_TYPES[$row['access']] ?>
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
                    <?= listPages() ?>
                    <div class="clear d-md-none"></div>
                    <div class="dropdown-divider d-md-none"></div>
                    <?= listAdd() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>