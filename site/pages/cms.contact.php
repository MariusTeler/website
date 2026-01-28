<?php

// Check if form is block
$various = getVar('various', $p__);
if ($_POST['formBlock']) {
    $various = dbShift(dbSelect(
        '*',
        'cms_various',
        'status = 1 AND id = ' . dbEscape($_POST['formBlock'])
    ));
}

$formType = FORM_CONTACT;
$formEmail = settingsGet('email-notify');
$formName = 'formContact';
$emailTemplate = 'cms.contact.email';

// Form validation
$formRules = array(
    'name' => array(
        'required' => true
    ),
    'phone' => array(
        'required' => true
    ),
    'email' => array(
        'required' => true,
        'email' => true
    ),
    'message' => array(
        'required' => true,
        'maxlength' => 1200
    ),
    'gdpr' => array(
        'required' => true
    )
);

$formMessages = array(
    'gdpr' => array(
        'required' => ''
    )
);

if ($various) {
    $formEmail = $various['metadata']['contact_email'] ?: $formEmail;
    $formName .= '-' . $various['id'];
    switch ($various['type']) {
        case VARIOUS_CONTACT:
            $emailTemplate = 'cms.contact.email.normal';
            unset($formRules['phone']);
            $formRules['subject'] = array(
                'required' => true
            );
            break;
        case VARIOUS_CONTACT_BUSINESS:
            $emailTemplate = 'cms.contact.email.business';
            unset($formRules['phone']);
            $formRules['volume'] = array(
                'required' => true
            );
            $formType = FORM_CONTACT_BUSINESS;
            break;
    }
}

$formOptions = array(
    'submitHandler' => "function() {
            var submit = $('#{$formName}_submit');

            submit.fadeTo(0, 0.4);
            submit.prop('disabled', true);
            submit.val(submit.data('message-loading'));
            ajaxRequest('{$websiteURL}index.php?page=cms.contact', [], 'POST', '#{$formName}');
        }"
);

formInit($formName, $formRules, $formMessages, $formOptions);

if ($_GET['ajax']) {
    if (formPost($formName)) {
        $contents = $css = $functions = array();

        if (formValid($formName)) {
            // Sanitize input data
            $data = dbStripTags($_POST);

            // Save data to DB
            $id = dbInsert('cms_contact', array(
                'type' => $formType,
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'message' => $_POST['message'],
                'date' => time(),
                'ip' => $_SERVER['REMOTE_ADDR'],
                'metadata' => [
                    'subject' => $data['subject'],
                    'volume' => $data['volume']
                ]
            ));

            // Save action
            userAction($id, ENTITY_CONTACT, [], []);

            // Sanitize input data for email
            $data = dbSpecialChars($data);

            // Id for admin
            $data['id'] = $id;

            // Send data as email
            parseVar('data', $data, $emailTemplate);
            $message = parseView($emailTemplate);

            mailSend(
                $formEmail,
                'Formular contact: ' . $data['name'] . ' (' . date('d.m.Y H:i') . ')',
                mailFormat($message),
                settingsGet('email-reply-to-address')
            );

            $contactResponse = variousGet('contact-thank-you', true, false);
            $contents[] = array(
                'id' => $formName,
                'value' => $contactResponse['text']
            );

            $functions[] = array(
                'id' => 'eventAnalytics',
                'params' => ['#' . $formName, 1]
            );
            $functions[] = array(
                'id' => 'scrollToTarget',
                'params' => ['#' . $formName]
            );
        } else {
            $css[] = array(
                'id' => "{$formName}_errors_top",
                'property' => 'display',
                'value' => 'block'
            );

            $functions[] = array(
                'id' => 'formReactivateById',
                'params' => array($formName)
            );
        }

        ajaxResponse($contents, array(), array(), $css, array(), $functions);
    }
}

$contact = variousGet('contact-form', true, false);
