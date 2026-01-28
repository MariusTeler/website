<?php

global $curPage;

$table = 'cms_list';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];

parseVar('curPage', $curPage, '@list.sortable.init');

// Drag & drop ordering
if ($_GET['sort']) {
    dbSort($table, $_GET['sort']);
    parseBlock('@list.sortable.restore');
}

// Change status for field
if ($_GET['set_status']) {
    $r = dbStatus($table, $_GET['set_status']);

    // Log action
    if ($r) {
        userActionStatus(
            $_GET['set_status'],
            ENTITY_LIST,
            $table,
            'status',
            STATUS_TYPES
        );
    }

    redirectURL($curPage . returnVar());
}

// Delete row with or without further verifications
if ($_GET['del']) {
    if (dbCheckDelete('cms_list_row', 'list_id', $_GET['del'])) {
        $result = dbDelete($table, array('id' => $_GET['del']));

        if ($result === false) {
            alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
        } else {
            alertsAdd('Stergerea a fost realizata cu success!', 'success');

            // Remove content block from entities
            $success = entityRemoveBlocks(ENTITY_LIST, $_GET['del']);

            if (!$success) {
                alertsAdd('Stergerea asocierii cu blocurile de continut nu a putut fi efectuata.', 'error');
            }
        }
    } else {
        alertsAdd('Lista are deja asociate linii.', 'error');
    }

    redirectURL($curPage . returnVar());
}

// List rows
$list = dbSelect('*', $table, '', 'ord ASC');
