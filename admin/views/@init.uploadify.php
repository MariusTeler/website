<? if(is_array($initUploadify) && count($initUploadify)) { ?>
<link rel="stylesheet" href="/public/site/js/vendor/jquery_uploadify/uploadifive.css" type="text/css"/>
<script src="/public/site/js/vendor/jquery_uploadify/jquery.uploadifive.min.js?<?= time() ?>"></script>
<script>
    $(function() {
        <? foreach($initUploadify AS $u) : $timestamp = time(); ?>
        $('#<?= $u['fieldId'] ?>').uploadifive({
            uploadScript : 'index.php?page=@init.upload',
            buttonText: '<i class="material-icons">cloud_upload</i> &nbsp;&nbsp;&nbsp;Selecteaza',
            buttonClass: 'btn btn-primary pointer',
            //width: 120,
            //height: 30,
            width: 'auto',
            height: 'auto',
            fileType : '<?= implode('|', $extUploadify['mimeTypes']) ?>',
            fileSizeLimit : '35MB',
            multi: <?= $u['multi'] ? 'true' : 'false' ?>,
            removeCompleted : false,
            'formData' : {
                'timestamp' : '<?= $timestamp ?>',
                'token' : '<?= md5(sessionGet('key_site') . $timestamp) ?>',
                'multi': <?= $u['multi'] ? 'true' : 'false' ?>
            },
            onSelect: function(queue) {
                disableUploadify('<?= $u['fieldId'] ?>', '<?= $u['formId'] ?>');
            },
            onUploadComplete : function(file, data) {
                if(data)
                {
                    $('#<?= $u['fieldId'] ?>Key').val(data);
                    enableUploadify('<?= $u['fieldId'] ?>', '<?= $u['formId'] ?>');
                }
            },
            onFallback: function() {
                alert('You do not have HTML5. Please try with another browser.');
            },
            onError : function(errorType) {
                enableUploadify('<?= $u['fieldId'] ?>', '<?= $u['formId'] ?>');
                alert('The error was: ' + errorType);
            },
            onSelectError : function(file, errorCode, errorMsg) {
                alert('The file ' + file.name + ' could not be uploaded: ' + errorMsg);
            }
        });
        <? endforeach ?>

        function enableUploadify(fieldId, formId) {
            $('#' + fieldId).css('opacity', '1');
            $('#' + formId).attr('onsubmit', '');
        }

        function disableUploadify(fieldId, formId) {
            $('#' + fieldId).css('opacity', '0.3');
            $('#' + formId).attr('onsubmit', 'return false');
        }
    });
</script>
<? } ?>