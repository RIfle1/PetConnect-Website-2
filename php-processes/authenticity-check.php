<?php

//include 'dbConnection.php';

function returnLoggedUser(): string {
    if(empty($_SESSION['ID']) || empty($_SESSION['Token']) || empty($_SESSION['Table']) || empty($_SESSION['loggedIn'])) {
        return 'noUser';
    }

    if($_SESSION['Table'] === 'client' && $_SESSION['loggedIn'] === true) {
        $cltToken = $_SESSION['Token'];
        $cltCheckSql = "SELECT * FROM client WHERE cltToken = '".$cltToken."'";
        $cltResult = runSQLQuery($cltCheckSql);
        $clientInfo = $cltResult->fetch_assoc();

        if(!$clientInfo || !compareIdAndToken($_SESSION['ID'], $cltToken, 'client')) {
            return 'fake client';
        } else {
            return 'client';
        }
    }
    elseif($_SESSION['Table'] === 'admin' && $_SESSION['loggedIn'] === true) {
        $admToken = $_SESSION['Token'];
        $admCheckSql = "SELECT * FROM admin WHERE admToken = '" . $admToken . "'";
        $admResult = runSQLQuery($admCheckSql);
        $adminInfo = $admResult->fetch_assoc();

        if (!$adminInfo || !compareIdAndToken($_SESSION['ID'], $admToken, 'admin')) {
            return 'fake admin';
        }
        else {
            return 'admin';
        }
    }
    else {
        return 'noUser';
    }

}

$user = returnLoggedUser();

// CHECK WHO'S LOGGED IN
if($user === 'client'){
    $clientLoggedIn = $_SESSION['clientLoggedIn'] = true;
    $adminLoggedIn = $_SESSION['adminLoggedIn'] = false;
    $loggedIn = $_SESSION['loggedIn'];

    $entityInfo = returnEntityInfo();
    $entityAttributes = returnEntityAttributes();
    $IDLetters = $entityAttributes['IDLetters'];

}
elseif($user === 'admin') {
    $clientLoggedIn = $_SESSION['clientLoggedIn'] = false;
    $adminLoggedIn = $_SESSION['adminLoggedIn'] = true;
    $loggedIn = $_SESSION['loggedIn'];

    $entityInfo = returnEntityInfo();
    $entityAttributes = returnEntityAttributes();
    $IDLetters = $entityAttributes['IDLetters'];
}
else {
    // Set default values
    $clientLoggedIn = $_SESSION['clientLoggedIn'] = false;
    $adminLoggedIn = $_SESSION['adminLoggedIn'] = false;
    $loggedIn = $_SESSION['loggedIn'] = false;
    $_SESSION['Table'] = '';
    $_SESSION['ID'] = '';
    $clientInfo = "";
    $adminInfo = "";
}

