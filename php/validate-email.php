<?php
include 'dbConnection.php';
$cltEmail = $_GET["cltEmail-input"];
$emailSQL = "SELECT cltEmail FROM Client WHERE cltEmail='".$cltEmail."'";
$result = runSQLResult($emailSQL);
$userEmail = $result->fetch_assoc();

$isAvailable = $result->num_rows === 0;

header("Content-Type: application/json");
echo json_encode(["available" => $isAvailable]);