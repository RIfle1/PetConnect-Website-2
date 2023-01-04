<?php
session_start();
include 'dbConnection.php';
include 'verification-functions.php';
//clientPage();

$loggedIn = $_SESSION['loggedIn'];
$table = $_SESSION['Table'];
$token = $_SESSION['Token'];
$newPassword = $_GET['newPassword'];
$entityAttributes = returnEntityAttributes();

$crossCheckPasswordSql = "SELECT * FROM ".$table." WHERE ".$entityAttributes['Token']." = '".$token."'";
$result = runSQLResult($crossCheckPasswordSql);
$entityInfo = $result->fetch_assoc();

$oldPasswordHash = $entityInfo[$entityAttributes['Password']];

if(password_verify($newPassword, $oldPasswordHash)) {
    $passwordAvailable = false;
}
else {
    $passwordAvailable = true;
}

header("Content-Type: application/json");
echo json_encode(["passwordAvailable" => $passwordAvailable]);

