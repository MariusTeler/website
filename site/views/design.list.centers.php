<!-- List - Center -->
<div class="container my-4 py-4">
    <div class="position-relative fw-light">
        <h2 class="mb-5 fw-light ls-wide">Relații clienți</h2>
        <table class="table table-borderless" id="table-centers" style="width: 100%;">
            <thead>
            <tr>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <? for ($i = 0; $i < 1; $i++) : ?>
                <tr>
                    <td>
                        <div class="h3 w-md-50 w-lg-35 ps-5 pb-2 mb-4 fw-bold border-bottom border-2 border-white">
                            București
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Relații clienți:</strong><br />
                                    0760.235.115
                                </div>
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Responsabil zonal:</strong><br />
                                    0760.222.333
                                </div>
                            </div>
                            <div class="col-lg-6 text-break">
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Email:</strong><br />
                                    contact@curierdragonstar.ro
                                </div>
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Adresa:</strong><br />
                                    Bdul. Muncii nr. 18, București, Sector 2<br />
                                    <a href="#" class="fs-4" target="_blank">Vezi pe harta</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="h3 w-md-50 w-lg-35 ps-5 pb-2 mb-4 fw-bold border-bottom border-2 border-white">
                            Cluj-Napoca
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Relații clienți:</strong><br />
                                    0760.235.115
                                </div>
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Responsabil zonal:</strong><br />
                                    0760.222.333
                                </div>
                            </div>
                            <div class="col-lg-6 text-break">
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Email:</strong><br />
                                    contact@curierdragonstar.ro
                                </div>
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Adresa:</strong><br />
                                    Bdul. Muncii nr. 18, Cluj Napoca, jud. Cluj<br />
                                    <a href="#" class="fs-4" target="_blank">Vezi pe harta</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="h3 w-md-50 w-lg-35 ps-5 pb-2 mb-4 fw-bold border-bottom border-2 border-white">
                            Timișoara
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Relații clienți:</strong><br />
                                    0760.235.115
                                </div>
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Responsabil zonal:</strong><br />
                                    0760.222.333
                                </div>
                            </div>
                            <div class="col-lg-6 text-break">
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Email:</strong><br />
                                    contact@curierdragonstar.ro
                                </div>
                                <div class="h3 ps-5 mb-4 fw-light">
                                    <strong>Adresa:</strong><br />
                                    Calea Lugojului, nr. 107, com. Ghiroda, jud. Timis<br />
                                    <a href="#" class="fs-4" target="_blank">Vezi pe harta</a>
                                </div>
                            </div>
                    </td>
                </tr>
            <? endfor; ?>
            </tbody>
        </table>
    </div>
</div>
<? captureJavaScriptStart() ?>
<link rel="stylesheet" href="/public/<?= ASSETS_PATH ?>/js/vendor/datatables/datatables.min.css" />
<script src="/public/<?= ASSETS_PATH ?>/js/vendor/datatables/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table-centers').DataTable({
            fixedHeader: true,
            responsive: false,
            paging: false,
            ordering: false,
            searching: true,
            scrollX: false,
            bInfo: false,
            layout: {
                topStart: 'search',
                topEnd: 'pageLength',
                bottomStart: 'info',
                bottomEnd: 'paging'
            },
            language: {
                url: '/public/<?= ASSETS_PATH ?>/js/vendor/datatables/ro.json'
            },
            initComplete: function(settings, json) {
                let $container = $(this).parents('.dt-bootstrap5');
                $container.find('div.dt-search input').addClass('flex-grow-1 border-top-0 border-start-0 border-end-0 rounded-0');
                $container.find('div.dt-length select').addClass('pe-3 border-top-0 border-start-0 border-end-0 rounded-0');
                $container.find('div.dt-length label').addClass('d-none d-md-inline-block');
                $container.find('div.dt-layout-start').addClass('col-auto w-100');
                $container.find('div.dt-search').addClass('d-flex w-md-50 w-lg-35');
                $container.find('div.dt-layout-end').addClass('col-auto');
                $container.find('div.dt-paging').css({
                    '--bs-pagination-border-radius': 0
                });
            }
        });
    });
</script>
<? captureJavaScriptEnd() ?>