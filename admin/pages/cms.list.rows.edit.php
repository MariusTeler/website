<?php

// Render and return HTML (if AJAX & modal)
parsePage('@init.modal');

global $retPage;

$table = 'cms_list_row';
$curPage = 'index.php?list_id=' . $_GET['list_id'] . '&upload=' . $_GET['upload'] . '&page=' . str_replace('.edit', '', $_GET['page']); // auto
$retPage = 'index.php?edit=' . $_GET['list_id'] . '&page=cms.list.edit'; // auto

// Modal flag
$modal = getVar('modal');

// Form validation
$formName = 'editFormRow';

// List info
$listInfo = dbShift(dbSelect(
    '*',
    'cms_list',
    'id = ' . dbEscape($_GET['list_id'])
));

// Set view
$hasImage = false;
$hasButtons = false;
switch ($listInfo['type']) {
    case LIST_FAQ:
        $view = 'cms.list.rows.edit.faq';
        break;
    case LIST_TESTIMONIAL:
        $view = 'cms.list.rows.edit.testimonial';
        $hasImage = true;
        break;
    case LIST_GALLERY:
        $view = 'cms.list.rows.edit.gallery';
        $hasImage = true;
        break;
    case LIST_JOBS:
        $view = 'cms.list.rows.edit.jobs';
        break;
    case LIST_SERVICES_DARK:
    case LIST_SERVICES_LIGHT:
    case LIST_SERVICES_BIG:
        $view = 'cms.list.rows.edit.services';
        $hasImage = true;
        $hasButtons = true;
        break;
    case LIST_STATS:
        $view = 'cms.list.rows.edit.stats';
        break;
    case LIST_TIMELINE:
        $view = 'cms.list.rows.edit.timeline';
        $hasButtons = true;
        break;
    case LIST_CENTERS:
        $view = 'cms.list.rows.edit.centers';
        break;
    case LIST_AREAS:
        $view = 'cms.list.rows.edit.areas';
        break;
    default:
        $view = 'cms.list.rows.edit';
}
setView($p__, $view);

// Status
$statusYesNo = array(
    '0' => array(
        'class' => 'text-danger',
        'key' => 'NU'
    ),
    '1' => array(
        'class' => 'text-success',
        'key' => 'DA'
    )
);

// Icons
$icons = [];
if (settingsGet('menu-icons')) {
    $icons = explode(',', settingsGet('menu-icons'));
    $icons = array_combine($icons, $icons);
}

// Pages
$pages = $pagesChildren = [];
dbGetWithChildren($pages, $pagesChildren);

if ($hasImage) {
    // Thumbs sizes
    $thumbs = array(
        THUMB_SMALL => array(150, 150)
    );

    if ($listInfo['type'] == LIST_GALLERY) {
        //$thumbs = GALLERY_TYPES[GALLERY_CAROUSEL_DESKTOP]['thumbs'];
        $thumbs = array(
            THUMB_SMALL => array(300, 169),
            THUMB_LARGE => array(1920, 1080)
        );
    }

    if (in_array($listInfo['type'], [LIST_SERVICES_DARK, LIST_SERVICES_LIGHT, LIST_SERVICES_BIG])) {
        $thumbs = array();
    }

    // Images upload settings
    $imagesUpload = array(
        'dir' => IMAGES_LIST,
        'thumbs' => $thumbs,
        'cropIsOptional' => true
    );

    // Form upload init
    formUpload(array(
        'fieldId' => 'image',
        'formId' => $formName,
        'multi' => $_GET['upload'] ? true : false,
        'imagesUpload' => $imagesUpload
    ));
}

// Ids for crop init or normal form upload & validation
if ($ids = unserialize($_GET['ids'], ['allowed_classes' => false])) {
    foreach ($ids as $i => $id) {
        $ids[$i] = (int)$id;
    }
    unset($id);

    // Crop images or init cropper
    $images = dbSelect('id, image', $table, 'id IN (' . implode(', ', $ids) . ')');
    foreach ($images as $image) {
        if (formPost($formName)) {
            // Crop image
            formUploadCrop($imagesUpload, $image['image'], 'imageKey', $table, $image['id']);
        } else {
            // Init cropper
            $_POST['image'] = $image['image'];
            //unset($imagesUpload['thumbs'][THUMB_SMALL]);
            formUploadCropInit($imagesUpload);
        }
    }

    // Normal redirect
    if (formPost($formName)) {
        unset($_POST, $_GET['ids'], $ids);
        alertsAdd('Imaginile au fost redimensionate cu success.');
    }
}

// Form validation
$formRules = array(
    'title' => array(
        'required' => !in_array($listInfo['type'], [LIST_GALLERY, LIST_SERVICES_LIGHT, LIST_SERVICES_DARK, LIST_SERVICES_BIG])
    ),
    'text' => array(
        'required' => !in_array($listInfo['type'], [LIST_GALLERY, LIST_STATS, LIST_TIMELINE, LIST_CENTERS])
    ),
    'imageKey' => array(
        'required' => $hasImage && !$_GET['edit'] && !$ids
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
    'metadata[subtitle]' => array(
        'required' => $listInfo['type'] == LIST_STATS
    ),
    'metadata[icon]' => array(
        'required' => $listInfo['type'] == LIST_STATS
    ),
    'metadata[month]' => array(
        'required' => $listInfo['type'] == LIST_TIMELINE
    ),
    'metadata[year]' => array(
        'required' => $listInfo['type'] == LIST_TIMELINE
    ),
);

$formMessages = array(
    'imageKey' => array(
        'required' => 'Incarcati o imagine.'
    ),
    'metadata[button_type]' => array(
        'required' => ''
    ),
    'metadata[button2_type]' => array(
        'required' => ''
    )
);

$formLink = 'index.php?' . http_build_query([
    'page' => $_GET['page'],
    'list_id' => $_GET['list_id'],
    'edit' => $_GET['edit'],
    'modal' => 1,
    'datatable' => $_GET['datatable'],
    'upload' => $_GET['upload'],
    'ids' => $_GET['ids']
]);

$formOptions = array(
    'submitHandler' => "function() {
        var submit = $('#{$formName}_submit');

        submit.fadeTo(0, 0.4);
        submit.prop('disabled', true);
        submit.val(submit.data('message-loading'));
        ajaxRequest('{$formLink}', [], 'POST', '#{$formName}');
    }"
);

formInit($formName, $formRules, $formMessages, $formOptions);

// Form processing
$eClass = 'hidden';
if (formPost($formName)) {
    // Alerts id in DOM
    $alertsId = 'ajaxAlerts';

    // AJAX contents
    $ajaxContents = [];

    // AJAX functions
    $ajaxFunctions = [];

    if (formValid($formName)) {
        // Set correct id
        $_POST['id'] = $_GET['edit'];

        // Set list id
        $_POST['list_id'] = $_GET['list_id'];

        // Old POST
        if ($_GET['edit']) {
            $oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
        }

        // Multiple images upload
        if ($_GET['upload']) {
            // Keep track of inserted ids in order to activate cropper
            $ids = array();

            // Fetch image session keys for multiple upload
            $imageKeys = sessionGet(sessionGet($_POST['imageKey'] . 's'));
            if (!is_array($imageKeys)) {
                alertsAdd('Nu exista imagini uploadate.', 'error');
                formRedirect($curPage, $id);
            }
        } else {
            $imageKeys = array('dummy');
        }

        foreach ($imageKeys as $imageKey) {
            // Init ordering index
            if (!$_GET['edit']) {
                $_POST['ord'] = dbOrderIndex($table, 'list_id = ' . dbEscape($_POST['list_id']));
            }

            if ($_GET['upload']) {
                //$_POST['title'] = (int)$_POST['ord'] + 1;
                $_POST['imageKey'] = $imageKey;
            }

            if ($hasButtons) {
                if ($_POST['metadata']['button_page_id']) {
                    $_POST['metadata']['button_link'] = '';
                }

                if ($_POST['metadata']['button2_page_id']) {
                    $_POST['metadata']['button2_link'] = '';
                }
            }

            // Insert / Update row
            $id = dbInsert($table, $_POST);

            // Save image
            formUploadResize($table, $id, $imagesUpload);

            // Crop image
            formUploadCrop($imagesUpload, $oldPost['image'], 'imageKey', $table, $id);

            // Notifications
            if ($id === false) {
                alertsAdd('Datele nu au putut fi salvate!', 'error');
                $id = $_GET['edit'];
            } else {
                alertsAdd('Datele au fost salvate cu success!');

                // Log actions
                $entitiesById = [
                    'status' => STATUS_TYPES,
                    'is_home' => ['Nu', 'Da'],
                    'button_type' => ['page_id' => 'Pagina', 'link' => 'Link'],
                    'button_is_popup' => ['Nu', 'Da'],
                    'button_page_id' => array_column($pages, 'link_name', 'id'),
                    'button2_type' => ['page_id' => 'Pagina', 'link' => 'Link'],
                    'button2_is_popup' => ['Nu', 'Da'],
                    'button2_page_id' => array_column($pages, 'link_name', 'id'),
                ];

                // Metadata
                $oldPost = array_merge($oldPost ?: [], $oldPost['metadata'] ?: []);
                $_POST = array_merge($_POST, $_POST['metadata'] ?: []);

                userAction($id, ENTITY_LIST_ROW, $_POST, $oldPost, $entitiesById);

                // Log actions for ENTITY_LIST
                if (!$oldPost) {
                    userActionText(
                        $listInfo['id'],
                        ENTITY_LIST,
                        MESSAGE_LIST_ROW_ADD
                    );
                } else {
                    userActionText(
                        $listInfo['id'],
                        ENTITY_LIST,
                        MESSAGE_LIST_ROW_UPDATE
                    );
                }
            }

            // Keep ids for crop activation
            if ($_GET['upload']) {
                if ($id) {
                    $ids[] = $id;
                }
            }
        }

        // Update list counter
        updateListCounter($_POST['list_id']);

        // Reset $_POST, form validation and image initialization in order to show edit page
        unset($_POST);
        $cfg__['forms'] = [];
        $cfg__['varsGlobal']['initUploadify'] = [];

        // For mass image crop
        if ($_GET['upload']) {
            $id = 0;
            $_GET['ids'] = $ids ? serialize($ids) : '';
        }

        // Parse edit page
        $_GET['edit'] = $id;
        parsePage($p__);
    } else {
        $eClass = '';
    }
} else {
    if ($_GET['edit']) {
        $_POST = dbShift(dbSelect(
            '*',
            $table,
            'id = ' . dbEscape($_GET['edit'])
        ));

        $_POST['button_page_id'] = $_POST['metadata']['button_page_id'];
        $_POST['button_is_popup'] = $_POST['metadata']['button_is_popup'];
        $_POST['button2_page_id'] = $_POST['metadata']['button2_page_id'];
        $_POST['button2_is_popup'] = $_POST['metadata']['button2_is_popup'];
        $_POST['icon'] = $_POST['metadata']['icon'];

        //unset($imagesUpload['thumbs'][THUMB_SMALL]);
        if ($hasImage) {
            formUploadCropInit($imagesUpload);
        }
    }

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
        'id' => 'icon-row',
        'options' => array(
            'width' => '100%'
        )
    ));
}
