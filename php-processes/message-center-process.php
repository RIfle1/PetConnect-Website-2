<?php
session_start();
include '../php-processes/dbConnection.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

clientPage();
$entityInfo = returnEntityInfo();


if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(!empty($_GET['userInfo'])) {

        $entityInfo['ID'] = $_SESSION['ID'];

        header("Content-Type: application/json");
        echo json_encode(["entityInfo" => $entityInfo]);
    }

    if(!empty($_GET['sessionMessages'])) {

        if($_SESSION['ID'] === 'client') {
            $sessionMessages = returnSessionMessages($_SESSION['cltID']);
        }
        elseif($_SESSION['ID'] === 'admin') {
            $sessionMessages = returnAllSessionMessages();
        }

        header("Content-Type: application/json");
        echo json_encode(["sessionMessagesList" => $sessionMessages]);
    }
}


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['msgMessage'])) {
        $IDLetters = $_POST['IDLetters'];
        $ID = $_POST['ID'];
        $entityID = $_POST['entityID'];
        $msgMessage = $_POST['msgMessage'];
        $newMsgID = autoSetID($IDLetters.'Msg');
        $entityForeignKey = $ID."_".$IDLetters."ID";

        $cltID = '';

        if($ID === 'client') {
            $cltID = $entityID;
            $insertMessageInNewSessionSql = "INSERT IGNORE INTO session_message (sesMsgID, Client_cltID) VALUES ('".$cltID."', '".$cltID."')";
            runSQLResult($insertMessageInNewSessionSql);
        }
        elseif($ID === 'admin') {
            $cltID = $_POST['cltID'];
        }

        $insertNewMessageSql = "INSERT INTO ".$ID."_message (".$IDLetters."MsgID, ".$IDLetters."MsgMessage, ".$entityForeignKey.", Session_Message_sesMsgID)
                            VALUES ('".$newMsgID."','".$msgMessage."','".$entityID."', '".$cltID."')";
        runSQLResult($insertNewMessageSql);
//        echo $insertNewMessageSql;
    }
}

