<?php
include '../php-processes/dbConnection.php';
include 'validation-functions.php';
session_start();
onlyClientPage();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_GET['type'];
    $addressSql = '';

    $adrAddress = $_POST["adrAddress-input"];
    $adrAddressOptional = $_POST["adrAddressOptional-input"];
    $adrPostalCode = $_POST["adrPostalCode-input"];
    $adrCity = $_POST["adrCity-input"];
    $adrDefault = 0;
    $Client_cltID = $_SESSION['ID'];

    validateAddress($adrAddress);
    validatePostalCode($adrPostalCode);
    validateCity($adrCity);



    if(empty($type)) {
        $adrID = autoSetID('adr');
        $addressSql = "INSERT INTO address(adrID, adrAddress, adrAddressOptional, adrPostalCode, adrCity, adrDefault, Client_cltID)
                         VALUES ('".$adrID."', '".$adrAddress."', '".$adrAddressOptional."', '".$adrPostalCode."', '".$adrCity."', '".$adrDefault."','".$Client_cltID."')";

    }
    else if($type === "modifyAddress") {
        $adrID = $_GET['adrID'];
        $addressSql = "UPDATE address SET 
                       adrAddress = '".$adrAddress."',
                       adrAddressOptional = '".$adrAddressOptional."',
                       adrPostalCode = '".$adrPostalCode."',
                       adrCity = '".$adrCity."'
                       WHERE adrID = '".$adrID."'";
    }

    runSQLResult($addressSql);

    header("Location: ../php-pages/address.php", true, 303);
}

