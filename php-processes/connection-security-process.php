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

    if(substr($entityAttribute, 3) === 'Password') {
        $entityValue = returnPasswordHash($entityValue);
    }

    $updateSql = "UPDATE ".$table." SET ".$entityAttribute." = '".$entityValue."' WHERE ".$entityAttributes['Token']." = '".$token."'";
    echo $updateSql;

    runSQLResult($updateSql);

}

