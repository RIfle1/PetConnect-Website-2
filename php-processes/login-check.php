<?php
include_once '../php-processes/dbConnection.php';

if(!empty($_COOKIE['Token-cookie']) && !empty($_COOKIE['Table-cookie'])) {
    $IDLetters = '';

    if($_COOKIE['Table-cookie'] === "client") {
        $IDLetters = "clt";
    }
    else if($_COOKIE['Table-cookie'] === "admin") {
        $IDLetters = "adm";
    }

    $loginCheckSql = "SELECT * FROM ".$_COOKIE['Table-cookie']." WHERE ".$IDLetters."Token = '".$_COOKIE['Token-cookie']."'";
    $entityInfo = runSQLResult($loginCheckSql)->fetch_assoc();

    if( mysqli_num_rows(runSQLResult($loginCheckSql)) > 0) {
        $_SESSION['Token'] = $_COOKIE['Token-cookie'];
        $_SESSION[$_COOKIE['Table-cookie'].'LoggedIn'] = true;

        $_SESSION["ID"] = $entityInfo[$IDLetters."ID"];
        $_SESSION['Table'] = $_COOKIE['Table-cookie'];
        $_SESSION['loggedIn'] = true;
    }
}

