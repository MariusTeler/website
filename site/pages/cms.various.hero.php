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
$awbHistory = [];

if ($various['metadata']['hero_tracking_awb'] && strlen(trim($_GET['awb']))) {
    try {
        // AWB number
        $awbNo = trim($_GET['awb']);

        // Check which API to use (setting: 'old' or 'new')
        $trackingApiVersion = settingsGet('dsc-tracking-api') ?: 'old';

        if ($trackingApiVersion === 'new') {
            // ========== NEW API ==========
            $apiURL = settingsGet('dsc-api-url') . sprintf(DSC_ENDPOINT_AWB_TRACKING, urlencode($awbNo));

            // Authorize with Basic Auth credentials for tracking
            $context = dscAPIAuthorize(
                settingsGet('dsc-tracking-username'),
                settingsGet('dsc-tracking-password')
            );
            $dataRaw = file_get_contents($apiURL, false, $context);

            // Get response code
            $status_line = $http_response_header[0];
            preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
            $status = $match[1];

            if ($status !== '200') {
                throw new Exception("Error: {$status_line}" . PHP_EOL . $dataRaw);
            }

            // Decode JSON response
            // Format: {"data":"2026-01-27 13:53:57","status":"Livrat","detalii":[]}
            $trackingData = json_decode($dataRaw, true);

            if (!$trackingData || !is_array($trackingData) || !isset($trackingData['status'])) {
                $awbInfo['error'] = "Codul AWB introdus este invalid.\n Te rugăm să încerci din nou.";
            } else {
                // Get status from response
                $latestStatus = $trackingData['status'];

                // Get latest eveniment from detalii (if available)
                $latestEveniment = '';
                if (!empty($trackingData['detalii']) && isset($trackingData['detalii'][0]['eveniment'])) {
                    $latestEveniment = $trackingData['detalii'][0]['eveniment'];
                }

                // Combine status + eveniment to match old format pattern
                $searchString = $latestStatus . ' -> ' . $latestEveniment;

                // Map to internal status constants
                $awbStatus = STATUS_REGISTERED; // default

                foreach ($statusList as $statusType => $statusValues) {
                    foreach ($statusValues as $value) {
                        if (stristr($searchString, $value)) {
                            $awbStatus = $statusType;
                            break 2;
                        }
                    }
                }

                // Fallback status detection based on status text
                if ($awbStatus == STATUS_REGISTERED) {
                    if (stristr($searchString, 'Livrat') || stristr($searchString, 'COK')) {
                        $awbStatus = STATUS_DELIVERED;
                    } elseif (stristr($searchString, 'Iesire Agent') || stristr($searchString, 'livrare')) {
                        $awbStatus = STATUS_DELIVERY;
                    } elseif (stristr($searchString, 'Centru') || stristr($searchString, 'EIA') || stristr($searchString, 'ECS') || stristr($searchString, 'tranzit')) {
                        $awbStatus = STATUS_TRANSIT;
                    } elseif (stristr($searchString, 'Preluata') || stristr($searchString, 'Colectata')) {
                        $awbStatus = STATUS_PICKED;
                    } elseif (stristr($searchString, 'Returnat')) {
                        $awbStatus = STATUS_RETURNED;
                    } elseif (stristr($searchString, 'Avizat')) {
                        $awbStatus = STATUS_APPROVED;
                    }
                }

                // Build status display and location
                $statusDisplay = $latestStatus;
                $location = '';
                if ($latestEveniment) {
                    $statusDisplay .= ' - ' . $latestEveniment;
                }
                if (!empty($trackingData['detalii'][0]['centru'])) {
                    $location = $trackingData['detalii'][0]['centru'];
                }

                $awbInfo = [
                    'status' => $statusDisplay,
                    'location' => $location,
                ];

                // Prepare history for view (if detalii has data)
                if (!empty($trackingData['detalii'])) {
                    $awbHistory = $trackingData['detalii'];
                }

                setView($p__, 'cms.various.hero.status');
            }

        } else {
            // ========== OLD API (fallback) ==========
            $apiURL = settingsGet('dsc-api-old-url') . sprintf(DSC_ENDPOINT_AWB_TRACKING_OLD, urlencode($awbNo));

            // Authorize (no username or password needed for old API)
            $context = dscAPIAuthorize('', '');

            // Fetch data
            $dataRaw = file_get_contents($apiURL, false, $context);

            // Get response code
            $status_line = $http_response_header[0];
            preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
            $status = $match[1];

            if ($status !== '200') {
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
                    throw new Exception("Error: Status negasit" . PHP_EOL . $dataRaw);
                }

                $data = explode('/', stristr($data, '-'));
                $awbInfo = [
                    'status' => substr(trim($data[0]), 2),
                    'location' => trim($data[1]),
                ];

                setView($p__, 'cms.various.hero.status');
            }
        }
    } catch (Exception $e) {
        $error = 'API DSC - AWB Tracking: ' . $e->getMessage();
        $awbInfo['error'] = "A apărut o eroare.\n Te rugăm să încerci mai târziu.";
        error_log($error);
    }
}