<div class="fixed-bottom toast float-end m-3 ms-auto show d-none" role="alert" data-autohide="false" id="cookie">
    <div class="toast-body d-flex flex-column">
        <p><?= settingsGet('cookies') ?></p>
        <div class="ml-auto">
            <button type="button" class="btn btn-primary close me-2">
                Accept
            </button>
            <a href="/<?= getPageByKey('name', 'cookies', true, 'url_key') ?>">Afla mai multe</a>
        </div>
    </div>
</div>