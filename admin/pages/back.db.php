<?php

//$languages = getVar('languages');

$r = dbRunQuery("SHOW TABLES FROM `{$cfg__['db']['main']['db']}`");
$tables = array();
if ($r !== false) {
    while ($row = mysqli_fetch_array($r)) {
        $r2 = dbRunQuery("SHOW COLUMNS FROM {$row[0]}");
        while ($row2 = mysqli_fetch_assoc($r2)) {
            $tables[$row[0]]['fields'][] = $row2['Field'];

            if ($languages) {
                if (substr($row2['Field'], -3, 1) == '_' && array_key_exists(substr($row2['Field'], -2), $languages)) {
                    $fieldLang = substr($row2['Field'], 0, -3);
                } else {
                    $fieldLang = $row2['Field'];
                }

                $tables[$row[0]]['fields_lang'][] = $fieldLang;
            }
        }

        if ($languages) {
            $tables[$row[0]]['fields_lang'] = array_unique($tables[$row[0]]['fields_lang']);
        }
    }
}

if ($_POST['tables']) {
    $dbTables = array();
    foreach ($_POST['tables'] as $key) {
        $exclude = $_POST['tables_exclude'][$key];
        if (!$exclude) {
            $exclude = array();
        }

        $dbTables[$key]['fields'] = $tables[$key]['fields'];
        $dbTables[$key]['exclude'] = $exclude;

        if ($languages) {
            $langs = $_POST['tables_lang'][$key];
            if (!$langs) {
                $langs = array();
            }

            $dbTables[$key]['lang'] = $langs;
        }
    }


    $export = '<?php $dbTables = ' . var_export($dbTables, true) . '; ?>';
    $result = file_put_contents(PLATFORM_PATH . '/config/db.tables.php', $export);

    // Notifications
    if ($result === false) {
        alertsAdd('Datele nu au putut fi salvate!', 'error');
    } else {
        alertsAdd('Datele au fost salvate cu success!');
    }

    // Redirect
    formRedirect('index.php?page=back.db', 0);
}
