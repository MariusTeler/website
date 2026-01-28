<?php
/**
 * PHP CMS Platform
 *
 * @category
 * @package
 * @copyright Horatiu Andrei (horatiu.andrei@gmail.com)
 */

/**
 *  Start timer
 */
$timeStart__ = microtime(true);


/**
 * Error reporting (default settings)
 * To modify please check front.php
 */
ini_set('display_errors', 'off');
ini_set('error_log', dirname(__FILE__) . '/error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);


/**
 * Define default & pages/views path: PLATFORM_PATH & PLATFORM_PAGES
 * Define env flag: PLATFORM_ENV
 */
$dirName = dirname(__FILE__);
define("PLATFORM_PATH", $dirName . '/../platform/');
define("PLATFORM_PAGES", $dirName . '/');
define("UPLOAD_PATH", $dirName . '/../public/uploads/');
define("PLATFORM_ENV", file_exists($dirName . '/../env'));

/**
 * Platform modules
 */
const PLATFORM_MODULE_FRONT = 'front';
const PLATFORM_MODULE_ADMIN = 'admin';

/**
 * Include specific configuration
 */
require_once(PLATFORM_PATH . 'config/admin.php');


/**
 * Login & logout
 */
if (strlen($cfg__['login']['settings']['table']) && !$argv) {
    if ($_GET['page'] == 'logout') {
        userLogout();
    }

    if ($_POST['goLogin'] && $cfg__['login']['settings']['user_pass']) {
        userLogin();
    } elseif (!userGet()) {
        if (!$_GET['ajax']) {
            sessionSet('loginRedirectSuccess', $_SERVER['REQUEST_URI']);
        } elseif ($_GET['page'] != 'login') {
            ajaxResponse([
                [
                    'id' => 'ajaxAlert',
                    'value' => parseView('login.alert')
                ]
            ]);
        }

        setTemplate('default.login');
        setPage('login');
        unset($_GET['page']);
    } else {
        adminAccess();
    }
}


/**
 * Cron jobs
 */
if ($argv) {
    $_GET['page'] = 'cron.' . $argv[1];
}


/**
 * @todo Page parsing
 */
parseAll();
