<?php

// Current page
$id_page = getVar('id_page', getPage());

// Get CMS content
$cms = $id_page;
$canonicalLink = makeLink(LINK_ABSOLUTE, $id_page);

// Facebook og:
$cms['fbURL'] = $canonicalLink;
$cms['fbTitle'] = $cms['title'] ?: $cms['link_name'];
$cms['fbDescription'] = $cms['site_description'];
$cms['fbImage'] = imageLink(IMAGES_PAGE, THUMB_FACEBOOK, $cms['image'], LINK_ABSOLUTE);

// Canonical
$cms['siteCanonical'] = $canonicalLink;

// SEO tags
parseSEO($cms, array('title', 'link_name'));

// Authors
$authorsList = dbSelect(
    "*, image != '' AS has_image, text != '' AS has_text",
    'blog_author',
    'status = 1',
    'has_image DESC, has_text DESC, name ASC'
);
