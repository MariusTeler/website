<?php

global $curPage, $nrOnPage, $listRows;

$table = 'back_users';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$where = "1";
$nrOnPage = 10;
if (!$_GET['page_nr']) {
    $_GET['page_nr'] = 1;
}

// Change status for field
if ($_GET['set_status']) {
    $r = dbStatus($table, $_GET['set_status']);

    // Log action
    if ($r) {
        $status = dbShiftKey(dbSelect(
            'status',
            $table,
            'id = ' . dbEscape($_GET['set_status'])
        ));

        // Save text message
        userAction(
            $_GET['set_status'],
            ENTITY_BACK_USER,
            ['status' => $status],
            [],
            ['status' => STATUS_TYPES]
        );
    }

    redirectURL($curPage . returnVar());
}

// Delete row with or without further verifications
if ($_GET['del']) {
    $result = dbDelete($table, array('id' => $_GET['del']));

    if ($result === false) {
        alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
    } else {
        alertsAdd('Stergerea a fost realizata cu success!');
    }

    redirectURL($curPage . returnVar());
}

// Filters
if (strlen($_GET['access'])) {
    $where .= " AND {$table}.access = " . dbEscape($_GET['access']);
}

if ($_GET['name']) {
    $search = dbEscape('%' . $_GET['name'] . '%');
    $where .= " AND ({$table}.name LIKE {$search} OR {$table}.email LIKE {$search})";
}

if (strlen($_GET['status'])) {
    $where .= " AND {$table}.status = " . dbEscape($_GET['status']);
}

// List rows
$listRows = dbShiftKey(dbSelect("COUNT({$table}.id)", $table, $where));
$list = dbSelect("
    {$table}.*,
    (SELECT l.date
        FROM back_users_logins l
        WHERE l.user_id = {$table}.id AND l.success = 1
        ORDER BY l.date DESC
        LIMIT 0,1
    ) AS last_login,
    (SELECT l.suspended_until_by_user
        FROM back_users_logins l
        WHERE l.user_id = {$table}.id AND l.suspended_until_by_user > " . time() . "
        ORDER BY l.date DESC
        LIMIT 0,1
    ) AS suspended_until",
    $table,
    $where,
    "{$table}.name ASC",
    '',
    dbLimit($nrOnPage)
);

// Options
$status = array(
    '0' => array(
        'class' => 'text-danger',
        'key' => 'Inactiv'
    ),
    '1' => array(
        'class' => 'text-success',
        'key' => 'Activ'
    )
);
