<?php

if ($_GET['key']) {
    // Set reset password view
    setView(getPage(), 'login.reset');

    // Get account by reset_key
    if ($cfg__['login']['settings']['user_pass']) {
        $accountInfo = dbShift(dbSelect(
            'id, email, name',
            $cfg__['login']['settings']['table'],
            'reset_key = ' . dbEscape($_GET['key']) . ' AND reset_expires > ' . time()
        ));
    }

    // Reset password form validation
    $formReset = 'formReset';
    formInit($formReset,
        array(
            'pass' => array(
                'required' => true,
                'minlength' => 8
            ),
            'pass_new2' => array(
                'required' => true,
                'equalTo' => '#pass'
            )
        ),
        array(
            'pass_new2' => array(
                'equalTo' => 'Parolele nu coincid.'
            )
        ),
        array(
            'submitHandler' => "function() {
                var submit = $('#{$formReset}_submit');
        
                submit.fadeTo(0, 0.4);
                submit.prop('disabled', true);
                submit.val(submit.data('message-loading'));
                ajaxRequest('index.php" . buildHttpQuery(['key' => $_GET['key']]) . "', [], 'POST', '#{$formReset}');
            }"
        ),
        false
    );

    // Parse variables to view
    parseVar('accountInfo', $accountInfo, getPage());
    parseVar('formReset', $formReset, getPage());

    if ($_GET['ajax']) {
        $contents = $css = $attributes = $functions = array();

        if ($accountInfo) {
            // Reset password
            if (formPost($formReset)) {
                if (formValid($formReset)) {
                    // Update password
                    $id = dbInsert($cfg__['login']['settings']['table'], array(
                        'id' => $accountInfo['id'],
                        $cfg__['login']['settings']['password'] => password_hash($_POST[$cfg__['login']['settings']['password']], PASSWORD_DEFAULT),
                        'reset_key' => '',
                        'reset_expires' => 0
                    ));

                    if ($id !== false) {
                        // Login into account
                        $_GET['return_redirect'] = true;
                        $_POST[$cfg__['login']['settings']['username']] = $accountInfo[$cfg__['login']['settings']['username']];
                        $redirect = userLogin();

                        // Show success message
                        $attributes[] = array(
                            'id' => "{$formReset}_errors_top",
                            'attribute' => 'class',
                            'value' => 'text-center text-success font-weight-bold'
                        );

                        $contents[] = array(
                            'id' => "{$formReset}_errors_top",
                            'value' => 'Parola a fost resetata cu succes!<br />Veti fi redirectionati in cateva secunde.'
                        );

                        // Redirect to account page
                        $functions[] = array('id' => 'redirectTimeout', 'params' => [$redirect, 5000]);
                    }
                }

                $css[] = array('id' => "{$formReset}_errors_top", 'property' => 'display', 'value' => 'block');
            }
        } else {
            // Show message if reset expired in the meantime
            $contents[] = array(
                'id' => $formReset,
                'value' => '<p class="text-center text-danger">Timpul pentru setarea unei noi parole a expirat.'
                    . '<a class="btn btn-success" href="' . $websiteURL . '">Login</a></p>'
            );
        }

        $functions[] = array('id' => 'formReactivateById', 'params' => [$formReset]);

        ajaxResponse($contents, array(), array(), $css, $attributes, $functions);
    }
}