<?php
if ($_GET['ajax']) {
    $contents = $fields = $options = $css = $attributes = $functions = array();

    parseBlock('back.help.edit');

    if ($_GET['tooltip']) {
        // JavaScript function to execute
        $functions[] = array('id' => 'loadHelpTooltip', 'params' => array(parseView('back.help.edit'), $_GET['modal']));
    } else {
        // Contents
        $contents[] = array('id' => 'boxHelp', 'value' => parseView('back.help.edit'));

        // Other displays
        $css[] = array('id' => 'boxHelp', 'property' => 'display', 'value' => 'block');

        // JavaScript functions to execute
        if (!formPost('editForm') && $_GET['edit'] && userGetAccess(ADMIN_SUPERADMIN)) {
            $functions[] = array('id' => 'loadHelpEditor', 'params' => array());
        }
    }

    ajaxResponse($contents, $fields, $options, $css, $attributes, $functions);
} else {
    die();
}
