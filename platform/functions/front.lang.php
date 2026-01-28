<?php

if (!function_exists('getLang')) {
    function getLang()
    {
        static $lang;

        if ($languages = getVar('languages')) {
            if (!$lang) {
                if ($_GET['lang'] && array_key_exists($_GET['lang'], $languages)) {
                    $lang = $_GET['lang'];
                } else {
                    reset($languages);
                    $lang = key($languages);
                }

                $langaugeSettings = getVar('languageSettings');
                if ($langaugeSettings['locale'][$lang]) {
                    setlocale(LC_TIME, $langaugeSettings['locale'][$lang]);
                }
            }
        }

        return $lang;
    }
}

if (!function_exists('getLangUrl')) {
    function getLangUrl($lang, $id_page, $id_subpage, $id_entity = array())
    {
        global $websiteURL;

        if ($lang == LANG_DEFAULT && !$id_page) {
            return $websiteURL;
        }

        $link = $websiteURL . $lang . '/' . $id_page['url_key_' . $lang];

        if ($id_subpage) {
            $link .= '/' . $id_subpage['url_key_' . $lang];
        }

        if ($id_entity) {
            $link .= '/' . $id_entity['url_key_' . $lang];
        }

        return $link;
    }
}

function tLang($text)
{
    static $translations;

    if (getLang() && 0) {
        if (!isset($translations)) {
            $translations = array();
            $translationsDb = dbSelect('*', 'cms_translations');
            foreach ($translationsDb as $row) {
                $translations[$row['text_ro']] = $row['text_' . getLang()];
            }
        }

        if (is_null($translations[$text])) {
            $translations[$text] = $text;
            dbInsert('cms_translations', backParseLang(array('text' => $text), 'cms_translations', 'text'));
        }

        return $translations[$text];
    } else {
        return $text;
    }
}

function parseLang($row, $table, $recursive = false)
{
    global $dbTables;

    if (getLang() && $row && $dbTables[$table]['lang']) {
        if (!$recursive) {
            foreach ($dbTables[$table]['lang'] as $field) {
                $row[$field] = $row[$field . '_' . getLang()];

                if ($field == 'metadata') {
                    if (strlen($row[$field])) {
                        $row[$field] = unserialize($row[$field], ['allowed_classes' => false]);
                    } else {
                        $row[$field] = array();
                    }
                }
            }
        } else {
            foreach ($row as $i => $row2) {
                $row[$i] = parseLang($row2, $table);
            }
        }
    }

    return $row;
}

function backParseLang($row, $table, $crossLangField = '', $editField = 'id')
{
    global $dbTables;

    if (getLang() && $row) {
        foreach ($dbTables[$table]['lang'] as $field) {
            if (isset($row[$field])) {
                $row[$field . '_' . getLang()] = $row[$field];

                if ($field == 'metadata') {
                    if (isset($row[$field]) && is_array($row[$field])) {
                        $row[$field . '_' . getLang()] = serialize($row[$field]);
                    } else {
                        $row[$field . '_' . getLang()] = serialize(array());
                    }
                }

                if ($crossLangField == $field && !$row[$editField]) {
                    foreach (getVar('languages') as $l => $langName) {
                        $row[$field . '_' . $l] = $row[$field];
                    }
                }
            }
        }
    }

    return $row;
}

function fieldsToLang($fields, $table)
{
    global $dbTables;

    if (getLang() && $dbTables[$table]['lang']) {
        if (!is_array($fields)) {
            $fields = explode(',', $fields);
            $fields = array_map('trim', $fields);
        }

        foreach ($fields as $i => $field) {

            $prefix = '';
            $field = explode('.', $field);

            if (strlen($field[1])) {
                $prefix = $field[0] . '.';
                $field = $field[1];
            } else {
                $field = $field[0];
            }

            if (in_array($field, $dbTables[$table]['lang'])) {
                $fields[$i] = $prefix . $field . '_' . getLang();
            }
        }

        $fields = implode(', ', $fields);
    }

    return $fields;
}