<?php

global $retPage;

$table = 'back_users_profile';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

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
        )
    ),
    array(
        'name' => array(
            'remote' => 'Valoarea introdusa exista deja in baza de date.'
        )
    )
);

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm')) {
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
        }

        // Redirect
        formRedirect($retPage, $id);
    } else {
        $eClass = '';
    }
} else {
    if ($_GET['edit']) {
        // Set data to $_POST
        $_POST = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
        $_POST['rights'] = $_POST['metadata']['rights'];
    }
}
