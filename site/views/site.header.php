<nav class="navbar navbar-expand-lg navbar-light position-absolute top-0 w-100 fixed-top_ pt-lg-0 z-3">
    <div class="container align-items-stretch align-items-lg-center mt-2 mt-lg-0 ps-4 pe-0 px-lg-3">
        <a href="/" class="navbar-brand me-0 py-0">
            <img src="/public/<?= ASSETS_PATH ?>/images/logo.svg" alt="" />
        </a>
        <div class="d-lg-none flex-grow-1 bg-danger"></div>
        <button class="navbar-toggler bg-danger rounded-0"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
            <div class="offcanvas-header bg-primary">
                <a href="/" class="navbar-brand me-0 py-0">
                    <img src="/public/<?= ASSETS_PATH ?>/images/logo.svg" alt="" />
                </a>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0">
                <ul class="navbar-nav justify-content-around align-content-stretch flex-grow-1 fw-light">
                    <? foreach($menu AS $i => $row) : ?>
                        <? $icon = ($row['name'] && $row['name'] != 'home') ? $row['name'] : '' ?>
                        <? if ($i == 1) : ?>
                            <li class="nav-item d-none d-lg-block bg-danger corner me-n3 px-3"
                                style="--background-color: var(--bs-red);
                            --border-color: var(--bs-red);
                            --edge-size-left: 0%;
                            --edge-size-right-top: 100%;"></li>
                            <li class="nav-item d-none d-lg-block bg-danger corner ms-n2 px-3"
                                style="--background-color: var(--bs-red);
                                --border-color: var(--bs-red);
                                --edge-size-left: 100%;"></li>
                            <li class="nav-item bg-danger px-2"></li>
                        <? endif; ?>
                        <li class="nav-item flex-grow-1 border-bottom border-2 border-lg-0 border-secondary text-left text-lg-center <?= !$row['icon'] ? 'bg-danger' : 'bg-white' ?> <?= $row['submenu'] ? 'dropdown' : '' ?>"
                            style="--bs-border-opacity: 0.1;">
                            <a <?= menuPopup($row) ?>
                                href="<?= menuLink($row) ?>"
                                class="nav-link mx-4 mx-lg-2 <?= !$i ? 'fw-bold ls-wide_' : '' ?> <?= $row['page_id'] == $id_page['id'] || $row['page_id'] == $id_subpage['id'] ? 'active' : '' ?> <?= $row['icon'] ? 'd-flex flex-column py-3 py-lg-2 text-primary fw-bold' : 'py-3 py-lg-4' ?>">
                                <? if ($row['icon']) : ?>
                                    <span class="d-none d-lg-block">
                                        <span class="px-1 py-1 bg-primary rounded-circle">
                                            <span class="icon <?= $row['icon'] ?> position-relative text-white fs-5"
                                                  style="top: 0.2rem;"></span>
                                        </span>
                                    </span>
                                <? endif; ?>
                                <span>
                                    <?= $row['link_name'] ?: $row['page']['link_name'] ?>
                                    <? if ($row['submenu']) : ?>
                                        <span class="icon icon-caret-down position-relative fs-6"></span>
                                    <? endif; ?>
                                </span>
                            </a>
                            <? if ($row['submenu']) : ?>
                                <ul class="dropdown-menu d-block d-lg-none corner <?= !$row['icon'] ? 'mx-lg-2' : '' ?>"
                                    style="--bs-dropdown-bg: var(--bs-body-color);
                                    --bs-dropdown-link-color: var(--bs-gray);
                                    --bs-dropdown-link-hover-color: var(--bs-gray);
                                    --bs-dropdown-link-hover-bg: var(--bs-gray-200);
                                    --bs-dropdown-link-active-color: var(--bs-gray);
                                    --bs-dropdown-link-active-bg: var(--bs-gray-200);
                                    --bs-dropdown-border-width: 0;
                                    --bs-dropdown-border-radius: 0;
                                    --bs-dropdown-padding-x: 0;
                                    --bs-dropdown-padding-y: 0;
                                    --bs-dropdown-min-width: <?= count($row['submenu']) >= 3 ? '33rem' : '22rem' ?>;
                                    --bs-dropdown-item-padding-x: 1rem;
                                    --bs-dropdown-item-padding-y: 1rem;
                                    --background-color: var(--bs-primary-rgb);
                                    --border-color: var(--bs-white);
                                    --edge-size-left: 2.5rem;">
                                    <? foreach ($row['submenu'] as $k => $row2) : ?>
                                        <li class="d-inline-block float-start w-50 <?= count($row['submenu']) >= 3 ? 'w-lg-33' : 'w-lg-50' ?>">
                                            <a <?= menuPopup($row2) ?>
                                                    href="<?= menuLink($row2) ?>"
                                                    class="dropdown-item d-flex flex-column text-center <?= $row2['page_id'] == $id_page['id'] || $row2['page_id'] == $id_subpage['id'] ? 'active' : '' ?>">
                                                <span class="icon <?= $row2['icon'] ?> text-dark display-2"></span>
                                                <span style="font-size: 0.75rem;"><?= $row2['link_name'] ?: $row2['page']['link_name'] ?></span>
                                            </a>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                            <? endif; ?>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</nav>