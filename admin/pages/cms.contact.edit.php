<?php

// Render and return HTML (if AJAX & modal)
parsePage('@init.modal');

global $retPage;

$table = 'cms_contact';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Old data
$oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));

if (!$oldPost) {
    redirectURL($retPage);
}

// Status
$status = dbSelect('*', 'nomen_status', '', 'ord ASC');

$modal = getVar('modal');

// Form validation
$formName = 'editForm';
$formOptions = [];

if ($modal) {
    $formOptions = array(
        'submitHandler' => "function() {
                var submit = $('#{$formName}_submit');
    
                submit.fadeTo(0, 0.4);
                submit.prop('disabled', true);
                submit.val(submit.data('message-loading'));
                ajaxRequest('index.php?page={$_GET['page']}&edit={$_GET['edit']}&modal=1', [], 'POST', '#{$formName}');
            }"
    );
}

formInit($formName,
    array(
        'status_id' => array(
            'required' => true
        )
    ),
    array(),
    $formOptions
);

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

        // Insert / Update row
        $id = dbInsert($table, $_POST);

        // Notifications
        if ($id === false) {
            alertsAdd('Datele nu au putut fi salvate!', 'error');
            $id = $_GET['edit'];
        } else {
            alertsAdd('Datele au fost salvate cu success!');

            // Log action
            $entitiesById = [
                'status_id' => array_column($status, 'name', 'id')
            ];

            userAction($id, ENTITY_CONTACT, $_POST, $oldPost, $entitiesById);
        }

        if (!$modal) {
            // Redirect
            formRedirect($retPage, $id);
        }
    } else {
        $eClass = '';
    }
}

if ($_GET['edit']) {
    // Set data to $_POST
    $_POST = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
}
