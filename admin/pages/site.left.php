<?php

global $cfg__;

$activeMenu = activeMenu();

if ($_GET['ajax'] && (int)$_GET['id']) {
    if (in_array($_GET['id'], $activeMenu)) {
        unset($activeMenu[array_search((int)$_GET['id'], $activeMenu)]);
    } else {
        array_push($activeMenu, (int)$_GET['id']);
    }

    $metadata = userGetInfo('metadata');
    $metadata['active_menu'] = $activeMenu;

    dbInsert('back_users', array(
        'id' => userGetInfo('id'),
        'metadata' => $metadata,
        '_no_admin_log' => $cfg__['session'][$cfg__['session']['default']]
    ));

    die();
}

$adminMenuRes = $cfg__['varsGlobal']['adminMenu'];
if (!userGetAccess(ADMIN_SUPERADMIN)) {
    $adminMenuRes = array();
    $adminAccess = $cfg__['varsGlobal']['adminAccess'];
    foreach ($cfg__['varsGlobal']['adminMenu'] as $cat) {
        foreach ($cat['pages'] as $page => $name) {
            if (!in_array(htmlspecialchars_decode($page), $adminAccess)) {
                unset($cat['pages'][$page]);
            }
        }

        if ($cat['pages']) {
            $adminMenuRes[] = $cat;
        }
    }
}

if ($_GET['dt_length'] && $_GET['dt_page']) {
    $adminMetadata = userGetInfo('metadata');
    $adminMetadata['datatable'][$_GET['dt_page']] = $_GET['dt_length'];

    dbInsert('back_users', [
        'id' => userGetInfo('id'),
        'metadata' => $adminMetadata
    ]);
}
