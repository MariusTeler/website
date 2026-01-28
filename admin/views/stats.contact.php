<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Statistici > Formular Contact</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-hover">
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
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="status_id_vs" class="col-form-label col-sm-3 mt-0 mt-md-1">VS.</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select id="status_id_vs" name="status_id_vs" class="custom-select custom-select-filter">
                                            <?= formSelectOptions($status, 'name', 'status_id_vs') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="graph_type" class="col-form-label col-sm-3 mt-0 mt-md-1">Grafic:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select name="graph_type" id="graph_type" class="custom-select custom-select-filter">
                                            <?= formSelectOptions(GRAPH_TYPES, '', 'graph_type', false, false) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="years" class="col-form-label col-sm-3 mt-0 mt-md-1">Ani:</label>
                                    <div class="col-sm-9 pt-0 pt-md-3">
                                        <select name="years[]" id="years" class="custom-select custom-select-filter" multiple>
                                            <?= formSelectOptions($yearsList, '', 'years') ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3"></div>
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
                    <div id="curve_chart" style="width: 100%; height: 350px;"></div>
                    <?= listExport() ?>
                    <div class="clear"></div>
                    <div class="material-datatables">
                        <table class="table" id="datatable" cellspacing="0" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="disabled-sorting">Data</th>
                                    <? foreach ($years as $i => $year) : ?>
                                        <th class="text-right">
                                            <span class="pr-4">
                                                <?= $year ?>
                                            </span>
                                        </th>
                                        <? if ($i) : ?>
                                            <th class="text-right">
                                                <span class="pr-4">
                                                    var. <?= $years[$i - 1] ?>
                                                </span>
                                            </th>
                                        <? endif; ?>
                                        <? if ($_GET['status_id_vs']) : ?>
                                            <th class="text-right">
                                                <span class="pr-4">
                                                    vs.
                                                </span>
                                            </th>
                                            <th class="text-right">
                                                <span class="pr-4">
                                                    vs.%
                                                </span>
                                            </th>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                    <th class="disabled-sorting" style="width: 10%;"></th>
                                </tr>
                                <tr class="font-weight-bold border-bottom">
                                    <td class="disabled-sorting">Total</td>
                                    <? foreach ($years as $i => $year) : ?>
                                        <? $total = array_sum(array_column($listByYear[$year], 'total')); ?>
                                        <td class="text-right">
                                            <span class="pr-4">
                                                <?= $total ?>
                                            </span>
                                        </td>
                                        <? if ($i) : ?>
                                            <? $vsYear = array_sum(array_column($listByYear[$years[$i - 1]], 'total')); ?>
                                            <td class="text-right" data-sort="<?= $vsYear ?>">
                                                <span class="pr-4">
                                                    <? if ($vsYear) : ?>
                                                        <? $percent = stringToFloat(($total / $vsYear - 1) * 100); ?>
                                                        <?= $percent <= 0 ? $percent : '+' . $percent ?>%
                                                    <? endif; ?>
                                                </span>
                                            </td>
                                        <? endif; ?>
                                        <? if ($_GET['status_id_vs']) : ?>
                                            <? $vs = array_sum(array_column($listByYear[$year], 'total_vs')); ?>
                                            <td class="text-right" data-sort="<?= $vs ?>">
                                                <span class="pr-4">
                                                    <?= $vs ?>
                                                </span>
                                            </td>
                                            <td class="text-right" data-sort="<?= $vs ?>">
                                                <span class="pr-4">
                                                    <? if ($total) : ?>
                                                        <?= stringToFloat($vs / $total * 100) . '%' ?>
                                                    <? endif; ?>
                                                </span>
                                            </td>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                    <td class="disabled-sorting" style="width: 10%;"></td>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                            <? foreach ($listByYear[reset($years)] as $i => $row) : ?>
                                <tr>
                                    <td><?= $graphPoints[$i]['point'] ?></td>
                                    <? foreach ($years as $j => $year) : ?>
                                        <? $total = $listByYear[$year][$i]['total']; ?>
                                        <td class="text-right">
                                            <span class="pr-4">
                                                <?= $total ?>
                                            </span>
                                        </td>
                                        <? if ($j) : ?>
                                            <? $vsYear = $listByYear[$years[$j - 1]][$i]['total']; ?>
                                            <td class="text-right" data-sort="<?= $vsYear ?>">
                                                <span class="pr-4">
                                                    <? if ($vsYear) : ?>
                                                        <? $percent = stringToFloat(($total / $vsYear - 1) * 100); ?>
                                                        <?= $percent <= 0 ? $percent : '+' . $percent ?>%
                                                    <? endif; ?>
                                                </span>
                                            </td>
                                        <? endif; ?>
                                        <? if ($_GET['status_id_vs']) : ?>
                                            <? $vs = (int)$listByYear[$year][$i]['total_vs']; ?>
                                            <td class="text-right" data-sort="<?= $vs ?>">
                                                <span class="pr-4">
                                                    <?= $vs ?>
                                                </span>
                                            </td>
                                            <td class="text-right" data-sort="<?= $vs ?>">
                                                <span class="pr-4">
                                                    <? if ($total) : ?>
                                                        <?= stringToFloat($vs / $total * 100) . '%' ?>
                                                    <? endif; ?>
                                                </span>
                                            </td>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                    <td></td>
                                </tr>
                            <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('legend', $legend, 'stats.graph') ?>
<? parseVar('legendPosition', $legendPosition, 'stats.graph') ?>
<? parseVar('graphPoints', $graphPoints, 'stats.graph') ?>
<?= parseView('stats.graph') ?>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<? parseVar('isOrdering', true, '@init.tables.mobile') ?>
<? parseVar('isScroll', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>
