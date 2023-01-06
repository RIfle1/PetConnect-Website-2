<?php
include '../php-processes/dbConnection.php';
clientPage();
$cltID = $_SESSION["ID"];
if (isset($_POST["addDevice"])) {

    $deviceNumber = $_POST["deviceNumber"];

    echo $deviceNumber;

    $checkDevice = "SELECT * FROM Device WHERE Client_cltID ='" . $cltID . "'";


    $IDdevice =  runSQLResult($checkDevice);

    while ($device = $IDdevice->fetch_assoc()) {

        echo $device["devID"];


        if ($deviceNumber == $device["devID"] and $device["devAdd"] == 0) {
            echo "success";
            $updateDev =  "UPDATE Device  SET devAdd = 1  WHERE devID ='" . $device["devID"] . "' AND Client_cltID ='" . $cltID . "'";
            runSQLResult($updateDev);
            header("Location: ../php-pages/devices.php?reg_err=success");
            die();
        } elseif ($deviceNumber == $device["devID"] and $device["devAdd"] == 1) {
            header("Location: ../php-pages/devices.php?reg_err=already");
            die();
        } else {
            echo "wrong number";
        }
    }
    header("Location: ../php-pages/devices.php?reg_err=wrong");
    die();
}



if (isset($_POST["deleteDevice"])) {
    $deleteDev =  "UPDATE Device  SET devAdd = 0  WHERE devID ='" . $_POST["deleteDevice"] . "' AND Client_cltID ='" . $cltID . "'";
    runSQLResult($deleteDev);
    header("Location: ../php-pages/devices.php?reg_err=suppr");
    die();
}
