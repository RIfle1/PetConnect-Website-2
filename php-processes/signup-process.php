<?php

include 'entities.php';
include 'php-mailer.php';
include 'validation-functions.php';

$languagesList = returnLanguageList()[returnLanguage()]['signup-process'];

$newUserInfo = new Client
(
    $_POST["username-input"],
    $_POST["firstName-input"],
    $_POST["lastName-input"],
    $_POST["email-input"],
    $_POST["phoneNumber-input"],
    $_POST["password-input"],
);

$cltID = $newUserInfo->getCltID();
$cltUsername = $newUserInfo->getCltUsername();
$cltFirstName = $newUserInfo->getCltFirstName();
$cltLastName = $newUserInfo->getCltLastName();
$cltEmail = $newUserInfo->getCltEmail();
$cltPhoneNumber = $newUserInfo->getCltPhoneNumber();
$cltPassword = $newUserInfo->getCltPassword();
$cltToken = $newUserInfo->getCltToken();
$newPasswordConfirmation = $_POST["passwordConfirmation-input"];

validateUsername($cltUsername);
validateFirstName($cltFirstName);
validateLastName($cltLastName);
validatePhoneNumber($cltPhoneNumber);
validateEmail($cltEmail);
validatePassword($cltPassword, $newPasswordConfirmation);

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
        $_SESSION['message'] = $languagesList["Signup Successful, Please verify your email address"];

        header("Location: ../php-pages/signup-success.php", true, 303);
        exit;
    }
    else {
        echo insertSQL($insertSQL);
    }
}
