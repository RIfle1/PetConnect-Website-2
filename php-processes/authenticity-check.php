<?php

//include 'dbConnection.php';

function returnLoggedUser(): string {
    if(empty($_SESSION['cltID']) && empty($_SESSION['admID']) && empty($_SESSION['Token']) && empty($_SESSION['ID']) && empty($_SESSION['loggedIn'])) {
        return 'noUser';
    }

    if(!empty($_SESSION['ID'])) {
        if($_SESSION['ID'] === 'client' && $_SESSION['loggedIn'] === true) {
            $cltToken = $_SESSION['Token'];
            $cltCheckSql = "SELECT * FROM client WHERE cltToken = '".$cltToken."'";
            $cltResult = runSQLResult($cltCheckSql);
            $clientInfo = $cltResult->fetch_assoc();

            if(!$clientInfo || !compareIdAndToken($_SESSION['cltID'], $cltToken, 'client')) {
                return 'fake client';
            } else {
                return 'client';
            }
        }
        elseif($_SESSION['ID'] === 'admin' && $_SESSION['loggedIn'] === true) {
            $admToken = $_SESSION['Token'];
            $admCheckSql = "SELECT * FROM admin WHERE admToken = '" . $admToken . "'";
            $admResult = runSQLResult($admCheckSql);
            $adminInfo = $admResult->fetch_assoc();

            if (!$adminInfo || !compareIdAndToken($_SESSION['admID'], $admToken, 'admin')) {
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

    $sql = "SELECT * FROM Client WHERE cltID = '".$_SESSION["cltID"]."'";
    $result = runSQLResult($sql);
    $clientInfo = $result->fetch_assoc();
}
elseif($user === 'admin') {
    $clientLoggedIn = $_SESSION['clientLoggedIn'] = false;
    $adminLoggedIn = $_SESSION['adminLoggedIn'] = true;
    $loggedIn = $_SESSION['loggedIn'];

    $sql = "SELECT * FROM admin WHERE admID = '".$_SESSION["admID"]."'";
    $result = runSQLResult($sql);
    $adminInfo = $result->fetch_assoc();
}
else {
    // Set default values
    $clientLoggedIn = $_SESSION['clientLoggedIn'] = false;
    $adminLoggedIn = $_SESSION['adminLoggedIn'] = false;
    $loggedIn = $_SESSION['loggedIn'] = false;
    $clientInfo = "";
    $adminInfo = "";
}

