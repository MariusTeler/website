<script>
    $(function() {
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };

        <? if(!$ignoreMain) : ?>
            $( "#sortable" ).sortable({
                handle: '> td > .b_drag',
                opacity: 0.7,
                forceHelperSize: true,
                forcePlaceholderSize: true,
                helper: fixHelper,
                placeholder: 'sortable-placeholder',
                update: function(event, ui) {
                    var sort = $(this).sortable('serialize');
                    $(this).sortable('option', 'disabled', true);
                    $('#sortable').find('.b_drag i').fadeTo(0, 0.4);
                    ajaxRequest('<?= $curPage ?>&' + sort);
                }
            });//.disableSelection();
        <? endif; ?>

        <? if(is_array($initSortable)) : ?>
            <? foreach($initSortable AS $row) : ?>
                $("#sortable-<?= $row['table'] ?>").sortable({
                    handle: '.b_drag.drag-<?= $row['table'] ?>',
                    opacity: 0.7,
                    forceHelperSize: true,
                    forcePlaceholderSize: true,
                    helper: fixHelper,
                    update: function(event, ui) {
                        var sort = $(this).sortable('serialize', {attribute: 'data-id'});

                        $(this).sortable('option', 'disabled', true);
                        $('#sortable-<?= $row['table'] ?>').find('.b_drag i').fadeTo(0, 0.4);
                        ajaxRequest('<?= $row['page'] ?: $curPage ?>&list_id=' + $(this).attr('id') + '&' + sort);
                    }
                });
            <? endforeach; ?>
        <? endif; ?>

        $('.b_drag').on('click', function(e) {
             e.preventDefault();
        });
    });

    function sortableRestore(id)
    {
        if(!id) {
            id = '#sortable';
        } else {
            id = '#' + id;
        }

        $(id).sortable('option', 'disabled', false);
        $(id).find('.b_drag i').fadeTo(0, 1);
        $('#sortable').find('.b_drag i').fadeTo(0, 1);
    }
</script>