<?php

global $retPage;

$table = 'blog';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Pages
$pages = $pagesChildren = [];
dbGetWithChildren(
    $pages,
    $pagesChildren,
    'id, parent_id, link_name',
    'cms_pages',
    'type = ' . dbEscape(PAGE_TYPE_BLOG)
);

// Authors
$authors = dbSelect('id, name', 'blog_author', '', 'name ASC');

if ($_GET['edit']) {
    $oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
    $previewLink = blogLink(LINK_RELATIVE, $oldPost);
}

// Images upload settings
$imagesUpload = array(
    'dir' => IMAGES_BLOG,
    'thumbs' => array(
        THUMB_MEDIUM => array('1200', '630'),
        THUMB_FACEBOOK => array('1200', '630')
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
        'page_id' => array(
            'required' => true
        ),
        'author_id' => array(
            'required' => true
        ),
        'date_publish' => array(
            'required' => $_GET['edit'] ? false : true
        ),
        'title' => array(
            'required' => true,
            'remote' => array(
                'url' => 'index.php?page=@validate.unique',
                'type' => 'post',
                'data' => array(
                    'unique_table' => $table,
                    'unique_field_name' => 'title',
                    'unique_id' => $_GET['edit'],
                    'unique_where_name' => 'page_id',
                    'unique_where_value' => "function() {
                                    return $('#page_id').val();
                                }",
                    'unique_change_id' => 'page_id',
                    'unique_field_id' => 'title'
                )
            )
        ),
        'imageKey' => array(
            'required' => (($_GET['edit']) ? false : true)
        ),
        'site_canonical' => array(
            'url' => true
        )
    ),
    array(
        'title' => array(
            'remote' => 'Titlul introdus este deja existent.'
        ),
        'imageKey' => array(
            'required' => 'Incarcati o imagine.'
        )
    )
);

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm')) {

        // URL Rewrite
        $_POST['url_key'] = rewriteEnc($_POST['title']);
        while (!dbUnique(
            $table,
            'url_key',
            $_POST['url_key'],
            $_GET['edit'],
            'page_id = ' . dbEscape($_POST['page_id'])
        )) {
            $_POST['url_key'] .= '-';
        }

        // Date publish
        if ($_POST['date_publish'] && !$_GET['edit']) {
            $_POST['date_publish'] = strtotime($_POST['date_publish']);
        }

        // Date update
        if ($_POST['is_date_update']) {
            $_POST['date_update'] = time();
        }

        // Sanitize metadata
        $_POST['metadata'] = dbSpecialChars($_POST['metadata']);

        // Outbound links
        $outboundLinks = getOutboundLinks($_POST['text']);

        if (isset($outboundLinks['outbound'])) {
            $_POST['outbound'] = $outboundLinks['outbound'];
            $_POST['metadata']['outbound_links'] = $outboundLinks['outbound_links'];
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

            // Log action
            if (!$_POST['date_update']) {
                unset($_POST['date_update'], $oldPost['date_update']);
            }

            $statusYesNo = ['Nu', 'Da'];

            $entitiesById = [
                'page_id' => array_column($pages, 'link_name', 'id'),
                'author_id' => array_column($authors, 'name', 'id'),
                'is_home' => $statusYesNo,
                'is_evergreen' => $statusYesNo,
                'is_toc' => $statusYesNo,
                'is_noindex' => $statusYesNo,
                'status' => STATUS_TYPES
            ];

            // Metadata
            $oldPost = array_merge($oldPost ?: [], $oldPost['metadata'] ?: []);
            $_POST = array_merge($_POST, $_POST['metadata'] ?: []);

            $oldPost['video_intro'] = $oldPost['video_intro'] ? htmlspecialchars_decode($oldPost['video_intro']) : '';
            $_POST['video_intro'] = $_POST['video_intro'] ? htmlspecialchars_decode($_POST['video_intro']) : '';

            userAction($id, ENTITY_BLOG, $_POST, $oldPost, $entitiesById);

            // Associate content blocks as entities
            $success = entityAddBlocks(ENTITY_BLOG, $id, $_POST['text']);

            if (!$success) {
                alertsAdd('Asocierea cu blocurile de continut nu a putut fi efectuata.', 'error');
            }

            // Create redirect
            if ($oldPost && $_POST['status'] && $_POST['is_redirect']) {
                // Page link
                $oldLink = $previewLink;
                $newLink = blogLink(LINK_RELATIVE, $_POST);

                // Check if is redirect from parent change or from page name
                if (
                    $oldPost['page_id'] != (int)$_POST['page_id']
                    || $oldPost['title'] != $_POST['title']
                ) {
                    dbRedirectAdd(
                        $newLink,
                        $oldLink,
                        ENTITY_BLOG
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
    } else {
        $_POST['date_publish'] = time();
    }
}

// Init datepicker
formDatepicker('date_publish_dummy');

// Init select2
formSelect2(array(
    'id' => 'page_id',
    'options' => array(
        'width' => '100%'
    )
));

formSelect2(array(
    'id' => 'author_id',
    'options' => array(
        'width' => '100%'
    )
));

// Editor init
formEditor('text', [], 'cmsblocks');
