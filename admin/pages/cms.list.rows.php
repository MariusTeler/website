<?php

// Render and return HTML
if ($_GET['ajax'] && !$_GET['sort']) {
    unset($_GET['ajax']);

    parseVar('modal', true);
    parseVar('dataTablesLoaded', true);

    // Parse page
    parsePage(getPage());

    // Contents
    $contents = [
        [
            'id' => 'list-rows-card-body',
            'value' => parseView($p__)
        ]
    ];

    ajaxResponse($contents);
}

global $curPage;

$table = 'cms_list_row';
$curPage = $websiteURL . 'index.php?&list_id=' . ($_GET['edit'] ?: $_GET['list_id']) . '&page=cms.list.rows';
$retPage = $websiteURL . 'index.php?&edit=' . ($_GET['edit'] ?: $_GET['list_id']) . '&page=cms.list.edit';
$where = 'list_id = ' . dbEscape($_GET['edit'] ?: $_GET['list_id']);

parseVar('curPage', $curPage, '@list.sortable.init');

$imagesUpload = array(
    'dir' => IMAGES_LIST,
    'thumbs' => array(
        THUMB_SMALL => array(),
        THUMB_MEDIUM => array(),
        THUMB_LARGE => array()
    )
);

// Drag & drop ordering
if ($_GET['sort']) {
    dbSort($table, $_GET['sort']);
    unset($_GET['list_id']);
    parseBlock('@list.sortable.restore');
}

// Delete row with or without further verifications
if ($_GET['del']) {
    formUploadDelete($imagesUpload, $table, $_GET['del']);

    $result = dbDelete($table, array('id' => $_GET['del']));

    if ($result === false) {
        alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
    } else {
        alertsAdd('Stergerea a fost realizata cu success!');

        // Log action
        userActionText(
            $_GET['list_id'],
            ENTITY_LIST,
            MESSAGE_LIST_ROW_DELETE
        );

        // Update list counter
        updateListCounter($_GET['edit'] ?: $_GET['list_id']);
    }

    redirectURL($retPage . returnVar() . '#list-rows');
}

// List rows
$list = dbSelect('*', $table, $where, 'ord ASC');

// List info
$listInfo = dbShift(dbSelect(
    '*',
    'cms_list',
    'id = ' . dbEscape(($_GET['edit'] ?: $_GET['list_id']))
));

$hasImage = in_array(
    $listInfo['type'],
    [
        LIST_TESTIMONIAL,
        LIST_GALLERY,
        LIST_SERVICES_DARK,
        LIST_SERVICES_LIGHT,
        LIST_SERVICES_BIG
    ]
);

if ($hasImage) {
    $thumbImage = THUMB_SMALL;
    if (in_array(
        $listInfo['type'],
        [LIST_SERVICES_DARK, LIST_SERVICES_LIGHT, LIST_SERVICES_BIG])
    ) {
        $thumbImage = THUMB_ORIGINAL;
    }
}

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

// Support for tinyMCE
formEditor('dummy');
