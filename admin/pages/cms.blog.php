<?php

global $curPage, $nrOnPage, $listRows;

$table = 'blog';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$tables = "{$table} b 
            LEFT JOIN blog_author b_a ON b_a.id = b.author_id
            LEFT JOIN cms_pages p ON p.id = b.page_id
            LEFT JOIN blog_visit_counter b_v ON b_v.blog_id = b.id";
$where = '1';
$order = 'b.date_publish DESC, b.id DESC';
$nrOnPage = 10;
if (!$_GET['page_nr']) {
    $_GET['page_nr'] = 1;
}

// Pages
$pagesById = $pagesChildren = [];
dbGetWithChildren(
    $pagesById,
    $pagesChildren,
    'id, parent_id, link_name',
    'cms_pages',
    'type = ' . dbEscape(PAGE_TYPE_BLOG)
);

// Change status for field
if ($_GET['set_is_noindex']) {
    $r = dbStatus($table, $_GET['set_is_noindex'], 'is_noindex');

    // Log action
    if ($r) {
        userActionStatus(
            $_GET['set_is_noindex'],
            ENTITY_BLOG,
            $table,
            'is_noindex',
            ['Nu', 'Da']
        );
    }

    redirectURL($curPage . returnVar());
}

if ($_GET['set_is_home']) {
    $r = dbStatus($table, $_GET['set_is_home'], 'is_home');

    // Log action
    if ($r) {
        userActionStatus(
            $_GET['set_is_home'],
            ENTITY_BLOG,
            $table,
            'is_home',
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
            ENTITY_BLOG,
            $table,
            'status',
            STATUS_TYPES
        );
    }

    redirectURL($curPage . returnVar());
}

// Delete row with or without further verifications
if ($_GET['del']) {
    // Images delete settings
    $imagesUpload = array(
        'dir' => IMAGES_BLOG,
        'thumbs' => array(
            THUMB_MEDIUM => array(),
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
        entityDeleteRelations(ENTITY_BLOG, $_GET['del']);
    }

    redirectURL($curPage . returnVar());
}

// Filters
if ($_GET['title']) {
    $where .= ' AND b.title LIKE ' . dbEscape('%' . $_GET['title'] . '%');
}

// Filters
if ($_GET['text']) {
    $text = dbEscape('%' . htmlspecialchars($_GET['text']) . '%');
    $where .= " AND (
                    b.title LIKE {$text} 
                    OR b.title_facebook LIKE {$text} 
                )";
}

if ($_GET['page_id']) {
    $pageIds = [$_GET['page_id']];
    if ($pagesChildren[$_GET['page_id']]) {
        $pageIds = array_merge(
            $pageIds,
            array_column($pagesChildren[$_GET['page_id']], 'id')
        );
    }

    $where .= ' AND b.page_id IN (' . dbEscapeIn($pageIds) . ')';
}

if ($_GET['author_id']) {
    $where .= ' AND b.author_id = ' . dbEscape($_GET['author_id']);
}

if ($_GET['date_start']) {
    $where .= ' AND b.date_publish >= ' . strtotime($_GET['date_start']);
}

if ($_GET['date_end']) {
    $where .= ' AND b.date_publish < ' . strtotime('+1 day', strtotime($_GET['date_end']));
}

if (strlen($_GET['status'])) {
    $where .= ' AND b.status = ' . dbEscape($_GET['status']);
}

if (strlen($_GET['outbound'])) {
    if ($_GET['outbound']) {
        $where .= " AND b.outbound > 0 ";
    } else {
        $where .= " AND b.outbound = 0 ";
    }
}

if ($_GET['seo']) {
    switch ($_GET['seo']) {
        case 'title':
            $where .= " AND TRIM(b.site_title) = ''";
            break;
        case 'description':
            $where .= " AND TRIM(b.site_description) = ''";
            break;
        case 'description_short':
            $where .= " AND CHAR_LENGTH(TRIM(b.site_description)) < 50 AND TRIM(b.site_description) != ''";
            break;
        default:
            break;
    }
}

// Order
$sort = array(
    array(
        'key' => 'Vizite Descrescator',
        'field' => 'b_v.visits',
        'direction' => 'DESC'
    ),
    array(
        'key' => 'Vizite Crescator',
        'field' => 'b_v.visits',
        'direction' => 'ASC'
    )
);

if (strlen($_GET['sort']) && $sort[$_GET['sort']]) {
    $order = $sort[$_GET['sort']]['field'] . ' ' . $sort[$_GET['sort']]['direction'];
}

// List rows
$listRows = dbShiftKey(dbSelect("COUNT(b.id)", $tables, $where));
$list = dbSelect(
    'b.*, b_a.name AS author, p.parent_id AS page_parent_id, b_v.visits',
    $tables,
    $where,
    $order,
    '',
    dbLimit($nrOnPage)
);

// Authors
$authors = dbSelect('id, name', 'blog_author', '', 'name ASC');

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

// SEO
$seo = array(
    'title' => 'Fara SEO Title',
    'description' => 'Fara SEO Description',
    'description_short' => 'SEO Description Scurt',
);

// Init datepicker
formDatepicker('date_start');
formDatepicker('date_end');

// Init select2
formSelect2(array(
    'id' => 'page_id',
    'options' => array(
        'width' => '100%'
    )
));

formSelect2(array(
    'id' => 'author_id',
    'options' => array(
        'width' => '100%'
    )
));
