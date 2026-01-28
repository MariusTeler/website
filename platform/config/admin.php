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
const PLATFORM_MODULE = PLATFORM_MODULE_ADMIN;


/**
 * Include common settings & functions
 * @todo Short description of included files
 */
require_once('common.php');
require_once(PLATFORM_PATH . 'functions/admin.php');
require_once(PLATFORM_PATH . 'functions/admin.lang.php');
require_once(PLATFORM_PATH . 'functions/front.php');


/**
 * Connect to main database
 */
dbConnect();


/**
 * Connect to additional databases
 */
//dbConnect('forum');


/**
 * Default title
 */
parseVar('siteTitle', $cfg__['cms']['title']);

/**
 * Admin user types
 */
const ADMIN_NORMAL = 0;
const ADMIN_SUPERADMIN = 1;

const ADMIN_TYPES = [
    ADMIN_NORMAL => 'Normal',
    ADMIN_SUPERADMIN => 'Superadmin',
];

/**
 * Admin rights
 */
const ADMIN_RIGHT_VIEW = 1;
const ADMIN_RIGHT_ADD = 2;
const ADMIN_RIGHT_EDIT = 3;
const ADMIN_RIGHT_DELETE = 4;

const ADMIN_RIGHTS = [
    ADMIN_RIGHT_VIEW => 'Vizualizare',
    ADMIN_RIGHT_ADD => 'Adaugare',
    ADMIN_RIGHT_EDIT => 'Modificare',
    ADMIN_RIGHT_DELETE => 'Stergere',
];

/**
 * Gallery types
 */
const GALLERY_TYPES = array(
    GALLERY_LANDSCAPE => array(
        'name' => 'Landscape',
        'thumbs' => array(
            THUMB_SMALL => array('140', '90'),
            THUMB_LARGE => array('800', '600')
        )
    ),
    GALLERY_PORTRAIT => array(
        'name' => 'Portrait',
        'thumbs' => array(
            THUMB_SMALL => array('100', '134'),
            THUMB_LARGE => array('800', '600')
        )
    ),
    GALLERY_CAROUSEL_DESKTOP => array(
        'name' => 'Carousel desktop',
        'thumbs' => array(
            THUMB_SMALL => array('288', '100'),
            THUMB_LARGE => array('1920', '667')
        )
    ),
    GALLERY_CAROUSEL_MOBILE => array(
        'name' => 'Carousel mobile',
        'thumbs' => array(
            THUMB_SMALL => array('67', '100'),
            THUMB_LARGE => array('480', '720')
        )
    )
);

/**
 * Color types
 */
const COLOR_SUCCESS = 1;
const COLOR_INFO = 2;
const COLOR_PRIMARY = 3;
const COLOR_WARNING = 4;
const COLOR_DANGER = 5;

const COLOR_TYPES = [
    COLOR_SUCCESS => 'Verde',
    COLOR_INFO => 'Albastru',
    COLOR_PRIMARY => 'Violet',
    COLOR_WARNING => 'Orange',
    COLOR_DANGER => 'Rosu'
];

const COLOR_CLASSES = [
    COLOR_SUCCESS => 'text-success',
    COLOR_INFO => 'text-info',
    COLOR_PRIMARY => 'text-primary',
    COLOR_WARNING => 'text-warning',
    COLOR_DANGER => 'text-danger'
];

/**
 * Graph types
 */
const GRAPH_TYPE_DAY = 1;
const GRAPH_TYPE_WEEK = 2;
const GRAPH_TYPE_MONTH = 3;

const GRAPH_TYPES = [
    GRAPH_TYPE_DAY => 'Pe zi',
    GRAPH_TYPE_WEEK => 'Pe saptamana',
    GRAPH_TYPE_MONTH => 'Pe luna'
];

/**
 * Admin action types
 */
const ADMIN_ACTION_CREATE = 0;
const ADMIN_ACTION_UPDATE = 1;
const ADMIN_ACTION_DELETE = 2;
const ADMIN_ACTION_STATUS = 3;
const ADMIN_ACTION_ORDER = 4;

const ADMIN_ACTION_TYPES = array(
    ADMIN_ACTION_CREATE => 'Creare',
    ADMIN_ACTION_UPDATE => 'Modificare',
    ADMIN_ACTION_DELETE => 'Stergere',
    ADMIN_ACTION_STATUS => 'Stare',
    ADMIN_ACTION_ORDER => 'Ordonare',
);
