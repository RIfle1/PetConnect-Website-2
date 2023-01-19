<?php
include '../php-processes/dbConnection.php';
session_start();

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

$commonStringsLanguagesList = returnLanguageList()[returnLanguage()]['common-strings'];
//$entityAttributes = returnEntityAttributesByTable($_GET['Table']);
//
//
//if(!empty($_GET['Table'])) {
//    if(!empty($_GET['searchBy'])) {
//        $searchBy = $_GET['searchBy'];
//    }else {
//        $searchBy = '';
//    }
//    if(!empty($_GET['sortBy'])) {
//        $sortBy = $_GET['sortBy'];
//    }else {
//        $sortBy = '';
//    }
//
//    if(empty($_GET['searchBy'])) {
//        $sql = "SELECT * FROM ".$_GET['Table']." ORDER BY ".$sortBy." ".$_GET['orderBy'];
//    }
//    else {
//        $sql = "SELECT * FROM ".$_GET['Table']."
//        WHERE ".$entityAttributes['ID']." LIKE '%".$searchBy."%'
//        OR ".$entityAttributes['Username']." LIKE '%".$searchBy."%'
//        OR ".$entityAttributes['FirstName']." LIKE '%".$searchBy."%'
//        OR ".$entityAttributes['LastName']." LIKE '%".$searchBy."%'
//        OR ".$entityAttributes['Email']." LIKE '%".$searchBy."%'
//        OR ".$entityAttributes['PhoneNumber']." LIKE '%".$searchBy."%'
//        OR ".$entityAttributes['SignupDate']." LIKE '%".$searchBy."%'
//    ORDER BY ".$sortBy." ".$_GET['orderBy'];
//    }
//}else {
//    $sql ='';
//}
//
//$result = runSQLQuery($sql);
//
//while($entityInfo = $result->fetch_array()) {
//
//    $newUserInfo = array(
//        $entityAttributes['ID'] => $entityInfo[$entityAttributes['ID']],
//        $entityAttributes['Username'] => $entityInfo[$entityAttributes['Username']],
//        $entityAttributes['FirstName'] => $entityInfo[$entityAttributes['FirstName']],
//        $entityAttributes['LastName'] => $entityInfo[$entityAttributes['LastName']],
//        $entityAttributes['Email'] => $entityInfo[$entityAttributes['Email']],
//        $entityAttributes['PhoneNumber'] => $entityInfo[$entityAttributes['PhoneNumber']],
//        $entityAttributes['SignupDate'] => $entityInfo[$entityAttributes['SignupDate']],
//    );
//    if($_GET['Table'] === 'client') {
//        $newUserInfo['cltIsModerator'] = $entityInfo['cltIsModerator'];
//    }
//
//    $entityList[] = $newUserInfo;
//}

$entityList = returnEntityList($_GET['Table'], $_GET['orderBy'], $_GET['sortBy']);

header("Content-Type: application/json");
echo json_encode(['entityList' => $entityList]);
