<?php

// Cities table
$table = 'dsc_city';

// Get counties
$counties = dbSelect('*', 'dsc_county', '', 'name ASC');

try {
    // API URL
    $apiURL = settingsGet('dsc-api-url');

    // Authorize
    $context = dscAPIAuthorize(
        settingsGet('dsc-api-username'),
        settingsGet('dsc-api-password')
    );

    // Fetch values for each attribute (via API)
    foreach ($counties AS $county) {
        usleep(200000);
        $countyInfo = "{$county['name']} ({$county['code']})";

        try {
            // Fetch data
            $data = dscAPIExecute($apiURL . sprintf(DSC_ENDPOINT_CITIES, $county['code']), $context);

            // Check if data is valid
            if (
                $data
                && is_array($data)
                && is_array($data['localitati'])
                // && count($data['localitati']) == $data['rezultate']
            ) {
                // Delete all cities for this county
                dbDelete($table, ['county_code' => $county['code']]);

                // Add all cities for this county
                foreach ($data['localitati'] AS $cityName => $km) {
                    $countyValue = array(
                        'county_code' => $county['code'],
                        'name' => $cityName,
                        'km' => $km,
                        'date_added' => time(),
                        '_no_admin_log' => $cfg__['session'][$cfg__['session']['default']]
                    );

                    $r = dbInsert($table, $countyValue);

                    if ($r === false) {
                        $error = "Cron DSC Localitati: Nu a putut fi adaugata localitatea {$cityName} pentru judetul {$county['code']}.";

                        error_log($error);
                        alertsAdd($error, 'error');
                    }
                }
            } else {
                throw new Exception("Datele sunt invalide pentru judetul {$countyInfo}.");
            }
        } catch (Exception $e) {
            $error = 'Cron DSC Localitati: ' . $e->getMessage();

            error_log($error);
            alertsAdd($error, 'error');
        }
    }
} catch (Exception $e) {
    $error = 'Cron DSC Localitati: ' . $e->getMessage();

    error_log($error);
    alertsAdd($error, 'error');
}

if ($_GET['web'] != 1 && !getVar('skipDie')) {
    die;
}
