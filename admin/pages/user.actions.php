<?php

global $retPage;

$entityId = getVar('entityId', $p__);
$entityType = getVar('entityType', $p__);

if ($entityId && $entityType) {
    $fields = 'u_a_t.*, b_u.name AS user';
    $tables = 'user_action_text u_a_t 
                LEFT JOIN user_action u_a ON u_a.id = u_a_t.user_action_id
                LEFT JOIN back_users b_u ON b_u.id = u_a_t.back_user_id';
    $where = 'u_a.entity_type = ' . dbEscape($entityType) . ' AND u_a.entity_id = ' . dbEscape($entityId);
    //$order = 'u_a_t.date ASC';
    $order = 'u_a_t.date DESC, u_a_t.id DESC';

    $messages = dbSelect(
        $fields,
        $tables,
        $where,
        $order
    );
}

$messageIcons = [
    MESSAGE_TEXT => [
        'icon' => 'message',
        'color' => 'success'
    ],
    MESSAGE_ADD => [
        'icon' => 'add',
        'color' => 'success',
    ],
    MESSAGE_DELETE => [
        'icon' => 'delete',
        'color' => 'danger',
    ],
    MESSAGE_RESTORE => [
        'icon' => 'restore_from_trash',
        'color' => 'warning',
    ],
    MESSAGE_STATUS => [
        'icon' => 'update',
        'color' => 'primary',
    ],
    MESSAGE_UPDATE => [
        'icon' => 'edit',
        'color' => 'info',
    ],
    MESSAGE_PASSWORD_RESET => [
        'icon' => 'forward_to_inbox',
        'color' => 'warning',
    ],
    MESSAGE_ACCOUNT_NEW => [
        'icon' => 'forward_to_inbox',
        'color' => 'warning',
    ],
    MESSAGE_ARCHIVE => [
        'icon' => 'inventory_2',
        'color' => 'danger',
    ],
    MESSAGE_IMAGE => [
        'icon' => 'add_photo_alternate',
        'color' => 'warning',
    ],
    MESSAGE_GALLERY_DELETE => [
        'icon' => 'image_not_supported',
        'color' => 'danger',
    ],
    MESSAGE_GALLERY_ADD => [
        'icon' => 'add_photo_alternate',
        'color' => 'success',
    ],
    MESSAGE_GALLERY_UPDATE => [
        'icon' => 'cameraswitch',
        'color' => 'info',
    ],
    MESSAGE_REDIRECT => [
        'icon' => 'directions',
        'color' => 'danger',
    ],
    MESSAGE_LIST_ROW_DELETE => [
        'icon' => 'playlist_remove',
        'color' => 'danger',
    ],
    MESSAGE_LIST_ROW_ADD => [
        'icon' => 'playlist_add',
        'color' => 'success',
    ],
    MESSAGE_LIST_ROW_UPDATE => [
        'icon' => 'edit_note',
        'color' => 'info',
    ]
];
