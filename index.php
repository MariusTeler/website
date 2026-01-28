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
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);


/**
 * Define default & pages/views path: PLATFORM_PATH & PLATFORM_PAGES
 * Define env flag: PLATFORM_ENV
 */
$dirName = dirname(__FILE__);
define("PLATFORM_PATH", $dirName . '/platform/');
define("PLATFORM_PAGES", $dirName . '/site/');
define("PLATFORM_ENV", file_exists($dirName . '/env'));

/**
 * Platform modules
 */
const PLATFORM_MODULE_FRONT = 'front';
const PLATFORM_MODULE_ADMIN = 'admin';

/**
 * Include specific configuration
 */
require_once(PLATFORM_PATH . 'config/front.php');


/**
 * Login & logout
 */
if (strlen($cfg__['login']['settings']['table'])) {
    //if($_GET['page'] == 'logout')
    //userLogout();

    if ($_POST['goLogin'] && $cfg__['login']['settings']['user_pass']) {
        userLogin();
        //sessionSet('loginRedirectSuccess', $_SERVER['REQUEST_URI']);
    }
    //elseif(!userGet())
    //setTemplate('login');
}


/**
 * @todo Page parsing
 */
parseAll();
