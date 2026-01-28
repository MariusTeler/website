<?php

global $curPage;

$table = 'back_settings';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$where = '';


// Delete row with or without further verifications
if ($_GET['del']) {
    $result = dbDelete($table, array('id' => $_GET['del']));

    if ($result === false) {
        alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
    } else {
        alertsAdd('Stergerea a fost realizata cu success!');
    }

    redirectURL($curPage . returnVar());
}

// List rows
$list = dbSelect('*', $table, $where, 'name ASC');
