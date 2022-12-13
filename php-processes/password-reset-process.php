<?php
session_start();
include '../php-processes/dbConnection.php';
include '../php-processes/verification-functions.php';

// Security stuff
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_SESSION['Token']) || empty($_SESSION['resetPassword']) || empty($_SESSION['ID'])) {
        header("Location: ../php-pages/restricted-access.php", true, 303);
        exit;
    }

    $newPassword = $_POST['newPassword-input'];
    $newPasswordConfirmation = $_POST['newPasswordConfirmation-input'];
    $token = $_SESSION['Token'];

    checkPasswordLength($newPassword);
    checkPasswordLetter($newPassword);
    checkPasswordNumber($newPassword);
    checkPasswordMatch($newPassword, $newPasswordConfirmation);

    $passwordHash = returnPasswordHash($newPassword);

// UPDATE PASSWORD SQL
    $updateSql = '';
    if ($_SESSION['ID'] === 'client') {
        // Check that the new password isn't the same as the old one
        $getPasswordSql = "SELECT cltPassword FROM client WHERE cltToken = '" . $token . "'";
        $cltResult = runSQLResult($getPasswordSql);
        $cltPassword = $cltResult->fetch_assoc()['cltPassword'];
        if (password_verify($newPassword, $cltPassword)) {
            header("Location: ../php-pages/password-reset.php?isInvalid=1", true,303);
            exit;
        }

        $updateSql = "UPDATE client SET cltPassword = '" . $passwordHash . "' WHERE cltToken = '" . $token . "'";
    } elseif ($_SESSION['ID'] === 'admin') {
        // Check that the new password isn't the same as the old one
        $getPasswordSql = "SELECT admPassword FROM admin WHERE admToken = '" . $token . "'";
        $admResult = runSQLResult($getPasswordSql);
        $admPassword = $admResult->fetch_assoc()['admPassword'];
        if (password_verify($newPassword, $admPassword)) {
            header("Location: ../php-pages/password-reset.php?isInvalid=1", true,303);
            exit;
        }

        $updateSql = "UPDATE admin SET admPassword = '" . $passwordHash . "' WHERE admToken = '" . $token . "'";
    }

//INSERT SQL INTO DB
    if ($_SESSION['ID'] === 'client' || $_SESSION['ID'] === 'admin') {
//    echo $token;
        runSQLResult($updateSql);
        header('Location: ../php-pages/password-reset-success.php?success=1', true, 303);
    }
    else {
        header('Location: ../php-pages/password-reset-success.php?success=2', true, 303);
    }
    exit;
}
