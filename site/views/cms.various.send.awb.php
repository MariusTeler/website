<div class="row mb-5">
    <div class="col-md-12 h4 fw-light">
        <p>
            <strong>Număr AWB: <?= $data['awb'] ?></strong>
        </p>
        <?= variousGet('send-awb-form-success', true, false)['text'] ?>
        <? if ($isPickupError) : ?>
            <p class="h5 fw-light text-danger">
                AWB-ul a fost generat cu succes, dar a apărut o problemă la înregistrarea comenzii de pick-up.
            </p>
        <? endif; ?>
        <? if ($isPdfError) : ?>
            <p class="h5 fw-light text-danger">
                AWB-ul a fost generat cu succes, dar a apărut o problemă la trimiterea etichetei pe email.
            </p>
        <? endif; ?>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between">
        <button class="btn btn-danger py-3 px-4 px-md-5 rounded-5"
                type="button"
                onclick="document.location.href = 'index.php?page=cms.various.send&download=1'" >
            Descarcă AWB
        </button>
        <button class="btn btn-link px-0 pe-4 fs-4 text-decoration-none float-end position-relative"
                type="button"
                onclick="document.location.reload()">
            Trimite alt colet
            <span class="icon icon-arrow-left-light position-absolute end-0 fs-5 text-white" style="transform: rotate(180deg);"></span>
        </button>
    </div>
</div>