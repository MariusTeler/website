<?php

$table = 'back_pages';

// Post form
if (formPost('editForm') && userGetAccess(ADMIN_SUPERADMIN)) {
    // Page
    $p = $_POST['pg'];

    if (substr($p, -5) == '.edit') {
        $p = substr($p, 0, -5);
        $_POST['help_edit'] = $_POST['helpCms'];
    } else {
        $_POST['help_list'] = $_POST['helpCms'];
    }

    // Search for page
    $id = dbShiftKey(dbSelect('id', $table, 'page = ' . dbEscape($p)));

    // Insert / Update help info
    if ($id) {
        $_POST['id'] = $id;
        $id = dbInsert($table, $_POST);
    }
}

// Page
$pg = $_GET['pg'];
if (!strlen($pg)) {
    $pg = 'home';
}

if (substr($pg, -5) == '.edit') {
    $pg = substr($pg, 0, -5);
}

// Info
$_POST = dbShift(dbSelect('id, name, help_list, help_edit', $table, "page = " . dbEscape($pg)));
