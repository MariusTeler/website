<?php

// Search box results
if (strlen(trim($_GET['q']))) {
    $q = dbEscape('%' . $_GET['q'] . '%');

    $nrOnPage = 30;
    if (!(int)$_GET['page_nr']) {
        $_GET['page_nr'] = 1;
    }

    $table = 'cms_pages';
    $where = fieldsToLang('title', $table) . " LIKE {$q} OR " . fieldsToLang('text', $table) . " LIKE {$q}";

    $listRows = dbShiftKey(dbSelect("COUNT({$table}.id)", $table, $where));
    $list = dbSelect('*', $table, $where, '', '', dbLimit($nrOnPage));

    $data = array(
        'per_page' => $nrOnPage,
        'total_count' => $listRows,
        'items' => $list
    );

    echo json_encode($data);
}

die;
