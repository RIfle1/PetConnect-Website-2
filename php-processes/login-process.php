<?php
include 'dbConnection.php';
include 'php-mailer.php';

$languagesList = returnLanguageList()[returnLanguage()]['login-process'];
$isInvalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "SELECT * FROM client WHERE cltEmail = '" . $_POST["lgEmail-input"] . "'";
    $result = runSQLQuery($sql);
    $clientInfo = $result->fetch_assoc();

    $sql2 = "SELECT * FROM admin WHERE admEmail = '".$_POST["lgEmail-input"]."'";
    $result2 = runSQLQuery($sql2);
    $adminInfo = $result2->fetch_assoc();

    if ($clientInfo) {

        if (password_verify($_POST["lgPassword-input"], $clientInfo["cltPassword"])) {


            $token = generateToken($clientInfo['cltID']);

            $insertTokenSql = "UPDATE client SET cltToken = '".$token."' WHERE cltID='".$clientInfo['cltID']."'";
            runSQLQuery($insertTokenSql);

            session_start();
            session_regenerate_id();

            $_SESSION['Token'] = $token;

            if($clientInfo["cltVerifiedEmail"] === '0') {
                $_SESSION['loggedIn'] = false;

                $verificationCode = generateVerificationCode();

                $body = returnEmailCodeValidationStructure($verificationCode)["body"];
                $subject = returnEmailCodeValidationStructure($verificationCode)["subject"];

                $cltEmail = $clientInfo['cltEmail'];
                $cltFirstName = $clientInfo['cltFirstName'];
                $cltID = $clientInfo['cltID'];
                $cltVerifiedEmail = $clientInfo['cltVerifiedEmail'];

                if(sendGmail($cltEmail, $cltFirstName, $body, $subject)) {
                    $_SESSION['message'] = $languagesList['Your account has been created but your email is still not validated. 
                A code has been sent to your email to validate your account'];
                    $_SESSION['verificationCode'] = $verificationCode;
                    $_SESSION['newCltID'] = $cltID;
                    $_SESSION['cltVerifiedEmail']= $cltVerifiedEmail;
                } else {
                    $_SESSION['message'] = $languagesList['A validation code could not be sent to your email, please contact a web developer'];
                }

                header("Location: ../php-pages/signup-success.php", true, 303);
                exit;

            } elseif ($clientInfo["cltVerifiedEmail"] === '1') {
                $_SESSION["ID"] = $clientInfo["cltID"];
                $_SESSION['Table'] = 'client';
                $_SESSION['loggedIn'] = true;

                setcookie("Token-cookie", $token, time() + (86400 * 30), "/");
                setcookie("Table-cookie", $_SESSION['Table'], time() + (86400 * 30), "/");

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

            $_SESSION["ID"] = $adminInfo["admID"];
            $_SESSION['Table'] = 'admin';
            $_SESSION['loggedIn'] = true;

            setcookie("Token-cookie", $token, time() + (86400 * 30), "/");
            setcookie("Table-cookie", $_SESSION['Table'], time() + (86400 * 30), "/");

            header("Location: ../php-pages/home.php", true, 303);
            exit;
        }
    }
    $isInvalid = true;
    header('Location: ../php-pages/login.php?isInvalid='.$isInvalid.'&lgEmail-input='.$_POST["lgEmail-input"], true, 303);
    exit;
}


