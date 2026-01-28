<?php

// API2 RESTFUL DRAGON STAR CURIER – V2.0.3
const DSC_ENDPOINT_COUNTIES = '/judete';
const DSC_ENDPOINT_CITIES = '/localitati/%s';
const DSC_ENDPOINT_AWB_TRACKING_OLD = '/getawb/%s';
const DSC_ENDPOINT_AWB_COST = '/awb/cost';
const DSC_ENDPOINT_AWB_SEND = '/awb/send';
const DSC_ENDPOINT_AWB_PDF = '/awb/pdf/%s';
const DSC_ENDPOINT_PICKUP_SEND = '/pickup/send';

/**
 * @param string $username Basic Auth Username (can be left empty for old API)
 * @param string $password Basic Auth Password (can be left empty for old API)
 * @param string $method GET | POST
 * @param bool $ignoreErrors Suppress errors
 * @param bool $json Send as JSON
 * @param array $jsonData Data for JSON
 * @return resource A stream context resource for file_get_contents API call
 */
function dscAPIAuthorize(
    string $username = '',
    string $password = '',
    string $method = 'GET',
    bool $ignoreErrors = false,
    bool $json = false,
    array $jsonData = []
) {
    $opts = array(
        'http' => array(
            'method' => $method,
            'header' => '',
            'ignore_errors' => $ignoreErrors,
        ),
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false
        )
    );

    if ($username && $password) {
        $auth = base64_encode("$username:$password");
        $opts['http']['header'] = ($opts['http']['header'] ? "\r\n" : '')
            ."Authorization: Basic $auth";  // Correct way to add Basic Auth
    }

    if ($json) {
        $opts['http']['header'] .= ($opts['http']['header'] ? "\r\n" : '')
            . "Content-type: application/json" . "\r\n"
            . "Content-length: " . strlen(json_encode($jsonData));
        $opts['http']['content'] = json_encode($jsonData);
    }

    return stream_context_create($opts);
}

/**
 * @param string $apiURL
 * @param resource $context A stream context resource for file_get_contents API call
 * @return array|mixed
 * @throws Exception
 */
function dscAPIExecute(string $apiURL, $context, $returRawData = false)
{
    // Fetch info
    $dataRaw = file_get_contents($apiURL, false, $context);

    // Get response code
    $status_line = $http_response_header[0];
    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
    $status = $match[1];

    // Decode json
    $data = [];
    if ($dataRaw !== false) {
        $data = json_decode($dataRaw, true);
    }

    // Get error message
    if ($status !== "200" && $status !== "201" && $status !== "202") {
        // Check if data is valid
        if ($data && is_array($data) && $data['message']) {
            $message = 'Code: ' . ($data['code'] ?: $data['error_type']) . PHP_EOL
                . 'Message: ' . $data['message'] . PHP_EOL;
        } else {
            $message = $dataRaw;
        }

        // Throw error message
        throw new Exception("Error: {$status_line}" . PHP_EOL . $message);
    }

    return $returRawData ? $dataRaw : $data;
}

function dscAPIAwbPdf(string $awb)
{
    // API URL
    $apiURL = settingsGet('dsc-api-url') . sprintf(DSC_ENDPOINT_AWB_PDF, $awb);

    // Authorize
    $context = dscAPIAuthorize(
        settingsGet('dsc-api-username'),
        settingsGet('dsc-api-password')
    );

    try {
        // Fetch data
        return dscAPIExecute($apiURL, $context, true);
    } catch (Exception $e) {
        $error = 'API DSC - AWB PDF: ' . $e->getMessage();
        error_log($error);

        return false;
    }
}
