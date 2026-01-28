<?php

// Current page
$id_page = getVar('id_page', getPage());

// Current subpage
$id_subpage = getVar('id_subpage', getPage());

// Blog post
$id_blog = getVar('id_blog', getPage());

// Autor
$authorPage = getPageByKey('type', PAGE_TYPE_AUTHOR, true, 'url_key');
$author = dbShift(dbSelect(
        'name, url_key, image, status, profile_facebook, profile_title',
        'blog_author',
        'id = ' . dbEscape($id_blog['author_id'])
));

// Facebook og:
$id_blog['fbURL'] = blogLink(LINK_ABSOLUTE, $id_blog);
$id_blog['fbTitle'] = $id_blog['title_facebook'] ?: $id_blog['title'];
$id_blog['fbDescription'] = $id_blog['text_intro'] ?: $id_blog['site_description'];
$id_blog['fbImage'] = imageLink(IMAGES_BLOG, THUMB_FACEBOOK, $id_blog['image'], LINK_ABSOLUTE);
$id_blog['fbImageWidth'] = 1200;
$id_blog['fbImageHeight'] = 630;
$id_blog['fbType'] = 'article';
$id_blog['fbAuthor'] = $author['profile_facebook'];
$id_blog['fbPublishedTime'] = date('c', $id_blog['date_publish']);
$id_blog['fbModifiedTime'] = $id_blog['date_update'] ? date('c', $id_blog['date_update']) : '';

// Canonical
$id_blog['siteCanonical'] = $id_blog['site_canonical'] ?: $id_blog['fbURL'];

// SEO tags
parseSEO($id_blog, array('title'));

// Count new visit
countVisit('blog_visit_counter', 'blog_visit', $id_blog['id'], 'blog_id', settingsGet('blog-visit-time'));

// Links summary from H2 tags
if ($id_blog['is_toc']) {
    global $titleLinks;

    $nText = 0;
    $titleLinks = array();
    $newText = preg_replace_callback('/\<h2(.*?)\>(.*?)\<\/h2\>/s', function($matches) {
        global $titleLinks;

        $link = rewriteEnc(strip_tags($matches[2]));
        $titleLinks[] = '<li><a href="#' . $link . '" class="text-decoration-none">' . strip_tags($matches[2]) . '</a></li>';

        return '<a id="' . $link . '"></a>' . $matches[0];
    }, $id_blog['text'], -1, $nText);

    if ($newText && $nText) {
        $id_blog['text'] = $newText;
        $id_blog['title_links'] = $titleLinks;
    }
}

parseVar('id_blog', $id_blog);

// Content blocks
$contentBlocks = entityToHtml(ENTITY_BLOG, $id_blog['id'], $id_blog['text']);
