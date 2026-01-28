<?php

global $curPage, $nrOnPage, $listRows;

$table = 'cms_404';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];

$tables = "{$table}";
$where = '1';
$ord = "{$table}.data DESC";

$nrOnPage = 3;
if (!$_GET['page_nr']) {
    $_GET['page_nr'] = 1;
}

// Filters
if (!$_GET['data']) {
    $_GET['data'] = date('d.m.Y');
}
if ($_GET['data']) {
    $where .= " AND {$table}.data >= " . strtotime($_GET['data']) . " AND {$table}.data < " . strtotime('tomorrow',
            strtotime($_GET['data']));
}

// List rows
$listRows = dbShiftKey(dbSelect("COUNT(DISTINCT {$table}.link)", $tables, $where));
$list = dbSelect("{$table}.*, COUNT(id) AS nr", $tables, $where, $ord, 'link', dbLimit($nrOnPage));

// Total rows
$listTotal = dbShiftKey(dbSelect('COUNT(id)', $table));

// Init calendar
formDatepicker('data');