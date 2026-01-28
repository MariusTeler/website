<? if($cfg__['forms']) : ?>
<script src="<?= $websiteURL ?>../public/site/js/vendor/jquery_validation/jquery.validate.min.js"></script>
<script src="<?= $websiteURL ?>../public/site/js/vendor/jquery_validation/localization/messages_ro.js"></script>
<script>
    $(document).ready(function(){
        <? foreach($cfg__['forms'] AS $formId => $form) : $changeIds = array(); ?>
        validator_<?= $formId ?> = $('#<?= $formId ?>').validate({
            <? foreach($form['options'] AS $key => $val) : ?>
            <?= $key . ': ' . formInitOption($val) ?>,
            <? endforeach; ?>
            rules: {
                <? foreach($form['rules'] AS $key => $val) : ?>
                "<?= $key ?>": {
                    <? foreach($val AS $key2 => $val2) : ?>
                    <? if(!is_array($val2)) : ?>
                    <?= $key2 . ': ' . formInitOption($val2) ?>,
                    <? else : ?>
                    <?= $key2 ?>: {
                        <? foreach($val2 AS $key3 => $val3) : ?>
                        <? if(!is_array($val3)) : ?>
                        <?= $key3 . ': ' . formInitOption($val3) ?>,
                        <? else : ?>
                        <?
                            if($key2 == 'remote' && $key3 == 'data' && $val3['unique_change_id'])
                                $changeIds[] = array(
                                    'change_id' => $val3['unique_change_id'],
                                    'field_id' => $val3['unique_field_id']
                                );
                        ?>
                        <?= $key3 ?>: {
                            <? foreach($val3 AS $key4 => $val4) : ?>
                            <?= $key4 . ': ' . formInitOption($val4) ?>,
                            <? endforeach;?>
                        },
                        <? endif; ?>
                        <? endforeach;?>
                    },
                    <? endif; ?>
                    <? endforeach ?>
                },
                <? endforeach; ?>
            },
            messages: {
                <? foreach($form['messages'] AS $key => $val) : ?>
                "<?= $key ?>": {
                    <? foreach($val AS $key2 => $val2) : ?>
                    <?= $key2 . ': ' . formInitOption($val2) ?>,
                    <? endforeach ?>
                },
                <? endforeach; ?>
            }
        });
        <? endforeach; ?>
        <? foreach($changeIds AS $change) : ?>
        var evType = 'change';
        if($('#<?= $change['change_id'] ?>').attr('type') == 'text')
            evType = 'keyup';

        $('#<?= $change['change_id'] ?>').on(evType, function() {
            if($('#<?= $change['field_id'] ?>').val()) {
                validator_editForm.resetForm();
                validator_editForm.form();
            }
        });
        <? endforeach; ?>

        <? if (
            getPage() != 'login'
            && (
                (!$_GET['edit'] && !userGetRight(ADMIN_RIGHT_ADD, $_SERVER['REQUEST_URI']))
                || ($_GET['edit'] && !userGetRight(ADMIN_RIGHT_EDIT, $_SERVER['REQUEST_URI']))
            )
        ) : ?>
            <? foreach ($cfg__['forms'] as $formId => $form) : ?>
                $('#<?= $formId ?>').find('input,select,textarea').prop('disabled', true);
            <? endforeach; ?>
        <? endif; ?>
    });
</script>
    <? if (
        getPage() != 'login'
        && (
            (!$_GET['edit'] && !userGetRight(ADMIN_RIGHT_ADD, $_SERVER['REQUEST_URI']))
            || ($_GET['edit'] && !userGetRight(ADMIN_RIGHT_EDIT, $_SERVER['REQUEST_URI']))
        )
    ) : ?>
    <style type="text/css">
        <? foreach ($cfg__['forms'] as $formId => $form) : ?>
            #<?= $formId ?> input[type="submit"],
            #<?= $formId ?> #upload-action .form-group {
                display: none !important;
            }
        <? endforeach; ?>
    </style>
    <? endif; ?>
<? endif; ?>