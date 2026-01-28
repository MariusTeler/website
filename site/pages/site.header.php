<?php

// Current page
$id_page = getVar('id_page', getPage());

// Current subpage
$id_subpage = getVar('id_subpage', getPage());

// Get menu items
$menu = menuGet(MENU_HEADER);
