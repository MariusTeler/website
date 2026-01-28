<?php

// Counties table
$table = 'dsc_county';

try {
    // API URL
    $apiURL = settingsGet('dsc-api-url') . DSC_ENDPOINT_COUNTIES;

    // Authorize
    $context = dscAPIAuthorize(
        settingsGet('dsc-api-username'),
        settingsGet('dsc-api-password')
    );

    // Fetch data
    $data = dscAPIExecute($apiURL, $context);

    // Check if data is valid
    if (
        $data
        && is_array($data)
        && is_array($data['judete'])
        && count($data['judete']) == $data['rezultate']
    ) {
        // Delete all counties
        dbDelete($table, '1');

        // Add all counties
        foreach ($data['judete'] AS $countyCode => $countyName) {
            $row = array(
                'name' => $countyName,
                'code' => $countyCode,
                'date_added' => time(),
                '_no_admin_log' => $cfg__['session'][$cfg__['session']['default']]
            );

            $r = dbInsert($table, $row);

            if ($r === false) {
                $error = "Cron DSC Judete: Nu a putut fi adaugat judetul {$countyName}({$countyCode}).";

                error_log($error);
                alertsAdd($error, 'error');
            }
        }
    } else {
        throw new Exception('Datele sunt invalide.');
    }
} catch (Exception $e) {
    $error = 'Cron DSC Judete: ' . $e->getMessage();

    error_log($error);
    alertsAdd($error, 'error');
}

if ($_GET['web'] != 1 && !getVar('skipDie')) {
    die;
}
