<? if (!$graphPoints) : ?>
    <strong class="text-warning position-absolute" style="top: 0;">Nu exista date!</strong>
<? endif; ?>
<? captureJavaScriptStart() ?>
<?
if (!is_array($colors)) {
    $colors = ['#4caf50', '#ff9800', '#9c27b0', '#00bcd4', '#f44336'];
}

if (!is_array($legend)) {
    $legend = ['Saptamana', ''];
}

if (!$legendPosition) {
    $legendPosition = 'none';
}
?>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {'packages':['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart,
            chartDiv,
            data,
            dataArray,
            ticks,
            options = {
                //curveType: 'function',
                //lineWidth: 1,
                pointSize: 4,
                vAxis: {
                    titleTextStyle: {
                        color: '#333',
                        fontName: 'Roboto'
                    },
                    textStyle: {
                        color: '#333',
                        fontName: 'Roboto'
                    },
                    gridlines: {
                        color: '#ddd'
                    },
                    baselineColor: '#ddd'
                },
                /*series: {
                    0: {targetAxisIndex: 0},
                    1: {targetAxisIndex: 1}
                },*/
                vAxes: {
                    // Adds titles to each axis.
                    0: {title: 'Cereri'},
                    //0: {title: '<?= $legend[1] ?>'},
                    //1: {title: '<?= $legend[2] ?>'}
                },
                chartArea: {
                    width: '100%',
                    left: 50
                },
                hAxis: {
                    titleTextStyle: {
                        color: '#333',
                        fontName: 'Roboto'
                    },
                    textStyle: {
                        color: '#333',
                        fontName: 'Roboto'
                    },
                    gridlines: {
                        color: 'transparent'
                    },
                    slantedText: true,
                    baselineColor: 'transparent',
                    title: '<?= $legend['0'] ?>'
                },
                tooltip: {
                    textStyle: {
                        color: '#333',
                        fontName: 'Roboto'
                        //bold: false
                    },
                    showColorCode: false
                },
                focusTarget: 'category',
                colors: <?= json_encode($colors) ?>,
                crosshair: {
                    trigger: 'focus',
                    orientation: 'vertical',
                    color: '#ddd'
                },
                legend: {
                    position: '<?= $legendPosition ?>'
                }/*,
                 width: 1000,
                 height: 150*/
            };

        dataArray = [
            <?= json_encode($legend) ?>
        ];

        ticks = [];

        <? $nPoints = 0; ?>
        <? foreach ($graphPoints AS $row) : $nPoints++; ?>
        <?
        $point = [
            $row['point'],
            $row['value']
        ];

        if (is_array($row['additional'])) {
            $point = array_merge($point, $row['additional']);
        }
        ?>
        dataArray.push(<?= json_encode($point) ?>);
        //ticks.push(<?= $row['value'] ?>);
        <? endforeach; ?>

        //options.vAxis.ticks = ticks;

        <? if ($nPoints > 40) : ?>
        options.lineWidth = 2;
        options.pointSize = 0;
        <? endif; ?>

        data = google.visualization.arrayToDataTable(dataArray);

        chartDiv = document.getElementById('curve_chart');
        chart = new google.visualization.LineChart(chartDiv);

        <? if ($_GET['print']) : ?>
        //options.vAxis.ticks = null;
        options.vAxis.format = 'short';
        options.width = 1000;
        options.height = 200;

        // Wait for the chart to finish drawing before calling the getImageURI() method.
        /*
         google.visualization.events.addListener(chart, 'ready', function () {
         chartDiv.innerHTML = '<img src="' + chart.getImageURI() + '">';
         });
         */
        <? endif; ?>

        if (dataArray.length > 1) {
            chart.draw(data, options);
        }
    }
</script>
<? captureJavaScriptEnd() ?>

<? if (getVar('modal')) : ?>
    <?= parseJavaScript() ?>
<? endif; ?>
