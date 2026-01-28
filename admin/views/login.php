<div class="wrapper wrapper-full-page d-flex flex-column justify-content-center">
    <div class="page-header login-page" >
        <div class="container pt-0 pb-0">
            <div class="col-md-4 col-sm-6 ml-auto mr-auto">
                <form class="form" method="POST" action="">
                    <input type="hidden" name="goLogin"  value="1" />
                    <div class="card card-login">
                        <div class="card-header card-header-success text-center">
                            <h3 class="card-title m-0 font-weight-light">Log in</h3>
                            <? /*
                            <div class="social-line pb-0 pt-0">
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                    <i class="fa fa-facebook-square"></i>
                                </a>
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-just-icon btn-link btn-white">
                                    <i class="fa fa-google"></i>
                                </a>
                            </div>
                            */?>
                        </div>
                        <div class="card-body ">
                            <? if ($cfg__['login']['settings']['google']) : ?>
                                <input type="hidden" id="code" name="code" />
                                <div class="text-center">
                                    <a href="#" id="googleLogin" class="btn btn-small btn-white text-dark m-0 mt-2 pt-2 pb-2 pl-4 pr-4 border w-75">
                                        <span class="d-inline-block w-25">
                                            <img height="25"
                                                 src="/public/site/images/google_login_buttons/google-account-logo.svg" />
                                        </span>
                                        <span class="d-inline-block w-75">
                                            Log in cu Google
                                        </span>
                                    </a>
                                </div>
                                <p id="googleLoginError" class="card-description text-center text-danger hidden"></p>
                            <? endif; ?>
                            <? if ($cfg__['login']['settings']['facebook']) : ?>
                                <input type="hidden" id="fb_code" name="fb_code" value="1" />
                                <div class="text-center">
                                    <a href="#" id="facebookLogin" class="btn btn-small btn-white text-dark m-0 mt-2 pt-2 pb-2 pl-4 pr-4 border w-75">
                                        <span class="d-inline-block w-25">
                                            <img height="25"
                                                 src="/public/site/images/facebook_login_buttons/facebook-account-logo.svg" />
                                        </span>
                                        <span class="d-inline-block w-75">
                                            Log in cu Facebook
                                        </span>
                                    </a>
                                </div>
                                <p id="facebookLoginError" class="card-description text-center text-danger hidden"></p>
                            <? endif; ?>
                            <? if ($cfg__['login']['settings']['microsoft']) : ?>
                                <div class="text-center">
                                    <a href="<?= userLoginMicrosoftUrl() ?>" id="microsoftLogin" class="btn btn-small btn-white text-dark m-0 mt-2 pt-2 pb-2 pl-4 pr-4 border w-75">
                                        <span class="d-inline-block w-25">
                                            <img height="25"
                                                 src="/public/site/images/microsoft_login_buttons/microsoft-account-logo.svg" />
                                        </span>
                                        <span class="d-inline-block w-75">
                                            Log in cu Microsoft
                                        </span>
                                    </a>
                                </div>
                                <p id="microsoftLoginError" class="card-description text-center text-danger hidden"></p>
                            <? endif; ?>
                            <? if (
                                    (
                                        $cfg__['login']['settings']['google']
                                        || $cfg__['login']['settings']['facebook']
                                        || $cfg__['login']['settings']['microsoft']
                                    )
                                    && $cfg__['login']['settings']['user_pass']
                            ) : ?>
                                <p class="card-description text-center mb-0 mt-3">sau</p>
                            <? endif; ?>
                            <? if(userGetError(false)) : ?>
                                <p class="card-description text-center text-danger"><?= userGetError(true) ?></p>
                            <? endif ?>
                            <? if ($cfg__['login']['settings']['user_pass']) : ?>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                          <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                  <i class="material-icons">face</i>
                                              </span>
                                          </div>
                                          <input type="text" id="email" name="email" class="form-control" placeholder="Email...">
                                    </div>
                                </span>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <input type="password" id="pass" name="pass" class="form-control" placeholder="Parola...">
                                    </div>
                                </span>
                            <? endif; ?>
                        </div>
                        <div class="card-footer justify-content-center">
                            <? if ($cfg__['login']['settings']['user_pass']) : ?>
                                <input type="submit" class="btn btn-success" value="Log in">
                            <? else : ?>
                                &nbsp;
                            <? endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>