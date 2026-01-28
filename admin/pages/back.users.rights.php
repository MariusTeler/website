<?php

// Select all pages
$pagesDB = dbSelect('id, is_rights, page', 'back_pages');
$pagesByRights = array_column($pagesDB, 'is_rights', 'page');
