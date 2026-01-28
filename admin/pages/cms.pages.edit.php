<?php

global $retPage;

$table = 'cms_pages';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Options
$options = dbSelect(
    'id, link_name',
    $table,
    'parent_id = 0 AND id != ' . dbEscape($_GET['edit'] ?: 0),
    'ord ASC'
);

// Images upload settings
$imagesUpload = array(
    'dir' => IMAGES_PAGE,
    'thumbs' => array(
        THUMB_FACEBOOK => array('1200', '630')
    ),
    'cropIsOptional' => true
);

// Form upload init
formUpload(array(
    'fieldId' => 'image',
    'formId' => 'editForm',
    'formLabel' => 'Imagine Facebook',
    'imagesUpload' => $imagesUpload
));

// Form validation
formInit('editForm',
    array(
        'link_name' => array(
            'required' => true,
            'remote' => array(
                'url' => 'index.php?page=@validate.unique',
                'type' => 'post',
                'data' => array(
                    'unique_table' => $table,
                    'unique_field_name' => 'link_name',
                    'unique_id' => $_GET['edit'],
                    'unique_where_name' => 'parent_id',
                    'unique_where_value' => "function() {
                                    return $('#parent_id').val();
                                }",
                    'unique_change_id' => 'parent_id',
                    'unique_field_id' => 'link_name'
                )
            )
        )
    ),
    array(
        'link_name' => array(
            'remote' => 'Numele introdus este deja existent.'
        )
    )
);

if ($_GET['edit']) {
    $oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
    $previewLink = makeLink(LINK_RELATIVE, $oldPost);

    // Preview link
    if ($oldPost['parent_id']) {
        $parentPage = getPageByKey('id', $oldPost['parent_id'], false);
        $previewLink = makeLink(LINK_RELATIVE, $parentPage, $oldPost);
    }
}

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm')) {
        // Init ordering index
        if (!$_GET['edit'] || $oldPost['parent_id'] != (int)$_POST['parent_id']) {
            $_POST['ord'] = dbOrderIndex($table, 'parent_id = ' . dbEscape($_POST['parent_id']));
        }

        // URL Rewrite
        $_POST['url_key'] = rewriteEnc($_POST['link_name']);
        while (!dbUnique(
            $table,
            'url_key',
            $_POST['url_key'],
            $_GET['edit'],
            'parent_id = ' . dbEscape($_POST['parent_id'])
        )) {
            $_POST['url_key'] .= '-';
        }

        // Sanitize metadata
        $_POST['metadata'] = dbSpecialChars($_POST['metadata']);

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

            // Log action
            $_POST['parent_id'] = (int)$_POST['parent_id'];
            $statusYesNo = ['Nu', 'Da'];

            $entitiesById = [
                'parent_id' => array_column($options, 'link_name', 'id'),
                'is_noindex' => $statusYesNo,
                'type' => PAGE_TYPES,
                'status' => STATUS_TYPES
            ];

            // Metadata
            //$oldPost = array_merge($oldPost ?: [], $oldPost['metadata'] ?: []);
            //$_POST = array_merge($_POST, $_POST['metadata'] ?: []);

            userAction($id, ENTITY_PAGE, $_POST, $oldPost, $entitiesById);

            // Associate content blocks as entities
            $success = entityAddBlocks(ENTITY_PAGE, $id, $_POST['text']);

            if (!$success) {
                alertsAdd('Asocierea cu blocurile de continut nu a putut fi efectuata.', 'error');
            }

            // Create redirect
            if ($oldPost && $_POST['status'] && $_POST['is_redirect']) {
                // Page link
                $oldLink = $previewLink;
                $newLink = makeLink(LINK_RELATIVE, $_POST);
                if ($_POST['parent_id']) {
                    $parentPage = getPageByKey('id', $_POST['parent_id'], false);
                    $newLink = makeLink(LINK_RELATIVE, $parentPage, $_POST);
                }

                // Check if is redirect from parent change or from page name
                if (
                    $oldPost['parent_id'] != (int)$_POST['parent_id']
                    || $oldPost['link_name'] != $_POST['link_name']
                ) {
                    dbRedirectAdd(
                        $newLink,
                        $oldLink,
                        ENTITY_PAGE
                    );
                }
            }
        }

        // Redirect
        formRedirect($retPage, $id);
    } else {
        $eClass = '';
    }
} else {
    if ($_GET['edit']) {
        $_POST = $oldPost;

        // Preview link param
        $previewLink .= '?preview=1';

        // Crop init
        formUploadCropInit($imagesUpload);
    }
}

// Init select2
formSelect2(array(
    'id' => 'parent_id',
    'options' => array(
        'width' => '100%'
    )
));

// Editor init
formEditor('text', [], 'cmsblocks');
