<?php
session_start();
include '../php-processes/dbConnection.php';
onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['info-device'];

$devID = $_GET['devID'];
$deviceInfo = returnDevicesList($devID);
$devName = $deviceInfo[0]['devName'];
$prdImg = $deviceInfo[0]['prdImg']
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--    Style Sheet-->
    <link rel="stylesheet" href="../css/info-devices2-styles.css">
    <!--    Jquery-->

    <title>PetConnectBasket</title>
</head>

<body>
    <main>
        <div id="ids-form-body" class="text-font-500">
            <section id="info_app">
                <h2><?php echo $devName ?></h2>
                <div id="produit">
                    <img src="<?php echo $prdImg ?>" />
                </div>
                <div class="grid3">
                    <div class="case">
                        <div class="elementChart">
                            <img src="<?php echo getImage("heart.png") ?>" />
                            <div class="controlChart">
                                <div class="controlChart-flex">
                                    <h3><?php echo $languageList["From"] ?></h3>
                                    <input type="date" onchange="startDateFilter(this,BPMChart)" value="2023-01-01" min="2023-01-01" max="2023-01-31" id="BPMstartDate">
                                    <h3><?php echo $languageList["to"] ?></h3>
                                    <input type="date" onchange="endDateFilter(this,BPMChart,dataBPM,dataBPM_hour,'BPM')" value="2023-01-31" min="2023-01-01" max="2023-01-31">
                                </div>
                                <button onclick="switchChart(BPMChart,dataBPM,dataBPM_hour,'BPM')" id="BPMhour"><?php echo $languageList["Day"] ?></button>
                                <button onclick=" typeChart(BPMChart)">Format</button>
                            </div>
                        </div>
                        <h4><?php echo $languageList["Heart rate"] ?></h4>
                        <div class="graph">
                            <canvas id="graphBPM"></canvas>
                        </div>
                    </div>

                    <div class="case">
                        <div class="elementChart">
                            <img src="<?php echo getImage("co2.png") ?>" />
                            <div class="controlChart">
                                <div class="controlChart-flex">
                                    <h3><?php echo $languageList["From"] ?></h3>
                                    <input type="date" onchange="startDateFilter(this,PPMChart)" value="2023-01-01" min="2023-01-01" max="2023-01-31" id="PPMstartDate">
                                    <h3><?php echo $languageList["to"] ?></h3>
                                    <input type="date" onchange="endDateFilter(this,PPMChart,dataPPM,dataPPM_hour,'PPM')" value="2023-01-31" min="2023-01-01" max="2023-01-31">
                                </div>
                                <button onclick="switchChart(PPMChart,dataPPM,dataPPM_hour,'PPM')" id="PPMhour"><?php echo $languageList["Day"] ?></button>
                                <button onclick=" typeChart(PPMChart)">Format</button>
                            </div>
                        </div>
                        <h4><?php echo $languageList["Air quality"] ?></h4>
                        <div class="graph">
                            <canvas id="graphPPM"></canvas>
                        </div>
                    </div>


                    <div class="case">
                        <div class="elementChart">
                            <img src="<?php echo getImage("thermo.png") ?>" />
                            <div class="controlChart">
                                <div class="controlChart-flex">
                                    <h3><?php echo $languageList["From"] ?></h3>
                                    <input type="date" onchange="startDateFilter(this,TcChart)" value="2023-01-01" min="2023-01-01" max="2023-01-31" id="TCstartDate">
                                    <h3><?php echo $languageList["to"] ?></h3>
                                    <input type="date" onchange="endDateFilter(this,TcChart,dataTc,dataTc_hour,'TC')" value="2023-01-31" min="2023-01-01" max="2023-01-31">
                                </div>
                                <button onclick="switchChart(TcChart,dataTc,dataTc_hour,'TC')" id="TChour"><?php echo $languageList["Day"] ?></button>
                                <button onclick=" typeChart(TcChart)">Format</button>
                            </div>
                        </div>
                        <h4><?php echo $languageList["Temperature"] ?></h4>
                        <div class="graph">
                            <canvas id="graphTc"></canvas>
                        </div>
                    </div>



                    <div class="case">
                        <div class="elementChart">
                            <img src="<?php echo getImage("aboiement.png") ?>" />
                            <div class="controlChart">
                                <div class="controlChart-flex">
                                    <h3><?php echo $languageList["From"] ?></h3>
                                    <input type="date" onchange="startDateFilter(this,DBChart)" value="2023-01-01" min="2023-01-01" max="2023-01-31" id="DBstartDate">
                                    <h3><?php echo $languageList["to"] ?></h3>
                                    <input type="date" onchange="endDateFilter(this,DBChart,dataDB,dataDB_hour,'DB')" value="2023-01-31" min="2023-01-01" max="2023-01-31">
                                </div>
                                <button onclick="switchChart(DBChart,dataDB,dataDB_hour,'DB')" id="DBhour"><?php echo $languageList["Day"] ?></button>
                                <button onclick=" typeChart(DBChart)">Format</button>
                            </div>
                        </div>
                        <h4><?php echo $languageList["Number of decibels"] ?></h4>
                        <div class="graph">
                            <canvas id="graphDB"></canvas>
                        </div>
                    </div>




                    <div class="case" id="plan">
                        <img src="<?php echo getImage("position.png") ?>" />

                        <!-- <p>Proche</p> -->
                        <h4>Localisation</h4>
                        <div class="graph">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <?php


    $selectData_Time = runSQLQuery("SELECT * FROM Data_Device WHERE Device_devID = '".$devID."' ORDER BY dapDate DESC");
    $selectData_Date = runSQLQuery("SELECT AVG(dapBPM),AVG(dapCO2),AVG(dapDecibel),AVG(dapTemp),dapDate FROM `Data_Device` WHERE Device_devID = '".$devID."' GROUP BY CAST(dapDate AS DATE)");
    $selectData_Coordinate = runSQLQuery("SELECT * FROM Data_Device WHERE Device_devID = '".$devID."' ORDER BY dapDate DESC LIMIT 0,1");

    while ($rowTime = $selectData_Time->fetch_assoc()) {
        $BPM_Time[] = $rowTime["dapBPM"];
        $PPM_Time[] = $rowTime["dapCO2"];
        $Tc_Time[] = $rowTime["dapTemp"];
        $DB_Time[] = $rowTime["dapDecibel"];

        $timeArray[] = $rowTime["dapDate"];
    }



    while ($rowDate = $selectData_Date->fetch_assoc()) {
        $BPM_Date[] = $rowDate["AVG(dapBPM)"];
        $PPM_Date[] = $rowDate["AVG(dapCO2)"];
        $Tc_Date[] = $rowDate["AVG(dapTemp)"];
        $DB_Date[] = $rowDate["AVG(dapDecibel)"];

        $dateArray[] = $rowDate["dapDate"];
    }

    while ($rowCoordinate = $selectData_Coordinate->fetch_assoc()) {
        $latitude[] = $rowCoordinate["dapLatitude"];
        $longitude[] = $rowCoordinate["dapLongitude"];
    }

    ?>

    <?php include 'site-footer.php' ?>

    <script type="text/javascript">
        setMarginTop('sih-main-header', 'id', 'ids-form-body', 'id', 40)

        // setToWindowHeight('ad-main-body-div', 'id', 0)
        setMarginTopFooter('ids-form-body', 'id', 'site-footer-main-div', 'id', 0)
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.1.1/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.3.0/dist/chartjs-adapter-luxon.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming@2.0.0/dist/chartjs-plugin-streaming.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

    <script>
        // récupération des valeurs pour date
        const BPM_Date = <?php echo json_encode($BPM_Date); ?>;
        const PPM_Date = <?php echo json_encode($PPM_Date); ?>;
        const Tc_Date = <?php echo json_encode($Tc_Date); ?>;
        const DB_Date = <?php echo json_encode($DB_Date); ?>;

        const dateArrayJS = <?php echo json_encode($dateArray); ?>;

        const dateChartJS = dateArrayJS.map((day, index) => {
            let dayjs = new Date(day);
            return dayjs.setHours(0, 0, 0, 0)

        })


        // récupération des valeurs pour temps
        const BPM_Time = <?php echo json_encode($BPM_Time); ?>;
        const PPM_Time = <?php echo json_encode($PPM_Time); ?>;
        const Tc_Time = <?php echo json_encode($Tc_Time); ?>;
        const DB_Time = <?php echo json_encode($DB_Time); ?>;


        const timeArrayJS = <?php echo json_encode($timeArray); ?>;

        const timeChartJS = timeArrayJS.map((day, index) => {
            let dayjs = new Date(day);
            return Date.parse(dayjs)
        })


        // data Rythme cardiaque
        const dataBPM = {
            labels: dateChartJS,
            datasets: [{
                label: 'BPM',
                data: BPM_Date,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };
        const dataBPM_hour = {
            labels: timeChartJS,
            datasets: [{
                label: 'BPM',
                data: BPM_Time,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                // barThickness: 7,
            }]
        };


        // data Qualité de l'air
        const dataPPM = {
            labels: dateChartJS,
            datasets: [{
                label: 'PPM',
                data: PPM_Date,
                backgroundColor: 'rgb(6, 219, 28, 0.2)',
                borderColor: 'rgb(6, 219, 28)',
                borderWidth: 1
            }]
        };
        const dataPPM_hour = {
            labels: timeChartJS,
            datasets: [{
                label: 'PPM',
                data: PPM_Time,
                backgroundColor: 'rgb(6, 219, 28, 0.2)',
                borderColor: 'rgb(6, 219, 28)',
                borderWidth: 1,
                // barThickness: 3,
            }]
        };

        // data Température
        const dataTc = {
            labels: dateChartJS,
            datasets: [{
                label: '°C',
                data: Tc_Date,
                backgroundColor: 'rgb(255, 184, 0, 0.2)',
                borderColor: 'rgb(255, 184, 0)',
                borderWidth: 1
            }]
        };
        const dataTc_hour = {
            labels: timeChartJS,
            datasets: [{
                label: '°C',
                data: Tc_Time,
                backgroundColor: 'rgb(255, 184, 0, 0.2)',
                borderColor: 'rgb(255, 184, 0)',
                borderWidth: 1,
                // barThickness: 3,
            }]
        };

        // data Décibel
        const dataDB = {
            labels: dateChartJS,
            datasets: [{
                label: 'DB',
                data: DB_Date,
                backgroundColor: 'rgb(105, 166, 170, 0.2)',
                borderColor: 'rgb(105, 166, 170)',
                borderWidth: 1
            }]
        };
        const dataDB_hour = {
            labels: timeChartJS,
            datasets: [{
                label: 'DB',
                data: DB_Time,
                backgroundColor: 'rgb(105, 166, 170, 0.2)',
                borderColor: 'rgb(105, 166, 170)',
                borderWidth: 1,
                // barThickness: 3,
            }]
        };





        // config block
        function config(data, ymin, ymax) {
            const config = {
                type: 'bar',
                data: data,
                options: {
                    // autoSkip: false,
                    scales: {
                        x: {
                            min: 1672527600000,
                            max: '2023-01-31',
                            type: 'time',
                            time: {
                                unit: 'day',
                            }
                        },
                        y: {
                            suggestedMin: ymin,
                            suggestedMax: ymax,
                        }
                    }
                }
            }
            return config
        }
        // Rythme cardique
        const BPMChart = new Chart(
            document.getElementById('graphBPM'),
            config(dataBPM, 0, 200)
        );

        // Qualité de l'air
        const PPMChart = new Chart(
            document.getElementById('graphPPM'),
            config(dataPPM, 400, 1600, 800, 1200)
        );

        // Température
        const TcChart = new Chart(
            document.getElementById('graphTc'),
            config(dataTc, 0, 45, 37, 40)
        );


        // Aboiement
        const DBChart = new Chart(
            document.getElementById('graphDB'),
            config(dataDB, 0, 110, 0, 10)
        );



        function typeChart(xChart) {
            if (xChart.config.type === 'line') {
                xChart.config.type = 'bar';
            } else {
                xChart.config.type = 'line';
            }
            xChart.update();


        }





        function switchChart(xChart, xData, hData, string) {
            var hourColor = document.getElementById(string + 'hour');
            var startDateColor = document.getElementById(string + 'startDate');

            if (xChart.config.options.scales.x.time.unit === 'day') {
                xChart.config.options.scales.x.time.unit = 'hour';
                xChart.config.data = hData;
                xChart.config.options.scales.x.max = xChart.config.options.scales.x.min + 86399999;
                // style
                hourColor.style.backgroundColor = 'red';
                startDateColor.style.color = 'red';
                startDateColor.style.margin = '-2px 3px 0 3px';
                startDateColor.style.border = '2px solid red'

            } else {
                xChart.config.options.scales.x.time.unit = 'day';
                xChart.config.data = xData;
                // style
                hourColor.style.backgroundColor = '#918D8D';
                startDateColor.style.color = 'black';
                startDateColor.style.border = 'none';
                startDateColor.style.margin = '0 5px 0 5px';
            }
            xChart.update();
        }


        function startDateFilter(date, xChart) {
            const startDate = new Date(date.value);
            xChart.config.options.scales.x.min = startDate.setHours(0, 0, 0, 0);

            if (xChart.config.options.scales.x.time.unit === 'hour') {
                xChart.config.options.scales.x.max = xChart.config.options.scales.x.min + 86399999;
            }
            xChart.update();
        }


        function endDateFilter(date, xChart, xData, hData, string) {
            const startDate = new Date(date.value);
            xChart.config.options.scales.x.max = startDate.setHours(0, 0, 0, 0);
            if (xChart.config.options.scales.x.time.unit === 'hour') {
                switchChart(xChart, xData, hData, string);
            }
            xChart.update();
        }




        const latitude = <?php echo json_encode($latitude); ?>;
        const longitude = <?php echo json_encode($longitude); ?>;


        // document.write(latitude);
        // document.write(longitude);

        // map localisation
        // navigator.geolocation.getCurrentPosition(position => {
        //     const {
        // latitude,
        // longitude
        //     } = position.coords;





        map.innerHTML = '<iframe width="100%" height="100%"  src="https://maps.google.com/maps?q=' + latitude + ',' + longitude + '&amp;z=15&amp;output=embed"></iframe>';
        // });
    </script>


</body>

</html>