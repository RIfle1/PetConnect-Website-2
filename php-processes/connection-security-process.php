<?php
include '../php-processes/dbConnection.php';
include 'validation-functions.php';
session_start();
clientPage();

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $table = $_SESSION['Table'];
    $token = $_SESSION['Token'];
    $entityAttributes = returnEntityAttributes();
    $entityAttribute = $_POST['entityAttribute'];
    $entityValue = $_POST['entityValue'];

    $entityID = substr($entityAttribute, 3);

    if($entityID === "Username") {
        validateUsername($entityValue);
    }
    else if($entityID === "FirstName") {
        validateFirstName($entityValue);
    }
    else if($entityID === "LastName") {
        validateLastName($entityValue);
    }
    else if($entityID === "PhoneNumber") {
        validatePhoneNumber($entityValue);
    }
    else if($entityID === "Email") {
        validateEmail($entityValue);
    }
    else if($entityID === 'Password') {
//        checkPassword($entityValue, $newPasswordConfirmation);
        $entityValue = returnPasswordHash($entityValue);
    }

    $updateSql = "UPDATE ".$table." SET ".$entityAttribute." = '".$entityValue."' WHERE ".$entityAttributes['Token']." = '".$token."'";
    echo $updateSql;

    runSQLResult($updateSql);

}

