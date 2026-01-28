<?php

// Get CMS content
$cms = getPageByKey('name', SECTION_HOME);

// Facebook og:
$cms['fbURL'] = $websiteURL;
$cms['fbTitle'] = $cms['title'] ?: $cms['link_name'];
$cms['fbDescription'] = $cms['site_description'];
$cms['fbImage'] = imageLink(IMAGES_PAGE, THUMB_FACEBOOK, $cms['image'], LINK_ABSOLUTE);

// Canonical
$cms['siteCanonical'] = $websiteURL;

// SEO tags
parseSEO($cms, array('title', 'link_name'));

parseVar('id_page', $cms, getPage());
parseVar('isHome', true, getPage());
setView(getPage(), 'cms.page');

// Content blocks
$contentBlocks = entityToHtml(ENTITY_PAGE, $cms['id'], $cms['text']);
