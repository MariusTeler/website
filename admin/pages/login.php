<?php

// Check for Google login
if ($_GET['ajax'] && strlen($_POST['code']) && $cfg__['login']['settings']['google']) {
    userLoginGoogle();
}

// Check for Facebook login
if ($_GET['ajax'] && strlen($_POST['fb_code']) && $cfg__['login']['settings']['facebook']) {
    userLoginFacebook();
}

// Check for Microsoft login
if (strlen($_GET['code']) && strlen($_GET['state']) && $cfg__['login']['settings']['microsoft']) {
    userLoginMicrosoft();
}

// Reset password
parsePage('login.reset');
