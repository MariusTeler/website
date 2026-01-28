<div class="wrapper wrapper-full-page d-flex flex-column justify-content-center">
    <div class="page-header login-page" >
        <div class="container pt-0 pb-0">
            <div class="col-md-4 col-sm-6 ml-auto mr-auto">
                <div class="card card-login">
                    <div class="card-header card-header-success text-center">
                        <h3 class="card-title m-0 font-weight-light">Resetare parola</h3>
                    </div>
                    <? if ($accountInfo) : ?>
                        <form class="form" method="POST" action="" id="<?= $formReset ?>">
                            <input type="hidden" name="formId" value="<?= $formReset ?>" />
                            <div class="card-body">
                                <?= parseBlock('site.alerts') ?>
                                <div id="<?= $formReset ?>_errors_top" class="text-center text-danger hidden">
                                    Va rugam sa completati campurile necesare.
                                    <ul></ul>
                                </div>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                              <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <div class="w-75">
                                            <input type="password" id="pass" name="pass" class="form-control" placeholder="Parola noua...">
                                        </div>
                                    </div>
                                </span>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <div class="w-75">
                                            <input type="password" id="pass_new2" name="pass_new2" class="form-control" placeholder="Confirma parola noua...">
                                        </div>
                                    </div>
                                </span>
                            </div>
                            <div class="card-footer justify-content-center">
                                <input type="submit"
                                       id="<?= $formReset ?>_submit"
                                       class="btn btn-success"
                                       data-message-loading="Se trimite..."
                                       data-message-normal="Reseteaza parola"
                                       value="Reseteaza parola" />

                            </div>
                        </form>
                    <? else : ?>
                        <div class="card-body">
                            <p class="text-danger text-center">Timpul pentru setarea unei noi parole a expirat sau link-ul este invalid.</p>
                        </div>
                        <div class="card-footer justify-content-center">
                            <a class="btn btn-success" href="<?= $websiteURL ?>">Login</a>
                        </div>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<? captureJavaScriptStart(); ?>
    <?= parseView('@init.form') ?>
<? captureJavaScriptEnd(); ?>
