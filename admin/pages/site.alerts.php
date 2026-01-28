<?php

$alerts = sessionGet('alerts');
sessionSet('alerts', array());

if (is_array($alerts)) {
    foreach ($alerts as $i => $alert) {
        if (!(
            $alert['page'] == getPage()
            || $alert['page'] == getPage() . '.edit'
            || (substr(getPage(), -5) == '.edit' && $alert['page'] == substr(getPage(), 0, -5))
        )) {
            unset($alerts[$i]);
        }
    }
}

$alertClasses = array(
    'error' => 'danger',
    'success' => 'success',
    'info' => 'info',
    'warning' => 'warning'
);
