<?php

if ($_GET['ajax'] && $_GET['coverage_county']) {
    $cities = dbSelect(
        'id AS value, name AS text',
        'dsc_city',
        'county_code = ' . dbEscape($_GET['coverage_county']),
        'name ASC'
    );
    array_unshift($cities, ['value' => '', 'text' => '']);

    ajaxResponse([], [], [['id' => 'coverage_city', 'value' => $cities]]);
}

$cities = dbSelect(
    'county.name AS county, county.code AS county_code, city.name AS city, city.km',
    'dsc_city city JOIN dsc_county county ON city.county_code = county.code',
    '',
    'county.name ASC, city.name ASC'
);

$counties = array_column($cities, 'county', 'county_code');

formSelect2(array(
    'id' => 'coverage_county',
    'options' => array(
        'width' => '100%',
        'allowClear' => 0,
        'theme' => 'bootstrap-5',
        'placeholder' => ''
    )
));

formSelect2(array(
    'id' => 'coverage_city',
    'options' => array(
        'width' => '100%',
        'allowClear' => 0,
        'theme' => 'bootstrap-5',
        'placeholder' => ''
    )
));
