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
                        <h3>XXXXXXX</h3>
                        <p>Proche</p>
                        <h4>Localisation</h4>
                        <div class="graph">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>



    <?php include 'site-footer.php' ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.1.1/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.3.0/dist/chartjs-adapter-luxon.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming@2.0.0/dist/chartjs-plugin-streaming.min.js"></script>
    <script src="../javaScript/charts.js">
    </script>
    <script type="text/javascript">
        setMarginTop('site-header-main-header', 'id', 'ids-form-body', 'id', 40)
    </script>



</body>

</html>