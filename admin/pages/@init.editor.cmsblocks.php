<?php

$blocks = [];

// List of blocks for each entity
foreach (ENTITY_MODULES_TABLES as $entityType => $dbTable) {
    $dbFields = 'id as value, title as text, type';
    $dbWhere = '';
    $dbOrd = 'ord ASC';

    if ($entityType == ENTITY_VARIOUS) {
        $dbWhere = "type != ''";
        $dbOrd = 'type ASC, title ASC';
    }

    $list = dbSelect($dbFields, $dbTable, $dbWhere, $dbOrd);

    $types = $entityType == ENTITY_VARIOUS ? VARIOUS_TYPES : LIST_TYPES;
    $list = array_map(function($row) use ($types) {
        $row['text'] = $types[$row['type']] . ' > ' . $row['text'];
        unset($row['type']);

        return $row;
    },$list);

    $blocks[] = [
        'value' => $entityType,
        'text' => ENTITY_TYPES[$entityType],
        'list' => $list,
        'page' => ENTITY_MODULES_PAGES[$entityType]
    ];
}

echo json_encode($blocks, JSON_NUMERIC_CHECK);

die;
