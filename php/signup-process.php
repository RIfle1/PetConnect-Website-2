<?php
include 'entities.php';

$newUserInfo = new Client
(
    $_POST["cltUsername-input"],
    $_POST["cltFirstName-input"],
    $_POST["cltLastName-input"],
    $_POST["cltEmail-input"],
    $_POST["cltPhoneNumber-input"],
    $_POST["cltPassword-input"]
);

$cltID = $newUserInfo->getCltID();
$cltUsername = $newUserInfo->getCltUsername();
$cltFirstName = $newUserInfo->getCltFirstName();
$cltLastName = $newUserInfo->getCltLastName();
$cltEmail = $newUserInfo->getCltEmail();
$cltPhoneNumber = $newUserInfo->getCltPhoneNumber();
$cltPassword = $newUserInfo->getCltPassword();

if(empty($cltUsername)) {
    die("Username Is Required");
}

if(empty($cltFirstName)) {
    die("First Name Is Required");
}

if(empty($cltLastName)) {
    die("Last Name Is Required");
}

if (! filter_var($cltPhoneNumber, FILTER_VALIDATE_INT)) {
    die("Valid Phone Number is Required");
}

if (! filter_var($cltEmail, FILTER_VALIDATE_EMAIL)) {
    die("Valid Email is Required");
}

if (strlen($cltPassword) < 8){
    die("Password must be at least 8 characters");
}

if (! preg_match("/[a-z]/i", $cltPassword)){
    die("Password must contain at least one letter");
}

if (! preg_match("/[0-9]/i", $cltPassword)){
    die("Password must contain at least one number");
}

if ($cltPassword !== $_POST["cltPasswordConfirmation-input"]) {
    die("Passwords must match");
}

$emailSQL = "SELECT cltEmail FROM Client WHERE cltEmail='".$cltEmail."'";
$result = runSQLResult($emailSQL);
$userEmail = $result->fetch_assoc();

if (!(is_null($userEmail))) {
    die("Email already Taken");
}

$cltPasswordHash = password_hash($cltPassword, PASSWORD_DEFAULT);

$insertSQL = "INSERT INTO client (`cltID`, `cltUsername`, `cltFirstName`, `cltLastName`, `cltEmail`, `cltPhoneNumber`, `cltPassword`) 
        VALUES ('".$cltID."', '".$cltUsername."', '".$cltFirstName."', '".$cltLastName."', '".$cltEmail."', '".$cltPhoneNumber."', '".$cltPasswordHash."')";

if(insertSQL($insertSQL) == "Success") {
    header("Location: signup-success.php", true, 303);
    exit;
}
else {
    echo insertSQL($insertSQL);
}

//print_r($_POST);
//var_dump($cltPasswordHash);
