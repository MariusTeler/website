<?php

global $curPage, $listRows;

$table = 'back_users_profile';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$where = '1';

// Delete row with or without further verifications
if ($_GET['del']) {
    if (dbCheckDelete('back_users', 'profile_id', $_GET['del'])) {

        $result = dbDelete($table, array('id' => $_GET['del']));

        if ($result === false) {
            alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
        } else {
            alertsAdd('Stergerea a fost realizata cu success!');
        }
    } else {
        alertsAdd('Exista administratori asociati acestui profil!', 'error');
    }

    redirectURL($curPage . returnVar());
}

// List rows
$list = dbSelect('*', $table, $where, 'name ASC');
$listRows = count($list);
