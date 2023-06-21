<?php
session_start();
include_once '../php-processes/dbConnection.php';

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












function generateDeviceData2($devID, $v, $date, $c): void
{
    //$dapDate = date('2023-01-01 00:00:00');
    $dapDate = $date->format('d/m/Y H:i:s');
    $dapID = autoSetID('dap');
    $dapBPM = rand(80, 100);
    $dapLatitude = randFloat(48, 49, 5);
    $dapLongitude = randFloat(2, 3, 5);
    $dapCO2 = rand(800, 1200);
    $dapDecibel = rand(0, 10);
    $dapTemp = rand(37, 40);

    if (hexdec($c) == 10) {
        $dapDecibel = $v;
    } elseif (hexdec($c) == 3) {
        $dapTemp = $v;
    } elseif (hexdec($c) == 4) {
        $dapCO2 = $v;
    } elseif (hexdec($c) == 5) {
        $dapTemp = $v;
    } elseif (hexdec($c) == 6) {
        $dapTemp = $v;
    }
    $insertDataSql = "INSERT INTO data_device(dapID, dapBPM, dapLatitude, dapLongitude, dapCO2, dapDecibel, dapTemp, dapDate, Device_devID) 
                          VALUES ('" . $dapID . "', '" . $dapBPM . "', '" . $dapLatitude . "', '" . $dapLongitude . "', '" . $dapCO2 . "', '" . $dapDecibel . "', '" . $dapTemp . "', '" . $dapDate . "', '" . $devID . "')";
    runSQLQuery($insertDataSql);

    //        echo $insertDataSql.'<br>';

}
?>
<!-- <script src='../javaScript/passerelle.js'>
    function insertData() {
        // Récupérer les valeurs des variables v et c du fichier PHP
        var v = <?php echo json_encode($v); ?>;
        var c = <?php echo json_encode($c); ?>;

        // Insérer les données dans la base de données
        // Utilisez ici la méthode appropriée pour envoyer les données au serveur, par exemple, avec une requête AJAX

        // Exemple d'utilisation d'une requête AJAX avec jQuery
        $.ajax({
            url: 'insert_data.php',
            method: 'POST',
            data: {
                v: v,
                c: c
            },
            success: function(response) {
                console.log('Données insérées avec succès.');
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de l\'insertion des données : ' + error);
            }
        });
    }

    // Appeler la fonction d'insertion des données toutes les 5 secondes
    setInterval(insertData, 5000);
</script> -->