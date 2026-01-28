<?
// Setup sitemaps list
$sitemaps = array(
    'sitemap-categories.xml',
    'sitemap-blog.xml'
);

// Parse $sitemaps variable to view
parseVar('sitemaps', $sitemaps, getPage());

// Init $items
$items = array();

// If sitemap type is set
if($_GET['type'] && in_array($_GET['type'], $sitemaps)) {

    // Sitemap for categories
    if($_GET['type'] == 'sitemap-categories.xml') {
        $categories = dbSelect(
            'id, parent_id, type, name, url_key, title, link_name, is_noindex',
            'cms_pages',
            'status = 1',
            'parent_id ASC, ord ASC'
        );
        $categories = array_column($categories, null, 'id');

        $items[] = array(
            'loc' => $websiteURL,
            'changefreq' => 'daily',
            'priority' => '1.0',
        );

        foreach ($categories AS $row) {
            if (
                !$row['is_noindex']
                && !in_array($row['name'], array('home', '404', 'login'))
            ) {
                $row['url_key'] = rawurlencode($row['url_key']);

                if (!$row['parent_id']) {
                    $url = makeLink(
                        LINK_ABSOLUTE,
                        rawurlencode($row['url_key'])
                    );
                } else {
                    $url = makeLink(
                        LINK_ABSOLUTE,
                        rawurlencode($categories[$row['parent_id']]['url_key']),
                        rawurlencode($row['url_key'])
                    );
                }

                $items[] = array(
                    'loc' => htmlspecialchars($url),
                    'changefreq' => 'daily',
                    'priority' => '0.2',
                );
            }
        }
    }

    // Sitemap for blog
    if ($_GET['type'] == 'sitemap-blog.xml') {
        // Blog list
        $blogList = dbSelect(
            $cfg__['category']['select'][PAGE_TYPE_BLOG]['fields'] . ', b.date_update',
            $cfg__['category']['select'][PAGE_TYPE_BLOG]['tables'],
            $cfg__['category']['select'][PAGE_TYPE_BLOG]['where'] . ' AND b.is_noindex = 0',
            'b.date_publish DESC'
        );

        foreach ($blogList as $row) {
            $items[] = array(
                'loc' => htmlspecialchars(blogLink(LINK_ABSOLUTE, $row)),
                'changefreq' => 'weekly',
                'priority' => '0.6',
                'lastmod' => date('c', $row['date_update'] ?: $row['date_publish'])
            );
        }
    }

    // Parse $items to view
    parseVar('items', $items, getPage());
}

/*$items[] = array(
    'loc' => '',
    'changefreq' => '',
    'priority' => '',
    'lastmod' => '',
    'image' => array(
        'loc' => '',
        'caption' => ''
    )
);*/
?>
<?= parseView(getPage()) ?>
<? die; ?>