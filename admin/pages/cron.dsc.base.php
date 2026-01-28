<?php

// Don't die when running sub-cron
parseVar('skipDie', true);

// Sync counties
parsePage('cron.dsc.counties');

// Sync cities
parsePage('cron.dsc.cities');

if ($_GET['web'] != 1) {
    die;
}
