<?php

// Current page
$id_page = getVar('id_page', getPage());

// Current subpage
$id_subpage = getVar('id_subpage', getPage());

// Get CMS content
$cms = $id_page;

if ($id_subpage) {
    $cms = $id_subpage;
    $canonicalLink = makeLink(LINK_ABSOLUTE, $id_page, $id_subpage);
} else {
    $canonicalLink = makeLink(LINK_ABSOLUTE, $id_page);
}

// 404
if ($id_page['name'] == SECTION_404) {
    header("HTTP/1.0 404 Not Found");
    header("Status: 404 Not Found");

    dbInsert('cms_404', array(
        'link' => $_SERVER['REQUEST_URI'],
        'data' => time(),
        'ip' => $_SERVER['REMOTE_ADDR']
    ));

    $cms = $id_page;
    //setTemplate('404');
    //setView(getPage(), 'cms.404');

    unset($canonicalLink);
}

// Facebook og:
$cms['fbURL'] = $canonicalLink;
$cms['fbTitle'] = $cms['title'] ?: $cms['link_name'];
$cms['fbDescription'] = $cms['site_description'];
$cms['fbImage'] = imageLink(IMAGES_PAGE, THUMB_FACEBOOK, $cms['image'], LINK_ABSOLUTE);

// Canonical
$cms['siteCanonical'] = $canonicalLink;

// SEO tags
parseSEO($cms, array('title', 'link_name'));

// Content blocks
$contentBlocks = entityToHtml(ENTITY_PAGE, $cms['id'], $cms['text']);
