<?php

redirectSite();

if (strlen($_GET['req'])) {
    $req = explode('/', $_GET['req']);
    if (substr($_GET['req'], -1) == '/') {
        array_pop($req);
    }
    parseDebug($req);

    // Skip 404 flag
    $skip404 = false;

    // Skip Req
    $rewriteSkipReq = array();

    if ($languages = getVar('languages')) {
        if (array_key_exists($req[0], $languages)) {
            $_GET['lang'] = $req[0];
            unset($req[0]);
            $req = array_values($req);
        }
    }

    switch ($req[0]) {

        // Random image
        case 'rand':
            $_GET['page'] = 'rand.img';
            $_GET['id_rand'] = $req[1];

            $skip404 = true;
            break;

        // CMS Pages
        default:
            $rewriteStatus = 'status = 1';
            $rewriteDBKey = 'url_key';

            rewritePage(
                $req,
                array(
                    rewriteOption('cms_pages', 'id_page', 'cms.page', '', 'parent_id = 0'),
                    rewriteOption('cms_pages', 'id_subpage', 'cms.page', 'parent_id'),
                    rewriteOption('blog', 'id_blog', 'blog.post', 'page_id', '', $rewriteStatus, $rewriteDBKey, ['blog.list']),
                    rewriteOption('blog_author', 'id_author', 'blog.author', '', '', $rewriteStatus, $rewriteDBKey, ['blog.authors'])
                )
            );

            break;
    }

    if ($req) {
        // Pagination
        if ($i = array_search('pagina', $req)) {
            if (is_numeric($req[$i + 1])) {
                parseVar('page_nr', $req[$i + 1], $_GET['page']);
                unset($req[$i + 1]);
            }
        }

        // Search
        if (end($req) == 'cautare') {
            $_GET['page'] = 'search';

            $skip404 = true;
        }

        // Sitemap
        if (
            !$_GET['page']
            && count($req) == 1
            && substr($req[0], -4) == '.xml'
            && strpos($req[0], 'sitemap') !== false
        ) {
            $_GET['page'] = 'sitemap';
            $_GET['type'] = $req[0];

            $skip404 = true;
        }

        // Generate 404 if no page found or number of arguments & parsed variables mismatch
        if (!$skip404) {
            if (!$_GET['page'] || count($cfg__['varsPage'][$_GET['page']]) != count($req)) {
                $_GET['page'] = 'cms.page';
                parseVar('id_page', getPageByKey('name', '404'), $_GET['page']);
            }
        }
    }
}

parseDebug('', 'URL Rewrite');
