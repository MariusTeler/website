<?php

global $curPage, $listRows;

$table = 'nomen_county';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$where = '1';

// Delete row with or without further verifications
if ($_GET['del'] && dbCheckDelete('nomen_city', 'county_id', $_GET['del'])) {
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
$listRows = count($list);
