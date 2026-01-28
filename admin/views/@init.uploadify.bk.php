<? if(count($initUploadify)) { ?>
<link rel="stylesheet" href="<?= $websiteURL ?>../public/site/js/vendor/jquery_uploadify/uploadify.css" type="text/css"/>
<script src="<?= $websiteURL ?>../public/site/js/vendor/jquery_uploadify/jquery.uploadify.min.js?<?= time() ?>"></script>
    <?= sessionGet('key_site') ?>
<script>
    $(function() {
        <? foreach($initUploadify AS $u) : $timestamp = time(); ?>
        setTimeout(function() {
        $('#<?= $u['fieldId'] ?>').uploadify({
            swf : '<?= $websiteURL ?>../public/site/js/vendor/jquery_uploadify/uploadify.swf',
            uploader : 'index.php?page=@init.upload',
            buttonImage : '<?= $websiteURL ?>../public/admin/images/browse-btn.png',
            fileTypeDesc : 'Image Files',
            fileTypeExts : '*.<?= implode('; *.', $extUploadify) ?>',
            fileSizeLimit : '5MB',
            multi: false,
            debug: true,
            removeCompleted : false,
            'formData' : {
                'timestamp' : '<?= $timestamp ?>',
                'token' : '<?= md5(sessionGet('key_site') . $timestamp) ?>'
            },
            onSelect: function(file) {
                disableUploadify('<?= $u['fieldId'] ?>', '<?= $u['formId'] ?>');
            },
            onUploadSuccess : function(file, data, response) {
                alert(data);
                if(response)
                {
                    enableUploadify('<?= $u['fieldId'] ?>', '<?= $u['formId'] ?>');
                    $('#<?= $u['fieldId'] ?>Key').val(data);
                }
            },
            onFallback: function() {
                lert('Flash was not detected.');
            },
            onUploadError : function(file, errorCode, errorMsg, errorString) {
                enableUploadify('<?= $u['fieldId'] ?>', '<?= $u['formId'] ?>');
                alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
            },
            onSelectError : function(file, errorCode, errorMsg) {
                alert('The file ' + file.name + ' could not be uploaded: ' + errorMsg);
            }
        });
        }, 0);
        <? endforeach ?>

        function enableUploadify(fieldId, formId) {
            $('#' + fieldId).uploadify('disable', false);
            $('#' + fieldId).css('opacity', '1');
            $('#' + formId).attr('onsubmit', '');
        }

        function disableUploadify(fieldId, formId) {
            $('#' + fieldId).uploadify('disable', true);
            $('#' + fieldId).css('opacity', '0.3');
            $('#' + formId).attr('onsubmit', 'return false');
        }
    });
</script>
<? } ?>