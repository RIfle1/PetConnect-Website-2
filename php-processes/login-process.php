<?php
include 'dbConnection.php';
include 'php-mailer.php';
$isInvalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "SELECT * FROM client WHERE cltEmail = '" . $_POST["lgEmail-input"] . "'";
    $result = runSQLResult($sql);
    $clientInfo = $result->fetch_assoc();

    $sql2 = "SELECT * FROM admin WHERE admEmail = '".$_POST["lgEmail-input"]."'";
    $result2 = runSQLResult($sql2);
    $adminInfo = $result2->fetch_assoc();

    if ($clientInfo) {

        if (password_verify($_POST["lgPassword-input"], $clientInfo["cltPassword"])) {


            $token = generateToken($clientInfo['cltID']);

            $insertTokenSql = "UPDATE client SET cltToken = '".$token."' WHERE cltID='".$clientInfo['cltID']."'";
            runSQLResult($insertTokenSql);

            session_start();

            $_SESSION['Token'] = $token;

            if($clientInfo["cltVerifiedEmail"] === '0') {
                $_SESSION['loggedIn'] = false;

                $verificationCode = generateVerificationCode();
                $body = '<p>Verification code is: <b style = "font-size: 30px;">'.$verificationCode.'</b></p>';
                $subject = "Email Verification";
                $cltEmail = $clientInfo['cltEmail'];
                $cltFirstName = $clientInfo['cltFirstName'];
                $cltID = $clientInfo['cltID'];
                $cltVerifiedEmail = $clientInfo['cltVerifiedEmail'];

                if(sendGmail($cltEmail, $cltFirstName, $body, $subject)) {
                    $_SESSION['message'] = 'Your account has been created but your email is still not validated. 
                A code has been sent to your email to validate your account';
                    $_SESSION['verificationCode'] = $verificationCode;
                    $_SESSION['newCltID'] = $cltID;
                    $_SESSION['cltVerifiedEmail']= $cltVerifiedEmail;
                } else {
                    $_SESSION['message'] = 'A validation code could not be sent to your email, please contact a web developer';
                }

                header("Location: ../php-pages/signup-success.php", true, 303);
                exit;

            } elseif ($clientInfo["cltVerifiedEmail"] === '1') {
                $_SESSION['loggedIn'] = true;
                $_SESSION["cltID"] = $clientInfo["cltID"];
                header("Location: ../php-pages/home.php", true, 303);
                exit;
            }

        }

    }
    elseif ($adminInfo) {
        if (password_verify($_POST["lgPassword-input"], $adminInfo["admPassword"])) {

            // Generate an admin Token
            $token = generateToken($adminInfo['admID']);

            $insertTokenSql = "UPDATE admin SET admToken = '".$token."' WHERE admID='".$adminInfo['admID']."'";
            insertSQL($insertTokenSql);

            session_start();
            session_regenerate_id();

            $_SESSION['Token'] = $token;

            $_SESSION['loggedIn'] = true;
            $_SESSION["admID"] = $adminInfo["admID"];
            header("Location: ../php-pages/home.php", true, 303);
            exit;
        }
    }
    $isInvalid = true;
    header('Location: ../php-pages/login.php?isInvalid='.$isInvalid.'&lgEmail-input='.$_POST["lgEmail-input"], true, 303);
    exit;
}


