<?php

global $curPage;

$table = 'cms_pages';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];

parseVar('curPage', $curPage, '@list.sortable.init');

// Drag & drop ordering
if ($_GET['sort']) {
    dbSort($table, $_GET['sort']);
    parseBlock('@list.sortable.restore');
}

// Change status for field
if ($_GET['set_is_noindex']) {
    $r = dbStatus($table, $_GET['set_is_noindex'], 'is_noindex');

    // Log action
    if ($r) {
        userActionStatus(
            $_GET['set_is_noindex'],
            ENTITY_PAGE,
            $table,
            'is_noindex',
            ['Nu', 'Da']
        );
    }

    redirectURL($curPage . returnVar());
}

if ($_GET['set_status']) {
    $r = dbStatus($table, $_GET['set_status']);

    // Log action
    if ($r) {
        userActionStatus(
            $_GET['set_status'],
            ENTITY_PAGE,
            $table,
            'status',
            STATUS_TYPES
        );
    }

    redirectURL($curPage . returnVar());
}

// Delete row with or without further verifications
if ($_GET['del']) {
    if (
        dbCheckDelete($table, 'parent_id', $_GET['del'])
        && dbCheckDelete('cms_menu', 'page_id', $_GET['del'])
    ) {
        // Images delete settings
        $imagesUpload = array(
            'dir' => IMAGES_PAGE,
            'thumbs' => array(
                THUMB_FACEBOOK => array()
            )
        );

        // Delete image
        formUploadDelete($imagesUpload, $table, $_GET['del']);

        $result = dbDelete($table, array('id' => $_GET['del']));

        if ($result === false) {
            alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
        } else {
            alertsAdd('Stergerea a fost realizata cu success!');

            // Delete relations
            entityDeleteRelations(ENTITY_PAGE, $_GET['del']);
        }
    } else {
        alertsAdd('Pagina are deja asociate subpagini / meniuri.', 'error');
    }

    redirectURL($curPage . returnVar());
}

// List rows
$listDB = dbSelect('*', $table, '', 'ord ASC');
$list = $listChildren = array();
$countPages = $countSubpages = 0;
foreach ($listDB as $i => $row) {
    $list[$row['id']] = $row;
    $listChildren[$row['parent_id']][] = $row['id'];

    if ($row['parent_id']) {
        $countSubpages++;
    } else {
        $countPages++;
    }
}

parseVar('list', $list);
parseVar('listChildren', $listChildren);

// Options
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
