<?php

/**
 * Entity types
 */
const ENTITY_BACK_USER = 1;
const ENTITY_PAGE = 2;
const ENTITY_BLOG = 3;
const ENTITY_CONTACT = 7;
const ENTITY_VARIOUS = 8;
const ENTITY_REDIRECT = 9;
const ENTITY_AUTHOR = 10;
const ENTITY_MENU = 14;
const ENTITY_LIST = 15;
const ENTITY_LIST_ROW = 16;

const ENTITY_TYPES = array(
    ENTITY_BACK_USER => 'Administrator',
    ENTITY_PAGE => 'Pagina',
    ENTITY_BLOG => 'Blog',
    ENTITY_CONTACT => 'Contact',
    ENTITY_VARIOUS => 'Blocuri',
    ENTITY_REDIRECT => 'Redirect',
    ENTITY_AUTHOR => 'Autor',
    ENTITY_MENU => 'Meniu',
    ENTITY_LIST => 'Lista',
    ENTITY_LIST_ROW => 'Lista - Linie',
);

const ENTITY_MAIN_TABLES = array(
    ENTITY_PAGE => 'cms_pages',
    ENTITY_BLOG => 'blog'
);

const ENTITY_MODULES_TABLES = array(
    ENTITY_VARIOUS => 'cms_various',
    ENTITY_LIST => 'cms_list',
);

const ENTITY_MODULES_PAGES = array(
    ENTITY_VARIOUS => 'cms.various.edit',
    ENTITY_LIST => 'cms.list.edit',
);

/**
 * Message types
 */
const MESSAGE_TEXT = 0;
const MESSAGE_ADD = 1;
const MESSAGE_DELETE = 2;
const MESSAGE_STATUS = 3;
const MESSAGE_UPDATE = 4;
const MESSAGE_PASSWORD_RESET = 5;
const MESSAGE_ACCOUNT_NEW = 6;
const MESSAGE_ARCHIVE = 7;
const MESSAGE_RESTORE = 8;
const MESSAGE_IMAGE = 9;
const MESSAGE_GALLERY_DELETE = 10;
const MESSAGE_GALLERY_ADD = 11;
const MESSAGE_GALLERY_UPDATE = 12;
const MESSAGE_REDIRECT = 13;
const MESSAGE_LIST_ROW_DELETE = 14;
const MESSAGE_LIST_ROW_ADD = 15;
const MESSAGE_LIST_ROW_UPDATE = 16;

const MESSAGE_TYPES = array(
    MESSAGE_TEXT => 'Observatii',
    MESSAGE_ADD => 'Adaugare',
    MESSAGE_DELETE => 'Stergere',
    MESSAGE_RESTORE => 'Restaureaza',
    MESSAGE_STATUS => 'Modificare status',
    MESSAGE_UPDATE => 'Modificare campuri',
    MESSAGE_PASSWORD_RESET => 'Resetare parola (email)',
    MESSAGE_ACCOUNT_NEW => 'Cont nou (email)',
    MESSAGE_ARCHIVE => 'Arhivare',
    MESSAGE_IMAGE => 'Adaugare / modificare imagine',
    MESSAGE_GALLERY_DELETE => 'Stergere imagine din galerie',
    MESSAGE_GALLERY_ADD => 'Adaugare imagine in galerie',
    MESSAGE_GALLERY_UPDATE => 'Modificare imagine in galerie',
    MESSAGE_REDIRECT => 'Adaugare redirect',
    MESSAGE_LIST_ROW_DELETE => 'Stergere linie',
    MESSAGE_LIST_ROW_ADD => 'Adaugare linie',
    MESSAGE_LIST_ROW_UPDATE => 'Modificare linie',
);

/**
 * Entity format
 */
const ENTITY_FORMAT_DATE = 1;
const ENTITY_FORMAT_DATETIME = 2;
const ENTITY_FORMAT_BY_ID = 3;

/**
 * User action + entity config
 */
const ENTITY_ACTIONS = [
    /*ENTITY_DEMO => [
        'fields' => [
            [
                'name' => 'name',
                'title' => 'Nume',
                'format' => ENTITY_FORMAT_BY_ID,
                'is_html' => true,
                'skip_value' => true,
                'skip_title' => true
            ]
        ],
        'status_field' => 'status',
        'comment_field' => 'comment',
        'image_fields' => [
            'imageKey',
            'crop'
        ]
    ],*/
    ENTITY_PAGE => [
        'fields' => [
            [
                'name' => 'parent_id',
                'title' => 'Parinte',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'link_name',
                'title' => 'Nume pagina'
            ],
            [
                'name' => 'is_noindex',
                'title' => 'Noindex',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'type',
                'title' => 'Tip sectiune',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'status',
                'title' => 'Status',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'title',
                'title' => 'Titlu'
            ],
            [
                'name' => 'text',
                'title' => 'Text',
                'is_html' => true
            ],
            [
                'name' => 'relation_' . ENTITY_LIST,
                'title' => 'Lista (bloc continut)',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'relation_' . ENTITY_VARIOUS,
                'title' => 'Blocuri (bloc continut)',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'site_title',
                'title' => 'SEO Title'
            ],
            [
                'name' => 'site_description',
                'title' => 'SEO Description'
            ],
            [
                'name' => 'imageKey',
                'title' => 'Imagine Facebook',
                'skip_value' => true
            ],
            [
                'name' => 'crop_' . IMAGES_PAGE,
                'title' => 'Imagine Facebook (crop)',
                'skip_value' => true
            ],
            [
                'name' => 'name',
                'title' => 'Identificator'
            ],
        ],
        'status_field' => 'status',
        'image_fields' => [
            'imageKey',
            'crop_' . IMAGES_PAGE
        ]
    ],
    ENTITY_BLOG => [
        'fields' => [
            [
                'name' => 'page_id',
                'title' => 'Categorie',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'author_id',
                'title' => 'Autor',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'title',
                'title' => 'Titlu'
            ],
            [
                'name' => 'title_facebook',
                'title' => 'Titlu Facebook'
            ],
            [
                'name' => 'date_update',
                'title' => 'Data actualizarii',
                'format' => ENTITY_FORMAT_DATETIME
            ],
            [
                'name' => 'is_toc',
                'title' => 'Cuprins autogenerat',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'is_home',
                'title' => 'Home',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'is_evergreen',
                'title' => 'Evergreen',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'is_noindex',
                'title' => 'Noindex',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'status',
                'title' => 'Status',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'text_intro',
                'title' => 'Text intro'
            ],
            [
                'name' => 'video_intro',
                'title' => 'Video intro',
                'is_html' => true,
            ],
            [
                'name' => 'text',
                'title' => 'Text',
                'is_html' => true
            ],
            [
                'name' => 'relation_' . ENTITY_LIST,
                'title' => 'Lista (bloc continut)',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'relation_' . ENTITY_VARIOUS,
                'title' => 'Blocuri (bloc continut)',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'site_title',
                'title' => 'SEO Title'
            ],
            [
                'name' => 'site_description',
                'title' => 'SEO Description'
            ],
            [
                'name' => 'site_canonical',
                'title' => 'SEO Canonical'
            ],
            [
                'name' => 'image_source',
                'title' => 'Surse foto'
            ],
            [
                'name' => 'imageKey',
                'title' => 'Imagine Facebook',
                'skip_value' => true
            ],
            [
                'name' => 'crop_' . IMAGES_BLOG,
                'title' => 'Imagine Facebook (crop)',
                'skip_value' => true
            ]
        ],
        'status_field' => 'status',
        'image_fields' => [
            'imageKey',
            'crop_' . IMAGES_BLOG
        ]
    ],
    ENTITY_AUTHOR => [
        'fields' => [
            [
                'name' => 'name',
                'title' => 'Nume'
            ],
            [
                'name' => 'profile_title',
                'title' => 'Ocupatia'
            ],
            [
                'name' => 'profile_gender',
                'title' => 'Sex',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'profile_facebook',
                'title' => 'Facebook'
            ],
            [
                'name' => 'profile_linkedin',
                'title' => 'LinkedIn'
            ],
            [
                'name' => 'profile_instagram',
                'title' => 'Instagram'
            ],
            [
                'name' => 'profile_twitter',
                'title' => 'Twitter'
            ],
            [
                'name' => 'status',
                'title' => 'Pagina autor',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'text',
                'title' => 'Descriere',
                'is_html' => true
            ],
            [
                'name' => 'imageKey',
                'title' => 'Imagine',
                'skip_value' => true
            ],
            [
                'name' => 'crop_' . IMAGES_AUTHOR,
                'title' => 'Imagine (crop)',
                'skip_value' => true
            ]
        ],
        'image_fields' => [
            'imageKey',
            'crop_' . IMAGES_AUTHOR
        ]
    ],
    ENTITY_VARIOUS => [
        'fields' => [
            [
                'name' => 'name',
                'title' => 'Identificator'
            ],
            [
                'name' => 'title',
                'title' => 'Titlu'
            ],
            [
                'name' => 'text',
                'title' => 'Text',
                'is_html' => true
            ],
            [
                'name' => 'imageKey',
                'title' => 'Imagine',
                'skip_value' => true
            ],
            [
                'name' => 'crop_' . IMAGES_VARIOUS,
                'title' => 'Imagine (crop)',
                'skip_value' => true
            ],
            [
                'name' => 'status',
                'title' => 'Status',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'address',
                'title' => 'Adresa'
            ],
            [
                'name' => 'map',
                'title' => 'Localizare (harta)'
            ],
            [
                'name' => 'button_text',
                'title' => 'Text buton'
            ],
            [
                'name' => 'button_type',
                'title' => 'Tip buton',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button_is_popup',
                'title' => 'Popup buton',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button_page_id',
                'title' => 'Pagina buton',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button_link',
                'title' => 'Link buton'
            ],
            [
                'name' => 'button2_text',
                'title' => 'Text buton #2'
            ],
            [
                'name' => 'button2_type',
                'title' => 'Tip buton #2',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button2_is_popup',
                'title' => 'Popup buton #2',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button2_page_id',
                'title' => 'Pagina buton #2',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button2_link',
                'title' => 'Link buton #2'
            ],
            [
                'name' => 'cta_bg_position',
                'title' => 'Imagine background - Pozitionare',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'cta_bg_opacity',
                'title' => 'Imagine background - Opacitate',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'hero_tracking_awb',
                'title' => 'Optiuni - Formular Tracking AWB',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'hero_tracking_page_id',
                'title' => 'Optiuni - Pagina Formular Tracking AWB',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'hero_bg_transparent',
                'title' => 'Optiuni - Cu background transparent',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'hero_home_awb_title',
                'title' => 'Box Tracking AWB - Titlu'
            ],
            [
                'name' => 'hero_home_awb_text',
                'title' => 'Box Tracking AWB - Text'
            ],
            [
                'name' => 'hero_home_secondary_title',
                'title' => 'Box box mic secundar - Titlu'
            ],
            [
                'name' => 'hero_home_secondary_text',
                'title' => 'Box box mic secundar - Text'
            ],
            [
                'name' => 'address_title',
                'title' => 'Box Telefon & Adresa - Titlu'
            ],
            [
                'name' => 'address_text',
                'title' => 'Box Telefon & Adresa - Text'
            ],
            [
                'name' => 'contact_subtitle',
                'title' => 'Subtitlu'
            ],
            [
                'name' => 'contact_email',
                'title' => 'Email'
            ],
            [
                'name' => 'analytics_action',
                'title' => 'Analytics - Action'
            ],
            [
                'name' => 'analytics_category',
                'title' => 'Analytics - Category'
            ],
            [
                'name' => 'analytics_label',
                'title' => 'Analytics - Label'
            ],
            [
                'name' => 'analytics_facebook',
                'title' => 'Analytics - Facebook'
            ],
        ],
        'status_field' => 'status',
        'comment_field' => 'comment',
        'image_fields' => [
            'imageKey',
            'crop_' . IMAGES_VARIOUS
        ]
    ],
    ENTITY_REDIRECT => [
        'fields' => [
            [
                'name' => 'url_from',
                'title' => 'De la'
            ],
            [
                'name' => 'url_to',
                'title' => 'Catre'
            ],
            [
                'name' => 'redirect_type',
                'title' => 'Tip',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'status',
                'title' => 'Status',
                'format' => ENTITY_FORMAT_BY_ID
            ]
        ],
        'status_field' => 'status'
    ],
    ENTITY_BACK_USER => [
        'fields' => [
            [
                'name' => 'name',
                'title' => 'Nume',
            ],
            [
                'name' => 'email',
                'title' => 'Email',
            ],
            [
                'name' => 'pass',
                'title' => 'Parola',
                'skip_value' => true,
            ],
            [
                'name' => 'access',
                'title' => 'Tip user',
                'format' => ENTITY_FORMAT_BY_ID,
            ],
            [
                'name' => 'status',
                'title' => 'Status',
                'format' => ENTITY_FORMAT_BY_ID,
            ],
            [
                'name' => 'profile_id',
                'title' => 'Profil access',
                'format' => ENTITY_FORMAT_BY_ID,
            ]
        ],
        'status_field' => 'status'
    ],
    ENTITY_CONTACT => [
        'fields' => [
            [
                'name' => 'status_id',
                'title' => 'Status',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'text',
                'title' => 'Comentariu',
                'skip_title' => true
            ]
        ],
        'status_field' => 'status_id',
        'comment_field' => 'text'
    ],
    ENTITY_MENU => [
        'fields' => [
            [
                'name' => 'parent_id',
                'title' => 'Meniu principal',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'page_id',
                'title' => 'Pagina',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'link',
                'title' => 'Link'
            ],
            [
                'name' => 'link_name',
                'title' => 'Nume pagina'
            ],
            [
                'name' => 'is_popup',
                'title' => 'Popup',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'icon',
                'title' => 'Icon'
            ]
        ]
    ],
    ENTITY_LIST => [
        'fields' => [
            [
                'name' => 'title',
                'title' => 'Titlu'
            ],
            [
                'name' => 'text',
                'title' => 'Text',
                'is_html' => true
            ],
            [
                'name' => 'status',
                'title' => 'Status',
                'format' => ENTITY_FORMAT_BY_ID
            ]
        ],
        'status_field' => 'status'
    ],
    ENTITY_LIST_ROW => [
        'fields' => [
            [
                'name' => 'title',
                'title' => 'Titlu'
            ],
            [
                'name' => 'subtitle',
                'title' => 'Subtitlu'
            ],
            [
                'name' => 'text',
                'title' => 'Text',
                'is_html' => true
            ],
            [
                'name' => 'button_text',
                'title' => 'Text buton'
            ],
            [
                'name' => 'button_type',
                'title' => 'Tip buton',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button_is_popup',
                'title' => 'Popup buton',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button_page_id',
                'title' => 'Pagina buton',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button_link',
                'title' => 'Link buton'
            ],
            [
                'name' => 'button2_text',
                'title' => 'Text buton #2'
            ],
            [
                'name' => 'button2_type',
                'title' => 'Tip buton #2',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button2_is_popup',
                'title' => 'Popup buton #2',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button2_page_id',
                'title' => 'Pagina buton #2',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'button2_link',
                'title' => 'Link buton #2'
            ],
            [
                'name' => 'icon',
                'title' => 'Icon'
            ],
            [
                'name' => 'month',
                'title' => 'Luna'
            ],
            [
                'name' => 'year',
                'title' => 'An'
            ],
            [
                'name' => 'centers_clients',
                'title' => 'Relatii clienti'
            ],
            [
                'name' => 'centers_area',
                'title' => 'Responsabil zonal'
            ],
            [
                'name' => 'centers_email',
                'title' => 'Email'
            ],
            [
                'name' => 'centers_address',
                'title' => 'Adresa'
            ],
            [
                'name' => 'is_home',
                'title' => 'Home',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'status',
                'title' => 'Status',
                'format' => ENTITY_FORMAT_BY_ID
            ],
            [
                'name' => 'imageKey',
                'title' => 'Imagine',
                'skip_value' => true
            ],
            [
                'name' => 'crop_' . IMAGES_LIST,
                'title' => 'Imagine (crop)',
                'skip_value' => true
            ]
        ],
        'status_field' => 'status',
        'image_fields' => [
            'imageKey',
            'crop_' . IMAGES_LIST
        ]
    ],
];
