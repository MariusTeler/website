<!-- Box - Timeline -->
<div class="position-relative py-5">
    <img class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover object-position-center opacity-25 z-n1"
         src="/public/<?= ASSETS_PATH ?>/images/design/box-timeline.jpg"
         alt="" />
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12 fw-light">
                <h2 class="mb-5 ls-wider">POVESTEA NOASTRĂ</h2>
                <div class="d-flex vh-70 vh-md-60 max-vh-70 max-vh-md-60 overflow-x-auto no-scrollbar"
                     style="padding-bottom: 4rem;">
                    <? for ($i = 0; $i < 2; $i++) : ?>
                        <div class="position-relative d-flex flex-column justify-content-end px-5 border-bottom border-3 border-white">
                            <div class="position-relative w-100 mh-90 mb-5 py-4 px-4"
                                 style="transform: rotate(-90deg) translateY(100%); transform-origin: bottom left;">
                                &nbsp;
                                <div class="position-absolute top-0 left-0 ms-n4 py-4 px-4 bg-primary text-nowrap">FONDARE COMPANIE</div>
                            </div>
                            <div class="position-absolute bottom-0 top-100 mt-3 ms-4">
                                <span class="small">SEP</span><br />
                                <span class="fw-bold">2024</span>
                            </div>
                            <div class="position-absolute bottom-0 top-100 mt-n5 ms-4 border-top border-start border-end w-0 h-0"
                                 style="--bs-border-width: 10px;
                                        --bs-border-color: transparent;
                                        border-top-color: var(--bs-primary) !important;"></div>
                            <div class="position-absolute bottom-0 top-100 translate-middle-y ms-4 rounded-circle bg-white"
                                 style="width: 15px; height: 15px;"></div>
                        </div>
                        <div class="position-relative d-flex flex-column justify-content-end min-w-80 min-w-md-50 min-w-lg-30 px-3 px-lg-5 border-bottom border-3 border-white">
                            <div class="w-100 mh-90 overflow-y-auto no-scrollbar mb-5 py-4 px-4 bg-white text-secondary">
                                <div class="mb-3 text-black fw-bold">LOREM IPSUM</div>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                                <a href="#" class="btn btn-sm btn-danger py-2 px-4 rounded-5">Află mai mult</a>
                            </div>
                            <div class="position-absolute bottom-0 top-100 mt-3 ms-4">
                                <span class="small">OCT</span><br />
                                <span class="fw-bold">2024</span>
                            </div>
                            <div class="position-absolute bottom-0 top-100 mt-n5 ms-4 border-top border-start border-end w-0 h-0"
                                 style="--bs-border-width: 10px;
                                        --bs-border-color: transparent;
                                        border-top-color: var(--bs-white) !important;"></div>
                            <div class="position-absolute bottom-0 top-100 translate-middle-y ms-4 rounded-circle bg-white"
                                 style="width: 15px; height: 15px;"></div>
                        </div>
                        <div class="position-relative d-flex flex-column justify-content-end min-w-80 min-w-md-50 min-w-lg-30 px-3 px-lg-5 border-bottom border-3 border-white">
                            <div class="w-100 mh-90 overflow-y-auto no-scrollbar mb-5 py-4 px-4 bg-white text-secondary">
                                <div class="mb-3 text-black fw-bold">LOREM IPSUM</div>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                <a href="#" class="btn btn-sm btn-danger py-2 px-4 rounded-5">Află mai mult</a>
                            </div>
                            <div class="position-absolute bottom-0 top-100 mt-3 ms-4">
                                <span class="small">DEC</span><br />
                                <span class="fw-bold">2024</span>
                            </div>
                            <div class="position-absolute bottom-0 top-100 mt-n5 ms-4 border-top border-start border-end w-0 h-0"
                                 style="--bs-border-width: 10px;
                                        --bs-border-color: transparent;
                                        border-top-color: var(--bs-white) !important;"></div>
                            <div class="position-absolute bottom-0 top-100 translate-middle-y ms-4 rounded-circle bg-white"
                                 style="width: 15px; height: 15px;"></div>
                        </div>
                        <div class="position-relative d-flex flex-column justify-content-end px-5 border-bottom border-3 border-white">
                            <div class="position-relative w-100 mh-90 mb-5 py-4 px-4"
                                 style="transform: rotate(-90deg) translateY(100%); transform-origin: bottom left;">
                                &nbsp;
                                <div class="position-absolute top-0 left-0 ms-n4 py-4 px-4 bg-primary text-nowrap">CA &euro;3000.000</div>
                            </div>
                            <div class="position-absolute bottom-0 top-100 mt-3 ms-4">
                                <span class="small">IAN</span><br />
                                <span class="fw-bold">2025</span>
                            </div>
                            <div class="position-absolute bottom-0 top-100 mt-n5 ms-4 border-top border-start border-end w-0 h-0"
                                 style="--bs-border-width: 10px;
                                        --bs-border-color: transparent;
                                        border-top-color: var(--bs-primary) !important;"></div>
                            <div class="position-absolute bottom-0 top-100 translate-middle-y ms-4 rounded-circle bg-white"
                                 style="width: 15px; height: 15px;"></div>
                        </div>
                    <? endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>