<?php

// Current entity
$entityType = getVar('entityType', $p__);
$entityId = getVar('entityId', $p__);

// Relation between module and entities
$entityRelation = [
    ENTITY_PAGE => [
        'entities' => [],
        'relation' => []
    ],
    ENTITY_BLOG => [
        'entities' => [],
        'relation' => []
    ]
];

$entityRelationDB = dbSelect(
    '*',
    'cms_relation',
    'module = ' . dbEscape($entityType) . ' AND module_id = ' . dbEscape($entityId)
);

foreach ($entityRelationDB as $rel) {
    $entityRelation[$rel['entity']]['relation'][] = $rel['entity_id'];
}

// Pages
$pagesAll = dbSelect(
    'id, parent_id, type, name, url_key, title, link_name, is_noindex',
    'cms_pages',
    '',
    'parent_id ASC, ord ASC'
);
$pagesAll = array_column($pagesAll, null, 'id');

$pages = [];
foreach ($pagesAll as $page) {
    if (!$page['parent_id']) {
        $pages[$page['id']] = $page;
        $pages[$page['id']]['children'] = [];
    } else {
        $pages[$page['parent_id']]['children'][$page['id']] = $page;
    }
}
$entityRelation[ENTITY_PAGE]['entities'] = $pages;

// Blog
$blog = dbSelect('id, title AS link_name', 'blog', '', 'date_publish DESC');
$entityRelation[ENTITY_BLOG]['entities'] = $blog;

parseVar('entityRelation', $entityRelation, $p__);
