<?php

global $retPage;

$table = 'back_settings';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Form validation
formInit('editForm',
    array(
        'name' => array(
            'required' => true
        ),
        'value' => array(
            'required' => true
        )
    ),
    array()
);

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm')) {
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
        $_POST = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
    }
}
