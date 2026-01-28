<?php

global $dbTables;

$table = $_POST['unique_table'];
$fieldName = $_POST['unique_field_name'];
$fieldWhereName = $_POST['unique_where_name'];
$fieldWhereName2 = $_POST['unique_where_name2'];

if (
    !$dbTables[$table]
    || !$fieldName
    || !in_array($fieldName, $dbTables[$table]['fields'])
    || ($fieldWhereName && !in_array($fieldWhereName, $dbTables[$table]['fields']))
    || ($fieldWhereName2 && !in_array($fieldWhereName2, $dbTables[$table]['fields']))
) {
    echo 'false';
    die;
}

if ($dbTables[$table] &&
    !in_array($fieldName, $dbTables[$table]['exclude'])) {
    $_POST[$fieldName] = htmlspecialchars($_POST[$fieldName]);
}


$where = array();
if ($fieldWhereName) {
    $where[] = $fieldWhereName . '=' . dbEscape($_POST['unique_where_value']);
}

if ($fieldWhereName2) {
    $where[] = $fieldWhereName2 . '=' . dbEscape($_POST['unique_where_value2']);
}

if (dbUnique(
    $table,
    $fieldName,
    $_POST[$fieldName],
    $_POST['unique_id'],
    implode(' AND ', $where)
)) {
    echo 'true';
} else {
    echo 'false';
}

die;
