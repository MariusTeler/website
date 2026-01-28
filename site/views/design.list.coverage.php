<!-- List - Coverage -->
<div class="container my-5 py-4">
    <div class="position-relative fw-light">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="row w-75 w-md-100 mx-auto mx-md-0 flex-wrap align-items-md-stretch justify-content-around mb-5">
                    <div class="col-md-3 mx-3 mb-4 px-5 pt-4 corner text-center"
                         style="--background-color: var(--bs-danger-rgb); --border-color: var(--bs-danger);">
                        <span class="h2">Zona Zero</span>
                        <p>Localitățile mari</p>
                    </div>
                    <div class="col-md-3 mx-3 mb-4 px-5 pt-4 corner text-center"
                         style="--background-color: var(--bs-danger-rgb); --border-color: var(--bs-danger);">
                        <span class="h2">Zona Unu</span>
                        <p>Pe o rază de 1 – 15 km de Zona Zero</p>
                    </div>
                    <div class="col-md-3 mx-3 mb-4 px-5 pt-4 corner text-center"
                         style="--background-color: var(--bs-danger-rgb); --border-color: var(--bs-danger);">
                        <span class="h2">Zona Doi</span>
                        <p>Restul localităților</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <h2 class="mb-5 fw-light ls-wide text-center">Caută localitatea dorită și află km suplimentari</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-floating mb-2 fs-5">
                            <select class="form-select border-top-0 border-start-0 border-end-0" id="coverage_county" name="coverage_county">
                                <option></option>
                                <option value="Alba">Alba</option>
                                <option value="București">București</option>
                                <option value="Cluj">Cluj</option>
                                <option value="Harghita">Harghita</option>
                            </select>
                            <label for="coverage_county">Județ</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-2 fs-5">
                            <select class="form-select border-top-0 border-start-0 border-end-0" id="coverage_city" name="coverage_city">
                                <option></option>
                                <option value="Abrud">Abrud</option>
                                <option value="Avramesti (Avram Iancu)">Avramesti (Avram Iancu)</option>
                                <option value="Balomiru de Camp">Balomiru de Camp</option>
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
                    <? for ($i = 0; $i < 1000; $i++) : ?>
                    <tr>
                        <td>Alba</td>
                        <td>Abrud</td>
                        <td>65</td>
                    </tr>
                    <tr>
                        <td>București</td>
                        <td>Avramesti (Avram Iancu)</td>
                        <td>120</td>
                    </tr>
                    <tr>
                        <td>Cluj</td>
                        <td>Balomiru de Camp</td>
                        <td>28</td>
                    </tr>
                    <tr>
                        <td>Harghita</td>
                        <td>Blaj</td>
                        <td>0</td>
                    </tr>
                    <? endfor; ?>
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
                    countyColumn.search($(this).val(), {exact: true}).draw();
                });

                $('#coverage_city').on('change', function () {
                    cityColumn.search($(this).val(), {exact: true}).draw();
                });
            }
        });
    });
</script>
<? captureJavaScriptEnd() ?>
