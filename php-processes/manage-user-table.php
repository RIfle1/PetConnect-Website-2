<?php
include '../php-processes/dbConnection.php';
session_start();

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

if($clientLoggedIn || !$loggedIn || !$adminLoggedIn) {
    $_SESSION['errorMsg'] = 'You do not have access to this page, if you think this is a mistake contact the web developer';
    header("Location: ../php-pages/restricted-access.php", true,303);
}

$entityAttributes = array();
$result = "";

// Different attributes depending on ID
if($_GET['ID'] === 'client') {
    $entityAttributes = array(
        "cltID",
        "cltUsername",
        "cltFirstName",
        "cltLastName",
        "cltEmail",
        "cltPhoneNumber",
        "cltIsModerator",
    );
}
elseif($_GET['ID'] === 'admin') {
    $entityAttributes = array(
        "admID",
        "admUsername",
        "admFirstName",
        "admLastName",
        "admEmail",
        "admPhoneNumber",
    );
}

if(!empty($_GET['ID'])) {
    if(!empty($_GET['searchBy'])) {
        $searchBy = $_GET['searchBy'];
    }else {
        $searchBy = '';
    }
    if(!empty($_GET['sortBy'])) {
        $sortBy = $_GET['sortBy'];
    }else {
        $sortBy = '';
    }

    if(empty($_GET['searchBy'])) {
        $sql = "SELECT * FROM ".$_GET['ID']." ORDER BY ".$sortBy;
    }
    else {
        $sql = "SELECT * FROM ".$_GET['ID']." WHERE ".$entityAttributes[0]." LIKE '%".$searchBy."%' 
    OR ".$entityAttributes[1]." LIKE '%".$searchBy."%' 
    OR ".$entityAttributes[2]." LIKE '%".$searchBy."%' 
    OR ".$entityAttributes[3]." LIKE '%".$searchBy."%'
    OR ".$entityAttributes[4]." LIKE '%".$searchBy."%'
    OR ".$entityAttributes[5]." LIKE '%".$searchBy."%' ORDER BY ".$sortBy;
    }
}else {
    $sql ='';
}

$result = runSQLResult($sql);

while($entityInfo = $result->fetch_array()) {

    $newUserInfo = array(
        $entityAttributes[0] => $entityInfo[$entityAttributes[0]],
        $entityAttributes[1] => $entityInfo[$entityAttributes[1]],
        $entityAttributes[2] => $entityInfo[$entityAttributes[2]],
        $entityAttributes[3] => $entityInfo[$entityAttributes[3]],
        $entityAttributes[4] => $entityInfo[$entityAttributes[4]],
        $entityAttributes[5] => $entityInfo[$entityAttributes[5]],
    );
    if($_GET['ID'] === 'client') {
        $newUserInfo[$entityAttributes[6]] = $entityInfo[$entityAttributes[6]];
    }

    $entityList[] = $newUserInfo;
}

header("Content-Type: application/json");
echo json_encode(['entityList' => $entityList]);
