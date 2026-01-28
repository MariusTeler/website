<?php

global $retPage;

$table = 'cms_redirects';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Types
$types = array('301', '302');

// Form validation
formInit('editForm',
    array(
        'url_from' => array(
            'required' => true,
        ),
        'url_to' => array(
            'required' => true,
        ),
        'redirect_type' => array(
            'required' => true,
        )
    ),
    array()
);

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm')) {
        // Old POST
        if ($_GET['edit']) {
            $oldPost = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
        }

        // Insert / Update row
        $id = dbInsert($table, $_POST);

        // Notifications
        if ($id === false) {
            alertsAdd('Datele nu au putut fi salvate!', 'error');
            $id = $_GET['edit'];
        } else {
            alertsAdd('Datele au fost salvate cu success!', 'success');

            // Log actions
            $entitiesById = [
                'redirect_type' => array_combine($types, $types),
                'status' => STATUS_TYPES
            ];

            userAction($id, ENTITY_REDIRECT, $_POST, $oldPost, $entitiesById);
        }

        // Update $dbRedirects array
        updateDbRedirects();

        // Redirect
        formRedirect($retPage, $id);
    } else {
        $eClass = '';
    }
} else {
    if ($_GET['edit']) {
        $_POST = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($_GET['edit'])));
    }
}
