<script>
    var diff = {};
</script>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Statistici > Actiuni Administratori</h4>
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
                          autocomplete="off"
                    >
                        <input type="hidden" name="page" value="<?= $_GET['page'] ?>" />
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="id_user" class="col-form-label col-sm-3 mt-0 mt-md-1">Utilizator:</label>
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
                            <div class="col-sm-4 mt-2 mt-md-2">
                                <div class="form-group">
                                    <label for="ip" class="bmd-label-floating">IP:</label>
                                    <input type="text" id="ip" name="ip" value="<?= $_GET['ip'] ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="type" class="col-form-label col-sm-3 mt-0 mt-md-1">Actiune:</label>
                                    <div class="col-sm-9 pt-0 pb-0 pt-md-3 pb-md-3">
                                        <select name="type" id="type" class="custom-select custom-select-filter">
                                            <option></option>
                                            <? foreach(ADMIN_ACTION_TYPES AS $i => $s) : ?>
                                                <option value="<?= $i ?>" <?= ($i == $_GET['type'] && strlen($_GET['type'])) ? ' selected="selected"' : '' ?>><?= $s ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="table" class="col-form-label col-sm-2 mt-0 mt-md-1">Modul:</label>
                                    <div class="col-sm-10 pt-0 pt-md-3">
                                        <select id="table" name="table" class="custom-select">
                                            <option value=""></option>
                                            <? foreach($tables AS $i => $s) : ?>
                                                <option value="<?= $s['table_'] ?>" <?= ($s['table_'] == $_GET['table']) ? ' selected="selected"' : '' ?>><?= $tablesName[$s['table_']] ?: $s['table_'] ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="status" class="col-form-label col-sm-2 mt-0 mt-md-1">Succes:</label>
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
                            <div class="col-sm-4 mt-3 mt-md-2">
                                <div class="form-group">
                                    <label for="data_start" class="bmd-label-floating">Data inceput:</label>
                                    <input type="text" id="data_start" name="data_start" value="<?= $_GET['data_start'] ?>" class="form-control" autocomplete="off" readonly="true" />
                                </div>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="form-group">
                                    <label for="data_end" class="bmd-label-floating">Data sfarsit:</label>
                                    <input type="text" id="data_end" name="data_end" value="<?= $_GET['data_end'] ?>" class="form-control" autocomplete="off" readonly="true" />
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
                    <div class="d-md-none clear"></div>
                    <?= listPages() ?>
                    <div class="clear"></div>
                    <table class="table" id="datatable" cellspacing="0" style="width:100%">
                        <thead>
                        <tr>
                            <th data-priority="1">Admin</th>
                            <th data-priority="2">Modul</th>
                            <th class="w-25">Entitate</th>
                            <th>Actiune</th>
                            <th class="text-center">Success</th>
                            <th>Data</th>
                            <th>IP</th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        <? foreach($list AS $row) : $metadata = $row['metadata']; ?>
                            <tr id="sort_<?= $row['id'] ?>">
                                <td>
                                    <? if ($row['admin_email']) : ?>
                                        <?= $row['admin_name'] ?><br />
                                        <?= $row['admin_email'] ?>
                                    <? else : ?>
                                        <b>Utilizator sters:</b> <?= $row['user'] ?>
                                    <? endif; ?>
                                </td>
                                <td><?= $tablesName[$row['table_']] ?: $row['table_'] ?></td>
                                <td>
                                    <?
                                        $title = '-';
                                        $info = array_merge(
                                            is_array($metadata['row_old']) ? $metadata['row_old'] : array(),
                                            is_array($metadata['row']) ? $metadata['row'] : array()
                                        );

                                        foreach ($info AS $key => $val) {
                                            if (in_array($key, $titles) && strlen($val)) {
                                                $title = shortText($val, 200, true);
                                                break;
                                            }
                                        }

                                        if ($info['id']) {
                                            if ($title == '-') {
                                                $title = '';
                                            } else {
                                                $title = '<br />' . $title;
                                            }

                                            $title = "ID: {$info['id']}" . $title;
                                        }
                                    ?>
                                    <?= $title ?>
                                    <? if ($row['type'] == ADMIN_ACTION_DELETE) : ?>
                                        <br />
                                        [ Randuri sterse: <?= $metadata['rows'] ?> ]<br />
                                        [ Where: <?= $metadata['where'] ?> ]
                                    <? endif; ?>
                                    <? if ($row['type'] == ADMIN_ACTION_UPDATE) : ?>
                                        <br />
                                        <a href="#" data-id="<?= $row['id'] ?>" class="text-success show-diff">Detalii &raquo;</a>
                                    <? endif; ?>
                                    <?//= print_v($metadata) ?>
                                </td>
                                <td class="nowrap">
                                    <?
                                        $class = $text = '';
                                        switch ($row['type']) {
                                            case ADMIN_ACTION_DELETE:
                                                $class = 'text-danger';
                                                break;

                                            case ADMIN_ACTION_CREATE:
                                                $class = 'text-success';
                                                break;

                                            case ADMIN_ACTION_UPDATE:
                                                $class = 'text-warning';
                                                break;

                                            case ADMIN_ACTION_ORDER:
                                                $class = 'text-primary';
                                                break;

                                            case ADMIN_ACTION_STATUS:
                                                $class = ($metadata['row'][$metadata['field']] ? 'text-danger' : 'text-success');
                                                $text = 'Camp: ' . $metadata['field'];
                                                break;
                                        }
                                    ?>
                                    <span class="<?= $class ?>">
                                        <?= ADMIN_ACTION_TYPES[$row['type']] ?><br />
                                        <? if ($text) : ?>
                                            [ <?= $text ?> ]
                                        <? endif; ?>
                                    </span>
                                </td>
                                <td class="text-center"><?= listStatus($row, 'success', $status, true) ?></td>
                                <td><?= date('d.m.Y H:i', $row['date']) ?></td>
                                <td><?= $row['ip'] ?></td>
                            </tr>
                            <? if ($row['type'] == ADMIN_ACTION_UPDATE && is_array($metadata['row_old']) && is_array($metadata['row'])) : ?>
                                <script>
                                    diff[<?= $row['id'] ?>] = {};
                                </script>
                                <tr class="hidden" id="<?= $row['id'] ?>" >
                                    <td colspan="2"></td>
                                    <td colspan="10">
                                        <table class="table" style="max-width: 100%;">
                                            <tr>
                                                <th>Camp</th>
                                                <th>Diferenta</th>
                                            </tr>
                                            <? foreach ($metadata['row_old'] AS $key => $val) : ?>
                                                <? if (isset($metadata['row'][$key]) && ($val != $metadata['row'][$key] || array_keys($metadata['row']) == array('image'))) : ?>
                                                    <script>
                                                        diff[<?= $row['id'] ?>]['<?= $key ?>'] = {
                                                            old: `<?= strip_tags(!is_array($val) ? $val : serialize($val), '<b><strong><i><p><br><br /><br/>') ?>`,
                                                            new: `<?= strip_tags(!is_array($metadata['row'][$key]) ? $metadata['row'][$key] : serialize($metadata['row'][$key]), '<b><strong><i><p><br><br /><br/>') ?>`
                                                        };
                                                    </script>
                                                    <tr>
                                                        <td><?= $key ?></td>
                                                        <td id="diff_<?= $row['id'] . '_' . $key ?>" class="break-word"></td>
                                                    </tr>
                                                <? endif; ?>
                                            <? endforeach; ?>
                                        </table>
                                    </td>
                                    <td class="d-md-none"></td>
                                    <td class="d-md-none"></td>
                                    <td class="d-md-none"></td>
                                    <td class="d-md-none"></td>
                                    <td class="d-md-none"></td>
                                </tr>
                            <? endif; ?>
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
<?= parseView('@init.tables.mobile') ?>

<? captureJavaScriptStart() ?>
<style type="text/css">
    ins {
        text-decoration: none;
        background-color: #d4fcbc;
    }

    del {
        text-decoration: line-through;
        background-color: #fbb6c2;
        color: #555;
    }

    .break-word {
        word-wrap: break-word;
        word-break: break-word;
    }

    .nowrap {
        white-space: nowrap;
    }
</style>
<script src="/public/site/js/vendor/htmldiff/htmldiff.min.js"></script>
<script>
    $(document).ready(function() {
        $('a.show-diff').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            if ($(this).hasClass('text-success')) {

                for (key in diff[id]) {
                    $('#diff_' + id + '_' + key).html(htmldiff(diff[id][key]['old'], diff[id][key]['new']));
                }

                $(this).removeClass('text-success').addClass('text-danger').html('Inchide x');
            } else {
                $(this).removeClass('text-danger').addClass('text-success').html('Detalii &raquo;');
            }

            $('#' + id).toggle();

            return false;
        });
    });
</script>
<? captureJavaScriptEnd() ?>
