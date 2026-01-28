<?php

global $retPage;

$table = 'cms_banner';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Images upload settings
$imagesUploadDesktop = array(
    'dir' => IMAGES_BANNER_DESKTOP,
    'thumbs' => array(
        THUMB_MEDIUM => array(900)
    )
);

$imagesUploadMobile = array(
    'dir' => IMAGES_BANNER_MOBILE,
    'thumbs' => array(
        THUMB_MEDIUM => array(0, 720)
    )
);

// Form upload init
formUpload(array(
    'fieldId' => 'image',
    'formId' => 'editForm',
    'formLabel' => 'Imagine desktop',
    'imagesUpload' => $imagesUploadDesktop
));

formUpload(array(
    'fieldId' => 'image_mobile',
    'formId' => 'editForm',
    'formLabel' => 'Imagine mobile',
    'imagesUpload' => $imagesUploadMobile
));

// Form validation
formInit('editForm',
    array(
        'title' => array(
            'required' => true,
        ),
        'link' => array(
            'url' => true
        ),
        'imageKey' => array(
            'required' => (($_GET['edit']) ? false : true)
        )
    ),
    array(
        'imageKey' => array(
            'required' => 'Incarcati o imagine.'
        )
    )
);

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm')) {
        // Old data
        if ($_GET['edit']) {
            $oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
        }

        // Date start / end
        if ($_POST['date_start']) {
            $_POST['date_start'] = strtotime($_POST['date_start']);
        }

        if ($_POST['date_end']) {
            $_POST['date_end'] = strtotime($_POST['date_end']);
        }

        // Insert / Update row
        $id = dbInsert($table, $_POST);

        // Save image
        formUploadResize($table, $id, $imagesUploadDesktop);
        formUploadResize($table, $id, $imagesUploadMobile, 'image_mobileKey', 'image_mobile');

        // Crop image
        formUploadCrop($imagesUploadDesktop, $oldPost['image']);
        formUploadCrop($imagesUploadMobile, $oldPost['image_mobile'], 'image_mobileKey');

        // Notifications
        if ($id === false) {
            alertsAdd('Datele nu au putut fi salvate!', 'error');
            $id = $_GET['edit'];
        } else {
            alertsAdd('Datele au fost salvate cu success!');
        }

        // Redirect
        formRedirect($retPage, $id);
    } else {
        $eClass = '';
    }
} else {
    if ($_GET['edit']) {
        // Set data to $_POST
        $_POST = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));

        // Crop init
        formUploadCropInit($imagesUploadDesktop);
        formUploadCropInit($imagesUploadMobile, 'image_mobile');
    }
}

// Init datepicker
formDatepicker('date_start');
formDatepicker('date_end');
