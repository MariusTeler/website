<? if ($initSelect2) : ?>
    <link href="/public/site/js/vendor/jquery_select2/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <script src="/public/site/js/vendor/jquery_select2/dist/js/select2.full.min.js"></script>
    <script src="/public/site/js/vendor/jquery_select2/dist/js/select2-searchInputPlaceholder.min.js"></script>
    <script src="/public/site/js/vendor/jquery_select2/dist/js/i18n/ro.js"></script>

    <?
    $optionsDefault = array(
        'placeholder' => 'Selectati ...',
        'searchInputPlaceholder' => 'Cauta ...',
        'allowClear' => true,
        'language' => 'ro',
        'dropdownCssClass' => 'select2-dropdown-smooth-scroll'
    );
    ?>

    <script>
        $(document).ready(function(){
            <? foreach($initSelect2 AS $row) : ?>
            $('#<?= $row['id'] ?>').select2({
                <? foreach(array_merge($optionsDefault, $row['options'] ?: []) AS $o => $v) : ?>
                <?= $o ?>: <?= is_bool($v) || is_int($v) ? $v : (is_array($v) && $v['type'] == 'callback' ? $v['content'] : "'{$v}'") ?>,
                <? endforeach; ?>
                //escapeMarkup: function (text) { return text; }
            }).on('select2:unselecting', function() {
                $(this).data('unselecting', true);
            }).on('select2:opening', function(e) {
                if ($(this).data('unselecting')) {
                    $(this).removeData('unselecting');
                    e.preventDefault();
                }
            });
            <? endforeach; ?>
        });
    </script>
<? endif; ?>