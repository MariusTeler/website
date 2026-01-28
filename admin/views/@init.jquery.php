<link rel="stylesheet" href="/public/site/js/vendor/jquery_ui/css/jquery-ui.min.css" type="text/css"/>
<link rel="stylesheet" href="/public/site/js/vendor/jquery_ui/css/jquery-ui.material.min.css?v=1.0.1" type="text/css"/>
<script src="/public/site/js/vendor/jquery_ui/js/jquery-ui.min.js"></script>
<script src="/public/site/js/vendor/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js"></script>

<? if($initDatepicker) : ?>
<script>
    $(document).ready(function() {
        $.datepicker.setDefaults({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd.mm.yy',
            dayNamesMin: ['Du','Lu','Ma','Mi','Jo','Vi','Sa'],
            firstDay: 1,
            monthNames: ['Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie','Iulie','August','Septembrie','Octombrie','Noiembrie','Decembrie'],
            monthNamesShort: ['Ian','Feb','Mar','Apr','Mai','Iun','Iul','Aug','Sep','Oct','Noi','Dec'],
            currentText: 'Azi',
            closeText: 'Reset',
            showButtonPanel: true,
            beforeShow: function( input ) {
                setTimeout(function() {
                    var $buttonClose = $( input )
                        .datepicker( "widget" )
                        .find( ".ui-datepicker-close" );

                    $buttonClose.unbind('click').bind('click', function() {
                        $.datepicker._clearDate( input );
                    });
                }, 1 );
            },
            onChangeMonthYear: function( year, month, instance ) {
                setTimeout(function() {
                    var $buttonClose = $( instance )
                        .datepicker( "widget" )
                        .find( ".ui-datepicker-close" );

                    $buttonClose.unbind('click').bind('click', function() {
                        $.datepicker._clearDate( instance.input );
                    });
                }, 1 );
            }
        });
        <? foreach($initDatepicker AS $d) : ?>
        $('#<?= $d ?>').datepicker();
        <? endforeach ?>
    });
</script>
<? endif; ?>

<? if ($initSelect2) : ?>
    <link href="/public/site/js/vendor/jquery_select2/dist/css/select2.min.css" rel="stylesheet" />
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
