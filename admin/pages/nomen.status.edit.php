<?php

global $retPage;

$table = 'nomen_status';
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
        // Init ordering index
        if (!$_GET['edit']) {
            $_POST['ord'] = dbOrderIndex($table);
        }

        // Insert / Update row
        $id = dbInsert($table, $_POST);

        // Notifications
        if ($id === false) {
            alertsAdd('Datele nu au putut fi salvate!', 'error');
            $id = $_GET['edit'];
        } else {
            alertsAdd('Datele au fost salvate cu success!', 'success');
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
    }
}
