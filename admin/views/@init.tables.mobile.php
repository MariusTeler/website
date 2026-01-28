<? if (isMobile() || $isDesktop) : ?>
    <? $dataTableId = '#' . ($tableId ?: 'datatable'); ?>
    <? captureJavaScriptStart() ?>
        <? if (!getVar('dataTablesLoaded')) : ?>
            <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />-->
            <!--<link rel="stylesheet" href="/public/admin/css/fixedHeader.bootstrap4.min.css" type="text/css" />-->
            <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
            <script src="/public/admin/js/plugins/jquery.dataTables.min.js"></script>
        <? endif; ?>
        <script>
            <? if (!getVar('dataTablesLoaded')) : ?>
                // Hidrate returned filters
                let urlParams = new URLSearchParams(window.location.search),
                    filters = null;
                <? if ($preserveFilters) : ?>
                    if (urlParams.get('datatable')) {
                        try {
                            filters = JSON.parse(urlParams.get('datatable'));
                        }  catch (e) {

                        }
                    }
                <? endif; ?>

                let filterPage = parseInt(filters ? filters.page : 0),
                    filterPageLength = parseInt(filters ? filters.pageLength : -1),
                    filterSearch = filters ? filters.search : '',
                    filterOrder = [],
                    filterOrderColumn = filters ? parseInt(filters.orderColumn) : '',
                    filterOrderDirection = filters ? filters.orderDirection : '';

                if (filterOrderDirection) {
                    filterOrder = [[ filterOrderColumn, filterOrderDirection ]];
                }
            <? endif; ?>

            $(document).ready(function() {
                $('<?= $dataTableId ?>').DataTable({
                    fixedHeader: true,
                    responsive: <?= $isScroll ? 'false' : 'true' ?>,
                    paging: false,
                    //pagingType: "full_numbers",
                    //pageLength: filterPageLength,
                    //displayStart: filterPage * filterPageLength,
                    /*lengthMenu: [
                        [10, 30, 50, -1],
                        [10, 30, 50, "Toate"]
                    ],*/
                    ordering: <?= $isOrdering ? 'true' : 'false' ?>,
                    searching: <?= $isSearch ? 'true' : 'false' ?>,
                    scrollX: <?= $isScroll ? 'true' : 'false' ?>,
                    order: filterOrder,
                    bInfo: false,
                    dom: '<"float-left" f>lrtip',
                    search: {
                        search: filterSearch
                    },
                    language: {
                        url: '/public/admin/js/plugins/jquery.datatables.ro.json'
                    },
                    initComplete: function(settings, json) {
                        $(this).parent().removeClass('container-fluid');
                    }
                });

                <? if ($preserveFilters && ($isOrdering || $isSearch)) : ?>
                    // Remember page number, page length and search filters
                    // for when returning from add / edit / delete / status change
                    $('<?= $dataTableId ?> a.btn-link, <?= $dataTableId ?> a.btn-status, a.btn-list-add').on('click', function(e) {
                        if (!$(this).hasClass('no-datatable')) {
                            let $table = $('<?= $dataTableId ?>').DataTable(),
                                info = $table.page.info(),
                                order = $table.order().length ? $table.order() : [['', '']],
                                filters = {
                                    page: info.page,
                                    pageLength: info.length,
                                    search: $table.search(),
                                    orderColumn: order[0][0],
                                    orderDirection: order[0][1]
                                };

                            $(this).attr('href', $(this).attr('href') + '&datatable=' + encodeURIComponent(JSON.stringify(filters)));
                        }
                    });
                <? endif; ?>
            });
        </script>
    <? captureJavaScriptEnd() ?>
    <? parseVar('dataTablesLoaded', true) ?>
<? endif; ?>