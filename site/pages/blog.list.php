<?php

// Current page
$id_page = getVar('id_page', getPage());

// Current subpage
$id_subpage = getVar('id_subpage', getPage());

// No of blog posts per page
$nrOnPage = settingsGet('blog-per-page');

// Canonical pagination
$canonicalPagination = '';

// Filter conditions
$where = '';

// Get CMS content
if ($id_subpage) {
    $cms = $id_subpage;
    $canonicalLink = makeLink(LINK_ABSOLUTE, $id_page, $id_subpage);
    $pageLink = makeLink(LINK_RELATIVE, $id_page, $id_subpage);
    $where = ' AND b.page_id = ' . dbEscape($cms['id']);
} else {
    $cms = $id_page;
    $canonicalLink = makeLink(LINK_ABSOLUTE, $id_page);
    $pageLink = makeLink(LINK_RELATIVE, $id_page);
    $where = ' AND (p.id = ' . dbEscape($cms['id']) . ' OR p.parent_id = ' . dbEscape($cms['id']) . ')';
}

// Pagination
$articlesNo = dbShiftKey(dbSelect(
    "COUNT(b.id)",
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['tables'],
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['where'] . $where
));
$pages = ceil($articlesNo / $nrOnPage);
if(!($page_nr = getVar('page_nr', getPage()))) {
    $page_nr = 1;
}

if($page_nr != 1) {
    $cms['site_title'] = $cms['site_title'] . ' - Pagina ' . $page_nr;
    $cms['site_description'] = $cms['site_description'] . ' - Pagina ' . $page_nr;
    $canonicalPagination = '/pagina/' . $page_nr;
}

// Facebook og:
$cms['fbURL'] = $canonicalLink;
$cms['fbTitle'] = $cms['title'] ?: $cms['link_name'];
$cms['fbDescription'] = $cms['site_description'];
$cms['fbImage'] = imageLink(IMAGES_PAGE, THUMB_FACEBOOK, $cms['image'], LINK_ABSOLUTE);

// Canonical
$cms['siteCanonical'] = $canonicalLink . $canonicalPagination;

// SEO tags
parseSEO($cms, array('title', 'link_name'));

// Blog list
$blogList = dbSelect(
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['fields'],
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['tables'],
    $cfg__['category']['select'][PAGE_TYPE_BLOG]['where'] . $where,
    'b.date_publish DESC',
    '',
    (($page_nr - 1) * $nrOnPage) . ',' . $nrOnPage
);
