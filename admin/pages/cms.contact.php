<?php

// Render and return HTML
if ($_GET['ajax']) {
    unset($_GET['ajax']);

    // Parse page
    parseVar('isHome', true, $p__);
    parseVar('isAjax', true, 'cms.contact.list');
    parsePage(getPage());

    // Contents
    $contents = [
        [
            'id' => 'contactContainer',
            'value' => parseView($p__)
        ]
    ];

    ajaxResponse($contents);
}

global $curPage, $nrOnPage, $listRows;

$table = 'cms_contact';
$curPage = $websiteURL . 'index.php?page=' . $p__;
$where = '1';

if (getVar('isHome', $p__)) {
    setView($p__, 'cms.contact.home');
    $where .= ' AND status_id = 0';

    parseVar('isHome', true, 'cms.contact.list');
}

$nrOnPage = 10;
if (!$_GET['page_nr']) {
    $_GET['page_nr'] = 1;
}

// Filters
if ($_GET['text']) {
    $text = dbEscape('%' . htmlspecialchars($_GET['text']) . '%');
    $where .= " AND (
                    name LIKE {$text} 
                    OR phone LIKE {$text} 
                    OR email LIKE {$text} 
                    OR message LIKE {$text}
                    OR ip LIKE {$text}
                )";
}

if ($_GET['type']) {
    $where .= ' AND type = ' . dbEscape($_GET['type']);
}

if (strlen($_GET['status_id'])) {
    $where .= ' AND status_id = ' . dbEscape($_GET['status_id']);
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
    'date DESC',
    '',
    !$_GET['export'] ? dbLimit($nrOnPage) : ''
);

// Status
$status = dbSelect('*', 'nomen_status', '', 'ord ASC');
$statusById = array_column($status, null, 'id');
array_unshift($status, ['id' => 0, 'name' => 'Nou']);

// Init datepicker
formDatepicker('date_start');
formDatepicker('date_end');

// Parse variables to cms.contact.list
parseVar('list', $list, 'cms.contact.list');
parseVar('statusById', $statusById, 'cms.contact.list');
parseVar('curPage', $curPage, 'cms.contact.list');

// Export
if ($_GET['export']) {
    header("Content-type: application/csv");
    header('Content-Type: text/html; charset=utf-8');
    header("Content-Disposition: attachment; filename=raport_" . date('d.m.Y_H.i') . ".csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    $header = [
        'status' => 'Status',
        'type' => 'Tip',
        'name' => 'Nume',
        'email' => 'Email',
        'phone' => 'Telefon',
        'volume' => 'Volum zilnic de transport',
        'subject' => 'Subiect',
        'message' => 'Mesaj',
        'date' => 'Data',
        'ip' => 'IP',
    ];

    $csvList = array();
    foreach ($list as $row) {
        $csvList[] = array(
            'status' => $statusById[$row['status_id']]['name'],
            'type' => FORM_TYPES[$row['type']],
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'subject' => $row['metadata']['subject'],
            'volume' => $row['metadata']['volume'],
            'message' => htmlspecialchars_decode($row['message']),
            'date' => date('d.m.Y H:i', $row['date']),
            'ip' => $row['ip']
        );
    }

    echo printCSV($header, $csvList);
    die;
}
