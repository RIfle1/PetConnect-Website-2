<?php
session_start();
include '../php-processes/dbConnection.php';
onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['devices'];


?>
<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/devices-styles.css">
    <title><?php echo $languageList['My devices'] ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     setInterval(function() {
        //         $.ajax({
        //             url: 'passerelle.php',
        //             type: 'GET',
        //             dataType: 'html',
        //             success: function(response) {
        //                 $('#element_a_actualiser').html(response);
        //             },
        //             error: function() {
        //                 console.log('Erreur lors de la récupération des données mises à jour.');
        //             }
        //         });
        //     }, 5000);
        // });
    </script>
</head>


<body>

    <script>
        let devicesList = <?php echo json_encode(returnDevicesListByClient()) ?>;
        let miscImgList = <?php echo json_encode(returnMiscImgList()) ?>;
    </script>
    <div id="dv-main-body-div" class="text-font-500">

        <h1><?php echo $languageList['My devices'] ?></h1>

        <div class="separation-line-1"></div>

        <div id="dv-main-div">

            <div id="dv-devices-product-div" class="text-font-500">
                <!--            DEVICES WILL BE DISPLAYED HERE-->

                <!--            <div class='dv-devices-product'>-->
                <!--                <div class='dv-product-image-div'>-->
                <!--                    <div class='dv-image-name-div'>-->
                <!--                        <span class='dv-name-span'>iCollar v1</span>-->
                <!--                        <input class='dv-name-input' type='text'>-->
                <!--                        <img class='dv-name-edit-img dv-name-img' src='--><?php //echo getImage('edit.png') 
                                                                                                ?><!--' alt='edit'>-->
                <!--                        <img class='dv-name-cancel-img dv-name-img' src='--><?php //echo getImage('cancel.png') 
                                                                                                ?><!--' alt='edit'>-->
                <!--                    </div>-->
                <!--                    <img class='div-image-device' src='--><?php //echo getImage('iCollar_v1_black.png') 
                                                                                ?><!--' alt='device img'>-->
                <!--                </div>-->
                <!---->
                <!--                <div class='dv-product-info-div'>-->
                <!--                    <div class='dv-info-container'>-->
                <!--                        <img class='dv-container-image' src='--><?php //echo getImage('heart.png') 
                                                                                    ?><!--' alt='heart img'>-->
                <!--                        <span class='dv-container-span'>Something</span>-->
                <!--                    </div>-->
                <!--                    <div class='dv-info-container'>-->
                <!--                        <img class='dv-container-image' src='--><?php //echo getImage('co2.png') 
                                                                                    ?><!--' alt='heart img'>-->
                <!--                        <span class='dv-container-span'>Something</span>-->
                <!--                    </div>-->
                <!--                    <div class='dv-info-container'>-->
                <!--                        <img class='dv-container-image' src='--><?php //echo getImage('thermo.png') 
                                                                                    ?><!--' alt='heart img'>-->
                <!--                        <span class='dv-container-span'>Something</span>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class='dv-product-button-div'>-->
                <!--                    <button class='dv-more-info-button' type='button'>More information</button>-->
                <!--                </div>-->
                <!--            </div>-->
                <?php
                $ch = curl_init();
                curl_setopt(
                    $ch,
                    CURLOPT_URL,
                    "http://projets-tomcat.isep.fr:8080/appService?ACTION=GETLOG&TEAM=9999"
                );
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $data = curl_exec($ch);
                curl_close($ch);

                echo ("$data");




                // Création d'une ressource cURL
                $ch = curl_init();

                // Définition de l'URL et autres options appropriées
                curl_setopt($ch, CURLOPT_URL, "http://projets-tomcat.isep.fr:8080/appService?ACTION=GETLOG&TEAM=9999");
                curl_setopt($ch, CURLOPT_HEADER, false);

                // Récupération de l'URL et passage au navigateur
                curl_exec($ch);

                // Fermeture de la ressource cURL et libération des ressources systèmes
                curl_close($ch);


                ?>


            </div>

            <div id="dv-devices-input-div" class="text-font-700">

            </div>

        </div>
    </div>
    <div id="element_a_actualiser">
        <!-- <?php


                $url = "http://projets-tomcat.isep.fr:8080/appService/?ACTION=GETLOG&TEAM=0G4D";
                $data = file_get_contents($url);

                $data_tab = str_split($data, 33);
                echo "Tabular Data:<br />";
                for ($i = 0, $size = count($data_tab); $i < $size - 1; $i++) {
                    echo "Trame $i: $data_tab[$i]";
                    $capteur = "";
                    $trame = $data_tab[$i];
                    // décodage avec des substring
                    $t = substr($trame, 0, 1);
                    $o = substr($trame, 1, 4);

                    // décodage avec scanf
                    list($t, $o, $r, $c, $n, $v, $a, $x, $year, $month, $day, $hour, $min, $sec) =
                        sscanf($trame, "%1s%4s%1s%1s%2s%4s%4s%2s%4s%2s%2s%2s%2s%2s");
                    //    echo(" || $t,$o,$r,$c,$n,$v,$a,$x,$year,$month,$day,$hour,$min,$sec<br />");

                    if (hexdec($c) == 10) {
                        $capteur = "Son";
                    } elseif (hexdec($c) == 3) {
                        $capteur = "Température";
                    } elseif (hexdec($c) == 4) {
                        $capteur = "Humidité";
                    } elseif (hexdec($c) == 5) {
                        $capteur = "CO2";
                    } elseif (hexdec($c) == 6) {
                        $capteur = "BPM";
                    }

                    echo (" || Value: " . hexdec($v) . "  || Capteur: " . $capteur . " <br />");
                }
                echo (" || Last Value of Sound:  " . hexdec($v));
                echo ('<br /> date: ');
                $date = new \DateTime();
                echo $date->format('d/m/Y H:i:s');



                ?> -->
    </div>

    <?php include '../php-pages/site-footer.php' ?>
    <script type="text/javascript">
        setMarginTop('sih-main-header', 'id', 'dv-main-body-div', 'id', 40)

        // setToWindowHeight('dv-main-body-div', 'id', 0)
        setMarginTopFooter('dv-main-body-div', 'id', 'site-footer-main-div', 'id', 0)
    </script>

    <script src="../javaScript/devices-buttons.js"></script>

</body>


</html>