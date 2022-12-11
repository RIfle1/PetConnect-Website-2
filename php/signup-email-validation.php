<?php
session_start();

include 'dbConnection.php';

// TO SEND JSON, ALL FIELDS MUST BE SENT IN SESSION => newCltID, verificationCode and cltVerifiedEmail !!!!!!!!!!!!!!

if(!empty($_SESSION['verificationCode']) && !empty($_SESSION['newCltID']) && empty($_POST)) {
    $clientInfo = array(
        'newCltID' => $_SESSION['newCltID'],
        'verificationCode' => $_SESSION['verificationCode'],
        'cltVerifiedEmail' => $_SESSION['cltVerifiedEmail'],
    );

    header("Content-Type: application/json");
    echo json_encode(['clientInfo' => $clientInfo]);
}

else if(!empty($_POST['newCltID']) && (!empty($_POST['verificationCode']))) {
    $sql = "UPDATE client SET cltVerifiedEmail = 1 WHERE cltID = '".$_POST['newCltID']."'";
    $_SESSION['cltVerifiedEmail'] = 1;
    runSQLResult($sql);
}


