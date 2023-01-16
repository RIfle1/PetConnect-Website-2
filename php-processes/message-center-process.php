<?php
session_start();
include '../php-processes/dbConnection.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

clientAndAdminPage();
$entityInfo = returnEntityInfo();


if($_SERVER['REQUEST_METHOD'] === 'GET') {
//    if(!empty($_GET['userInfo'])) {
//
//        $entityInfo['Table'] = $_SESSION['Table'];
//
//        header("Content-Type: application/json");
//        echo json_encode(["entityInfo" => $entityInfo]);
//    }

    if(!empty($_GET['sessionMessages'])) {

        if($_SESSION['Table'] === 'client') {
            $sessionMessages = returnSessionMessages($_SESSION['ID']);
        }
        elseif($_SESSION['Table'] === 'admin') {
            $sessionMessages = returnAllSessionMessages();
        }

        header("Content-Type: application/json");
        echo json_encode(["sessionMessagesList" => $sessionMessages]);
    }
}


if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(!empty($_GET['msgMessage'])) {

        $msgMessage = $_GET['msgMessage'];
        $entityID = $_GET['entityID'];
        $IDLetters = $_GET['IDLetters'];
        $Table = $_GET['Table'];

        $newMsgID = autoSetID($IDLetters.'Msg');
        $entityForeignKey = $Table."_".$IDLetters."ID";

        $cltID = '';

        if($Table === 'client') {
            $cltID = $entityID;
            $insertMessageInNewSessionSql = "INSERT IGNORE INTO session_message (sesMsgID, Client_cltID) VALUES ('".$cltID."', '".$cltID."')";
            runSQLQuery($insertMessageInNewSessionSql);
        }
        elseif($Table === 'admin') {
            $cltID = $_GET['ID'];
        }

        $insertNewMessageSql = "INSERT INTO ".$Table."_message (".$IDLetters."MsgID, ".$IDLetters."MsgMessage, ".$entityForeignKey.", Session_Message_sesMsgID)
                            VALUES ('".$newMsgID."','".$msgMessage."','".$entityID."', '".$cltID."')";

        echo $insertNewMessageSql;
        runSQLQuery($insertNewMessageSql);
//        echo $insertNewMessageSql;
    }
}

