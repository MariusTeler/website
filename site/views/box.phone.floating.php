<? if (settingsGet('icon-phone-number')) : ?>
    <a class="position-fixed top-0 end-0 d-flex btn btn-lg btn-light bg-white p-2 pb-2 ps-3 py-3 border-0 rounded-0 rounded-start-5 z-2"
       style="margin-top: 15vh;"
       href="tel:<?= settingsGet('icon-phone-number') ?>"
       id="icon-phone-number">
        <i class="icon icon-phone pb-1 pb-1 pb-md-0 fs-3 text-primary" style="line-height: 1;"></i>
        <span class="d-none fs-6 ps-2 text-primary"><?= str_replace('+4', '', settingsGet('icon-phone-number')) ?></span>
    </a>
    <? captureJavaScriptStart() ?>
    <style>
        #icon-phone-number:hover span {
            display: block !important;
        }
    </style>
    <? captureJavaScriptEnd() ?>
<? endif; ?>