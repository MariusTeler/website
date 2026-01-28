<?php

$counties = dbSelect('code AS id, name','dsc_county', '', 'name ASC');
$counties = array_column($counties, null, 'id');

$formName = 'formCalculator';

// Form validation
$formRules = array(
    'tipExpeditie' => array(
        'required' => true
    ),
    'nrColete' => array(
        'required' => "function(element) {
            return ($(element.form).find(\"[name='tipExpeditie']:checked\").val() == 'colet');
        }",
        'digits' => true
    ),
    'height' => array(
        'digits' => true
    ),
    'length' => array(
        'digits' => true
    ),
    'width' => array(
        'digits' => true
    ),
    'greutate' => array(
        'required' => "function(element) {
            let tipExpeditie = $(element.form).find(\"[name='tipExpeditie']:checked\").val();
            
            return (tipExpeditie == 'colet' || tipExpeditie == 'palet');
        }",
        'min' => "function(element) {
            return ($(element.form).find(\"[name='tipExpeditie']:checked\").val() == 'palet' ? 10 : 1);
        }",
        'number' => true
    ),
    'valoareAsigurare' => array(
        'number' => true,
        'max' => 15000
    ),
    'valoareRamburs' => array(
        'number' => true
    ),
    'from_county' => array(
        'required' => true
    ),
    'from_city' => array(
        'required' => true
    ),
    'to_county' => array(
        'required' => true
    ),
    'to_city' => array(
        'required' => true
    )
);

$formMessages = array(
    'tipExpeditie' => array(
        'required' => ''
    ),
    'nrColete' => array(
        'required' => ''
    ),
    'greutate' => array(
        'required' => ''
    ),
    'from_county' => array(
        'required' => ''
    ),
    'from_city' => array(
        'required' => ''
    ),
    'to_county' => array(
        'required' => ''
    ),
    'to_city' => array(
        'required' => ''
    )
);

$formOptions = array(
    'submitHandler' => "function() {
            var submit = $('#{$formName}_submit');

            submit.fadeTo(0, 0.4);
            submit.prop('disabled', true);
            submit.val(submit.data('message-loading'));
            
            $('#tarifWrapper').html('');
            ajaxRequest('{$websiteURL}index.php?page=cms.various.calculator', [], 'POST', '#{$formName}');
        }"
);

formInit($formName, $formRules, $formMessages, $formOptions);

if ($_GET['ajax']) {
    $contents = $fields = $options = $css = $functions = [];

    // County and cities dropdowns
    if ($_GET['from_county'] || $_GET['to_county']) {
        $cities = dbSelect(
            'id AS value, name AS text',
            'dsc_city',
            'county_code = ' . dbEscape($_GET['from_county'] ?: $_GET['to_county']),
            'name ASC'
        );
        array_unshift($cities, ['value' => '', 'text' => '']);

        $options = [
            [
                'id' => $_GET['from_county'] ? 'from_city' : 'to_city',
                'value' => $cities
            ]
        ];
    }

    // Form submit
    if (formPost($formName)) {
        if (formValid($formName)) {
            try {
                // From city
                $fromCity = dbSelect('*', 'dsc_city', 'id = ' . dbEscape($_POST['from_city']));

                // To county
                $toCity = dbSelect('*', 'dsc_city', 'id = ' . dbEscape($_POST['to_city']));

                // API parameters in JSON format
                $apiJson = [
                    'judExp' => $counties[$_POST['from_county']]['name'],
                    'locaExp' => dbShiftKey($fromCity, 'name'),
                    'judDest' => $counties[$_POST['to_county']]['name'],
                    'locaDest' => dbShiftKey($toCity, 'name'),
                    'tipExpeditie' => $_POST['tipExpeditie'],
                    'nrColete' => $_POST['nrColete'],
                    'greutate' => $_POST['greutate'],
                    'inaltime' => $_POST['height'],
                    'lungime' => $_POST['length'],
                    'latime' => $_POST['width'],
                    'valoareAsigurare' => $_POST['valoareAsigurare'] ?: 0,
                    'valoareRamburs' => $_POST['valoareRamburs'] ?: 0,
                    'tipPlata' => $_POST['tipPlata'],
                    'retNt' => '0',
                    'retDoc' => '0',
                    'tarifUrgenta' => '0',
                    'livrareSediu' => '0',
                    'tarifSambata' => $_POST['tarifSambata'] ? 1 : 0,
                    'deschidereColet' => $_POST['deschidereColet'] ? 1 : 0,
                    'sms' => '0'
                ];

                // API URL
                $apiURL = settingsGet('dsc-api-url') . DSC_ENDPOINT_AWB_COST;

                // Authorize
                $context = dscAPIAuthorize(
                    settingsGet('dsc-api-username'),
                    settingsGet('dsc-api-password'),
                    'POST',
                    true,
                    true,
                    $apiJson
                );

                // Fetch data
                $data = dscAPIExecute($apiURL, $context);

                // Check if data is valid
                if (!$data || !is_array($data)) {
                    throw new Exception('Datele sunt invalide.');
                }

                // Return calculated tarif
                parseVar('data', $data, 'cms.various.calculator.tarif');
                $html = parseView('cms.various.calculator.tarif');

                $contents[] = array(
                    'id' => 'tarifWrapper',
                    'value' => $html
                );

                $functions[] = array(
                    'id' => 'scrollToTarget',
                    'params' => ['#tarifWrapper']
                );
            } catch (Exception $e) {
                $error = 'API DSC - AWB Cost: ' . $e->getMessage();
                error_log($error);
                $functions[] = [
                    'id' => 'alert',
                    'params' => ['A apărut o eroare. Te rugam sa încerci mai târziu.']
                ];
            }
        } else {
            $css[] = array(
                'id' => "{$formName}_errors_top",
                'property' => 'display',
                'value' => 'block'
            );
            $css[] = array(
                'id' => "{$formName}_errors_bottom",
                'property' => 'display',
                'value' => 'block'
            );
        }

        $functions[] = array(
            'id' => 'formReactivateById',
            'params' => array($formName)
        );
    }

    ajaxResponse($contents, $fields, $options, $css, [], $functions);
}

formSelect2(array(
    'id' => 'from_county',
    'options' => array(
        'width' => '100%',
        'allowClear' => 0,
        'theme' => 'bootstrap-5',
        'placeholder' => ''
    )
));

formSelect2(array(
    'id' => 'from_city',
    'options' => array(
        'width' => '100%',
        'allowClear' => 0,
        'theme' => 'bootstrap-5',
        'placeholder' => ''
    )
));

formSelect2(array(
    'id' => 'to_county',
    'options' => array(
        'width' => '100%',
        'allowClear' => 0,
        'theme' => 'bootstrap-5',
        'placeholder' => ''
    )
));

formSelect2(array(
    'id' => 'to_city',
    'options' => array(
        'width' => '100%',
        'allowClear' => 0,
        'theme' => 'bootstrap-5',
        'placeholder' => ''
    )
));
