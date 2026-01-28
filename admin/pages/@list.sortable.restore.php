<?php
/*
 * @todo: Add comments & examples
 */
if ($_GET['ajax']) {
    $contents = $fields = $options = $css = $attributes = $functions = array();

    $functions[] = array('id' => 'sortableRestore', 'params' => array($_GET['list_id']));

    ajaxResponse($contents, $fields, $options, $css, $attributes, $functions);
}

die;
