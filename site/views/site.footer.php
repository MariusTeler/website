<?= parseBlock('cms.newsletter') ?>

<!-- Footer - Links -->
<div class="bg-body-lighter py-0 py-lg-4">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4 d-none d-md-block">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <a href="/">
                            <img src="/public/<?= ASSETS_PATH ?>/images/logo.svg" alt="Dragon Star Curier" class="w-50" />
                        </a>
                    </div>
                    <div class="col-md-12">
                        <a href="<?= settingsGet('footer-link-sal') ?>" target="_blank">
                            <img src="/public/<?= ASSETS_PATH ?>/images/logo-sal.svg" alt="SAL" class="w-50" />
                        </a>
                    </div>
                    <div class="col-md-12">
                        <a href="<?= settingsGet('footer-link-sol') ?>" target="_blank">
                            <img src="/public/<?= ASSETS_PATH ?>/images/logo-sol.svg" alt="SOL" class="w-50" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-n4">
                <div class="row">
                    <? foreach($menu AS $row) : ?>
                        <div class="col-6 col-md-4 mb-4">
                            <a href="<?= menuLink($row) ?>" <?= menuPopup($row) ?> class="h5 d-inline-block text-decoration-none"><?= $row['link_name'] ?: $row['page']['link_name'] ?></a>
                            <? if ($row['submenu']) : ?>
                                <ul class="nav flex-column">
                                    <? foreach ($row['submenu'] as $row2) : ?>
                                        <li class="nav-item mb-1">
                                            <a href="<?= menuLink($row2) ?>" <?= menuPopup($row2) ?> class="nav-link p-0 text-muted">
                                                <?= $row2['link_name'] ?: $row2['page']['link_name'] ?>
                                            </a>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                            <? endif; ?>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer - Social media -->
<div class="container">
    <div class="row">
        <div class="col-4 d-md-none my-3">
            <a href="/">
                <img src="/public/<?= ASSETS_PATH ?>/images/logo.svg" alt="Dragon Star Curier" class="pb-2" />
            </a>
            <a href="<?= settingsGet('footer-link-sal') ?>" target="_blank">
                <img src="/public/<?= ASSETS_PATH ?>/images/logo-sal.svg" alt="SAL" class="w-100" />
            </a>
            <a href="<?= settingsGet('footer-link-sol') ?>" target="_blank">
                <img src="/public/<?= ASSETS_PATH ?>/images/logo-sol.svg" alt="SAL" class="w-100" />
            </a>
        </div>
        <div class="col-8 col-md-12">
            <div class="d-flex flex-column flex-md-row justify-content-between my-3 lh-1 text-end">
                <p class="m-0">Copyright &copy; <?= date('Y') ?> DSC</p>
                <ul class="nav align-self-end align-self-md-auto">
                    <? if (settingsGet('social-youtube')) : ?>
                        <li class="nav-item">
                            <a href="<?= settingsGet('social-youtube') ?>"
                               target="_blank"
                               class="nav-link py-0 pt-3 pt-md-0 px-2 px-md-3">
                                <span class="icon icon-youtube fs-4"></span>
                            </a>
                        </li>
                    <? endif; ?>
                    <? if (settingsGet('social-facebook')) : ?>
                        <li class="nav-item">
                            <a href="<?= settingsGet('social-facebook') ?>"
                               target="_blank"
                               class="nav-link py-0 pt-3 pt-md-0 px-2 px-md-3">
                                <span class="icon icon-facebook fs-4"></span>
                            </a>
                        </li>
                    <? endif; ?>
                    <? if (settingsGet('social-linkedin')) : ?>
                        <li class="nav-item">
                            <a href="<?= settingsGet('social-linkedin') ?>"
                               target="_blank"
                               class="nav-link py-0 pt-3 pt-md-0 px-2 px-md-3">
                                <span class="icon icon-linkedin fs-4"></span>
                            </a>
                        </li>
                    <? endif; ?>
                    <? if (settingsGet('social-instagram')) : ?>
                        <li class="nav-item">
                            <a href="<?= settingsGet('social-instagram') ?>"
                               target="_blank"
                               class="nav-link py-0 pt-3 pt-md-0 px-2 px-md-3">
                                <span class="icon icon-instagram fs-4"></span>
                            </a>
                        </li>
                    <? endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>