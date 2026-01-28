<? captureJavaScriptStart(); ?>
<script>
    // Flag to avoid infinite loop
    var processTableLength = false;

    $(document).ready(function() {
        $('table').on('length.dt', function(e, settings, len) {
            // If we are not already processing page length updates
            if (!processTableLength) {
                // Flag to avoid infinite loop
                processTableLength = true;

                // Save vertical scroll
                let $tableWrapper = $('#' + $(this).attr('id') + '_wrapper'),
                    offsetTop = $tableWrapper.offset().top;


                // Save page length settings for this user & page
                const urlParams = new URLSearchParams(window.location.search);
                ajaxRequest('index.php?page=site.left&dt_length=' + len + '&dt_page=' + urlParams.get('page'));

                // Update page length for all tables on this page
                updateDatatableLength(len);

                // Flag to avoid infinite loop
                processTableLength = false;

                // Scroll back to original table
                // (when page has scrolled vertically because of tables above this one)
                if ($tableWrapper.offset().top !== offsetTop) {
                    $('html,body').animate({
                        scrollTop: $tableWrapper.offset().top
                    }, 0);
                }
            }
        });

        // Update page length for all tables on this page if there's a saved one
        <? $metadata = userGetInfo('metadata') ?: []; ?>
        let dt_length = <?= ($metadata['datatable'] && $metadata['datatable'][getPage()]) ? $metadata['datatable'][getPage()] : 0 ?>;
        if (dt_length) {
            processTableLength = true;
            updateDatatableLength(dt_length);
            processTableLength = false;
        }
    });

    function updateDatatableLength(pageLength) {
        $('table').each(function(index, element) {
            let elementId = $(element).attr('id');
            if (
                elementId
                && $.fn.dataTable.isDataTable('#' + elementId)
            ) {
                $('#' + elementId).DataTable().page.len(pageLength).draw()
            }
        });
    }
</script>
<? captureJavaScriptEnd(); ?>
