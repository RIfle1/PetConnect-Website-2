<?php

//include 'dbConnection.php';

function returnLoggedUser(): string {
    if(empty($_SESSION['cltID']) && empty($_SESSION['admID']) && empty($_SESSION['Token']) && empty($_SESSION['ID']) && empty($_SESSION['loggedIn'])) {
        return 'noUser';
    }
    elseif($_SESSION['ID'] === 'client' && $_SESSION['loggedIn'] === true) {
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
