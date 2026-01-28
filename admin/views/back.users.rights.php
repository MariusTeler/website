<div class="row">
    <label class="col-sm-2 col-form-label" for="pages">Acces pagini:</label>
    <div class="col-sm-10" style="overflow: scroll;">
        <div class="form-group my-3" style="min-width: 600px;">
            <? foreach($adminMenu AS $i => $row) : ?>
                <div class="row border-bottom ml-0 mt-3 mb-2">
                    <div class="d-inline-block col-2 pl-0 font-weight-bold"><?= $row['cat'] ?></div>
                    <? foreach (ADMIN_RIGHTS as $rightId => $rightText) : ?>
                        <div class="form-check form-check-inline col-2 mt-0 mr-0">
                            <label class="form-check-label">
                                <input type="checkbox"
                                       class="form-check-input ck"
                                       data-i="<?= $i ?>"
                                       data-right-id="<?= $rightId ?>"
                                />
                                <?= $rightText ?>
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    <? endforeach; ?>
                    <div class="form-check form-check-inline col-2 mr-0">
                        <label class="form-check-label">
                            <input type="checkbox"
                                   class="form-check-input ck ck-all"
                                   data-i="<?= $i ?>"
                            />
                            Toate
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                        </label>
                    </div>
                </div>
                <? foreach($row['pages'] AS $dbLink => $dbPage) : ?>
                    <div class="row ml-0">
                        <div class="form-check form-check-inline col-2 my-2 mr-0">
                            <label class="form-check-label_">
                                <?= $dbPage ?>
                            </label>
                        </div>
                        <? if ($pagesByRights[$dbLink]) : ?>
                            <? foreach (ADMIN_RIGHTS as $rightId => $rightText) : ?>
                                <div class="form-check form-check-inline col-2 mr-0">
                                    <label class="form-check-label">
                                        <input type="checkbox"
                                               class="form-check-input ck_<?= $i ?> ck_<?= $i ?>_<?= $rightId ?> ck_<?= $i ?>_<?= md5($dbLink) ?> ck-right"
                                               name="rights[<?= $dbLink ?>][]"
                                               value="<?= $rightId ?>"
                                            <?= (($_POST['rights'][$dbLink] && in_array($rightId, $_POST['rights'][$dbLink])) ? 'checked' : '') ?> />
                                        &nbsp;
                                        <span class="form-check-sign">
                                          <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            <? endforeach; ?>
                        <? else : ?>
                            <div class="form-check form-check-inline col-8 mr-0"></div>
                        <? endif; ?>
                        <div class="form-check form-check-inline col-2 mr-0">
                            <label class="form-check-label">
                                <input type="checkbox"
                                       class="form-check-input ck_<?= $i ?> ck ck-all-page"
                                       data-i="<?= $i ?>"
                                       data-page="<?= md5($dbLink) ?>"
                                    <? if (!$pagesByRights[$dbLink]) : ?>
                                        name="rights[<?= $dbLink ?>][]"
                                        value="all"
                                    <? endif; ?>
                                    <?= ($_POST['rights'][$dbLink] && (count($_POST['rights'][$dbLink]) == 4) ? 'checked' : '')?> />
                                &nbsp;
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                <? endforeach ?>
            <? endforeach ?>
        </div>
    </div>
</div>
<? captureJavaScriptStart(); ?>
<script>
    $('body').on('click', '.ck', function() {
        if ($(this).hasClass('ck-all')) {
            $('.ck_' + $(this).data('i')).prop('checked', $(this).prop('checked'));
        } else {
            if ($(this).hasClass('ck-all-page')) {
                $('.ck_' + $(this).data('i') + '_' + $(this).data('page'))
                .prop('checked', $(this).prop('checked'));
            } else {
                $('.ck_' + $(this).data('i') + '_' + $(this).data('right-id'))
                .prop('checked', $(this).prop('checked')).trigger('change');
            }
        }
    });

    $('body').on('change', '.ck-right', function() {
        if ($(this).prop('checked') === false) {
            $(this).closest('.row').find('.ck-all-page').prop('checked', false);
        }
    });
</script>
<? captureJavaScriptEnd(); ?>
