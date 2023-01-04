<?php
include '../php-processes/dbConnection.php';
include 'verification-functions.php';
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
        checkUsername($entityValue);
    }
    else if($entityID === "FirstName") {
        checkFirstName($entityValue);
    }
    else if($entityID === "LastName") {
        checkLastName($entityValue);
    }
    else if($entityID === "PhoneNumber") {
        checkPhoneNumber($entityValue);
    }
    else if($entityID === "Email") {
        checkEmail($entityValue);
    }
    else if($entityID === 'Password') {
//        checkPassword($entityValue, $newPasswordConfirmation);
        $entityValue = returnPasswordHash($entityValue);
    }

    $updateSql = "UPDATE ".$table." SET ".$entityAttribute." = '".$entityValue."' WHERE ".$entityAttributes['Token']." = '".$token."'";
    echo $updateSql;

    runSQLResult($updateSql);

}

