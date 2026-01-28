<?php

global $retPage;

$table = 'back_pages';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Form validation
formInit('editForm',
    array(
        'name' => array(
            'required' => true
        ),
        'page' => array(
            'required' => "function(element){
                return ($(element.form).find(\"[name='id_parent']\").val().length >= 1);
            }"
        )
    ),
    array()
);

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm') && !($_POST['id_parent'] && !strlen($_POST['page']))) {
        if ($_GET['edit']) {
            $oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
        }

        // Init ordering index
        if (!$_GET['edit'] || $oldPost['id_parent'] != (int)$_POST['id_parent']) {
            $_POST['ord'] = dbOrderIndex($table, 'id_parent = ' . dbEscape($_POST['id_parent']));
        }

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

// Options
$options = dbSelect('id, name', $table, 'id_parent = 0', 'ord ASC');
