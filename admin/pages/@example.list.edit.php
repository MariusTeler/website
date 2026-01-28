<?php

global $retPage;

$table = '';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

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
                    'unique_table' => '',
                    'unique_field_name' => '',
                    'unique_id' => $_GET['edit'],
                    'unique_where_name' => '',
                    'unique_where_value' => "function() {
                        return $('#').val();
                    }",
                    'unique_change_id' => '',
                    'unique_field_id' => ''
                )
            )
        ),
        'email' => array(
            'required' => true,
            'email' => true,
            'minlength' => 10,
            'maxlength' => 30,
            'equalTo' => '#field'
        ),
        'url' => array(
            'url' => true
        ),
        'metadata[address]' => array(
            'required' => true
        ),
        'metadata[map]' => array(
            'required' => true
        ),
        'page' => array(
            'required' => "function(element){
                return ($(element.form).find(\"[name='parent_id']\").val().length >= 1);
            }"
        ),
        'imageKey' => array(
            'required' => (($_GET['edit']) ? false : true)
        )
    ),
    array(
        'name' => array(
            'remote' => 'Numele introdus este deja existent.'
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
        // Old data
        if ($_GET['edit']) {
            $oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
        }

        // Init ordering index
        if (
            !$_GET['edit']
            || $oldPost['parent_id'] != (int)$_POST['parent_id']
        ) {
            $_POST['ord'] = dbOrderIndex($table, 'parent_id = ' . dbEscape($_POST['parent_id']));
        }

        // URL Rewrite
        $_POST['url_key'] = rewriteEnc($_POST['title']);
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

        // Preview link
        $previewLink = makeLink(LINK_RELATIVE, $_POST) . '?preview=1';

        // Crop init
        formUploadCropInit($imagesUpload);
    }
}

// Parents
$parents = dbSelect('id, name', $table, 'parent_id = 0', 'ord ASC');

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

// Init datepicker
formDatepicker('date');

// Init select2
formSelect2(array(
    'id' => 'parent_id',
    'options' => array(
        'width' => '100%'
    )
));

formSelect2(array(
    'id' => 'parent_id',
    'options' => array(
        'templateResult' => ['type' => 'callback', 'content' => 'formatSelect2'],
        'templateSelection' => ['type' => 'callback', 'content' => 'formatSelect2Selection'],
        'width' => '100%'
    )
));

formSelect2(array(
    'id' => 'parent_id',
    'options' => array(
        'width' => '100%',
        'templateResult' => ['type' => 'callback', 'content' => 'formatSelect2'],
        'templateSelection' => ['type' => 'callback', 'content' => 'formatSelect2Selection'],
        'minimumInputLength' => 1,
        'ajax' => [
            'type' => 'callback',
            'content' => "
                {
                    url: 'index.php?page=@example.ajax.children',
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        return {
                            q: params.term,
                            page_nr: params.page
                        }
                    },
                    processResults: processResultsSelect2
                }
            "
        ]
    )
));

// Editor init
formEditor('text');
