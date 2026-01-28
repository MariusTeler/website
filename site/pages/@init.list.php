<?php

// List counter
$listCount = getVar('listCount');
$listCount++;
parseVar('listCount', $listCount);

// FAQ list (query DB only once)
$cmsList = getVar('cmsList');

if (!$cmsList) {
    // Current page
    $id_page = getVar('id_page', getPage());
    $entityId = $id_page['id'];

    // Current subpage
    $id_subpage = getVar('id_subpage', getPage());
    $entityId = $id_subpage ? $id_subpage['id'] : $entityId;

    // Blog post
    $id_blog = getVar('id_blog', getPage());
    $entityId = $id_blog ? $id_blog['id'] : $entityId;

    // Home
    $isHome = getVar('isHome', $p__);

    // Entity type
    $entityType = $id_blog ? ENTITY_BLOG : ENTITY_PAGE;

    // Get CMS list
    $cmsList = dbSelect(
        'l.*',
        'cms_list l 
            JOIN cms_relation r ON l.id = r.module_id',
        'l.status = 1 
            AND r.entity_id = ' . dbEscape($entityId) . ' 
            AND r.entity = ' . dbEscape($entityType) . '
            AND r.module = ' . dbEscape(ENTITY_LIST),
        'l.ord ASC',
        'l.id'
    );

    // Get rows for each list
    foreach ($cmsList as $i => $row) {
        $row['rows'] = dbSelect(
            '*',
            'cms_list_row',
            'status = 1 
                AND list_id = ' . dbEscape($row['id']) .
                ($isHome ? ' AND is_home = 1' : ''),
            'ord ASC'
        );

        $cmsList[$i] = $row;
    }

    $cmsList = array_column($cmsList, null, 'id');

    // Save for later use of block
    parseVar('cmsList', $cmsList);


    // Extract FAQ list
    $faqList = array_filter($cmsList, function ($row) {
        return $row['type'] == LIST_FAQ;
    });
    parseVar('faqList', $faqList);
    parseVar('faqCount', 0);
}

// Set view
$blockId = getVar('blockId', $p__);
if ($cmsList[$blockId]) {
    $listInfo = $cmsList[$blockId];

    switch ($listInfo['type']) {
        case LIST_FAQ:
            $view = '@init.list.faq';

            // FAQ counter
            $faqCount = getVar('faqCount');
            $faqCount++;
            parseVar('faqCount', $faqCount);

            break;
        case LIST_TESTIMONIAL:
            $view = '@init.list.testimonial';
            break;
        case LIST_GALLERY:
            $view = '@init.list.gallery';
            break;
        case LIST_JOBS:
            $view = '@init.list.jobs';
            break;
        case LIST_SERVICES_DARK:
            $view = '@init.list.services.dark';
            break;
        case LIST_SERVICES_LIGHT:
            $view = '@init.list.services.light';
            break;
        case LIST_SERVICES_BIG:
            $view = '@init.list.services.big';
            break;
        case LIST_STATS:
            $view = '@init.list.stats';
            break;
        case LIST_TIMELINE:
            $view = '@init.list.timeline';
            break;
        case LIST_CENTERS:
            $view = '@init.list.centers';
            break;
        case LIST_AREAS:
            $view = '@init.list.areas';
            break;
        default:
            $view = '@init.list';
    }
    setView($p__, $view);
}
