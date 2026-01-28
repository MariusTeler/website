<?php

global $curPage, $nrOnPage, $listRows;

$table = 'cms_contact';
$curPage = $websiteURL . 'index.php?page=' . $_GET['page'];
$where = '1';

// Set default filters
if (!$_GET['graph_type']) {
    $_GET['graph_type'] = GRAPH_TYPE_MONTH;
}

if (!is_array($_GET['years'])) {
    $_GET['years'] = [date('Y')];
}

if (getVar('isHome', $p__)) {
    $curPage .= $p__;
    $_GET['years'][] = date('Y') - 1;
    setView($p__, 'stats.contact.home');
}

// Get first year and last year
sort($_GET['years']);
$years = $_GET['years'];
$yearStart = reset($years);
$yearEnd = end($years);

$dayStart = new DateTime();
$dayStart->setTime(0, 0);
$dayStart->setDate($yearStart, 1, 1);

$dayEnd = clone $dayStart;
$dayEnd->setDate($yearEnd + 1, 1, 1);

// Filters
if ($_GET['type']) {
    $where .= ' AND type = ' . dbEscape($_GET['type']);
}

/*if ($_GET['status_id']) {
    $where .= ' AND status_id = ' . dbEscape($_GET['status_id']);
}*/

$where .= ' AND date >= ' . $dayStart->format('U');
$where .= ' AND date < ' . $dayEnd->format('U');

switch ($_GET['graph_type']) {
    case GRAPH_TYPE_DAY:
        $dateInterval = 'P1D';
        $legend = ['Ziua'];
        break;

    case GRAPH_TYPE_WEEK:
        $dateInterval = 'P1W';
        $legend = ['Saptamana'];
        break;

    default:
        $dateInterval = 'P1M';
        $legend = ['Luna'];
        break;
}

// List rows
$listDB = dbSelect(
    'COUNT(id) AS n, status_id, date, FROM_UNIXTIME(date, "%d.%m.%Y") t',
    $table,
    $where,
    'date ASC',
    't, status_id'
);

// List by year and graph type
$listByYear = [];
foreach ($years as $year) {
    switch ($_GET['graph_type']) {
        case GRAPH_TYPE_DAY:
            $dayStart->setDate($year, 1, 1);
            $dayEnd->setDate($year, 12, 31);
            break;

        case GRAPH_TYPE_WEEK:
            $dayStart->setISODate($year, 1);
            $dayEnd->setISODate($year, 52);
            break;

        default:
            $dayStart->setDate($year, 1, 1);
            $dayEnd->setDate($year, 12, 1);
    }

    // Interval
    $list = [];
    while ($dayStart->format('U') <= $dayEnd->format('U')) {
        $dateStart = $dayStart->format('U');
        $dateEnd = clone $dayStart;
        $dateEnd->add(new DateInterval($dateInterval));
        $dateEnd = $dateEnd->format('U');

        $list[$dateStart] = [
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'date_start_text' => date('d.m.Y', $dateStart),
            'date_end_text' => date('d.m.Y', $dateEnd),
            'status' => [],
            'total' => 0
        ];

        foreach ($listDB as $i => $row) {
            if ($row['date'] >= $dateStart && $row['date'] < $dateEnd) {
                $list[$dateStart]['status'][$row['status_id']] += $row['n'];

                if (
                    !$_GET['status_id']
                    || $row['status_id'] == $_GET['status_id']
                ) {
                    $list[$dateStart]['total'] += $row['n'];
                }

                if ($row['status_id'] == $_GET['status_id_vs']) {
                    $list[$dateStart]['total_vs'] += $row['n'];
                }

                unset($listDB[$i]);
            }
        }

        // Add dummy day for leap year
        if (
            $_GET['graph_type'] == GRAPH_TYPE_DAY
            && !date('L', $dateStart)
            && date('d.m', $dateStart) == '28.02'
        ) {
            $list[] = [
                'date_start_leap' => '29 Feb',
                'status' => [],
                'total' => 0
            ];
        }

        $dayStart->add(new DateInterval($dateInterval));
    }

    $listByYear[$year] = array_column($list, null);
}

// Graph points
$graphPoints = [];
for ($i = 0; $i < count($listByYear[reset($years)]); $i++) {
    $point = [
        'point' => $i + 1,
        'value' => 0,
        'additional' => []
    ];

    foreach ($years as $j => $year) {
        $info = $listByYear[$year][$i];
        if ($_GET['status_id']) {
            $value = $info['status'][$_GET['status_id']];
        } else {
            $value = $info['total'];
        }

        $value = stringToFloat($value);

        if (!$j) {
            $point['value'] = $value;
        } else {
            $point['additional'][] = $value;
        }

        switch ($_GET['graph_type']) {
            case GRAPH_TYPE_DAY:
                $point['point'] = $info['date_start_leap'] ?: ucwords(strftime('%d %b', $info['date_start']));
                break;

            case GRAPH_TYPE_WEEK:
                $point['point'] = 'S' . strftime('%V', $info['date_start']);
                if (count($years) == 1) {
                    $point['point'] = $point['point'] . ' ' . ucwords(strftime('%d %h', $info['date_start'])
                        . ' - '
                        . strftime('%d %h', strtotime('-1 day', $info['date_end'])));
                }

                break;

            default:
                $point['point'] = ucwords(strftime('%b', $info['date_start']));
                break;
        }
    }

    $graphPoints[] = $point;
}

// Legend info
$legendPosition = 'top';
$legend = array_merge($legend, $years);
array_walk($legend, function(&$item) {
    $item = (string)$item;
});

// Total rows
$listRows = count($listByYear[reset($years)]);

// Status
$status = dbSelect('*', 'nomen_status', '', 'ord ASC');
$statusById = array_column($status, null, 'id');

// Years
$minYear = dbShiftKey(dbSelect('MIN(date)', $table, '', '', '', '0,1'));
$minYear = $minYear ? date('Y', $minYear) : date('Y');
$yearsList = range($minYear, date('Y'));
$yearsList = array_combine($yearsList, $yearsList);

// Init select2
formSelect2(array(
    'id' => 'years',
    'options' => array(
        'width' => '100%',
        'allowclear' => 0
    )
));

// Export
if ($_GET['export']) {
    header("Content-type: application/csv");
    header('Content-Type: text/html; charset=utf-8');
    header("Content-Disposition: attachment; filename=statistici-" . rewriteEnc(GRAPH_TYPES[$_GET['graph_type']]) . '-'. date('d.m.Y_H.i') . ".csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    $header = [
        'type' => 'Tip',
        'status' => 'Status',
        'date' => 'Data'
    ];

    foreach ($years as $year) {
        $header[$year] = $year;

        if ($_GET['status_id_vs']) {
            $header['vs' . $year] = 'vs. ' . $statusById[$_GET['status_id_vs']]['name'];
        }
    }

    $csvList = array();
    foreach ($listByYear[reset($years)] as $i => $row) {
        $csvRow = array(
            'type' => FORM_TYPES[$_GET['type']],
            'status' => $_GET['status_id'] ? $statusById[$_GET['status_id']]['name'] : '',
            'date' => $graphPoints[$i]['point'],
        );

        foreach ($years as $year) {
            $csvRow[$year] = $listByYear[$year][$i]['total'];
            $csvRow['vs' . $year] = (int)$listByYear[$year][$i]['total_vs'];
        }

        $csvList[] = $csvRow;
    }

    echo printCSV($header, $csvList);
    die;
}
