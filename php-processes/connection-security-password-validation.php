<?php
session_start();
include 'dbConnection.php';
include 'verification-functions.php';
clientPage();

$loggedIn = $_SESSION['loggedIn'];
$table = $_SESSION['ID'];
$token = $_SESSION['Token'];
$newPassword = $_GET['newPassword'];
$entityAttributeList = returnEntityAttributes();

$crossCheckPasswordSql = "SELECT * FROM ".$table." WHERE ".end($entityAttributeList)." = '".$token."'";
$result = runSQLResult($crossCheckPasswordSql);
$entityInfo = $result->fetch_assoc();
$oldPasswordHash = $entityInfo[$entityAttributeList[8]];

if(password_verify($newPassword, $oldPasswordHash)) {
    $samePassword = true;
}
else {
    $samePassword = false;
}

header("Content-Type: application/json");
echo json_encode(["samePassword" => $samePassword]);

