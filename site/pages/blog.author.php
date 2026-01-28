<?php

// Current page
$id_page = getVar('id_page', getPage());

// Author
$id_author = getVar('id_author', getPage());

// Facebook og:
$id_author['fbURL'] = makeLink(LINK_ABSOLUTE, $id_page, $id_author);
$id_author['fbTitle'] = $id_author['name'];
$id_author['fbDescription'] = shortText($id_author['text'], 250, true);
$id_author['fbImage'] = imageLink(IMAGES_AUTHOR, THUMB_SMALL, $id_author['image'], LINK_ABSOLUTE);

// Canonical
$id_author['siteCanonical'] = $id_author['fbURL'];

// SEO tags
parseSEO($id_author, array('name'));

// Blog list
$blogList = dbSelect(
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['fields'],
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['tables'],
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['where'] . ' AND b.author_id = ' . dbEscape($id_author['id']),
    'b.date_publish DESC'
);
