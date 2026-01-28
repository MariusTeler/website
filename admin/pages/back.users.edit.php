<?php

global $retPage;

$table = 'back_users';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Profiles
$profiles = dbSelect('*', 'back_users_profile', '', 'name ASC');
$profilesById = array_column($profiles, null, 'id');

// Companies
$companies = [];
//$companies = dbSelect('id, name', 'company', '', 'name ASC');

// Default user rights
if (!is_array($_POST['rights'])) {
    $_POST['rights'] = [];
}

// Form validation
formInit('editForm',
    array(
        'name' => array(
            'required' => true,
            'remote' => array(
                'url' => 'index.php?page=@validate.unique',
                'type' => 'post',
                'data' => array(
                    'unique_table' => $table,
                    'unique_field_name' => 'name',
                    'unique_id' => $_GET['edit'],
                    'unique_field_id' => 'name'
                )
            )
        ),
        'email' => array(
            'required' => true,
            'email' => true,
            'remote' => array(
                'url' => 'index.php?page=@validate.unique',
                'type' => 'post',
                'data' => array(
                    'unique_table' => $table,
                    'unique_field_name' => 'email',
                    'unique_id' => $_GET['edit'],
                    'unique_field_id' => 'email'
                )
            )
        ),
        'pass' => array(
            'required' => "function(element){
                return ($(element.form).find(\"[name='id']\").val() == 0);
            }",
            'minlength' => 8
        ),
        'company_id' => array(
            'required' => "function(element){
                let access = parseInt($(element.form).find(\"[name='access']\").val());
                return (access !== " . ADMIN_SUPERADMIN . " && access !== " . ADMIN_NORMAL . ");
            }"
        )
    ),
    array(
        'name' => array(
            'remote' => 'Valoarea introdusa exista deja in baza de date.'
        ),
        'email' => array(
            'remote' => 'Valoarea introdusa exista deja in baza de date.'
        )
    )
);

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm') && !(!$_POST['id'] && !(strlen($_POST['pass'])))) {
        // Get old data
        if ($_GET['edit']) {
            $oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
            $_POST['metadata'] = $oldPost['metadata'];
        }

        // Set password
        if (strlen($_POST['pass'])) {
            $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        } else {
            unset($_POST['pass']);
            unset($oldPost['pass']);
        }

        // Set user rights
        foreach ($_POST['rights'] as $rightPage => $rights) {
            if (in_array('all', $rights)) {
                $_POST['rights'][$rightPage] = array_keys(ADMIN_RIGHTS);
            }
        }
        $_POST['metadata']['rights'] = $_POST['rights'];

        // Insert / Update row
        $id = dbInsert($table, $_POST);

        // Notifications
        if ($id === false) {
            alertsAdd('Datele nu au putut fi salvate!', 'error');
            $id = $_GET['edit'];
        } else {
            alertsAdd('Datele au fost salvate cu success!');

            // Log action
            $_POST['profile_id'] = (int)$_POST['profile_id'];

            $entitiesById = [
                'access' => ADMIN_TYPES,
                'status' => STATUS_TYPES,
                'profile_id' => array_column($profiles, 'name', 'id')
            ];

            userAction($id, ENTITY_BACK_USER, $_POST, $oldPost, $entitiesById);
        }

        // Redirect
        formRedirect($retPage, $id);
    } else {
        $eClass = '';
    }
} else {
    if ($_GET['edit']) {
        $_POST = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
        $_POST['rights'] = $_POST['metadata']['rights'];

        // Reset password
        if ($_GET['reset_password']) {
            try {
                // Generate reset link & send email
                $emailSent = userResetPasswordAdmin($_POST);

                if ($emailSent !== true) {
                    throw new Exception(
                        'Nu au putut fi trimis email-ul pentru setarea unei noi parole.'
                    );
                }

                // Save user action
                userActionText(
                    $_POST['id'],
                    ENTITY_BACK_USER,
                    MESSAGE_PASSWORD_RESET
                );

                alertsAdd('Email-ul pentru setarea unei noi parole a fost trimis catre adresa indicata.');
            } catch (Exception $e) {
                alertsAdd($e->getMessage(), 'error');
            }

            // Redirect
            formRedirect($retPage, $_POST['id']);
        }

        // New account
        if ($_GET['new_account']) {
            try {
                // Generate reset link & send email
                $emailSent = userWelcomeEmailAdmin($_POST);

                if ($emailSent !== true) {
                    throw new Exception(
                        'Nu au putut fi trimis email-ul pentru noul cont.'
                    );
                }

                // Save user action
                userActionText(
                    $_POST['id'],
                    ENTITY_BACK_USER,
                    MESSAGE_ACCOUNT_NEW
                );

                alertsAdd('Email-ul pentru noul cont a fost trimis catre adresa indicata.');
            } catch (Exception $e) {
                alertsAdd($e->getMessage(), 'error');
            }

            // Redirect
            formRedirect($retPage, $_POST['id']);
        }
    }
}

// Init select2
formSelect2(array(
    'id' => 'company_id',
    'options' => array(
        'width' => '100%'
    )
));

// Update user rights for selected profile
if ($_GET['ajax']) {
    $_POST['rights'] = [];

    if ($profilesById[$_GET['profile_id']]) {
        $_POST['rights'] = $profilesById[$_GET['profile_id']]['metadata']['rights'];
    }

    $ajaxContents = [
        [
            'id' => 'userRights',
            'value' => parseBlock('back.users.rights')
        ]
    ];

    ajaxResponse($ajaxContents);
}
