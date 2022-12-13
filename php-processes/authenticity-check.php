<?php

include 'dbConnection.php';

if(empty($_SESSION['cltID']) || empty($_SESSION['admID']) || empty($_SESSION['Token']) || empty($_SESSION['ID'])) {
    header("Location: login.php", true, 303);
    exit;
}elseif($_SESSION['ID'] === 'client') {
    $cltToken = $_SESSION['Token'];
    $cltCheckSql = "SELECT * FROM client WHERE cltToken = '".$cltToken."'";
    $cltResult = runSQLResult($cltCheckSql);
    $clientInfo = $cltResult->fetch_assoc();

    if(!$clientInfo) {
        header("Location: login.php", true, 303);
        exit;
    }
}elseif($_SESSION['ID'] === 'admin') {
    $admToken = $_SESSION['Token'];
    $admCheckSql = "SELECT * FROM admin WHERE admToken = '" . $admToken . "'";
    $admResult = runSQLResult($admCheckSql);
    $adminInfo = $admResult->fetch_assoc();

    if (!$adminInfo) {
        header("Location: login.php", true, 303);
        exit;
    }
}
