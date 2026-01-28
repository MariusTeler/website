<?php

const STATUS_REGISTERED = 'registered';
const STATUS_PICKED = 'picked';
const STATUS_TRANSIT = 'transit';
const STATUS_DELIVERY = 'delivery';
const STATUS_DELIVERED = 'delivered';
const STATUS_RETURNED = 'returned';
const STATUS_REDIRECTED = 'redirected';
const STATUS_APPROVED = 'approved';

$statusText = [
    STATUS_DELIVERED => 'Livrat',
    STATUS_RETURNED => 'Returnat',
    STATUS_REDIRECTED => 'Redirecționat',
    STATUS_APPROVED => 'Avizat',
];

$statusList = [
    STATUS_PICKED => ['Preluata -> Preluata', 'Colectata -> Preluata'],
    STATUS_TRANSIT => [
        'Colectata -> PLS',
        'Preluata -> Intrare Centru',
        'Preluata -> Intrare Agent',
        'Preluata -> Iesire Centru',
        'Colectata -> Iesire Centru',
        'Colectata -> Intrare Centru',
        'Colectata -> EIA',
        'Preluata -> EIA',
        'Preluata -> ECS',
        'Retinut -> Intrare Centru',
        'Reexpediat -> EIA - Exceptie in Asteptare',
        'Reavizat -> Iesire Centru'
    ],
    STATUS_DELIVERY => ['Preluata -> Iesire Agent', 'Colectata -> Iesire Agent'],
    STATUS_DELIVERED => [
        'Livrat',
        'Preluata -> COK - Livrare Efectuata cu succes'
    ],
    STATUS_RETURNED => ['Returnat'],
    STATUS_REDIRECTED => ['Redirectionat'],
    STATUS_APPROVED => [
        'Avizat',
        'Livrare nereusita',
        'Preluata -> ENL - Exceptie Expeditie Nelivrata'
    ],
    STATUS_REGISTERED => ['Colectata'] // It's last because it can also be found in other statuses
];

$various = getVar('various', $p__);

// Check if tracking AWB is enabled and AWB number is present
$awbInfo = [];
if ($various['metadata']['hero_tracking_awb'] && strlen(trim($_GET['awb']))) {
    try {
        // AWB number
        $awbNo = trim($_GET['awb']);

        // API URL
        $apiURL = settingsGet('dsc-api-old-url') . sprintf(DSC_ENDPOINT_AWB_TRACKING_OLD, urlencode($awbNo));

        // Authorize (no username or password needed, since we are using old API)
        $context = dscAPIAuthorize('', '');

        // Fetch data
        $dataRaw = file_get_contents($apiURL, false, $context);

        // Get response code
        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = $match[1];

        if ($status !== '200') {
            // Throw error message
            throw new Exception("Error: {$status_line}" . PHP_EOL . $dataRaw);
        }

        $data = strip_tags($dataRaw);

        if (stristr($data, 'invalida')) {
            $awbInfo['error'] = "Codul AWB introdus este invalid.\n Te rugăm să încerci din nou.";
        } else {
            foreach ($statusList as $statusType => $statusValues) {
                foreach ($statusValues as $value) {
                    if (stristr($dataRaw, '- ' . $value)) {
                        $awbStatus = $statusType;
                        break 2;
                    }
                }
            }

            if (!isset($awbStatus)) {
                // Throw error message
                throw new Exception("Error: Status negasit" . PHP_EOL . $dataRaw);
            }

            $data = explode('/', stristr($data, '-'));
            $awbInfo = [
                'status' => substr(trim($data[0]), 2),
                'location' => trim($data[1]),
            ];

            setView($p__, 'cms.various.hero.status');
        }
    } catch (Exception $e) {
        $error = 'API DSC - AWB Tracking: ' . $e->getMessage();

        $awbInfo['error'] = "A apărut o eroare.\n Te rugăm să încerci mai târziu.";
        error_log($error);
    }
}