<?php

global $curPage, $nrOnPage, $listRows;

$table = 'back_users_log';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];

$tables = $table . ' b_u_l LEFT JOIN back_users b_u ON b_u_l.user_id = b_u.id';
$where = '1';
$order = 'b_u_l.date DESC, b_u_l.id DESC';

$nrOnPage = 50;
if (!$_GET['page_nr']) {
    $_GET['page_nr'] = 1;
}

// Filters
if (strlen($_GET['id_user'])) {
    $where .= " AND b_u.id = " . dbEscape($_GET['id_user']);
}

if (strlen($_GET['user'])) {
    $where .= " AND b_u_l.user LIKE " . dbEscape('%' . $_GET['user'] . '%');
}

if (strlen($_GET['ip'])) {
    $where .= " AND b_u_l.ip LIKE " . dbEscape('%' . $_GET['ip'] . '%');
}

if (strlen($_GET['type'])) {
    $where .= " AND b_u_l.type = " . dbEscape($_GET['type']);
}

if (strlen($_GET['table'])) {
    $where .= " AND b_u_l.table_ = " . dbEscape($_GET['table']);
}

if (strlen($_GET['status'])) {
    $where .= " AND b_u_l.success = " . dbEscape($_GET['status']);
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
$status = array(
    '0' => array(
        'class' => 'text-danger',
        'key' => 'Nu'
    ),
    '1' => array(
        'class' => 'text-success',
        'key' => 'Da'
    )
);

// Tables
$tables = dbSelect('id, table_', $table, 'table_ != ""', 'table_ ASC', 'table_');
$tablesName = array(
    'nomen_city' => 'Nomenclatoare > Orase',
    'nomen_county' => 'Nomenclatoare > Judete',

    'cms_pages' => 'Continut > Pagini',
    'cms_various' => 'Continut > Blocuri',
    'cms_list' => 'Continut > Liste',
    'cms_list_row' => 'Continut > Liste > Linii',
    'cms_translations' => 'Continut > Traduceri',
    'cms_redirects' => 'Continut > Redirect',

    'blog' => 'Continut > Blog',
    'blog_author' => 'Continut > Blog - Autori',

    'back_users' => 'Utilizatori > Administratori',
    'back_users_profile' => 'Utilizatori > Profile Access',

    'back_settings' => 'Administrare > Setari',
    'back_pages' => 'Administrare > Pagini',
);

$titles = array(
    'link_name',
    'title',
    'name',
    'text'
);

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

formSelect2(array(
    'id' => 'table',
    'options' => array(
        'width' => '100%'
    )
));
