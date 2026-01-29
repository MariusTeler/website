<!-- Hero -->
<div class="bg-primary pt-5">
    <div class="container mt-5 pt-5">
        <div class="d-flex flex-column flex-lg-row justify-content-between mt-lg-5 pt-lg-5 pb-5">
            <h1 class="fw-bold ls-wider">VERIFICARE AWB</h1>
            <h2 class="h1 fw-light">Nr. AWB <?= htmlspecialchars($awbNo) ?></h2>
        </div>
    </div>
</div>

<div class="container my-5">
    <h3 class="h1 mb-5 fw-light ls-wider">PROGRES LIVRARE</h3>
    <div class="row g-2 g-lg-4 mb-5">

        <? $isCurrent = $awbStatus == STATUS_PICKED; ?>
        <div class="col-6 col-lg-3">
            <div class="d-flex flex-column align-items-center h-100 py-3 border rounded-2 border-white <?= $isCurrent ? 'bg-white text-dark' : '' ?>">
                <span class="icon icon-house display-3"></span>
                <span class="fs-5 fw-bold pt-2 pb-4">Preluată</span>
                <!--<span class="fs-5 fw-light pb-4">25/02/2033</span>-->
                <? if ($awbStatus != STATUS_REGISTERED) : ?>
                    <span class="px-2 py-1 rounded-circle <?= $isCurrent ? 'bg-primary text-white' : 'bg-white text-primary' ?>">
                        <span class="icon icon-check position-relative fs-5" style="top: 0.1rem;"></span>
                    </span>
                <? endif; ?>
            </div>
        </div>

        <? $isCurrent = $awbStatus == STATUS_TRANSIT; ?>
        <div class="col-6 col-lg-3">
            <div class="d-flex flex-column align-items-center h-100 py-3 border rounded-2 border-white <?= $isCurrent ? 'bg-white text-dark' : '' ?>">
                <span class="icon icon-truck display-3"></span>
                <span class="fs-5 fw-bold pt-2 pb-4">În tranzit</span>
                <!--<span class="fs-5 fw-light pb-4">25/02/2033</span>-->
                <? if (!in_array($awbStatus, [STATUS_REGISTERED, STATUS_PICKED])) : ?>
                    <span class="px-2 py-1 rounded-circle <?= $isCurrent ? 'bg-primary text-white' : 'bg-white text-primary' ?>">
                        <span class="icon icon-check position-relative fs-5" style="top: 0.1rem;"></span>
                    </span>
                <? endif; ?>
            </div>
        </div>

        <? $isCurrent = $awbStatus == STATUS_DELIVERY; ?>
        <div class="col-6 col-lg-3">
            <div class="d-flex flex-column align-items-center h-100 py-3 border rounded-2 border-white <?= $isCurrent ? 'bg-white text-dark' : '' ?>">
                <span class="icon icon-map-location display-3"></span>
                <span class="fs-5 fw-bold pt-2 pb-4">În livrare</span>
                <!--<span class="fs-5 fw-light pb-4">25/02/2033</span>-->
                <? if (!in_array($awbStatus, [STATUS_REGISTERED, STATUS_PICKED, STATUS_TRANSIT])) : ?>
                    <span class="px-2 py-1 rounded-circle <?= $isCurrent ? 'bg-primary text-white' : 'bg-white text-primary' ?>">
                        <span class="icon icon-check position-relative fs-5" style="top: 0.1rem;"></span>
                    </span>
                <? endif; ?>
            </div>
        </div>

        <? $isCurrent = in_array($awbStatus, [STATUS_DELIVERED, STATUS_RETURNED, STATUS_REDIRECTED, STATUS_APPROVED]); ?>
        <div class="col-6 col-lg-3">
            <div class="d-flex flex-column align-items-center h-100 py-3 border rounded-2 border-white <?= $isCurrent == STATUS_DELIVERY ? 'bg-white text-dark' : '' ?>">
                <span class="icon icon-delivery-man display-3"></span>
                <span class="fs-5 fw-bold pt-2 pb-4">
                    <?= $isCurrent ? $statusText[$awbStatus] : $statusText[STATUS_DELIVERED] ?>
                </span>
                <!--<span class="fs-5 fw-light pb-4">25/02/2033</span>-->
                <? if ($isCurrent) : ?>
                    <span class="px-2 py-1 bg-primary rounded-circle">
                        <span class="icon icon-check position-relative text-white fs-5" style="top: 0.1rem;"></span>
                    </span>
                <? endif; ?>
            </div>
        </div>
    </div>

    <h3 class="h1 mb-5 fw-light ls-wider">DETALII LIVRARE</h3>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="rounded-3 px-4 py-4 h-100" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
                <div class="text-white text-opacity-50 text-uppercase small fw-semibold mb-2">Număr AWB</div>
                <div class="h3 fw-bold mb-0"><?= htmlspecialchars($awbNo) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="rounded-3 px-4 py-4 h-100" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
                <div class="text-white text-opacity-50 text-uppercase small fw-semibold mb-2">Status</div>
                <div class="h4 fw-bold mb-0 text-white"><?= htmlspecialchars($awbInfo['status']) ?></div>
            </div>
        </div>
        <? if ($awbInfo['location']) : ?>
        <div class="col-md-4">
            <div class="rounded-3 px-4 py-4 h-100" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
                <div class="text-white text-opacity-50 text-uppercase small fw-semibold mb-2"><span class="icon icon-map-location me-1"></span>Locație</div>
                <div class="h3 fw-bold mb-0"><?= htmlspecialchars($awbInfo['location']) ?></div>
            </div>
        </div>
        <? endif; ?>
    </div>

    <? if (!empty($awbHistory)) : ?>
        <hr class="my-5 opacity-25" />

        <h3 class="h1 mb-5 fw-light ls-wider">ISTORIC LIVRARE</h3>

        <div class="row">
            <div class="col-lg-8">
                <div class="position-relative ps-4" style="border-left: 3px solid var(--bs-danger);">
                    <? foreach ($awbHistory as $index => $event) : ?>
                        <div class="position-relative mb-4">
                            <div class="position-absolute bg-danger rounded-circle" style="width: 14px; height: 14px; left: -24.5px; top: 8px; box-shadow: 0 0 0 4px rgba(220,53,69,0.3);"></div>
                            <div class="rounded-3 px-4 py-3" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%); backdrop-filter: blur(10px);">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                                    <div>
                                        <h5 class="fw-bold mb-1 text-white"><?= htmlspecialchars($event['eveniment']) ?></h5>
                                        <span class="text-white text-opacity-75"><span class="icon icon-map-location me-1"></span><?= htmlspecialchars($event['centru']) ?></span>
                                    </div>
                                    <div class="fw-semibold text-white">
                                        <?= date('d.m.Y, H:i', strtotime($event['data'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    <? endif; ?>
</div>
<div class="bg-primary">
    <div class="container position-relative py-5">
        <div class="row">
            <div class="col-md-5">
                <h2 class="h1 mb-4 ls-wider">VERIFICARE AWB</h2>
                <form method="get">
                    <label for="awb" class="visually-hidden">Introduceţi codul AWB</label>
                    <input id="awb"
                           name="awb"
                           type="text"
                           class="form-control mb-4 py-2 border-0 border-bottom border-2 border-white fs-3 fw-lighter"
                           autocomplete="off"
                           placeholder="Introduceţi codul AWB">
                    <button class="btn btn-sm btn-danger py-3 px-5 rounded-5" type="submit">CAUTĂ</button>
                </form>
            </div>
        </div>

        <img class="d-none d-lg-block position-absolute bottom-0 start-50 w-lg-25 ms-4 opacity-50"
             style="filter: invert(10%) sepia(9%) saturate(7480%) hue-rotate(207deg) brightness(88%) contrast(107%); transform: translateX(-80%)"
             src="/public/<?= ASSETS_PATH ?>/images/design/pyramid.svg"
             alt="" />
    </div>
</div>