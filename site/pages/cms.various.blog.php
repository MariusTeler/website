<?php

$where = ' AND b.is_evergreen = 1';
$limit = '0,3';

if (getVar('title', $p__)) {
    $title = getVar('title', $p__);
}

if (getVar('isHome', $p__)) {
    $where .= ' AND b.is_home = 1';
}

$id_blog = getVar('id_blog', getPage());
if ($id_blog) {
    $where .= ' AND b.id != ' . dbEscape($id_blog['id']);
}

if (getVar('limit', $p__)) {
    $limit = '0, ' . (int)getVar('limit', $p__);
}

// Blog list
$blogList = dbSelect(
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['fields'],
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['tables'],
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['where'] . $where,
    'b.date_publish DESC',
    '',
    $limit
);
