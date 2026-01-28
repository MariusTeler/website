<?php

global $curPage, $nrOnPage, $listRows;

$table = '';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$where = '1';
$nrOnPage = 10;
if (!$_GET['page_nr']) {
    $_GET['page_nr'] = 1;
}

parseVar('curPage', $curPage, '@list.sortable.init');

// Drag & drop ordering
if ($_GET['sort']) {
    dbSort($table, $_GET['sort']);
    parseBlock('@list.sortable.restore');
}

// Change status for field
if ($_GET['set_status']) {
    dbStatus($table, $_GET['set_status']);
    redirectURL($curPage . returnVar());
}

// Delete row with or without further verifications
if ($_GET['del']) {
    if (dbCheckDelete($table, 'parent_id', $_GET['del'])) {
        // Images delete settings
        $imagesUpload = array(
            'dir' => IMAGES_PAGE,
            'thumbs' => array(
                THUMB_MEDIUM => array(),
                THUMB_FACEBOOK => array()
            )
        );

        formUploadDelete($imagesUpload, $table, $_GET['del']);

        $result = dbDelete($table, array('id' => $_GET['del']));

        if ($result === false) {
            alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
        } else {
            alertsAdd('Stergerea a fost realizata cu success!');
        }
    } else {
        alertsAdd('Entitatea are deja asociate alte entitati.', 'error');
    }

    redirectURL($curPage . returnVar());
}

// Filters
if ($_GET['title']) {
    $title = dbEscape('%' . htmlspecialchars($_GET['title']) . '%');
    $where .= " AND title LIKE {$title}";
}

if ($_GET['parent_id']) {
    $where .= ' AND parent_id = ' . dbEscape($_GET['parent_id']);
}

if (strlen($_GET['status'])) {
    $where .= ' AND status = ' . dbEscape($_GET['status']);
}

if ($_GET['date_start']) {
    $where .= ' AND date >= ' . strtotime($_GET['date_start']);
}

if ($_GET['date_end']) {
    $where .= ' AND date < ' . strtotime('+1 day', strtotime($_GET['date_end']));
}

// List rows
$listRows = dbShiftKey(dbSelect("COUNT(id)", $table, $where));
$list = dbSelect(
    '*',
    $table,
    $where,
    'ord ASC',
    '',
    !$_GET['export'] ? dbLimit($nrOnPage) : ''
);

// Parents
$parents = dbSelect('id, name', $table, 'parent_id = 0', 'ord ASC');

// Status
$statusYesNo = array(
    '0' => array(
        'class' => 'text-danger',
        'key' => 'NU'
    ),
    '1' => array(
        'class' => 'text-success',
        'key' => 'DA'
    )
);

// Init datepicker
formDatepicker('date_start');
formDatepicker('date_end');

// Init select2
formSelect2(array(
    'id' => 'type',
    'options' => array(
        'width' => '100%'
    )
));

// Export
if ($_GET['export']) {
    $fileName = "export_" . date('d.m.Y_H.i', time());

    header("Content-type: application/csv");
    header('Content-Type: text/html; charset=utf-8');
    header("Content-Disposition: attachment; filename={$fileName}.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    $header = [
        'id' => 'ID',
        'name' => 'Nume',
        'status' => 'Status'
    ];

    $csvList = array();
    foreach ($list as $i => $row) {
        $csvList[] = $row;
    }

    echo printCSV($header, $csvList);
    die;
}
