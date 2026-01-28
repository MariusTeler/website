<?php

global $curPage, $listRows;

$counties = dbSelect('*', 'nomen_county', '', 'name ASC');
$countiesIds = array_column($counties, null, 'id');

$countyId = (int)$_GET['county_id'];

if ($countyId && $countiesIds[$countyId]) {
    $county = $countiesIds[$countyId];
} else {
    redirectURL($websiteURL . 'index.php?county_id=' . $counties[0]['id'] . '&page=' . $_GET['page']);
}

$table = 'nomen_city';
$curPage = $websiteURL . 'index.php?county_id=' . $countyId . '&page=' . $_GET['page'];
$where = 'county_id = ' . dbEscape($countyId);

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

// Filters
if ($_GET['name']) {
    $where .= ' AND name LIKE ' . dbEscape('%' . $_GET['name'] . '%');
}

// List rows
$list = dbSelect('*', $table, $where, 'name ASC');
$listRows = count($list);

// Init select2
formSelect2(array(
    'id' => 'county_id',
    'options' => array(
        'width' => '100%'
    )
));
