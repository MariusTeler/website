<? global $dbTables ?>
<? $languages = []; ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Administrare > Tabele DB</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="clear"></div>
                <a id="check-all" class="text-success" href="javascript: void(0);">toate</a>&nbsp;|
                <a id="uncheck-all" class="text-danger" href="javascript: void(0);">nici unul</a>
                <form method="POST" action="" id="editForm" enctype="multipart/form-data" class="form-horizontal my-4">
                    <input type="hidden" name="formRedirect" value="1" />
                    <p><i class="material-icons">info</i><span class="align-top"> &nbsp;Se vor selecta campurile ce contin cod HTM si nu vor fi procesate cu htmlspecialchars</span></p>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group my-2">
                                <? foreach($tables AS $key => $row) : $exclude = $dbTables[$key]['exclude'] ? $dbTables[$key]['exclude'] : array(); ?>
                                    <div class="border-bottom">
                                        <div class="form-check">
                                            <label class="form-check-label font-weight-bold">
                                                <input type="checkbox"
                                                       class="form-check-input"
                                                       id="ck_<?= $key ?>"
                                                       name="tables[]"
                                                       value="<?= $key ?>"
                                                    <?= (($dbTables[$key]) ? 'checked' : '')?> />
                                                <?= $key ?>
                                                <span class="form-check-sign">
                                                  <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="border-bottom">
                                        <? foreach($row['fields'] AS $i => $field) : ?>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox"
                                                           class="form-check-input"
                                                           id="ck_<?= $key . '_' . $i ?>"
                                                           name="tables_exclude[<?= $key ?>][]"
                                                           value="<?= $field ?>"
                                                        <?= ((in_array($field, $exclude)) ? 'checked' : '')?> />
                                                    <?= $field ?>
                                                    <span class="form-check-sign">
                                                      <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        <? endforeach; ?>
                                        <? if($languages) : $langs = $dbTables[$key]['lang'] ? $dbTables[$key]['lang'] : array(); ?>
                                            <div class="bg-light p-2">
                                                <p class="my-0"><i class="material-icons">info</i><span class="align-top"> &nbsp;Se vor selecta campurile folosite pentru traduceri.</span></p>
                                                <? foreach($row['fields_lang'] AS $i => $field) : ?>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox"
                                                                   class="form-check-input"
                                                                   id="ck_lang_<?= $key . '_' . $i ?>"
                                                                   name="tables_lang[<?= $key ?>][]"
                                                                   value="<?= $field ?>"
                                                                <?= ((in_array($field, $langs)) ? 'checked' : '')?> />
                                                            <?= $field ?>
                                                            <span class="form-check-sign">
                                                              <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                <? endforeach; ?>
                                            </div>
                                        <? endif; ?>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-fill btn-success" value="Genereaza db.tables.php" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#check-all').on('click', function() {
           $('input[name="tables[]"]').prop('checked', true);
        });

        $('#uncheck-all').on('click', function() {
            $('input[name="tables[]"]').prop('checked', false);
        });
    });
</script>