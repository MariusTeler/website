<?php
/**
 * PHP CMS Platform
 *
 * @category
 * @package
 * @copyright Horatiu Andrei (horatiu.andrei@gmail.com)
 */

/**
 * Define platform module that is loaded
 */
const PLATFORM_MODULE = PLATFORM_MODULE_FRONT;

/**
 * Define pages/views path to admin
 */
const ADMIN_PATH = PLATFORM_PAGES . '../admin/';

/**
 * Include common settings & functions
 * @todo Short description of included files
 */
require_once('common.php');
require_once(PLATFORM_PATH . 'functions/front.php');
require_once(PLATFORM_PATH . 'functions/front.lang.php');


/**
 * Connect to main database
 */
dbConnect();


/**
 * Connect to additional databases
 */
//dbConnect('forum');


/**
 *  URL Rewrite
 */
require_once('rewrite.php');
