<?php

include 'entities.php';
include 'php-mailer.php';
include 'verification-functions.php';
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
$cltToken = $newUserInfo->getCltToken();

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


$newPasswordConfirmation = $_POST["cltPasswordConfirmation-input"];

checkPasswordLength($cltPassword);
checkPasswordLetter($cltPassword);
checkPasswordNumber($cltPassword);
checkPasswordMatch($cltPassword, $newPasswordConfirmation);

$emailSQL = "SELECT cltEmail FROM Client WHERE cltEmail='".$cltEmail."'";
$result = runSQLResult($emailSQL);
$userEmail = $result->fetch_assoc();

if (!(is_null($userEmail))) {
    die("Email already Taken");
}

//$verificationCode = generateVerificationCode();
//$body = '<p>Verification code is: <b style = "font-size: 30px;">'.$verificationCode.'</b></p>';
//$subject = "Email Verification";

$verificationCode = generateVerificationCode();
$body = returnEmailCodeValidationStructure($verificationCode)["body"];
$subject = returnEmailCodeValidationStructure($verificationCode)["subject"];

if(sendGmail($cltEmail, $cltFirstName, $body, $subject)) {
    $cltPasswordHash = returnPasswordHash($cltPassword);

    $insertSQL = "INSERT INTO client (`cltID`, `cltUsername`, `cltFirstName`, `cltLastName`, `cltEmail`, `cltPhoneNumber`, `cltPassword`, `cltIsModerator`, `cltVerifiedEmail`, cltToken)
        VALUES ('".$cltID."', '".$cltUsername."', '".$cltFirstName."', '".$cltLastName."', '".$cltEmail."', '".$cltPhoneNumber."', '".$cltPasswordHash."', 0, 0,'".$cltToken."')";

    if(insertSQL($insertSQL) == "Success") {
        session_start();
        // Variables in the session
        $_SESSION['verificationCode'] = $verificationCode;
        $_SESSION['newCltID'] = $cltID;
        $_SESSION['Token'] = $cltToken;
        $_SESSION['cltVerifiedEmail'] = 0;
        $_SESSION['message'] = "Signup Successful, Please verify your email address";

        header("Location: ../php-pages/signup-success.php", true, 303);
        exit;
    }
    else {
        echo insertSQL($insertSQL);
    }
}
