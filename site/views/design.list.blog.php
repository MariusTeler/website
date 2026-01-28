<div class="container container-image-fluid mt-n4 mt-lg-n5 mb-4 fw-light fs-5">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb fs-6">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" title="#" class="text-decoration-none">Blog</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" title="#" class="text-decoration-none">Categorie</a>
            </li>
        </ol>
    </nav>
    <!-- Breadcrumbs (end) -->

    <h2 class="ls-wide">Articole DSC</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquam, asperiores, aut consectetur, consequatur consequuntur dignissimos ducimus hic ipsam iusto magnam non optio quam rem sapiente sit sunt ullam voluptatum!</p>
</div>

<div class="container mb-5">
    <div class="row d-flex mb-2 g-4">
        <? for ($i = 0; $i <= 3; $i++) : ?>
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="g-0 overflow-hidden d-flex flex-column mb-4 position-relative">
                    <div>
                        <img src="/public/<?= ASSETS_PATH ?>/images/design/hero-man-02.jpg" alt="" class="mw-100" />
                    </div>
                    <div class="pt-4">
                        <a href="#" class="stretched-link text-decoration-none">
                            <h2 class="h3 fw-light">Previziuni in curierat cu Directorul Comercial DSC</h2>
                        </a>
                        <p class="card-text mb-auto fw-light">Vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait...</p>
                    </div>
                    <div class="mt-auto">
                        <hr class="my-3 opacity-50" />
                        <div class="fw-light">Corina Popescu &nbsp;•&nbsp; 28 aprilie 2024</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="g-0 overflow-hidden d-flex flex-column mb-4 position-relative">
                    <div>
                        <img src="/public/<?= ASSETS_PATH ?>/images/design/hero-man-01.jpg" alt="" class="mw-100" />
                    </div>
                    <div class="pt-4">
                        <a href="#" class="stretched-link text-decoration-none">
                            <h2 class="h3 fw-light">Previziuni in curierat cu Directorul Comercial DSC</h2>
                        </a>
                        <p class="card-text mb-auto fw-light">
                            Vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait...
                            Vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait...
                        </p>
                    </div>
                    <div class="mt-auto">
                        <hr class="my-3 opacity-50" />
                        <div class="fw-light">Corina Popescu &nbsp;•&nbsp; 28 aprilie 2024</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="g-0 overflow-hidden d-flex flex-column mb-4 position-relative">
                    <div>
                        <img src="/public/<?= ASSETS_PATH ?>/images/design/hero-woman-01.jpg" alt="" class="mw-100" />
                    </div>
                    <div class="pt-4">
                        <a href="#" class="stretched-link text-decoration-none">
                            <h2 class="h3 fw-light">Previziuni in curierat cu Directorul Comercial DSC</h2>
                        </a>
                        <p class="card-text mb-auto fw-light"></p>
                    </div>
                    <div class="mt-auto">
                        <hr class="my-3 opacity-50" />
                        <div class="fw-light">Corina Popescu &nbsp;•&nbsp; 28 aprilie 2024</div>
                    </div>
                </div>
            </div>
        <? endfor; ?>
    </div>
    <hr class="my-4 opacity-100" />
    <nav class="pagenav">
        <ul class="pagination justify-content-center" style="--bs-border-width: 0;">
            <li class="page-item">
                <a class="page-link" href="#">
                    <span class="icon icon-arrow-left-bold text-danger fs-5"></span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link">1</a>
            </li>
            <li class="page-item">
                <a class="page-link">2</a>
            </li>
            <li class="page-item">
                <a class="page-link">...</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#">33</a>
            </li>
            <li class="page-item">
                <a class="page-link">...</a>
            </li>
            <li class="page-item">
                <a class="page-link">45</a>
            </li>
            <li class="page-item">
                <a class="page-link">46</a>
            </li>
            <li class="page-item">
                <a class="page-link lh-1" href="#" style="transform: rotate(180deg);">
                    <span class="icon icon-arrow-left-bold text-danger fs-5"></span>
                </a>
            </li>
        </ul>
    </nav>
</div>