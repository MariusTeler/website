<?php

global $retPage;

$table = 'cms_list';
$retPage = 'index.php?page=' . str_replace('.edit', '', $_GET['page']); // auto

// Form validation
formInit('editForm',
    array(
        'type' => array(
            'required' => !$_GET['edit']
        ),
        'title' => array(
            'required' => true
        ),
    ),
    array()
);

// Form processing
$eClass = 'hidden';
if (formPost('editForm')) {
    if (formValid('editForm')) {
        // Init ordering index
        if (!$_GET['edit']) {
            $_POST['ord'] = dbOrderIndex($table);
        } else {
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

            // Log action
            $entitiesById = [
                'status' => STATUS_TYPES
            ];

            userAction($id, ENTITY_LIST, $_POST, $oldPost, $entitiesById);
        }

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

// Editor init
formEditor('text');
