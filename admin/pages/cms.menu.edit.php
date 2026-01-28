<?php

global $retPage;

$table = 'cms_menu';
$retPage = 'index.php?' . http_build_query([
    'identifier' => $_GET['identifier'],
    'page' => str_replace('.edit', '', $_GET['page'])
]); // auto

if (!MENU_TYPES[$_GET['identifier']]) {
    alertsAdd('Tip invalid!', 'error');

    $menuIdentifiers = array_keys(MENU_TYPES);
    redirectURL($retPage . buildHttpQuery(['identifier' => reset($menuIdentifiers)], [], true));
}

// Pages
$pages = $pagesChildren = [];
dbGetWithChildren($pages, $pagesChildren);

// Main menus
$menu = dbSelect(
    'm.id, IF(LENGTH(m.link_name), m.link_name, p.link_name) AS link_name',
    "{$table} m LEFT JOIN cms_pages p ON p.id = m.page_id",
    'm.parent_id = 0 AND m.identifier = ' . dbEscape($_GET['identifier']),
    'm.ord ASC'
);

// Old data
if ($_GET['edit']) {
    $oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
}

// Form validation
formInit('editForm',
    array(
        'type' => array(
            'required' => true
        ),
        'page_id' => array(
            'required' => "function(element){
                return ($(element.form).find(\"[name='type']:checked\").val() == 'page_id');
            }"
        ),
        'link' => array(
            'required' => "function(element){
                return ($(element.form).find(\"[name='type']:checked\").val() == 'link');
            }"
        ),
        'link_name' => array(
            'required' => "function(element){
                return ($(element.form).find(\"[name='type']:checked\").val() == 'link');
            }"
        )
    ),
    array(
        'type' => array(
            'required' => ''
        )
    )
);

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm')) {
        // Init ordering index
        if (!$_GET['edit'] || $oldPost['parent_id'] != (int)$_POST['parent_id']) {
            $_POST['ord'] = dbOrderIndex(
                $table,
                'parent_id = ' . dbEscape($_POST['parent_id']) . ' AND identifier = ' . dbEscape($_GET['identifier'])
            );
        }

        // Menu identifier
        $_POST['identifier'] = $_GET['identifier'];

        if ($_POST['page_id']) {
            $_POST['link'] = '';
        }

        // Insert / Update row
        $id = dbInsert($table, $_POST);

        // Notifications
        if ($id === false) {
            alertsAdd('Datele nu au putut fi salvate!', 'error');
            $id = $_GET['edit'];
        } else {
            alertsAdd('Datele au fost salvate cu success!');

            // Log action
            $_POST['parent_id'] = (int)$_POST['parent_id'];
            $_POST['page_id'] = (int)$_POST['page_id'];

            $entitiesById = [
                'parent_id' => array_column($menu, 'link_name', 'id'),
                'page_id' => array_column($pages, 'link_name', 'id'),
                'is_popup' => ['Nu', 'Da']
            ];

            userAction($id, ENTITY_MENU, $_POST, $oldPost, $entitiesById);
        }

        // Redirect
        formRedirect($retPage, $id);
    } else {
        $eClass = '';
    }
} else {
    if ($_GET['edit']) {
        $_POST = $oldPost;
    }
}

// Icons
$icons = [];
if (settingsGet('menu-icons')) {
    $icons = explode(',', settingsGet('menu-icons'));
    $icons = array_combine($icons, $icons);
}

// Init select2
formSelect2(array(
    'id' => 'parent_id',
    'options' => array(
        'width' => '100%'
    )
));

formSelect2(array(
    'id' => 'page_id',
    'options' => array(
        'width' => '100%'
    )
));

formSelect2(array(
    'id' => 'icon',
    'options' => array(
        'width' => '100%'
    )
));
