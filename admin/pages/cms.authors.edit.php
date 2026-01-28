<?php

global $retPage;

$table = 'blog_author';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Sex
$sex = ['Female', 'Male'];
$sex = array_combine($sex, $sex);

// Images upload settings
$imagesUpload = array(
    'dir' => IMAGES_AUTHOR,
    'thumbs' => array(
        THUMB_SMALL => array('215', '215')
    ),
    'cropIsOptional' => true
);

// Form upload init
formUpload(array(
    'fieldId' => 'image',
    'formId' => 'editForm',
    'formLabel' => 'Imagine',
    'imagesUpload' => $imagesUpload
));

// Form validation
formInit('editForm',
    array(
        'name' => array(
            'required' => true,
            'remote' => array(
                'url' => 'index.php?page=@validate.unique',
                'type' => 'post',
                'data' => array(
                    'unique_table' => $table,
                    'unique_field_name' => 'name',
                    'unique_id' => $_GET['edit'],
                    'unique_field_id' => 'name'
                )
            )
        ),
        'profile_facebook' => array(
            'url' => true
        ),
        'profile_linkedin' => array(
            'url' => true
        ),
        'profile_instagram' => array(
            'url' => true
        ),
        'profile_twitter' => array(
            'url' => true
        )
    ),
    array(
        'name' => array(
            'remote' => 'Numele introdus este deja existent.'
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

        // URL Rewrite
        $_POST['url_key'] = rewriteEnc($_POST['name']);
        while (!dbUnique($table, 'url_key', $_POST['url_key'], $_GET['edit'])) {
            $_POST['url_key'] .= '-';
        }

        // Insert / Update row
        $id = dbInsert($table, $_POST);

        // Save image
        formUploadResize($table, $id, $imagesUpload);

        // Crop image
        formUploadCrop($imagesUpload, $oldPost['image']);

        // Notifications
        if ($id === false) {
            alertsAdd('Datele nu au putut fi salvate!', 'error');
            $id = $_GET['edit'];
        } else {
            alertsAdd('Datele au fost salvate cu success!');

            // Log actions
            $entitiesById = [
                'status' => ['Nu', 'Da'],
                'profile_gender' => $sex
            ];

            // Metadata
            //$oldPost = array_merge($oldPost ?: [], $oldPost['metadata'] ?: []);
            //$_POST = array_merge($_POST, $_POST['metadata'] ?: []);

            userAction($id, ENTITY_AUTHOR, $_POST, $oldPost, $entitiesById);
        }

        // Redirect
        formRedirect($retPage, $id);
    } else {
        $eClass = '';
    }
} else {
    if ($_GET['edit']) {
        $_POST = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));

        // Crop init
        formUploadCropInit($imagesUpload);
    }
}

// Authors page
$authorPage = getPageByKey('type', PAGE_TYPE_AUTHOR);

// Editor init
formEditor('text');
