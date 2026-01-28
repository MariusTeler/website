<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?= getLang() ?: LANG_DEFAULT ?>">
    <head>
        <?= parseBlock('site.head'); ?>

        <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />-->

        <? if ($cfg__['login']['settings']['google']) : ?>
            <script src="https://accounts.google.com/gsi/client" onload="initLogin()" async defer></script>

            <script>
                var googleClient;

                function initLogin() {
                    googleClient = google.accounts.oauth2.initCodeClient({
                        client_id: '<?= settingsGet('google-api-client-id') ?>',
                        scope: 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
                        ux_mode: 'popup',
                        callback: signInCallback,
                    });
                }

                function signInCallback(authResult) {
                    if (authResult['code']) {
                        $('#code').val(authResult['code']);

                        ajaxRequest('index.php?page=login', ['code'], 'POST');
                    }
                }

                function redirectTimeout(URL, delay) {
                    setTimeout(function() {
                        document.location.href = URL;
                    }, delay);
                }

                $(document).ready(function() {
                    $('#googleLogin').click(function(e) {
                        e.preventDefault();
                        googleClient.requestCode();

                        return false;
                    });
                });
            </script>
        <? endif; ?>

        <? if ($cfg__['login']['settings']['facebook']) : ?>
            <script>
                window.fbAsyncInit = function() {
                    FB.init({
                        appId      : '<?= settingsGet('facebook-app-id') ?>',
                        cookie     : true,
                        xfbml      : false,
                        version    : 'v10.0'
                    });

                    FB.AppEvents.logPageView();
                };
            </script>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

            <script>
                $(document).ready(function() {
                    $('#facebookLogin').on('click', function(e) {
                        e.preventDefault();

                        FB.login(function(response) {
                            if (response.status === 'connected') {
                                // Check if email is present in current scopes
                                let scopes = response.authResponse.grantedScopes.split(',');

                                if (scopes.indexOf('email') !== -1) {
                                    ajaxRequest('index.php?page=login', ['fb_code'], 'POST');

                                    $("#facebookLoginError").html('').addClass('hidden');
                                } else {
                                    $("#facebookLoginError").html('Email-ul este obligatoriu.').removeClass('hidden');
                                }
                            }
                        }, {
                            auth_type: 'reauthorize',
                            scope: 'public_profile, email',
                            return_scopes: true
                        });
                    });
                });
            </script>
        <? endif; ?>
    </head>
    <body class="off-canvas-sidebar login-page">
        <?= parseView('login') ?>
        <?= parseView('site.js') ?>
        <?= parseJavaScript() ?>
    </body>
</html>