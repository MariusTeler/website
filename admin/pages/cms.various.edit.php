<?php

global $retPage;

$table = 'cms_various';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Old POST
$oldPost = [];
if ($_GET['edit']) {
    $oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
}

// Images upload settings
$imagesUpload = array(
    'dir' => IMAGES_VARIOUS,
    'thumbs' => array(
        THUMB_LARGE => array('1920')
    ),
    'cropIsOptional' => true
);

// Set addon view
$hasImage = false;
$imagesLabel = '';
switch ($oldPost['type']) {
    case VARIOUS_IMAGE:
        $view = 'cms.various.edit.image';
        $hasImage = true;
        break;
    case VARIOUS_MAP:
        $view = 'cms.various.edit.map';
        break;
    case VARIOUS_CONTACT:
        $view = 'cms.various.edit.contact';
        break;
    case VARIOUS_CONTACT_BUSINESS:
        $view = 'cms.various.edit.contact.business';
        break;
    case VARIOUS_CTA_SIMPLE:
        $view = 'cms.various.edit.cta';
        break;
    case VARIOUS_CTA_BG:
        $view = 'cms.various.edit.cta.bg';
        $hasImage = true;
        break;
    case VARIOUS_CTA_PHONE:
        $view = 'cms.various.edit.cta.phone';
        break;
    case VARIOUS_HERO:
        $view = 'cms.various.edit.hero';
        $hasImage = true;
        $imagesUpload['thumbs'] = [
            THUMB_LARGE => array('1920', '1080')
        ];
        break;
    case VARIOUS_HERO_HOME:
        $view = 'cms.various.edit.hero.home';
        $hasImage = true;
        $imagesUpload['thumbs'] = [
            THUMB_LARGE => array('1920', '1080')
        ];
        break;
    case VARIOUS_ADDRESS:
        $view = 'cms.various.edit.address';
        break;
    default:
        $view = '';
}

// Pages
$pages = $pagesChildren = [];
dbGetWithChildren($pages, $pagesChildren);
parseVar('pages', $pages);
parseVar('pagesChildren', $pagesChildren);

// Background position
$bgPosition = [
    'object-position-center' => 'Centru',
    'object-position-left' => 'Stanga',
    'object-position-right' => 'Dreapta',
    'object-position-top' => 'Sus',
    'object-position-bottom' => 'Jos',
];
parseVar('bgPosition', $bgPosition);

// Background opacity
$bgOpacity = [
    'opacity-25' => '25%',
    'opacity-50' => '50%',
    'opacity-75' => '75%',
    'opacity-100' => '100%'
];
parseVar('bgOpacity', $bgOpacity);

// Form validation
$formRules = array(
    'name' => array(
        'required' => "function(element){
                return ($(element.form).find(\"[name='title']\").val() == '');
            }"
    ),
    'metadata[button_text]' => array(
        'required' => "function(element){
                return ($(element.form).find(\"[name='metadata[button_type]']:checked\").val() != undefined);
            }"
    ),
    'metadata[button_type]' => array(
        'required' => "function(element){
                return ($(element.form).find(\"[name='metadata[button_text]']\").val() != '');
            }"
    ),
    'metadata[button_page_id]' => array(
        'required' => "function(element){
                return ($(element.form).find(\"[name='metadata[button_type]']:checked\").val() == 'page_id');
            }"
    ),
    'metadata[button_link]' => array(
        'required' => "function(element){
                return ($(element.form).find(\"[name='metadata[button_type]']:checked\").val() == 'link');
            }"
    ),
    'metadata[button2_text]' => array(
        'required' => "function(element){
                return ($(element.form).find(\"[name='metadata[button2_type]']:checked\").val() != undefined);
            }"
    ),
    'metadata[button2_type]' => array(
        'required' => "function(element){
                return ($(element.form).find(\"[name='metadata[button2_text]']\").val() != '');
            }"
    ),
    'metadata[button2_page_id]' => array(
        'required' => "function(element){
                return ($(element.form).find(\"[name='metadata[button2_type]']:checked\").val() == 'page_id');
            }"
    ),
    'metadata[button2_link]' => array(
        'required' => "function(element){
                return ($(element.form).find(\"[name='metadata[button2_type]']:checked\").val() == 'link');
            }"
    ),
);

$formMessages = array(
    'name' => array(
        'required' => 'Introduceti un identificator.'
    )
);

formInit('editForm',
    $formRules,
    $formMessages
);

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm')) {

        // Sanitize metadata
        $_POST['metadata'] = dbSpecialChars($_POST['metadata']);

        // Insert / Update row
        $id = dbInsert($table, $_POST);

        if ($hasImage) {
            // Save image
            formUploadResize($table, $id, $imagesUpload);

            // Crop image
            formUploadCrop($imagesUpload, $oldPost['image']);
        }

        // Notifications
        if ($id === false) {
            alertsAdd('Datele nu au putut fi salvate!', 'error');
            $id = $_GET['edit'];
        } else {
            alertsAdd('Datele au fost salvate cu success!');

            // Log actions
            $entitiesById = [
                'status' => STATUS_TYPES,
                'button_type' => ['page_id' => 'Pagina', 'link' => 'Link'],
                'button_is_popup' => ['Nu', 'Da'],
                'button_page_id' => array_column($pages, 'link_name', 'id'),
                'button2_type' => ['page_id' => 'Pagina', 'link' => 'Link'],
                'button2_is_popup' => ['Nu', 'Da'],
                'button2_page_id' => array_column($pages, 'link_name', 'id'),
                'cta_bg_position' => $bgPosition,
                'cta_bg_opacity' => $bgOpacity,
                'hero_tracking_awb' => ['Nu', 'Da'],
                'hero_tracking_page_id' => array_column($pages, 'link_name', 'id'),
                'hero_bg_transparent' => ['Nu', 'Da'],
            ];

            // Metadata
            $oldPost = array_merge($oldPost ?: [], $oldPost['metadata'] ?: []);
            $_POST = array_merge($_POST, $_POST['metadata'] ?: []);

            userAction($id, ENTITY_VARIOUS, $_POST, $oldPost, $entitiesById);
        }

        // Redirect
        formRedirect($retPage, $id);
    } else {
        $eClass = '';
    }
} else {
    if ($_GET['edit']) {
        $_POST = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));

        // Buttons
        $_POST['button_page_id'] = $_POST['metadata']['button_page_id'];
        $_POST['button_is_popup'] = $_POST['metadata']['button_is_popup'];
        $_POST['button2_page_id'] = $_POST['metadata']['button2_page_id'];
        $_POST['button2_is_popup'] = $_POST['metadata']['button2_is_popup'];

        // Background position
        $_POST['cta_bg_position'] = $_POST['metadata']['cta_bg_position'];

        // Background opacity
        $_POST['cta_bg_opacity'] = $_POST['metadata']['cta_bg_opacity'];

        // Tracking AWB form
        $_POST['hero_tracking_awb'] = $_POST['metadata']['hero_tracking_awb'];
        $_POST['hero_tracking_page_id'] = $_POST['metadata']['hero_tracking_page_id'];

        // Header with transparent background
        $_POST['hero_bg_transparent'] = $_POST['metadata']['hero_bg_transparent'];

        if ($hasImage) {
            // Save image
            formUploadCropInit($imagesUpload);

            // Form upload init
            formUpload(array(
                'fieldId' => 'image',
                'formId' => 'editForm',
                'formLabel' => $imagesLabel ?: 'Imagine',
                'imagesUpload' => $imagesUpload
            ));
        }
    }
}

// Editor init
formEditor('text');

// Init select2
formSelect2(array(
    'id' => 'button_page_id-row',
    'options' => array(
        'width' => '100%'
    )
));

formSelect2(array(
    'id' => 'button2_page_id-row',
    'options' => array(
        'width' => '100%'
    )
));

formSelect2(array(
    'id' => 'hero_tracking_page_id-row',
    'options' => array(
        'width' => '100%'
    )
));

// Map
if (!$_POST['metadata']['map']) {
    $_POST['LatLng'] = '44.431819,26.102035';
    $_POST['zoom'] = 12;
} else {
    $_POST['LatLng'] = $_POST['metadata']['map'];
    $_POST['zoom'] = 16;
}
