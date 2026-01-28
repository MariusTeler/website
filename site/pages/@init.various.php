<?php

// List counter
$variousCount = getVar('variousCount');
$variousCount++;
parseVar('variousCount', $variousCount);

// List (query DB only once)
$variousList = getVar('variousList');

if (!$variousList) {
    // Current page
    $id_page = getVar('id_page', getPage());
    $entityId = $id_page['id'];

    // Current subpage
    $id_subpage = getVar('id_subpage', getPage());
    $entityId = $id_subpage ? $id_subpage['id'] : $entityId;

    // Blog post
    $id_blog = getVar('id_blog', getPage());
    $entityId = $id_blog ? $id_blog['id'] : $entityId;

    // Entity type
    $entityType = $id_blog ? ENTITY_BLOG : ENTITY_PAGE;

    // Get various list
    $variousList = dbSelect(
        'v.*',
        'cms_various v 
            JOIN cms_relation r ON v.id = r.module_id',
        'v.status = 1 
            AND v.type != ""
            AND r.entity_id = ' . dbEscape($entityId) . ' 
            AND r.entity = ' . dbEscape($entityType) . '
            AND r.module = ' . dbEscape(ENTITY_VARIOUS),
        'v.type ASC, v.title ASC',
        'v.id'
    );

    $variousList = array_column($variousList, null, 'id');

    // Save for later use of block
    parseVar('variousList', $variousList);
}

// Set view
$HTML = '';
$blockId = getVar('blockId', $p__);
if ($variousList[$blockId]) {
    $various = $variousList[$blockId];

    // $view = '@init.various';
    $view = 'cms.various.' . $various['type'];

    switch ($various['type']) {
        case VARIOUS_BLOG:
            parseVar('isHome', getVar('isHome', getPage()), $view);
            parseVar('various', $various, $view);
            $HTML = parseBlock($view);
            $view = '@init.various';
            break;
        case VARIOUS_CONTACT:
        case VARIOUS_CONTACT_BUSINESS:
            parseVar('various', $various, 'cms.contact');
            setView('cms.contact', $view);
            $HTML = parseBlock('cms.contact');
            $view = '@init.various';
            break;
        case VARIOUS_COVERAGE:
        case VARIOUS_HERO:
        case VARIOUS_CALCULATOR:
        case VARIOUS_SEND:
            parseVar('various', $various, $view);
            $HTML = parseBlock($view);
            $view = '@init.various';
            break;
    }

    setView($p__, $view);
}

// Home flag
$isHome = getVar('isHome', getPage());
