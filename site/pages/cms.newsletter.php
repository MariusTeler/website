<?php
use \Mailjet\Resources;

$formName = 'formNewsletter';
if (getVar('isHeader', $p__) || $_POST['isHeader']) {
    $formName = 'formNewsletterHeader';
    setView($p__, 'cms.newsletter.header');
}

// Form validation
$formRules = array(
    'email' => array(
        'required' => true,
        'email' => true
    ),
    'gdpr' => array(
        'required' => false
    )
);

$formMessages = array(
    'email' => array(
        'required' => ''
    ),
    'gdpr' => array(
        'required' => ''
    )
);

$formOptions = array(
    'submitHandler' => "function() {
            var submit = $('#{$formName}_submit');

            submit.fadeTo(0, 0.4);
            submit.prop('disabled', true);
            submit.val(submit.data('message-loading'));
            ajaxRequest('{$websiteURL}index.php?page=cms.newsletter', [], 'POST', '#{$formName}');
        }"
);

formInit($formName, $formRules, $formMessages, $formOptions);

if ($_GET['ajax']) {
    if (formPost($formName)) {
        $contents = $css = $functions = array();

        if (formValid($formName)) {
            // Subscribe contact to newsletter service via API
            $mj = new \Mailjet\Client(
                settingsGet('mailjet-api-key-public'),
                settingsGet('mailjet-api-key-private'),
                true,
                ['version' => 'v3']
            );
            $body = [
                //'IsExcludedFromCampaigns' => "true",
                //'Name' => "New Contact",
                'Email' => $_POST['email']
            ];
            $response = $mj->post(Resources::$Contact, ['body' => $body]);
            //$response->success() && var_dump($response->getData());

            // Success or error message
            if ($response->success()) {
                $contactResponse = variousGet('newsletter-thank-you', true, false);
            } elseif (
                $response->getData()
                && stristr($response->getData()['ErrorMessage'], 'Email already exists') !== false
            ) {
                $contactResponse['text'] = '<span class="text-warning ' . ($_POST['isHeader'] ? 'small' : '') . '">'
                    . 'Email-ul este deja abonat la newsletter.'
                    . '</span>';
            } else {
                $contactResponse['text'] = '<span class="text-danger">'
                    . 'Ne pare rau. A aparut o eroare. Te rugam sa incerci mai tarziu.'
                    . '</span>';
            }

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