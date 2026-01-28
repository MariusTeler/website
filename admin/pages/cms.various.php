<?php

global $curPage;

$table = 'cms_various';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];

// Change status for field
if ($_GET['set_status']) {
    $r = dbStatus($table, $_GET['set_status']);

    // Log action
    if ($r) {
        userActionStatus(
            $_GET['set_status'],
            ENTITY_VARIOUS,
            $table,
            'status',
            STATUS_TYPES
        );
    }

    redirectURL($curPage . returnVar());
}


// Delete row with or without further verifications
if ($_GET['del']) {
    // Images delete settings
    $imagesUpload = array(
        'dir' => IMAGES_VARIOUS,
        'thumbs' => array(
            THUMB_FACEBOOK => array()
        )
    );

    formUploadDelete($imagesUpload, $table, $_GET['del']);

    $result = dbDelete($table, array('id' => $_GET['del']));

    if ($result === false) {
        alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
    } else {
        alertsAdd('Stergerea a fost realizata cu success!');

        // Remove content block from entities
        $success = entityRemoveBlocks(ENTITY_VARIOUS, $_GET['del']);

        if (!$success) {
            alertsAdd('Stergerea asocierii cu blocurile de continut nu a putut fi efectuata.', 'error');
        }
    }

    redirectURL($curPage . returnVar());
}

// List rows
$list = dbSelect('id, name, type, title, status', $table, '', 'name ASC');
