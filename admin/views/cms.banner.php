<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Continut > Banner Promotii</h4>
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
                            <div class="col-sm-4 mt-3 mt-md-2">
                                <div class="form-group">
                                    <label for="title" class="bmd-label-floating">Title:</label>
                                    <input type="text" id="title" name="title" value="<?= htmlspecialchars(stripslashes($_GET['title'])) ?>" autocomplete="off" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="status" class="col-form-label col-sm-3 mt-0 mt-md-1">Status:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="status" name="status" class="custom-select custom-select-filter">
                                            <?= formSelectOptions(STATUS_TYPES, '', 'status') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4 mt-3 mt-md-2">
                                <div class="form-group">
                                    <label for="date_start" class="bmd-label-floating">Data inceput:</label>
                                    <input type="text" id="date_start" name="date_start" value="<?= $_GET['date_start'] ?>" class="form-control" autocomplete="off" readonly />
                                </div>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="form-group">
                                    <label for="date_end" class="bmd-label-floating">Data sfarsit:</label>
                                    <input type="text" id="date_end" name="date_end" value="<?= $_GET['date_end'] ?>" class="form-control" autocomplete="off" readonly />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="row">
                                        <!--<div class="col-sm-3"></div>-->
                                        <div class="col-sm-9">
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
                                <th data-priority="1">Titlu</th>
                                <th data-priority="1">Valabilitate</th>
                                <th class="text-center not-mobile">Status</th>
                                <th data-priority="1" class="disabled-sorting"></th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <? foreach($list AS $row) : ?>
                                <tr id="sort_<?= $row['id'] ?>">
                                    <td><?= $row['title'] ?></td>
                                    <td class="<?= $row['date_end'] < strtotime('midnight') ? 'text-danger' : ($row['date_start'] < time() ? 'text-success' : '') ?>">
                                        <? if ($row['date_start']) : ?>
                                            <strong>Data inceput:</strong> <?= date('d.m.Y', $row['date_start']) ?><br />
                                        <? endif; ?>
                                        <? if ($row['date_end']) : ?>
                                            <strong>Data sfarsit:</strong> <?= date('d.m.Y', $row['date_end']) ?>
                                        <? endif; ?>
                                        <? if (!$row['date_start'] && !$row['date_end']) : ?>
                                            <span class="text-primary">Nelimitat</span>
                                        <? endif; ?>
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
                    <?= parseView('@list.sortable.init') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>