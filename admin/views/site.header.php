<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top">
    <a class="text-secondary navbar-brand position-absolute d-lg-none" id="help-button" data-page="<?= getPage() ?>" href="#" title="Ajutor" data-placement="left">
        <i class="material-icons">help_outline</i> Ajutor
    </a>
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-minimize">
                <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round" data-id="-1">
                    <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                    <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                </button>
            </div>
            <a class="navbar-brand" id="toggleMenuDesktop" href="javascript:;">Meniu</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <span class="navbar-form"></span>
            <ul class="navbar-nav">
                <? /*
                <li class="nav-item">
                    <a class="nav-link" href="#pablo">
                        <i class="material-icons">dashboard</i>
                        <p>
                            <span class="d-lg-none d-md-block">Stats</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#pablo" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">notifications</i>
                        <span class="notification">5</span>
                        <p>
                    <span class="d-lg-none d-md-block">Some Actions
                      <b class="caret"></b>
                    </span>

                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#pablo">Mike John responded to your email</a>
                        <a class="dropdown-item" href="#pablo">You have 5 new tasks</a>
                        <a class="dropdown-item" href="#pablo">You're now friend with Andrew</a>
                        <a class="dropdown-item" href="#pablo">Another Notification</a>
                        <a class="dropdown-item" href="#pablo">Another One</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pablo">
                        <i class="material-icons">person</i>
                        <p>
                            <span class="d-lg-none d-md-block">Account</span>
                        </p>
                    </a>
                </li>
                */ ?>
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link" id="help-button" data-page="<?= getPage() ?>" href="#" rel="tooltip" title="Ajutor" data-placement="left">
                        <i class="material-icons">help_outline</i>
                        <p>
                            <span class="d-lg-none d-md-block">Ajutor</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=logout" rel="tooltip" title="Logout" data-placement="left">
                        <i class="material-icons">power_settings_new</i>
                        <p>
                            <span class="d-lg-none d-md-block">Logout</span>
                        </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->