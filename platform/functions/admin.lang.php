<?php

function getLang()
{
    static $lang;

    if ($languages = getVar('languages')) {
        if (!$lang) {
            if ($_GET['lang'] && array_key_exists($_GET['lang'], $languages)) {
                $lang = $_GET['lang'];
            } elseif (sessionGet('lang') && array_key_exists(sessionGet('lang'), $languages)) {
                $lang = sessionGet('lang');
            } else {
                reset($languages);
                $lang = key($languages);
            }

            sessionSet('lang', $lang);
        }
    }

    return $lang;
}

function getLangUrl()
{
    static $url;

    if (!$url) {
        parse_str($_SERVER['QUERY_STRING'], $query);
        unset($query['lang']);
        $query = http_build_query($query);
        $url = '/admin/index.php?' . $query;
    }

    return $url;
}