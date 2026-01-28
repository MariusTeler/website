<?php

global $curPage, $nrOnPage, $listRows;

$table = 'back_users_logins';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];

$tables = $table . ' b_u_l LEFT JOIN back_users b_u ON b_u_l.user_id = b_u.id';
$where = '1';
$order = 'b_u_l.date DESC';

$nrOnPage = 50;
if (!$_GET['page_nr']) {
    $_GET['page_nr'] = 1;
}

// Filters
if (strlen($_GET['id_user'])) {
    $where .= " AND b_u.id = " . dbEscape($_GET['id_user']);
}

if (strlen($_GET['user'])) {
    $search = dbEscape('%' . $_GET['user'] . '%');
    $where .= " AND (b_u_l.user LIKE {$search} OR b_u_l.email LIKE {$search})";
}

if (strlen($_GET['ip'])) {
    $where .= " AND b_u_l.ip LIKE " . dbEscape('%' . $_GET['ip'] . '%');
}

if (strlen($_GET['status'])) {
    if ($_GET['status'] == 0) {
        $where .= ' AND b_u_l.success = 1';
    } else {
        if ($_GET['status'] == '4') {
            $where .= ' AND b_u_l.suspended_until_by_user > ' . time();
        } elseif ($_GET['status'] == '5') {
            $where .= ' AND b_u_l.suspended_until_by_ip > ' . time();
        } else {
            $where .= ' AND b_u_l.error_code = ' . dbEscape($_GET['status']);
        }
    }
}

if ($_GET['data_start']) {
    $where .= " AND b_u_l.date >= " . strtotime($_GET['data_start']);
}

if ($_GET['data_end']) {
    $where .= " AND b_u_l.date < " . strtotime('+1 day', strtotime($_GET['data_end']));
}

// List rows
$listRows = dbShiftKey(dbSelect(
    "COUNT(b_u_l.id)",
    $tables,
    $where
));

$list = dbSelect(
    'b_u_l.*, b_u.name AS admin_name, b_u.email AS admin_email',
    $tables,
    $where,
    $order,
    '',
    dbLimit($nrOnPage)
);

// Users
$users = dbSelect('id, name, email', 'back_users', '', 'email ASC');

// Status codes
$status = [0 => 'Success'] + $cfg__['login']['errorCode'];

// Init datepicker
formDatepicker('data_start');
formDatepicker('data_end');

// Init select2
formSelect2(array(
    'id' => 'id_user',
    'options' => array(
        'width' => '100%'
    )
));
