<?php

global $curPage;

$table = 'back_pages';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$where = "id_parent = '0' ";

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
    if (dbCheckDelete($table, 'id_parent', $_GET['del'])) {
        $result = dbDelete($table, array('id' => $_GET['del']));

        if ($result === false) {
            alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
        } else {
            alertsAdd('Stergerea a fost realizata cu success!');
        }
    } else {
        alertsAdd('Pagina are deja asociate subpagini.', 'error');
    }

    redirectURL($curPage . returnVar());
}

// List rows
$list = dbSelect('*', $table, $where, 'ord ASC');
foreach ($list as $i => $row) {
    $list[$i]['subpages'] = dbSelect('id, page, name, status', $table, 'id_parent = ' . dbEscape($row['id']),
        'ord ASC');
}
