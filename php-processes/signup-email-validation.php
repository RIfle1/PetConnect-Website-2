<?php
session_start();

include '../php-processes/dbConnection.php';
$languagesList = returnLanguageList()[returnLanguage()]['signup-email-validation'];

// .getJSON COMMAND
// TO SEND JSON, ALL FIELDS MUST BE SENT IN SESSION => newCltID, verificationCode and cltVerifiedEmail !!!!!!!!!!!!!!
// PUT THE VARIABLES IN A JSON FILE AND ALLOW SIGNUP-EMAIL-VALIDATION TO CHECK IF THE VERIFICATION CODE IS CORRECT
if(!empty($_SESSION['verificationCode']) && !empty($_SESSION['newCltID'] && !empty($_SESSION['Token']))  && empty($_POST)) {
    $clientInfo = array(
        'newCltID' => $_SESSION['newCltID'],
        'verificationCode' => $_SESSION['verificationCode'],
        'cltVerifiedEmail' => $_SESSION['cltVerifiedEmail'],
        'cltToken' => $_SESSION['Token'],
    );

    header("Content-Type: application/json");
    echo json_encode(['clientInfo' => $clientInfo]);
}

// .AJAX COMMAND
// SET THE CLTVERIFIEDEMAIL TO 1 IF THE VERIFICATION CODE IS CORRECT

else if(!empty($_POST['newCltID']) && !empty($_POST['verificationCode']) && !empty($_POST['cltToken'])) {

    // CHECK IF TOKEN MATCHES NEW CLIENT ID
    if(compareIdAndToken(($_POST['newCltID']), $_POST['cltToken'], 'client')) {
        $sql = "UPDATE client SET cltVerifiedEmail = 1 WHERE cltID = '".$_POST['newCltID']."'";
        $_SESSION['cltVerifiedEmail'] = 1;
        runSQLResult($sql);
    }
    else {
        $_SESSION['errorMsg'] = $languagesList['The new Client ID does not match the cltID fetched with the token. Review signup-email-validation'];
        header("Location: ../php-pages/restricted-access");
    }
}

