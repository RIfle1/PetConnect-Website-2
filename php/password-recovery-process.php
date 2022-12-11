<?php

include 'dbConnection.php';
include 'php-mailer.php';

if($_SERVER["REQUEST_METHOD"] === "POST") {

    //Verify that the input email exists in the database
    $cltEmailInput = $_POST['cltEmail-input'];
    $selectSql = "SELECT * FROM client WHERE cltEmail='".$cltEmailInput."'";
    $result = runSQLResult($selectSql);
    $clientInfo = $result->fetch_assoc();
    $cltToken = $clientInfo['cltToken'];

    if(strlen($cltToken) === 0) {
        $newCltToken = $token = generateToken($clientInfo['cltID']);
        $updateSQL = "UPDATE client SET cltToken = '".$newCltToken."'";
        runSQLResult($updateSQL);

        $result2 = runSQLResult($selectSql);
        $clientInfo = $result2->fetch_assoc();
        $cltToken = $clientInfo['cltToken'];
    }


    session_start();

    if($clientInfo) {


        $cltFirstName = $clientInfo['cltFirstName'];
        $cltID = $clientInfo['cltID'];
        $cltVerifiedEmail = $clientInfo['cltVerifiedEmail'];



        $_SERVER['cltToken'] = $cltToken;
        $_SESSION['resetPassword'] = true;

        $serverName = $_SERVER['SERVER_PORT'];
        $cltEmail = $clientInfo['cltEmail'];

        $test = "test";
        $url = 'https://localhost:'.$serverName.'/password-recovery.php?cltEmail='.$cltEmail.'&cltToken='.$cltToken;

        echo strlen($url);
        echo $url;

        // THIS FUCKING SHIT IS ANNOYING AS FUCK

        $body = "<div>We got a request from you to reset your Password!. Please click this link to reset your password:<a>Test</a></div>";

        $subject = "Email Verification";

        if(sendEmail($cltEmail, $cltFirstName, $test, $subject)) {
            $_SESSION['message'] = 'A recovery link has been sent to '.$cltEmail.' please follow the link to reset your password.';
        } else {
            $_SESSION['message'] = 'The recovery link could not be sent to '.$cltEmail.'. Contact a web developer if you think this is a mistake.';
        }
        header("Location: password-recovery-output.php", true, 303);
    }
    else {
        header("Location: password-recovery-input.php?isInvalid=1", true, 303);
    }
    exit;
}

