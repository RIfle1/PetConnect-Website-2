<?php
include_once '../php-processes/dbConnection.php';

$email = $_GET["email-input"];
$emailSQL1 = "SELECT cltEmail FROM client WHERE cltEmail='".$email."'";
$emailSQL2 = "SELECT admEmail FROM admin WHERE admEmail='".$email."'";
$result1 = runSQLQuery($emailSQL1);
$result2 = runSQLQuery($emailSQL2);

if($result1->num_rows === 0 && $result2->num_rows === 0) {
    $emailAvailable = true;
}
else {
    $emailAvailable = false;
}

header("Content-Type: application/json");
echo json_encode(["emailAvailable" => $emailAvailable]);