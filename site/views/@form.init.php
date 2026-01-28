<? if($cfg__['forms']) : ?>
<script src="<?= $websiteURL ?>public/site/js/vendor/jquery_validation/jquery.validate.min.js"></script>
<script src="<?= $websiteURL ?>public/site/js/vendor/jquery_validation/localization/messages_<?= getLang() ?: 'ro' ?>.js"></script>
<script>
    $(document).ready(function(){
        <? foreach($cfg__['forms'] AS $formId => $form) : ?>
        $('#<?= $formId ?>').validate({
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
    });
</script>
<? endif; ?>