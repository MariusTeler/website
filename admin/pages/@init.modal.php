<?php

// Render and return HTML
if ($_GET['ajax'] && $_GET['modal']) {
    unset($_GET['modal']);

    parseVar('modal', true);

    // Parse page
    parsePage(getPage());

    // Contents
    $contents = [
        [
            'id' => 'ajaxContainer',
            'value' => parseView(getPage())
        ]
    ];

    // Functions
    $functions = [
        [
            'id' => 'showModal',
            'params' => ['myModal']
        ],
        [
            'id' => 'initHelpTooltip',
            'params' => [getPage(), 1]
        ]
    ];

    ajaxResponse($contents, [], [], [], [], $functions);
}
