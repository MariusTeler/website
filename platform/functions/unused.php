<?php

function uploadByCurl($url, $table, $id, $imagesUpload)
{
    $tmpDir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
    $file = current(explode(',', $url));
    $fileTmp = $tmpDir . '/' . 'feed_' . time();

    if (getByCurl($file, $fileTmp)) {
        $_POST['imageKey'] = time();
        sessionSet($_POST['imageKey'], array(
            'name' => $file,
            'tmp_name' => $fileTmp,
        ));
        formUploadResize($table, $id, $imagesUpload);
    }
}

// Get file by CURL with URL provided
function getByCurl($url, $file = '')
{
    global $curlTime, $curlErr;

    $url = str_replace(' ', '%20', $url);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($ch, CURLOPT_USERAGENT,
        'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/3.0');
    //curl_setopt($ch, CURLOPT_REFERER, 'http://www.sibela.ro/');

    if ($file) {
        $f = fopen($file, 'w');
        curl_setopt($ch, CURLOPT_FILE, $f);
        curl_exec($ch);
        $curlErr = curl_error($ch);
        $curlTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        fclose($f);
        if (is_file($file) && filesize($file) && strlen($type) && ($type == 'image/jpeg' || $type == 'image/gif' || $type == 'image/png')) {
            chmod($file, 0777);
            return true;
        } else {
            if (is_file($file)) {
                unlink($file);
            }

            return false;
        }
    } else {
        $ch_get = curl_exec($ch);
    }

    $curlErr = curl_error($ch);
    $curlTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
    curl_close($ch);

    return $ch_get;
}

/**
 * @param $array
 * @param $value
 * @param string $key
 * @return array
 */
function extractByKey($array, $value, $key = 'id')
{
    foreach ($array as $row) {
        if ($row[$key] == $value) {
            return $row;
        }
    }

    return array();
}

/**
 * @param string $type
 * @param array $additionalFields
 * @param string $additionalWhere
 * @param string $table
 * @return array|bool|mixed|mysqli_result
 */
function categoriesByType($type = '', $additionalFields = array(), $additionalWhere = '', $table = 'cms_pages')
{
    // Original select
    $select = "{$table}.id, {$table}.url_key, p.id AS id_subpage, p.url_key AS url_key_subpage";

    // Default select for known case
    if ($table == 'cms_pages') {
        $additionalFields = array_merge($additionalFields, array('link_name', 'name'));
    }

    // Add fields to original select
    foreach ($additionalFields as $field) {
        $select .= ", {$table}.{$field}, p.{$field} AS {$field}_subpage";
    }

    // Add where clause
    $where = "{$table}.id_parent = 0";

    if ($type) {
        $where .= " AND {$table}.type = " . dbEscape($type);
    }

    if ($additionalWhere) {
        $where .= $additionalWhere;
    }

    // Query database
    $categories = dbSelect($select, "{$table} LEFT JOIN {$table} AS p ON {$table}.id = p.id_parent", $where,
        "{$table}.ord ASC, p.ord ASC");

    return $categories;
}

/**
 * @param $categories
 * @return array
 */
function categoriesById($categories)
{
    $categoriesById = array();

    foreach ($categories as $row) {
        if (!$categoriesById[$row['id']]) {
            $categoriesById[$row['id']] = array(
                'link_name' => $row['link_name'],
                'url_key' => $row['url_key'],
                'name' => $row['name']
            );
        }

        if ($row['id_subpage'] && !$categoriesById[$row['id_subpage']]) {
            $categoriesById[$row['id_subpage']] = array(
                'link_name' => $row['link_name_subpage'],
                'url_key' => $row['url_key_subpage'],
                'name' => $row['name_subpage'],
                'id_parent' => $row['id']
            );
        }
    }

    return $categoriesById;
}