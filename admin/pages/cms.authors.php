<?php

global $curPage;

$table = 'blog_author';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];

if ($_GET['set_status']) {
    $r = dbStatus($table, $_GET['set_status']);

    // Log action
    if ($r) {
        userActionStatus(
            $_GET['set_status'],
            ENTITY_AUTHOR,
            $table,
            'status',
            ['Nu', 'Da']
        );
    }

    redirectURL($curPage . returnVar());
}

// Delete row with or without further verifications
if ($_GET['del']) {
    if (dbCheckDelete('blog', 'author_id', $_GET['del'])) {
        // Images delete settings
        $imagesUpload = array(
            'dir' => IMAGES_AUTHOR,
            'thumbs' => array(
                THUMB_SMALL => array()
            )
        );

        // Delete image
        formUploadDelete($imagesUpload, $table, $_GET['del']);

        $result = dbDelete($table, array('id' => $_GET['del']));

        if ($result === false) {
            alertsAdd('Stergerea nu a putut fi efectuata!', 'error');
        } else {
            alertsAdd('Stergerea a fost realizata cu success!');
        }
    } else {
        alertsAdd('Autorul are deja asociate postari pe blog.', 'error');
    }

    redirectURL($curPage . returnVar());
}

// List rows
$list = dbSelect(
    "*, (SELECT COUNT(blog.id) FROM blog WHERE author_id = {$table}.id) AS articles",
    $table,
    '',
    'name ASC'
);

// Authors page
$authorPage = getPageByKey('type', PAGE_TYPE_AUTHOR);

// Options
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
