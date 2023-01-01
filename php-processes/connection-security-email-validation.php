<?php
session_start();
include 'dbConnection.php';
include 'verification-functions.php';
include 'php-mailer.php';
clientPage();

$loggedIn = $_SESSION['loggedIn'];
$table = $_SESSION['Table'];
$token = $_SESSION['Token'];
$newEmail = $_GET['newEmail'];

$entityInfo = returnEntityInfo();
$entityAttributes = returnEntityAttributes();

$entityFirstName = $entityInfo[$entityAttributes["FirstName"]];

$verificationCode = generateVerificationCode();
$body = returnEmailCodeValidationStructure($verificationCode)["body"];
$subject = returnEmailCodeValidationStructure($verificationCode)["subject"];
$emailSent = false;


if(sendGmail($newEmail, $entityFirstName, $body, $subject)) {
    $emailSent = true;
} else {
    $verificationCode = "";
}

$processValues = array(
    'emailSent' => $emailSent,
    'verificationCode' => $verificationCode,
);

header("Content-Type: application/json");
echo json_encode(["processValues" => $processValues]);
