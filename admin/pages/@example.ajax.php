<?php
/*
 * @todo: Add comments & examples
 */
if ($_GET['ajax']) {
    $contents = $fields = $options = $css = $attributes = $functions = array();

    $contents[] = array('id' => '', 'value' => '');

    $fields[] = array('id' => '', 'value' => '');
    $fields[] = array('id' => 'ckeckbox', 'value' => 'checked');

    $blank[] = array('value' => '', 'text' => '');
    $opts[] = array('value' => '', 'text' => '');
    $options[] = array('id' => '', 'value' => array_merge($blank, $opts));

    $css[] = array('id' => '', 'property' => '', 'value' => '');

    $attributes[] = array('id' => '', 'attribute' => '', 'value' => '');

    $functions[] = array('id' => 'alert', 'params' => array('a', 'b', 'c'));

    ajaxResponse($contents, $fields, $options, $css, $attributes, $functions);
}

die;
