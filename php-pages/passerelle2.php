<?php
session_start();
include_once '../php-processes/dbConnection.php';


$devID = "dev1";
$deviceInfo = returnDevicesList($devID);
$devName = $deviceInfo[0]['devName'];
$prdImg = $deviceInfo[0]['prdImg'];


$url = "http://projets-tomcat.isep.fr:8080/appService/?ACTION=GETLOG&TEAM=G04D";
$data = file_get_contents($url);

$data_tab = str_split($data, 33);
echo "<br /><br /><br /><br /><br /><br />Tabular Data:<br />";
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
    } elseif (hexdec($c) == 6) {
        $capteur = "CO2";
    } elseif (hexdec($c) == 5) {
        $capteur = "BPM";
    } else {
        $capteur = $c;
    }

    echo (" || Value: " . hexdec($v) . "  || Capteur: " . $capteur . " <br />");
}
echo ('<br /> date: ');
$date = new \DateTime();
echo $date->format('d/m/Y H:i:s');


generateDeviceData("dev1", hexdec($v), $date, $c);
