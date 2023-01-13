<?php
session_start();
include '../php-processes/dbConnection.php';
clientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['info-device'];

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--    Style Sheet-->
    <link rel="stylesheet" href="../css/info-device-styles.css">
    <!--    Jquery-->

    <title>PetConnectBasket</title>
</head>

<body>



    <main>
        <div id="ids-form-body" class="text-font-500">
            <lien><a href="profile.php"><?php echo $languageList["Account"] ?></a>><a href="devices.php"><?php echo $languageList["My devices"] ?></a>><a id="actif" href=""><?php echo $languageList["Device information"] ?></a></lien>
            <section id="info_app">
                <h2>iCollar</h2>
                <div id="produit">
                    <img src="<?php echo getImage("iCollar_blanc2.png") ?>" />
                </div>
                <div class="grid3">
                    <div class="case">
                        <img src="<?php echo getImage("heart.png") ?>" />
                        <button onclick="typeChart(BPMChart)">Format</button>
                        <button onclick="pauseChart(BPMChart)">Pause</button>
                        <button onclick="liveChart(BPMChart)">Live</button>
                        <h3>XXX BPM</h3>
                        <p><?php echo $languageList["Good"] ?></p>
                        <div id=date>
                            <button onclick="dayChart(BPMChart)">Jour</button>
                            <button onclick="weekChart(BPMChart)">Semaine</button>
                            <button onclick="monthChart(BPMChart)">Mois</button>
                        </div>
                        <h4>Fréquence cardiaque</h4>
                        <div class="graph">
                            <canvas id="graphBPM"></canvas>
                        </div>
                    </div>
                    <div class="case">
                        <img src="<?php echo getImage("co2.png") ?>" />
                        <button onclick="typeChart(PPMChart)">Format</button>
                        <button onclick="pauseChart(PPMChart)">Pause</button>
                        <button onclick="liveChart(PPMChart)">Live</button>
                        <h3>XXX ppm</h3>
                        <p><?php echo $languageList["Good"] ?></p>
                        <div id=date>
                            <button onclick="dayChart(PPMChart)">Jour</button>
                            <button onclick="weekChart(PPMChart)">Semaine</button>
                            <button onclick="monthChart(PPMChart)">Mois</button>
                        </div>
                        <h4>Qualitée de l'air</h4>
                        <div class="graph">
                            <canvas id="graphPPM"></canvas>
                        </div>
                    </div>

                    <div class="case">
                        <img src="<?php echo getImage("thermo.png") ?>" />
                        <button onclick="typeChart(TcChart)">Format</button>
                        <button onclick="pauseChart(TcChart)">Pause</button>
                        <button onclick="liveChart(TcChart)">Live</button>
                        <h3>XX°C</h3>
                        <p><?php echo $languageList["Good"] ?></p>
                        <div id=date>
                            <button onclick="dayChart(TcChart)">Jour</button>
                            <button onclick="weekChart(TcChart)">Semaine</button>
                            <button onclick="monthChart(TcChart)">Mois</button>
                        </div>
                        <h4>Température</h4>
                        <div class="graph">
                            <canvas id="graphTc"></canvas>
                        </div>
                    </div>

                    <div class="case">
                        <img src="<?php echo getImage("aboiement.png") ?>" />
                        <button onclick="typeChart(DBChart)">Format</button>
                        <button onclick="pauseChart(DBChart)">Pause</button>
                        <button onclick="liveChart(DBChart)">Live</button>
                        <h3>XXX db</h3>
                        <p>Silencieux</p>
                        <div id=date>
                            <button onclick="dayChart(DBChart)">Jour</button>
                            <button onclick="weekChart(DBChart)">Semaine</button>
                            <button onclick="monthChart(DBChart)">Mois</button>
                        </div>
                        <h4>Nombre de décibel</h4>
                        <div class="graph">
                            <canvas id="graphDB"></canvas>
                        </div>
                    </div>

                    <div class="case">
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

    $idate = "%01-02%";
    $selectData_Device = runSQLResult("SELECT *,DATE_FORMAT(dapDate,'%d-%m') AS FormatDate,DATE_FORMAT(dapDate,'%H:%i') AS FormatTime FROM Data_Device WHERE Dapdate LIKE ('%01-02%') ");
    $BPM = array();
    $date = array();

    while ($row = $selectData_Device->fetch_assoc()) {
        $BPM[] = $row["dapBPM"];
        $date[] = $row["dapDate"];
        $dateFormat[] = $row["FormatDate"];
        $timeFormat[] = $row["FormatTime"];
    }

    echo $idate;
    // print_r($BPM);
    print_r($date);
    ?>

    <?php include 'site-footer.php' ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.1.1/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.3.0/dist/chartjs-adapter-luxon.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming@2.0.0/dist/chartjs-plugin-streaming.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

    </script>
    <script type="text/javascript">
        setMarginTop('site-header-main-header', 'id', 'ids-form-body', 'id', 40)
    </script>

    <script>
        var ladate = new Date();
        document.write(ladate.getDate() + "-" + (ladate.getMonth() + 1));

        const BPM = <?php echo json_encode($BPM); ?>;
        const date = <?php echo json_encode($dateFormat); ?>;
        const time = <?php echo json_encode($timeFormat); ?>;
        // const labeltime = ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00'];


        // data Rythme cardiaque
        const dataBPM = {
            labels: time.slice(0, 24),
            datasets: [{
                label: 'BPM',
                data: BPM,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };


        // data Qualité de l'air
        const dataPPM = {
            datasets: [{
                label: 'PPM',
                data: [],
                backgroundColor: 'rgb(6, 219, 28, 0.2)',
                borderColor: 'rgb(6, 219, 28)',
                borderWidth: 1
            }]
        };

        // data Température
        const dataTc = {
            datasets: [{
                label: '°C',
                data: [],
                backgroundColor: 'rgb(255, 184, 0, 0.2)',
                borderColor: 'rgb(255, 184, 0)',
                borderWidth: 1
            }]
        };

        // data Décibel
        const dataDB = {
            datasets: [{
                label: 'DB',
                data: [],
                backgroundColor: 'rgb(105, 166, 170, 0.2)',
                borderColor: 'rgb(105, 166, 170)',
                borderWidth: 1
            }]
        };




        // config block
        function config(data, ymin, ymax) {
            const config = {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        x: {

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




        function dayChart(xChart) {
            if (xChart.data.labels === time) {
                xChart.data.labels = date;
            } else {
                xChart.data.labels = time;
            }
            xChart.update();
        };


        function weekChart(xChart) {

            if (xChart.options.plugins.streaming.duration !== 604800000) {
                xChart.options.plugins.streaming.duration = 604800000;
            } else {
                xChart.options.plugins.streaming.duration = 20000;
            }
            xChart.update();





            // var a = 1;
            // var b = 2;
            // window.location.href = "info-device.php?var1=" + a + "&var2=" + b;
        };

        function monthChart(xChart) {

            if (xChart.options.plugins.streaming.duration !== 2628002880) {
                xChart.options.plugins.streaming.duration = 2628002880;
            } else {
                xChart.options.plugins.streaming.duration = 20000;
            }
            xChart.update();
        };






        // map localisation
        navigator.geolocation.getCurrentPosition(position => {
            const {
                latitude,
                longitude
            } = position.coords;

            map.innerHTML = '<iframe width="350" height="250" src="https://maps.google.com/maps?q=' + latitude + ',' + longitude + '&amp;z=15&amp;output=embed"></iframe>';
        });
    </script>


</body>

</html>