<?php

$counties = dbSelect('code AS id, name','dsc_county', '', 'name ASC');
$counties = array_column($counties, null, 'id');

// Form steps
const FORM_STEP1 = 1;
const FORM_STEP2 = 2;
const FORM_STEP3 = 3;
const FORM_STEP4 = 4;
const FORM_STEP5 = 5;

// Form validation
$form = [
    FORM_STEP1 => [
        'name' => 'formSendStep1',
        'rules' => [
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
            'locPlata' => array(
                'required' => true
            ),
            'valoareAsigurare' => array(
                'number' => true,
                'max' => 15000
            ),
            'valoareRamburs' => array(
                'number' => true
            )
        ],
        'messages' => [
            'tipExpeditie' => array(
                'required' => ''
            ),
            'nrColete' => array(
                'required' => ''
            ),
            'greutate' => array(
                'required' => ''
            ),
        ],
        'options' => [
            'submitHandler' => "function() {
                showNext(" . FORM_STEP1 . ");                
            }"
        ]
    ],
    FORM_STEP2 => [
        'name' => 'formSendStep2',
        'rules' => [
            'from_name' => array(
                'required' => true
            ),
            'from_email' => array(
                'required' => true,
                'email' => true
            ),
            'from_phone' => array(
                'required' => true
            ),
            'from_county' => array(
                'required' => true
            ),
            'from_city' => array(
                'required' => true
            ),
            'from_address' => array(
                'required' => true
            ),
            'from_zipcode' => array(
                'digits' => true
            )
        ],
        'messages' => [
            'from_county' => array(
                'required' => ''
            ),
            'from_city' => array(
                'required' => ''
            ),
        ],
        'options' => [
            'submitHandler' => "function() {
                showNext(" . FORM_STEP2 . ");
            }"
        ]
    ],
    FORM_STEP3 => [
        'name' => 'formSendStep3',
        'rules' => [
            'to_name' => array(
                'required' => true
            ),
            'to_email' => array(
                'email' => true
            ),
            'to_phone' => array(
                'required' => true
            ),
            'to_county' => array(
                'required' => true
            ),
            'to_city' => array(
                'required' => true
            ),
            'to_address' => array(
                'required' => true
            ),
            'to_zipcode' => array(
                'digits' => true
            )
        ],
        'messages' => [
            'to_county' => array(
                'required' => ''
            ),
            'to_city' => array(
                'required' => ''
            )
        ],
        'options' => [
            'submitHandler' => "function() {
                var submit = $('#formSendStep3_submit');
    
                submit.fadeTo(0, 0.4);
                submit.prop('disabled', true);
                submit.val(submit.data('message-loading'));
                
                ajaxRequest(
                    '{$websiteURL}index.php?page=cms.various.send', 
                    [], 
                    'POST', 
                    '#formSendStep1, #formSendStep2, #formSendStep3'
                );
            }"
        ]
    ],
    FORM_STEP4 => [
        'name' => 'formSendStep4',
        'rules' => [],
        'messages' => [],
        'options' => [
            'submitHandler' => "function() {
                var submit = $('#formSendStep4_submit');
    
                submit.fadeTo(0, 0.4);
                submit.prop('disabled', true);
                submit.val(submit.data('message-loading'));
                
                ajaxRequest(
                    '{$websiteURL}index.php?page=cms.various.send', 
                    [], 
                    'POST', 
                    '#formSendStep1, #formSendStep2, #formSendStep3, #formSendStep4'
                );
            }"
        ]
    ]
];

// Initialize form validation for each step
for ($i = 1; $i <= 4; $i ++) {
    $formStep = constant('FORM_STEP' . $i);

    formInit(
        $form[$formStep]['name'],
        $form[$formStep]['rules'],
        $form[$formStep]['messages'],
        $form[$formStep]['options'],
    );
}

if ($_GET['ajax']) {
    $contents = $fields = $options = $css = $functions = [];

    // Form submit
    if (formPost('formSendStep3') || formPost('formSendStep4')) {
        formInit(
            $_POST['formId'],
            array_merge($form[FORM_STEP1]['rules'], $form[FORM_STEP2]['rules'], $form[FORM_STEP3]['rules'])
        );

        if (formValid($_POST['formId'])) {
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
                    'inaltime' => $_POST['height'],
                    'lungime' => $_POST['length'],
                    'latime' => $_POST['width'],
                    'greutate' => $_POST['greutate'],
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

                // If it's the last step, change parameters and API URL
                if (formPost('formSendStep4')) {
                    // Append API parameters
                    $apiJson = array_merge($apiJson, [
                        'ret_colet' => $_POST['ret_colet'] ? 1 : 0,
                        'locPlata' => $_POST['locPlata'],
                        'expeditor' => (settingsGet('dsc-api-prefix-expeditor') ?: '') . $_POST['from_name'],
                        'telExp' => $_POST['from_phone'],
                        'adrExp' => $_POST['from_address'],
                        'cpExp' => $_POST['from_zipcode'],
                        'destinatar' => $_POST['to_name'],
                        'telDest' => $_POST['to_phone'],
                        'adrDest' => $_POST['to_address'],
                        'cpDest' => $_POST['to_zipcode'],
                        'observatii' => (
                                settingsGet('dsc-api-prefix-observatii')
                                    ? settingsGet('dsc-api-prefix-observatii') . PHP_EOL
                                    : ''
                            )
                            . $_POST['continut'] . PHP_EOL
                            . $_POST['observatii']
                    ]);

                    // API URL
                    $apiURL = settingsGet('dsc-api-url') . DSC_ENDPOINT_AWB_SEND;
                }

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
                if (formPost('formSendStep3')) {
                    parseVar('data', $data, 'cms.various.send.tarif');
                    $html = parseView('cms.various.send.tarif');

                    $contents[] = array(
                        'id' => 'tarifWrapper',
                        'value' => $html
                    );

                    $functions[] = array(
                        'id' => 'showNext',
                        'params' => [FORM_STEP3]
                    );
                } else {
                    // Generate Pickup
                    $apiJson = [
                        'awb' => $data['awb']
                    ];

                    // API URL
                    $apiURL = settingsGet('dsc-api-url') . DSC_ENDPOINT_PICKUP_SEND;

                    // Authorize
                    $context = dscAPIAuthorize(
                        settingsGet('dsc-api-username'),
                        settingsGet('dsc-api-password'),
                        'POST',
                        true,
                        true,
                        $apiJson
                    );

                    // Call API for pickup
                    try {
                        $dataPickup = dscAPIExecute($apiURL, $context);
                        $isPickupError = false;
                    } catch (Exception $e) {
                        $isPickupError = true;

                        $error = 'API DSC - AWB Send > Pickup: ' . $e->getMessage();
                        error_log($error);
                    }

                    // Save AWB number for later pdf download
                    sessionSet('awb', $data['awb']);

                    // Get AWB pdf for printing
                    $isPdfError = false;
                    $pdf = dscAPIAwbPdf($data['awb']);

                    // Send AWB pdf via email
                    if ($pdf !== false) {
                        // Email messages
                        $awbEmail = variousGet('send-awb-form-email', true, false);
                        $awbEmail['title'] = str_replace(
                            '{awb}',
                            $data['awb'],
                            $awbEmail['title']
                        );
                        $awbEmail['text'] = str_replace(
                            '{from_name}',
                            $_POST['from_name'],
                            $awbEmail['text']
                        );

                        // Write AWB pdf to temporary file
                        $awbPdf = tempnam(sys_get_temp_dir(), '');
                        file_put_contents($awbPdf, $pdf);

                        // Send email
                        $isPdfError = !mailSend(
                                $_POST['from_email'],
                                $awbEmail['title'],
                                mailFormat($awbEmail['text']),
                                settingsGet('email-reply-to-address'),
                                [
                                    [
                                        'path' => $awbPdf,
                                        'name' => "Eticheta AWB nr {$data['awb']}.pdf"
                                    ]
                                ]
                            );

                        // Destroy temporary file
                        unlink($awbPdf);
                    } else {
                        $isPdfError = true;
                    }

                    parseVar('data', $data, 'cms.various.send.awb');
                    parseVar('isPickupError', $isPickupError, 'cms.various.send.awb');
                    parseVar('isPdfError', $isPdfError, 'cms.various.send.awb');
                    $html = parseView('cms.various.send.awb');

                    $contents[] = array(
                        'id' => 'awbWrapper',
                        'value' => $html
                    );

                    $functions[] = array(
                        'id' => 'showNext',
                        'params' => [FORM_STEP4]
                    );
                }
            } catch (Exception $e) {
                $error = 'API DSC - AWB Send: ' . $e->getMessage();
                error_log($error);
                $functions[] = [
                    'id' => 'alert',
                    'params' => ['A apărut o eroare. Te rugam sa încerci mai târziu.']
                ];
            }
        } else {
            /*$css[] = array(
                'id' => "{$_POST['formId']}_errors_top",
                'property' => 'display',
                'value' => 'block'
            );*/
            $css[] = array(
                'id' => "{$_POST['formId']}_errors_bottom",
                'property' => 'display',
                'value' => 'block'
            );
        }

        $functions[] = array(
            'id' => 'formReactivateById',
            'params' => array($_POST['formId'])
        );
    }

    ajaxResponse($contents, $fields, $options, $css, [], $functions);
}

// Download AWB pdf on button press
if ($_GET['download']) {
    try {
        // Get AWB number
        $awb = sessionGet('awb');

        if (!$awb) {
            throw new Exception();
        }

        // Get pdf file via API
        $pdf = dscAPIAwbPdf($awb);

        if (!$pdf) {
            throw new Exception();
        }

        // Set pdf and download headers
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=\"Eticheta AWB nr {$awb}.pdf\"");
        echo $pdf;
        exit;
    } catch (Exception $e) {
        redirectURL(makeLink(LINK_RELATIVE, getPageByKey('name', SECTION_404, true, 'url_key')));
    }
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
