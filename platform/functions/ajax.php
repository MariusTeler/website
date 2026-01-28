<?php
/**
 * Return a JSON object as a response to an ajaxRequest() function call from client-side
 *
 * @param array $contents HTML contents to be updated, as a multidimensional array
 *                        with 'key' as HTML element id and 'value' as element HTML content
 * @param array $fields Fields to be updated, as a multidimensional array with 'key' as HTML field id
 *                      and 'value' as field value. For checkbox, 'checked' should be used as value
 * @param array $options Select element options to be updated, as a multidimensional array
 *                       with 'key' as HTML select id and 'value' as an multidimensional array of options
 *                       ('value' as option value, 'text' as option text)
 * @param array $css CSS properties to be updated, as a multidimensional array with 'key' as HTML element id,
 *                   'property' as CSS property, 'value' as CSS property value
 * @param array $attributes HTML attributes to be updated, as a multidimensional array with 'key' as HTML element id,
 *                          'attribute' as attribute name, 'value' as attribute value
 * @param array $functions JavaScript functions to be executed, as a multidimensional array with 'id' as
 *                         function name and 'value' as an array of functions params
 */
function ajaxResponse(
    $contents,
    $fields = array(),
    $options = array(),
    $css = array(),
    $attributes = array(),
    $functions = array()
) {
    $response = array(
        'contents' => array(),
        'fields' => array(),
        'options' => array(),
        'css' => array(),
        'attributes' => array(),
        'functions' => array()
    );

    if ($contents) {
        $response['contents'] = $contents;
    }

    if ($fields) {
        $response['fields'] = $fields;
    }

    if ($options) {
        $response['options'] = $options;
    }

    if ($css) {
        $response['css'] = $css;
    }

    if ($attributes) {
        $response['attributes'] = $attributes;
    }

    if ($functions) {
        $response['functions'] = $functions;
    }

    echo json_encode($response);
    die;
}
