<?php

global $curPage;

$table = 'cms_menu';
$curPage = $websiteURL . 'index.php?' . http_build_query([
    'identifier' => $_GET['identifier'],
    'page' => $_GET['page']
]);
$where = '1';

// Default menu identifier
if (!$_GET['identifier']) {
    $menuIdentifiers = array_keys(MENU_TYPES);
    redirectURL($curPage . buildHttpQuery(['identifier' => reset($menuIdentifiers)], [], true));
}

parseVar('curPage', $curPage, '@list.sortable.init');

// Drag & drop ordering
if ($_GET['sort']) {
    dbSort($table, $_GET['sort']);
    parseBlock('@list.sortable.restore');
}

// Delete row with or without further verifications
if ($_GET['del']) {
    if (dbCheckDelete($table, 'parent_id', $_GET['del'])) {
        $result = dbDelete($table, array('id' => $_GET['del']));

        if ($result === false) {
            alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
        } else {
            alertsAdd('Stergerea a fost realizata cu success!');
        }
    } else {
        alertsAdd('Meniul are deja asociate submeniuri.', 'error');
    }

    redirectURL($curPage . returnVar());
}

// Pages
$pages = dbSelect(
    'id, url_key',
    'cms_pages',
    'parent_id = 0',
    'ord ASC'
);
$pages = array_column($pages, null, 'id');

// Filters
if ($_GET['identifier']) {
    $where .= ' AND m.identifier = ' . dbEscape($_GET['identifier']);
}

// List rows
$listDB = dbSelect(
    'm.*, p.parent_id AS page_parent_id, p.link_name AS p_link_name, p.url_key, p.status',
    "{$table} m LEFT JOIN cms_pages p ON p.id = m.page_id",
    $where,
    'm.ord ASC'
);
$listRows = count($listDB);

$list = $listChildren = array();
$countMenu = $countSubmenu = 0;
foreach ($listDB as $i => $row) {
    // Build link
    if (!$row['link']) {
        if ($row['page_parent_id']) {
            $row['link'] = makeLink(LINK_RELATIVE, $pages[$row['page_parent_id']], $row);
        } else {
            $row['link'] = makeLink(LINK_RELATIVE, $row);
        }
    } elseif (substr($row['link'], 0, 1) == '#') {
        $row['link'] = '/' . $row['link'];
    }

    $list[$row['id']] = $row;
    $listChildren[$row['parent_id']][] = $row['id'];

    if ($row['parent_id']) {
        $countSubmenu++;
    } else {
        $countMenu++;
    }
}

parseVar('list', $list);
parseVar('listChildren', $listChildren);
