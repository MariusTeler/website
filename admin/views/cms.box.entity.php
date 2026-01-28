<? foreach ($entityRelation as $entityType => $relation) : ?>
    <div class="row">
        <label class="col-sm-2 col-form-label" for="relation_<?= $entityType ?>"><?= ENTITY_TYPES[$entityType] ?>:</label>
        <div class="col-sm-10">
            <div class="form-group my-3">
                <? foreach ($relation['entities'] AS $i => $row) : ?>
                    <div class="mb-3">
                        <div class="form-check">
                            <label class="form-check-label font-weight-bold">
                                <input type="checkbox"
                                       class="form-check-input"
                                       name="relation[<?= $entityType ?>][]" value="<?= $row['id'] ?>"
                                       disabled
                                    <?= ((in_array($row['id'], $entityRelation[$entityType]['relation'])) ? 'checked' : '')?> />
                                <?= $row['link_name'] ?>
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        <? if ($row['children']) : ?>
                            <div class="ml-4">
                                <? foreach($row['children'] AS $j => $row2) : ?>
                                    <div class="form-check form-check-inline mb-0">
                                        <label class="form-check-label">
                                            <input type="checkbox"
                                                   class="form-check-input"
                                                   name="relation[<?= $entityType ?>][]" value="<?= $row2['id'] ?>"
                                                   disabled
                                                <?= ((in_array($row2['id'], $entityRelation[$entityType]['relation'])) ? 'checked' : '')?> />
                                            <?= $row2['link_name'] ?>
                                            <span class="form-check-sign">
                                              <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                <? endforeach ?>
                            </div>
                        <? endif ?>
                    </div>
                <? endforeach ?>
            </div>
        </div>
    </div>
<? endforeach; ?>