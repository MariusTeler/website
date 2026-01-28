<?php
/**
 * Connect to database
 *
 * @param string $conn Database identifier as defined in configuration array, defaults to 'main'
 * @param string $charset Database connection charset, defaults to 'utf8'
 */
function dbConnect($conn = 'main', $charset = 'utf8mb4')
{
    global $cfg__;

    $cfg__['db'][$conn]['conn'] = mysqli_connect(
        $cfg__['db'][$conn]['host'],
        $cfg__['db'][$conn]['user'],
        $cfg__['db'][$conn]['pass'],
        $cfg__['db'][$conn]['db']
    );

    if (mysqli_connect_errno()) {
        parseDebug(mysqli_connect_error(), 'DB Connection: ' . $conn);
        die();
    }

    if (!mysqli_set_charset($cfg__['db'][$conn]['conn'], $charset)) {
        parseDebug('Charset not set for connection: ' . $conn);
    }

    dbRunQuery("SET SESSION sql_mode = 'ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
}

/**
 * Execute SQL query
 *
 * @param $q SQL query
 * @param string $conn Database connection, defaults to 'main'
 * @return mixed|bool|mysqli_result Returns false if an error has occurred
 */
function dbRunQuery($q, $conn = 'main')
{
    global $cfg__;

    $qStart = microtime(true);
    $r = mysqli_query($cfg__['db'][$conn]['conn'], $q);
    $qEnd = microtime(true);

    if ($r !== false) {
        if ($cfg__['debug']['on']) {
            parseDebug('[Rows: ' . mysqli_affected_rows($cfg__['db'][$conn]['conn']) . '] [Time: ' . round($qEnd - $qStart,
                    4) . '] ' . $q);
        }
    } else {
        $backTrace = debug_backtrace();
        //$backTrace = $backTrace[0]['file'];
        $backTrace = implode(array_reduce($backTrace, function ($carry, $item) {
            $carry[] = implode(' ', [$item['file'], 'on line', $item['line']]);

            return $carry;
        }, array()), "\n");

        error_log("\nQuery: " . $q . "\nError: " . mysqli_error($cfg__['db'][$conn]['conn']) . "\nFile: " .
            $backTrace . "\n");

        if ($cfg__['debug']['on']) {
            parseDebug($q . '<br />[Error: ' . mysqli_error($cfg__['db'][$conn]['conn']) . ' ]<br />[File: ' .
                $backTrace . ' ]');
        }
    }

    return $r;
}

/**
 * Get number of affected rows
 *
 * @param string $conn Database connection, defaults to 'main'
 * @return int The number of affected rows in a previous MySQL operation
 */
function dbAffectedRows($conn = 'main')
{
    global $cfg__;

    return mysqli_affected_rows($cfg__['db'][$conn]['conn']);
}

/**
 * Construct and execute a DELETE query
 *
 * @param string $table Table that holds rows to be deleted
 * @param string|array $where Where condition(s) as part of SQL query. Also supports array of fields, with column name as key and value.
 * @param string $whereGlue The query glue to join conditions where conditions together if an array was provided as $where param. Defaults to 'AND'
 * @param false $children Also delete children (not implemented)
 * @param string $conn Database connection, defaults to 'main'
 * @return mixed|bool|mysqli_result Returns false if an error has occurred
 */
function dbDelete($table, $where, $whereGlue = 'AND', $children = false, $conn = 'main')
{
    global $argv;

    // Check user rights
    if (PLATFORM_MODULE == PLATFORM_MODULE_ADMIN && !$argv) {
        if (!userGetRight(ADMIN_RIGHT_DELETE, $_SERVER['REQUEST_URI'])) {
            return false;
        }
    }

    if (is_array($where)) {
        $w = array();
        foreach ($where as $k => $v) {
            $w[] = $k . ' = ' . dbEscape($v, $conn);
        }

        $where = implode(' ' . $whereGlue . ' ', $w);
    }

    // Data for user log
    if (PLATFORM_MODULE == PLATFORM_MODULE_ADMIN && !$argv) {
        $data = array();
        $data['rows'] = dbShiftKey(dbSelect('COUNT(id)', $table, $where));
        $data['row'] = dbShift(dbSelect('*', $table, $where, '', '', '0,1'));
        $data['where'] = $where;
    }

    $r = dbRunQuery('DELETE FROM ' . $table . ' WHERE ' . $where, $conn);

    // User log
    if (PLATFORM_MODULE == PLATFORM_MODULE_ADMIN && !$argv) {
        dbLog($table, ADMIN_ACTION_DELETE, ($r === false ?: true), $data);
    }

    return $r;

    /**
     * @todo Delete with children
     */
}

/**
 * Construct and execute an UPDATE or INSERT SQL query
 *
 * @param string $table Table that needs insert / update
 * @param array $values Array of fields, with column name as key and value. If id field is provided, then an update operation will be executed on the corresponding row
 * @param string $idField Id field used for update, defaults to 'id'
 * @param string $conn Database connection, defaults to 'main'
 * @return false|int|mixed|string Id of the corresponding row. Returns false if an error has occurred
 */
function dbInsert($table, $values, $idField = 'id', $conn = 'main')
{
    global $cfg__, $dbTables, $argv;

    $id = $values[$idField];
    $qFields = $qValues = array();

    // Data for user log
    if (PLATFORM_MODULE == PLATFORM_MODULE_ADMIN) {
        $data = array();

        // Get old row data for UPDATE
        if ($id) {
            $data['row_old'] = dbShift(dbSelect('*', $table, $idField . " = " . dbEscape($id, $conn)));
        } else {
            $data['row']['id'] = $id;
        }
    }

    foreach ($dbTables[$table]['fields'] as $field) {
        if ($field != $idField && isset($values[$field])) {
            $value = $values[$field];
            if (!in_array($field, $dbTables[$table]['exclude'])) {
                $value = htmlspecialchars($value);
            }

            if ($field == 'metadata') {
                if (is_array($value)) {
                    $value = serialize($value);
                } else {
                    $value = serialize(array());
                }
            }

            if ($id) {
                $qValues[] = $field . ' = ' . dbEscape($value, $conn);
            } else {
                $qFields[] = $field;
                $qValues[] = dbEscape($value, $conn);
            }

            // Data for user log
            if (PLATFORM_MODULE == PLATFORM_MODULE_ADMIN) {
                if ($field == 'metadata') {
                    $value = unserialize($value, ['allowed_classes' => false]);
                }

                $data['row'][$field] = $value;
            }
        }
    }

    if ($id) {
        $q = 'UPDATE ' . $table . ' SET ' . implode(', ', $qValues) . ' WHERE ' . $idField . " = " . dbEscape($id,
                $conn);
    } else {
        $q = 'INSERT INTO ' . $table . ' (' . implode(', ', $qFields) . ') VALUES (' . implode(', ', $qValues) . ')';
    }

    $r = dbRunQuery($q, $conn);

    // User log
    if (PLATFORM_MODULE == PLATFORM_MODULE_ADMIN
        && $table != 'back_users_log'
        && $table != 'back_users_logins'
        && $table != 'user_action'
        && $table != 'user_action_text'
        && array_keys($values) != array('id', 'ord')
        && array_keys($values) != array('id', 'active_menu')
        && $values['_no_admin_log'] != $cfg__['session'][$cfg__['session']['default']]
        && !$argv
    ) {

        $success = false;
        $type = !$id ? ADMIN_ACTION_CREATE : ADMIN_ACTION_UPDATE;

        if ($r !== false) {
            $success = true;

            // In order to avoid wrong redirect to last inserted id from back_users_log table
            if (!$id) {
                $id = mysqli_insert_id($cfg__['db'][$conn]['conn']);
            }

            // Get DB date if insert / update was successful
            $data['row'] = dbShift(dbSelect('*', $table, $idField . " = " . dbEscape($id, $conn)));
        }

        dbLog($table, $type, $success, $data);
    }

    if ($r !== false) {
        if ($id) {
            return $id;
        } else {
            return mysqli_insert_id($cfg__['db'][$conn]['conn']);
        }
    } else {
        return $r;
    }
}

/**
 * Construct and execute a SELECT SQL query, using parts that are formatted as a query
 *
 * @param string $fields Fields list, separated by comma
 * @param string $table Table or multiple tables joined
 * @param string $where Where condition(s)
 * @param string $order Order by
 * @param string $group Group by
 * @param string $limit Limit
 * @param string $having Having condition(s)
 * @param string $conn Database connection, defaults to 'main'
 * @return array|false Array of rows, each row containing column name as key and value. Returns false if an error has occurred
 */
function dbSelect($fields, $table, $where = '', $order = '', $group = '', $limit = '', $having = '', $conn = 'main')
{
    $q = "SELECT {$fields} FROM {$table}";
    if ($where) {
        $q .= ' WHERE ' . $where;
    }
    if ($group) {
        $q .= ' GROUP BY ' . $group;
    }
    if ($having) {
        $q .= ' HAVING ' . $having;
    }
    if ($order) {
        $q .= ' ORDER BY ' . $order;
    }
    if ($limit) {
        $q .= ' LIMIT ' . $limit;
    }

    $r = dbRunQuery($q, $conn);
    if ($r !== false) {
        $arr = array();
        while ($row = mysqli_fetch_assoc($r)) {
            foreach ($row as $key => $val) {
                $row[$key] = stripslashes($val);

                if ($key == 'metadata') {
                    if (strlen($row[$key])) {
                        $row[$key] = unserialize($row[$key], ['allowed_classes' => false]);
                    } else {
                        $row[$key] = array();
                    }
                }
            }

            $arr[] = $row;
        }

        /*if (count($arr) == 1 && count($arr[0]) == 1) {
            $arr = current($arr[0]);
        }*/

        return $arr;
    } else {
        return $r;
    }
}

/**
 * Escapes special characters in a string for use in an SQL statement
 *
 * @param string $str Text to be escaped
 * @param string $conn Database connection, defaults to 'main'
 * @return string Escaped string, between single quotes
 */
function dbEscape($str, $conn = 'main')
{
    global $cfg__;

    return "'" . mysqli_real_escape_string($cfg__['db'][$conn]['conn'], $str) . "'";
}

/**
 * Escapes special characters in a list of strings for use in an IN SQL statement
 *
 * @param array $arr Array of strings to be escaped
 * @param string $conn Database connection, defaults to 'main'
 * @return string Escaped strings separated by comma
 */
function dbEscapeIn($arr, $conn = 'main')
{
    $arr = array_map(function ($val) {
        return dbEscape($val);
    }, $arr);

    return implode(',', $arr);
}

/**
 * Return first row from an array of selected rows
 *
 * @param array $arr Array of rows after dbSelect() function
 * @return array|mixed First row of the array or empty array if parameter $arr is empty
 */
function dbShift($arr)
{
    if (count($arr)) {
        return $arr[0];
    } else {
        return array();
    }
}

/**
 * Return a value from the first row of selected rows
 *
 * @param array $arr Array of rows after dbSelect() function
 * @param string $key Key that indicates which value to return from first row.
 *                    If empty, first value from row will be returned.
 *                    Defaults to empty string.
 * @return mixed|string Value found using $key
 */
function dbShiftKey($arr, $key = '')
{
    $value = '';

    if ($arr) {
        $arr = array_shift($arr);

        if (!$key) {
            $value = reset($arr);
        } else {
            $value = $arr[$key];
        }
    }

    return $value;
}

/**
 * Check if a value for a column is unique in a table
 *
 * @param string $table Table to check
 * @param string $field Column to check
 * @param string $value Value to check
 * @param int $id Id for the current row that contains the specified $value
 * @param string $where Additional query conditions
 * @param string $idField Id field used to check if existing row matches current row, defaults to 'id'
 * @return bool Return true if the value is unique or false otherwise
 */
function dbUnique($table, $field, $value, $id, $where = '', $idField = 'id')
{
    if (strlen($where)) {
        $where = ' AND ' . $where;
    }

    $newId = dbShiftKey(dbSelect(
        $idField,
        $table,
        $field . ' = ' . dbEscape(trim($value)) . $where,
        '',
        '',
        '0,1'
    ));

    if ($newId && $newId != $id) {
        return false;
    }

    return true;
}

/**
 * Convert special characters to HTML entities for values in single or multidimensional array
 *
 * @param array $row Array of values or multidimensional array
 * @return array
 */
function dbSpecialChars($row)
{
    if ($row) {
        foreach ($row as $key => $val) {
            if (!is_array($val)) {
                $row[$key] = htmlspecialchars($val);
            } else {
                $row[$key] = dbSpecialChars($val);
            }
        }
    }

    return $row;
}

/**
 * Strip HTML and PHP tags from from values in single or multidimensional array
 *
 * @param array $row Array of values or multidimensional array
 * @return array
 */
function dbStripTags($row)
{
    foreach ($row as $key => $val) {
        if (!is_array($val)) {
            $row[$key] = strip_tags($val);
        } else {
            $row[$key] = dbStripTags($val);
        }
    }

    return $row;
}
