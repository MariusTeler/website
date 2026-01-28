<?php
/**
 * PHP CMS Platform
 *
 * @category
 * @package
 * @copyright Horatiu Andrei (horatiu.andrei@gmail.com)
 */

/**
 * Set headers & start session
 */
session_start();
header("Content-Type: text/html; charset=utf-8");
header_remove('x-powered-by');

/**
 * Set timezone & locale for date
 */
date_default_timezone_set('Europe/Bucharest');
setlocale(LC_TIME, 'ro_RO.utf8');
setlocale(LC_CTYPE, 'C');

/**
 * Constants for languages
 */
const LANG_RO = 'ro';
const LANG_EN = 'en';
const LANG_DEFAULT = LANG_RO;

/**
 * General configuration array
 */
$cfgApp__ = array(
    /**
     * Default settings (used also as production)
     */
    'production' => array(
        'common' => array(
            /**
             * Database connections (overwritten by config.php)
             */
            'db' => array(
                'main' => array(
                    'host' => '',
                    'user' => '',
                    'pass' => '',
                    'db' => ''
                ),
            ),

            /**
             * Debug settings
             */
            'debug' => array(
                'mess' => array(),
                'key' => '373',
                'on' => false
            ),

            /**
             * Containers for global & local vars
             */
            'vars' => array(),
            'varsGlobal' => array(
                /**
                 * Languages - Multilingv: comment if not used
                 */
                /*'languages' => array(
                    LANG_RO => 'Română',
                    LANG_EN => 'English'
                ),*/
                'languageSettings' => array(
                    'locale' => array(
                        LANG_RO => 'ro_RO.utf8',
                        LANG_EN => 'en_US.utf8'
                    )
                )
            ),
            'varsPage' => array(),

            /**
             * Default parsed components: template & page
             */
            'parse' => array(
                'template' => 'default',
                'page' => 'home',
                'view' => array()
            )
        ),
        'front' => array(
            /**
             * Debug settings (overwritten by config.php)
             */
            'debug' => array(
                'on' => false
            ),

            /**
             * Key used to find the session hash key inside config
             */
            'session' => array(
                'default' => 'key_front'
            ),

            /**
             * Lazy load images settings
             */
            'lazyLoad' => true,

            /**
             * Compress HTML settings
             */
            'compressHtml' => false,

            /**
             * Login settings
             */
            /*'login' => array(
                'settings' => array(
                    'table' => 'es_user',
                    'table_log' => 'es_user_logins',
                    'username' => 'email',
                    'password' => 'password',
                    'email' => 'email',
                    //'domain' => '.phprel.ro',
                    'user_pass' => true,
                    'google' => true,
                    'facebook' => true,
                    'microsoft' => true
                ),
                'errorCode' => array(
                    '1' => 'Utilizator sau parola incorecte.',
                    //'2' => 'Utilizator inactiv. Un nou link de activare a fost trimis pe adresa de email indicata. Va rugam verificati.',
                    '2' => 'Utilizator cu acces restrictionat.',
                    '3' => 'Utilizator cu acces restrictionat.',
                    '4' => 'Numarul maxim de incercari nereusite a fost atins. Asteptati 5 minute.',
                    '5' => 'Numarul maxim de incercari nereusite de la acest IP a fost atins. Asteptati 5 minute.',
                    '6' => 'A aparut o eroare.',
                )
            )*/
        ),
        'admin' => array(
            /**
             * Debug settings (overwritten by config.php)
             */
            'debug' => array(
                'on' => false
            ),

            /**
             * Key used to find the session hash key inside config
             */
            'session' => array(
                'default' => 'key_admin'
            ),

            /**
             * Login settings
             */
            'login' => array(
                'settings' => array(
                    'table' => 'back_users',
                    'table_log' => 'back_users_logins',
                    'username' => 'email',
                    'password' => 'pass',
                    'email' => 'email',
                    'user_pass' => true,
                    'google' => true,
                    'facebook' => true,
                    'microsoft' => true
                ),
                'errorCode' => array(
                    '1' => 'Utilizator sau parola incorecte.',
                    '2' => 'Utilizator inactiv.',
                    '3' => 'Utilizator cu acces restrictionat.',
                    '4' => 'Numarul maxim de incercari nereusite a fost atins. Asteptati 5 minute.',
                    '5' => 'Numarul maxim de incercari nereusite de la acest IP a fost atins. Asteptati 5 minute.',
                    '6' => 'A aparut o eroare.',
                    '7' => 'Utilizatorul nu are permisiunea de log in cu Google',
                    '8' => 'Utilizatorul nu are permisiunea de log in cu Facebook',
                    '9' => 'Utilizatorul nu are permisiunea de log in cu Microsoft'
                )
            ),

            /**
             * Container for global vars
             */
            'varsGlobal' => array(
                /**
                 * Uploadify file types settings
                 */
                'extUploadify' => array(
                    'extensions' => array(
                        'jpg',
                        'jpeg',
                        'gif',
                        'png',
                        'webp',
                        'svg',
                        'pdf',
                        'xml',
                        'doc',
                        'docx',
                        'odt',
                        'csv',
                        'xls',
                        'xlsx',
                        'ods',
                        'ppt',
                        'pptx',
                        'odp',
                    ),
                    'mimeTypes' => array(
                        'image/*',
                        'text/csv',
                        'application/pdf',
                        'application/xml',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.oasis.opendocument.text',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.oasis.opendocument.spreadsheet',
                        'application/vnd.ms-powerpoint',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'application/vnd.oasis.opendocument.presentation'
                    )
                ),

                /**
                 * Editor settings for templates
                 */
                'initEditorTemplates' => [
                    [
                        'title' => 'Tabel preturi',
                        'description' => 'Tabelul complex de la care se porneste cu lista de preturi',
                        'url' => 'index.php?page=template.prices'
                    ],
                    [
                        'title' => 'Buton programare',
                        'description' => 'Buton care la apasare va deschide formularul de programare si va trimite un event in analytics',
                        'url' => 'index.php?page=template.button'
                    ],
                    [
                        'title' => 'Numar de telefon (link)',
                        'description' => 'Link care va initia un apel si va trimite un event in analytics',
                        'url' => 'index.php?page=template.phone'
                    ]
                ],
            ),

            /**
             *  Content settings
             */
            'cms' => array(
                /**
                 * Title tag
                 */
                'title' => ''
            )
        )
    ),

    /**
     * Development settings (that override what is needed from production)
     */
    'development' => array(
        'common' => array(
            /**
             * Database connections (overwritten by config.php)
             */
            'db' => array(
                'main' => array(
                    'host' => '',
                    'user' => '',
                    'pass' => '',
                    'db' => ''
                )
            )
        ),
        'front' => array(
            /**
             * Debug settings (overwritten by config.php)
             */
            'debug' => array(
                'on' => false
            ),
            'compressHtml' => false,
        ),
        'admin' => array(
            /**
             * Debug settings (overwritten by config.php)
             */
            'debug' => array(
                'on' => false
            )
        )
    ),
);

/**
 * Include unversioned configuration array
 */
if (!$tinyMce) {
    require_once('config.php');
} else {
    require_once($incPath . 'config.php');
}


/**
 * Setup config
 */
$cfg__ = array_replace_recursive(
    $cfgApp__['production']['common'],
    $cfgAppLocal__['production']['common'],
    $cfgApp__['production'][PLATFORM_MODULE],
    $cfgAppLocal__['production'][PLATFORM_MODULE]
);

if (PLATFORM_ENV) {
    $cfg__ = array_replace_recursive(
        $cfg__,
        $cfgApp__['development']['common'],
        $cfgAppLocal__['development']['common'],
        $cfgApp__['development'][PLATFORM_MODULE],
        $cfgAppLocal__['development'][PLATFORM_MODULE]
    );
}

/**
 *  Session settings
 */
$cfg__['session']['key_front'] = md5($cfg__['db']['main']['pass'] . 'front');
$cfg__['session']['key_admin'] = md5($cfg__['db']['main']['pass'] . 'admin');


/**
 * Debug settings
 */
if (isset($_GET['debug']) && $_GET['debug'] == $cfg__['debug']['key']) {
    $cfg__['debug']['on'] = true;
}

if ($cfg__['debug']['on']) {
    ini_set('display_errors', 'on');
}


/**
 * Website URL
 * http://www.site.com/ or auto (as below)
 */
$websiteURL = ((strpos($_SERVER['SERVER_PROTOCOL'],
            'HTTPS/') === false && (!isset($_SERVER['HTTP_X_FORWARDED_PROTO']) || $_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https') && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on')) ? 'http://' : 'https://') . $_SERVER['SERVER_NAME'] . str_replace('index.php',
        '', $_SERVER['PHP_SELF']);
$cfg__['varsGlobal']['websiteURL'] = $websiteURL;

/**
 *  Constants for category types (used for url rewrite)
 */
const PAGE_TYPE_BLOG = 'blog';
const PAGE_TYPE_AUTHOR = 'author';

const PAGE_TYPES = array(
    PAGE_TYPE_BLOG => 'Blog',
    PAGE_TYPE_AUTHOR => 'Autor'
);

$cfg__['category'] = array(
    'tables' => array(),
    'pages' => array(
        PAGE_TYPE_BLOG => 'blog.list',
        PAGE_TYPE_AUTHOR => 'blog.authors',
    ),
    'select' => array(
        PAGE_TYPE_BLOG => array(
            'fields' => 'b.id, b.page_id, b.title, b.text_intro, b.url_key, b.image, b.image_timestamp, b.date_publish, 
                            b_a.name AS author,
                            p.link_name AS page, p.name AS page_name,
                            p_p.link_name AS parent_page, p_p.name AS parent_page_name',
            'tables' => 'blog b 
                            JOIN blog_author b_a ON b_a.id = b.author_id
                            JOIN cms_pages p ON p.id = b.page_id
                            LEFT JOIN cms_pages p_p ON p_p.id = p.parent_id',
            'where' => 'b.status = 1
                            AND b.date_publish < ' . time() . '
                            AND p.status = 1
                            AND (p_p.status = 1 OR p_p.status IS NULL)'
        )
    )
);

/**
 * Constants for category identifiers
 */
const SECTION_404 = '404';
const SECTION_HOME = 'home';

/**
 * Menu types
 */
const MENU_HEADER = 'header';
const MENU_FOOTER = 'footer';

const MENU_TYPES = [
    MENU_HEADER => 'Header',
    MENU_FOOTER => 'Footer'
];

/**
 * List types
 */
const LIST_FAQ = 1;
const LIST_TESTIMONIAL = 2;
const LIST_GALLERY = 3;
const LIST_JOBS = 4;
const LIST_SERVICES_DARK = 5;
const LIST_SERVICES_LIGHT = 6;
const LIST_SERVICES_BIG = 7;
const LIST_STATS = 8;
const LIST_TIMELINE = 9;
const LIST_CENTERS = 10;
const LIST_AREAS = 11;

const LIST_TYPES = [
    LIST_FAQ => 'FAQ',
    LIST_TESTIMONIAL => 'Testimonial',
    LIST_GALLERY => 'Galerie',
    LIST_JOBS => 'Cariere',
    LIST_SERVICES_DARK => 'Servicii - Box-uri mici, fundal inchis',
    LIST_SERVICES_LIGHT => 'Servicii - Box-uri mici, fundal deschis',
    LIST_SERVICES_BIG => 'Servicii - Box-uri mari',
    LIST_STATS => 'Statistici',
    LIST_TIMELINE => 'Cronologie',
    LIST_CENTERS => 'Centre',
    LIST_AREAS => 'Zone',
];

/**
 * Various types
 */
const VARIOUS_TEXT = 'text';
const VARIOUS_IMAGE = 'image';
const VARIOUS_MAP = 'map';
const VARIOUS_BLOG = 'blog';
const VARIOUS_CONTACT = 'contact';
const VARIOUS_CONTACT_BUSINESS = 'contact.business';
const VARIOUS_CTA_SIMPLE = 'cta.simple';
const VARIOUS_CTA_BG = 'cta.bg';
const VARIOUS_CTA_PHONE = 'cta.phone';
const VARIOUS_HERO = 'hero';
const VARIOUS_HERO_HOME = 'hero.home';
const VARIOUS_PRICES = 'prices';
const VARIOUS_ADDRESS = 'address';
const VARIOUS_COVERAGE = 'coverage';
const VARIOUS_CALCULATOR = 'calculator';
const VARIOUS_SEND = 'send';

const VARIOUS_TYPES = [
    VARIOUS_TEXT => 'Text',
    VARIOUS_IMAGE => 'Imagine',
    VARIOUS_MAP => 'Harta',
    VARIOUS_BLOG => 'Blog (recomandari)',
    VARIOUS_CONTACT => 'Formular contact',
    VARIOUS_CONTACT_BUSINESS => 'Formular contact - Client business',
    VARIOUS_CTA_SIMPLE => 'Box CTA simplu',
    VARIOUS_CTA_BG => 'Box CTA cu imagine',
    VARIOUS_CTA_PHONE => 'Box CTA telefon',
    VARIOUS_HERO => 'Box Header',
    VARIOUS_HERO_HOME => 'Box Header - Home',
    VARIOUS_PRICES => 'Tabel preturi',
    VARIOUS_ADDRESS => 'Box Telefon & Adresa',
    VARIOUS_COVERAGE => 'Tabel acoperire / km suplimentari',
    VARIOUS_CALCULATOR => 'Formular calculator tarife',
    VARIOUS_SEND => 'Formular trimite colet',
];

/**
 * Form types
 */
const FORM_CONTACT = 1;
const FORM_CONTACT_BUSINESS = 2;

const FORM_TYPES = [
    FORM_CONTACT => 'Contact',
    FORM_CONTACT_BUSINESS => 'Contact - Client Business'
];

/**
 * Link types
 */
const LINK_RELATIVE = 1;
const LINK_ABSOLUTE = 2;
const LINK_FRONT = 3;

/**
 * Upload URL
 */
const UPLOAD_URL = '/public/uploads/';

/**
 * Images folders
 */
const IMAGES_PAGE = 'pages';
const IMAGES_BLOG = 'blog';
const IMAGES_AUTHOR = 'authors';
const IMAGES_GALLERY = 'gallery';
const IMAGES_TESTIMONIAL = 'testimonial';
const IMAGES_VARIOUS = 'various';
const IMAGES_BANNER_DESKTOP = 'banner_desktop';
const IMAGES_BANNER_MOBILE = 'banner_mobile';
const IMAGES_LIST = 'list';

/**
 * Images thumbs
 */
const THUMB_ORIGINAL = 'original';
const THUMB_SMALL = 'thumbs-sm';
const THUMB_MEDIUM = 'thumbs-md';
const THUMB_LARGE = 'thumbs-lg';
const THUMB_FACEBOOK = 'thumbs-fb';

/**
 * Gallery types
 */
const GALLERY_LANDSCAPE = 0;
const GALLERY_PORTRAIT = 1;
const GALLERY_CAROUSEL_DESKTOP = 2;
const GALLERY_CAROUSEL_MOBILE = 3;

/**
 * Status types
 */
const STATUS_INACTIVE = 0;
const STATUS_ACTIVE = 1;

const STATUS_TYPES = array(
    STATUS_INACTIVE => 'Inactiv',
    STATUS_ACTIVE => 'Activ'
);

/**
 * Archive types
 */
const ARCHIVE_NO = 0;
const ARCHIVE_YES = 1;

const ARCHIVE_TYPES = array(
    ARCHIVE_NO => 'Dezarhivare',
    ARCHIVE_YES => 'Arhivare'
);

/**
 * @todo Short description of included files
 */
if (!($tinyMce ?? null)) {
    require_once(PLATFORM_PATH . 'config/common.entities.php');
    require_once(PLATFORM_PATH . 'config/db.redirects.php');
    require_once(PLATFORM_PATH . 'config/db.tables.php');
    require_once(PLATFORM_PATH . 'functions/db.php');
    require_once(PLATFORM_PATH . 'functions/ajax.php');
    require_once(PLATFORM_PATH . 'functions/common.php');
    require_once(PLATFORM_PATH . 'functions/project.php');
    require_once(PLATFORM_PATH . '../vendor/autoload.php');
}
