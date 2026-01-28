<?php

global $curPage, $nrOnPage, $listRows;

$table = 'cms_banner';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$where = '1';
$nrOnPage = 10;
if (!$_GET['page_nr']) {
    $_GET['page_nr'] = 1;
}

// Change status for field
if ($_GET['set_status']) {
    dbStatus($table, $_GET['set_status']);
    redirectURL($curPage . returnVar());
}

// Delete row with or without further verifications
if ($_GET['del']) {
    // Images delete settings
    $imagesUploadDesktop = array(
        'dir' => IMAGES_BANNER_DESKTOP,
        'thumbs' => array(
            THUMB_MEDIUM => array()
        )
    );

    $imagesUploadMobile = array(
        'dir' => IMAGES_BANNER_MOBILE,
        'thumbs' => array(
            THUMB_MEDIUM => array()
        )
    );

    formUploadDelete($imagesUploadDesktop, $table, $_GET['del']);
    formUploadDelete($imagesUploadMobile, $table, $_GET['del']);

    $result = dbDelete($table, array('id' => $_GET['del']));

    if ($result === false) {
        alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
    } else {
        alertsAdd('Stergerea a fost realizata cu success!');
    }

    redirectURL($curPage . returnVar());
}

// Filters
if ($_GET['title']) {
    $title = dbEscape('%' . htmlspecialchars($_GET['title']) . '%');
    $where .= " AND title LIKE {$title}";
}

if (strlen($_GET['status'])) {
    $where .= ' AND status = ' . dbEscape($_GET['status']);
}

if ($_GET['date_start']) {
    $where .= ' AND date_start AND date_start >= ' . strtotime($_GET['date_start']);
}

if ($_GET['date_end']) {
    $where .= ' AND date_end AND date_end < ' . strtotime('+1 day', strtotime($_GET['date_end']));
}

// List rows
$listRows = dbShiftKey(dbSelect("COUNT(id)", $table, $where));
$list = dbSelect(
    '*',
    $table,
    $where,
    'date_start DESC, date_end DESC',
    '',
    dbLimit($nrOnPage)
);

// Init datepicker
formDatepicker('date_start');
formDatepicker('date_end');
