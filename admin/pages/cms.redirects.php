<?php

global $curPage;

$table = 'cms_redirects';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$where = "";

if ($_GET['set_status']) {
    $r = dbStatus($table, $_GET['set_status']);

    // Update $dbRedirects array
    updateDbRedirects();

    // Log action
    if ($r) {
        userActionStatus(
            $_GET['set_status'],
            ENTITY_REDIRECT,
            $table,
            'status',
            STATUS_TYPES
        );
    }

    redirectURL($curPage . returnVar());
}


// Delete row with or without further verifications
if ($_GET['del']) {
    $result = dbDelete($table, array('id' => $_GET['del']));

    if ($result === false) {
        alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
    } else {
        alertsAdd('Stergerea a fost realizata cu success!', 'success');
    }

    // Update $dbRedirects array
    updateDbRedirects();

    redirectURL($curPage . returnVar());
}

// List rows
$list = dbSelect('*', $table, $where, 'url_from ASC');
