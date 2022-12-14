<?php

include 'dbConnection.php';
include 'php-mailer.php';

/**
 * @param string $url
 * @param mixed $email
 * @param mixed $firstName
 * @return void
 */

function variablesToSendTheEmail(string $url, mixed $email, mixed $firstName): void
{
    $body = "<div>We got a request from you to reset your Password!. <a href=$url>Please click this link to reset your password</a></div>";
    $subject = "Email Verification";

    // Send email
    if (sendGmail($email, $firstName, $body, $subject)) {
        $_SESSION['message'] = 'A recovery link has been sent to ' . $email . ' please follow the link to reset your password.';
    } else {
        $_SESSION['message'] = 'The recovery link could not be sent to ' . $email . '. Contact a web developer if you think this is a mistake.';
    }

    // Redirect to the page to reset the password
    header("Location: ../php-pages/password-recovery-output.php", true, 303);
}



if($_SERVER["REQUEST_METHOD"] === "POST") {

    //Verify that the input email exists in the database
    $emailInput = $_POST['email-input'];

    $selectClientSql = "SELECT * FROM client WHERE cltEmail='".$emailInput."'";
    $cltResult = runSQLResult($selectClientSql);
    $clientInfo = $cltResult->fetch_assoc();

    $selectAdminSql = "SELECT * FROM admin WHERE admEmail='".$emailInput."'";
    $admResult = runSQLResult($selectAdminSql);
    $adminInfo = $admResult->fetch_assoc();

    session_start();

    if($clientInfo) {
        // Generate new token for the client
        $newToken = generateToken($clientInfo['cltID']);
        // Update client token and get new client info
        $updateCltTokenSQL = "UPDATE client SET cltToken = '".$newToken."' WHERE cltEmail='".$emailInput."' ";
        runSQLResult($updateCltTokenSQL);
        $cltResult2 = runSQLResult($selectClientSql);
        $clientInfo = $cltResult2->fetch_assoc();

        // Get new client variables
        $cltFirstName = $clientInfo['cltFirstName'];
        $cltID = $clientInfo['cltID'];
        $cltVerifiedEmail = $clientInfo['cltVerifiedEmail'];
        $newCltToken = $clientInfo['cltToken'];

        // Store variable in the session
        $_SESSION['resetPassword'] = true;

        // Get variables for the link to reset the password
        $serverName = $_SERVER['SERVER_PORT'];
        $cltEmail = $clientInfo['cltEmail'];
        $serverHost= $_SERVER['HTTP_HOST'];
        $serverName = explode('/', $_SERVER['SCRIPT_NAME'])[1];

        // Create a url
        $url = "https://".$serverHost."/".$serverName."/php-pages/password-reset.php?cltEmail=".$cltEmail."&Token=".$newCltToken;

        // Send the email
        variablesToSendTheEmail($url, $cltEmail, $cltFirstName);
    }

    elseif($adminInfo) {
        // Generate new token for the admin
        $newToken = generateToken($adminInfo['admID']);
        // Update client token and get new client info
        $updateAdmTokenSQL = "UPDATE admin SET admToken = '" . $newToken . "' WHERE admEmail='" . $emailInput . "' ";
        runSQLResult($updateAdmTokenSQL);
        $admResult2 = runSQLResult($selectAdminSql);
        $adminInfo = $admResult2->fetch_assoc();

        // Get new client variables
        $admFirstName = $adminInfo['admFirstName'];
        $admID = $adminInfo['admID'];
        $admVerifiedEmail = $adminInfo['admVerifiedEmail'];
        $newAdmToken = $adminInfo['admToken'];

        // Store variable in the session
        $_SESSION['resetPassword'] = true;

        // Get variables for the link to reset the password
        $serverName = $_SERVER['SERVER_PORT'];
        $admEmail = $adminInfo['admEmail'];
        $serverHost = $_SERVER['HTTP_HOST'];
        $serverName = explode('/', $_SERVER['SCRIPT_NAME'])[1];

        // Create a url
        $url = "https://" . $serverHost . "/" . $serverName . "/php-pages/password-reset.php?admEmail=" . $admEmail . "&Token=" . $newAdmToken;

        // Send the email
        variablesToSendTheEmail($url, $admEmail, $admFirstName);

    }
    else {
        header("Location: ../php-pages/password-recovery-input.php?isInvalid=1&email-input=".$emailInput, true, 303);
    }
    exit;
}

