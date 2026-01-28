<?php

// Default field settings for upload
$uploadify = $initUploadify[0];

// Specific field settings for upload
if ($fieldId) {
    $iUploadify = array_column($initUploadify, null, 'fieldId');
    $uploadify = $iUploadify[$fieldId];
}

// Current image
$postImage = $_POST[$uploadify['fieldId']];

// Current upload dir & thumbs
$imgUpload = $uploadify['imagesUpload'] ?: $imagesUpload;

// Current crop
$isJcrop = false;

if (is_array($initJcrop) && count($initJcrop)) {
    $jcropDirs = array_column($initJcrop, 'parent_dir');
    $isJcrop = in_array($imgUpload['dir'], $jcropDirs);
}

?>
<div class="row" id="upload-action">
    <label class="col-sm-2 col-form-label" for="<?= $uploadify['fieldId'] ?>"><?= $uploadify['formLabel'] ? $uploadify['formLabel'] : 'Imagine' ?>:</label>
    <div class="col-sm-10">
        <div class="form-group">
            <input type="file" id="<?= $uploadify['fieldId'] ?>" name="<?= $uploadify['fieldId'] ?>" />
            <input type="hidden" id="<?= $uploadify['fieldId'] ?>Key" name="<?= $uploadify['fieldId'] ?>Key" />
        </div>
    </div>
</div>
<? if($imgUpload['thumbs']) : ?>
    <div class="row" id="upload-action-info">
        <label class="col-sm-2 col-form-label">Dimensiuni resize:</label>
        <div class="col-sm-10">
            <div class="form-group pt-1">
                <?
                    $iResize = array();
                    foreach($imgUpload['thumbs'] AS $row) {
                        $iResize[] = $row[0] . ' x ' . $row[1];
                    }
                ?>
                <?= implode(' | ', $iResize); ?>
            </div>
        </div>
    </div>
<? endif; ?>
<? if(strlen($postImage) && !$isJcrop) : $image = explode('.', $postImage); ?>
    <div class="row">
        <div class="col-sm-10 offset-sm-2">
            <div class="form-group">
                <input type="submit" class="btn btn-fill btn-success" value="Salveaza" />
            </div>
        </div>
    </div>
    <div class="row">
        <? if (in_array(end($image), ['jpg','jpeg','gif','png','webp','svg'])) : ?>
            <label class="col-sm-2 col-form-label" for="">Imagine curenta:</label>
            <div class="col-sm-10">
                <div class="form-group">
                    <img style="max-width: 100%;" id="thumbs" src="<?= UPLOAD_URL . $imgUpload['dir'] . '/' . ($imgUpload['thumbs'] ? key($imgUpload['thumbs']) : 'original') . '/' . $postImage . '?' . time() ?>" />
                </div>
            </div>
        <? else : ?>
            <label class="col-sm-2 col-form-label" for="">Fisier curent:</label>
            <div class="col-sm-10">
                <div class="form-group">
                    <a href="<?= UPLOAD_URL . $imgUpload['dir'] . '/original/' . $postImage . '?' . time() ?>" class="btn-list-new-tab" target="_blank"><?= $postImage ?> <i class="material-icons">open_in_new</i></a>
                </div>
            </div>
        <? endif; ?>
    </div>
<? endif ?>
<? if($isJcrop) : ?>
    <!--<div class="row">
        <div class="col-sm-10 offset-sm-2">
            <div class="form-group">
                <input type="submit" class="btn btn-fill btn-success" value="Salveaza" />
            </div>
        </div>
    </div>-->
    <div class="row">
        <label class="col-sm-2 col-form-label font-weight-bold" id="crop_dialog_<?= $imgUpload['dir'] ?>">Redimensionare imagini</label>
    </div>
    <? foreach($initJcrop AS $j) : ?>
        <? if ($j['parent_dir'] == $imgUpload['dir']) : ?>
            <div class="row">
                <label class="col-sm-2 col-form-label">Imagine (<?= $j['w'] . ' x ' . $j['h'] ?>):</label>
                <div class="col-sm-10" style="overflow: scroll;">
                    <div class="form-group">
                        <img id="<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_jcrop" src="<?= UPLOAD_URL . $imgUpload['dir'] . '/' . $j['dir'] . '/' . $j['image'] . '?' . time() ?>" alt=""/>
                        <input type="hidden" id="<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_x" name="<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_x" value="" />
                        <input type="hidden" id="<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_y" name="<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_y" value="" />
                        <input type="hidden" id="<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_w" name="<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_w" value="" />
                        <input type="hidden" id="<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_h" name="<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_h" value="" />
                    </div>
                </div>
            </div>
        <? endif; ?>
    <? endforeach ?>
    <? if($imgUpload['cropIsOptional'] && !$_GET['upload']) : ?>
        <div class="row">
            <label class="col-sm-2 col-form-label" for="crop_<?= $imgUpload['dir'] ?>">Crop imagine:</label>
            <div class="col-sm-10 checkbox-radios">
                <div class="form-group form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="crop_<?= $imgUpload['dir'] ?>" name="crop_<?= $imgUpload['dir'] ?>" value="1" />&nbsp;
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
    <? else : ?>
        <input type="hidden" name="crop_<?= $imgUpload['dir'] ?>" value="1">
    <? endif; ?>
    <? captureJavaScriptStart() ?>
    <script>
        $(document).ready(function() {
            $('a.crop-dialog-scroll').on('click', function(e) {
                let $parentTab = $('label[id="' + $(this).attr('href').substring(1) + '"]').parents('.tab-pane');

                if ($parentTab.length) {
                    let tabId = $parentTab.eq(0).attr('id');

                    e.preventDefault();
                    $('.nav-pills a.nav-link[href="#' + tabId + '"]').tab('show');
                    scrollToTarget($(this).attr('href'));
                }
            });
        });
    </script>
    <? captureJavaScriptEnd() ?>
<? endif ?>