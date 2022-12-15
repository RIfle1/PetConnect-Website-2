<?php
include '../php-processes/dbConnection.php';
include 'verification-functions.php';
session_start();
//clientPage();

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $entity = $_SESSION['ID'];
    $token = $_SESSION['Token'];
    $entityAttributeList = returnEntityAttributes();
    $entityAttribute = $_POST['entityAttribute'];
    $entityValue = $_POST['entityValue'];

    if(substr($entityAttribute, 3) === 'Password') {
        $entityValue = returnPasswordHash($entityValue);
    }

    $updateSql = "UPDATE ".$entity." SET ".$entityAttribute." = '".$entityValue."' WHERE ".end($entityAttributeList)." = '".$token."'";

    if(runSQLResult($updateSql)) {
        $_SESSION['errorMsg'] = $updateSql;
        header("Location ../php-pages/restricted-access");
    }

}

