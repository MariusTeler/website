<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Nomenclatoare > Localitati</h4>
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
                                    <label for="county_id" class="col-form-label col-sm-2 mt-0 mt-md-1">Judet:</label>
                                    <div class="col-sm-10 pt-0 pt-md-3">
                                        <select id="county_id" name="county_id" class="custom-select custom-select-filter">
                                            <?= formSelectOptions($counties, 'name', 'county_id', false, false) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-3 mt-md-0">
                                <div class="form-group">
                                    <label for="name" class="bmd-label-floating">Nume:</label>
                                    <input type="text" id="name" name="name" value="<?= $_GET['name'] ?>" class="form-control" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-fill btn-success btn-sm" value="Filtreaza" />
                                    [ Inregistrari: <span class="text-success"><?= $listRows ?></span> ]
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider d-md-none"></div>
                    </form>
                    <div class="clear"></div>
                    <?= listAdd() ?>
                    <div class="d-md-none clear"></div>
                    <div class="dropdown-divider d-md-none"></div>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th data-priority="1">Nume</th>
                                <th data-priority="2"></th>
                            </tr>
                            <tr>
                                <td colspan="2" class="d-md-none"></td>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <? foreach($list AS $row) : ?>
                                <tr id="sort_<?= $row['id'] ?>">
                                    <td><?= $row['name'] ?></td>
                                    <td class="td-actions text-right">
                                        <?= listEdit($row) ?>
                                        <?= listDelete($row) ?>
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