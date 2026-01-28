<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Utilizatori > Formular Contact</h4>
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
                                    <label for="text" class="bmd-label-floating">Nume / Email / Tel / IP:</label>
                                    <input type="text" id="text" name="text" value="<?= htmlspecialchars(stripslashes($_GET['text'])) ?>" autocomplete="off" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="type" class="col-form-label col-sm-3 mt-0 mt-md-1">Tip:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="type" name="type" class="custom-select custom-select-filter">
                                            <?= formSelectOptions(FORM_TYPES, '', 'type') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="status_id" class="col-form-label col-sm-3 mt-0 mt-md-1">Status:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="status_id" name="status_id" class="custom-select custom-select-filter">
                                            <?= formSelectOptions($status, 'name', 'status_id') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="form-group">
                                    <label for="data_start" class="bmd-label-floating">Data inceput:</label>
                                    <input type="text" id="date_start" name="date_start" value="<?= $_GET['date_start'] ?>" autocomplete="off" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="form-group">
                                    <label for="date_end" class="bmd-label-floating">Data sfarsit:</label>
                                    <input type="text" id="date_end" name="date_end" value="<?= $_GET['date_end'] ?>" autocomplete="off" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <input type="submit" class="btn btn-fill btn-success btn-sm" value="Filtreaza" />
                                            [ Inregistrari: <span class="text-success"><?= $listRows ?></span> ]
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clear"></div>
                    <?= listExport() ?>
                    <div class="d-md-none clear"></div>
                    <div class="dropdown-divider d-md-none"></div>
                    <?= listPages() ?>
                    <div class="clear"></div>
                    <?= parseView('cms.contact.list') ?>
                    <div class="clear"></div>
                    <?= listPages() ?>
                </div>
            </div>
        </div>
    </div>
</div>