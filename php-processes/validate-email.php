<?php
include 'dbConnection.php';

$email = $_GET["email-input"];
$emailSQL1 = "SELECT cltEmail FROM Client WHERE cltEmail='".$email."'";
$emailSQL2 = "SELECT admEmail FROM admin WHERE admEmail='".$email."'";
$result1 = runSQLResult($emailSQL1);
$result2 = runSQLResult($emailSQL2);

if($result1->num_rows === 0 && $result2->num_rows === 0) {
    $emailAvailable = true;
}
else {
    $emailAvailable = false;
}

header("Content-Type: application/json");
echo json_encode(["emailAvailable" => $emailAvailable]);