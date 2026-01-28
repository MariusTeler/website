<!-- Box - Coverage -->
<div class="container my-5 py-4">
    <div class="position-relative fw-light">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h2 class="fw-light ls-wide text-center"><?= $various['title'] ?></h2>
                <div class="mb-4 fw-light"><?= $various['text'] ?></div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-floating mb-2 fs-5">
                            <select class="form-select border-top-0 border-start-0 border-end-0" id="coverage_county" name="coverage_county">
                                <option></option>
                                <?= formSelectOptions($counties, '', '') ?>
                            </select>
                            <label for="coverage_county">Județ</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-2 fs-5">
                            <select class="form-select border-top-0 border-start-0 border-end-0" id="coverage_city" name="coverage_city">
                                <option></option>
                            </select>
                            <label for="coverage_city">Localitate</label>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered border-secondary table-hover" id="table-coverage" style="width: 100%;">
                    <thead>
                    <tr>
                        <th class="table-active" style="--bs-table-bg-state: rgba(var(--bs-emphasis-color-rgb), 0.15)">Județ</th>
                        <th class="table-active" style="--bs-table-bg-state: rgba(var(--bs-emphasis-color-rgb), 0.15)">Localitate</th>
                        <th class="table-active" style="--bs-table-bg-state: rgba(var(--bs-emphasis-color-rgb), 0.15)">KM Suplimentari</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($cities as $city) : ?>
                        <tr>
                            <td><?= $city['county'] ?></td>
                            <td><?= $city['city'] ?></td>
                            <td><?= $city['km'] ?></td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<? captureJavaScriptStart() ?>
<link rel="stylesheet" href="/public/<?= ASSETS_PATH ?>/js/vendor/datatables/datatables.min.css" />
<script src="/public/<?= ASSETS_PATH ?>/js/vendor/datatables/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table-coverage').DataTable({
            fixedHeader: true,
            responsive: false,
            paging: true,
            pagingType: "full_numbers",
            pageLength: 10,
            //displayStart: filterPage * filterPageLength,
            /*lengthMenu: [
                [10, 30, 50, -1],
                [10, 30, 50, "Toate"]
            ],*/
            ordering: false,
            searching: true,
            scrollX: false,
            bInfo: false,
            layout: {
                // topStart: 'search',
                topStart: null,
                // topEnd: 'pageLength',
                topEnd: null,
                bottomStart: 'info',
                bottomEnd: 'paging'
            },
            language: {
                url: '/public/<?= ASSETS_PATH ?>/js/vendor/datatables/ro.json'
            },
            initComplete: function(settings, json) {
                // let $container = $(this).parents('.dt-bootstrap5');
                // $container.find('div.dt-search input').addClass('border-top-0 border-start-0 border-end-0 rounded-0');
                // $container.find('div.dt-length select').addClass('pe-3 border-top-0 border-start-0 border-end-0 rounded-0');
                // $container.find('div.dt-length label').addClass('d-none d-md-inline-block');
                // $container.find('div.dt-layout-start').addClass('col-auto');
                // $container.find('div.dt-layout-end').addClass('col-auto');
                // $container.find('div.dt-paging').css({
                //     '--bs-pagination-border-radius': 0
                // });

                // Apply listener for user change in value
                let countyColumn = this.api().column(0),
                    cityColumn = this.api().column(1);

                $('#coverage_county').on('change', function () {
                    countyColumn.search($(this).find(':selected').text().trim(), {exact: true}).draw();
                    ajaxRequest('index.php?page=cms.various.coverage', ['coverage_county']);
                });

                $('#coverage_city').on('change', function () {
                    cityColumn.search($(this).find(':selected').text(), {exact: true}).draw();
                });
            }
        });
    });
</script>
<link rel="stylesheet" href="/public/<?= ASSETS_PATH ?>/css/select2-bootstrap5-dark.css" />
<? captureJavaScriptEnd() ?>
