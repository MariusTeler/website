<div class="alert-holder">
    <? if($alerts) : ?>
        <? foreach($alerts AS $alert) : ?>
            <div class="alert alert-<?= $alertClasses[$alert['type']] ?>">
                <button type="button" class="close font-weight-light text-light">&times;</button>
                <?= $alert['alert'] ?>
            </div>
        <? endforeach; ?>
    <? endif; ?>
</div>
