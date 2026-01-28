<? if (userGetRight(ADMIN_RIGHT_VIEW, 'index.php?page=cms.contact')) : ?>
    <? parseVar('isHome', true, 'cms.contact') ?>
    <?= parseBlock('cms.contact') ?>
<? endif; ?>

<? if (userGetRight(ADMIN_RIGHT_VIEW, 'index.php?page=stats.contact')) : ?>
    <? parseVar('isHome', true, 'stats.contact') ?>
    <?= parseBlock('stats.contact') ?>
<? endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">info</i>
                </div>
                <h3 class="card-title">Bun venit!</h3>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="">
                            Pentru a afla instructiunile de folosire pentru fiecare sectiune a interfetei de administrare, apasati pe butonul "<b>Ajutor</b>" din zona dreapta-sus, in timp ce va aflati in cadrul sectiunii respective.<br /><br />
                            <i>Sa aveti o zi minunata!</i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>