<?php
session_start();
include_once '../php-processes/dbConnection.php';


$devID = "dev1";
$deviceInfo = returnDevicesList($devID);
$devName = $deviceInfo[0]['devName'];
$prdImg = $deviceInfo[0]['prdImg'];


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
echo ('<br /> date: ');
$date = new \DateTime();
echo $date->format('d/m/Y H:i:s');


generateDeviceData("dev1", hexdec($v), $date, $c);







$selectData_Time = runSQLQuery("SELECT * FROM Data_Device WHERE Device_devID = '" . $devID . "' ORDER BY dapDate DESC");
$selectData_Date = runSQLQuery("SELECT AVG(dapBPM),AVG(dapCO2),AVG(dapDecibel),AVG(dapTemp),dapDate FROM `Data_Device` WHERE Device_devID = '" . $devID . "' GROUP BY CAST(dapDate AS DATE)");
$selectData_Coordinate = runSQLQuery("SELECT * FROM Data_Device WHERE Device_devID = '" . $devID . "' ORDER BY dapDate DESC LIMIT 0,1");

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
print_r(" <br /><br />|| Valors: " . $DB_Time . "  || Cvalor: " .  $timeArray . " <br />");
print_r($DB_Time);
print_r(" <br /> <br />");
print_r($timeArray);


$data = array(
    'DB_Time' => $DB_Time,
    'timeArray' => $timeArray
);

file_put_contents('data.php', '<?php return ' . var_export($data, true) . ';');
