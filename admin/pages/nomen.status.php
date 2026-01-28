<?php

global $curPage;

$table = 'nomen_status';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$where = "1";

parseVar('curPage', $curPage, '@list.sortable.init');

// Drag & drop ordering
if ($_GET['sort']) {
    dbSort($table, $_GET['sort']);
    parseBlock('@list.sortable.restore');
}

// Delete row with or without further verifications
if ($_GET['del']) {
    if (dbCheckDelete('cms_contact', 'status_id', $_GET['del'])) {
        $result = dbDelete($table, array('id' => $_GET['del']));

        if ($result === false) {
            alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
        } else {
            alertsAdd('Stergerea a fost realizata cu success!', 'success');
        }
    } else {
        alertsAdd('Exista deja cereri de contact asociate.', 'error');
    }

    redirectURL($curPage . returnVar());
}

// List rows
$list = dbSelect('*', $table, $where, 'ord ASC');
