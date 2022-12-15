<?php
function OpenCon()
{
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $db = "app db";
    $conn = new mysqli($dbHost, $dbUser, $dbPass,$db) or die("Connect failed: %s\n". $conn -> error);

    if ($conn->connect_errno) {
        die("Connection Error: " . $conn->connect_error);
    }
    else {
        return $conn;
    }
}

function CloseCon($conn): void
{
    $conn->close();
}

function runSQLResult($query) : bool|mysqli_result
{
    $conn = OpenCon();
    $result = mysqli_query($conn, $query);
    CloseCon($conn);
    return $result;
}

function insertSQL($sql): string
{
    $mysqli = OpenCon();
    $stmt = $mysqli->stmt_init();

    if ( ! $stmt->prepare($sql)) {
        die("SQL Error: " . $mysqli->error);
    }

    if($stmt->execute()) {
        CloseCon($mysqli);
        return "Success";
    }
    else {
        return ($mysqli->error . " " . $mysqli->errno);
    }
}

function getImage($imgPath): bool|array|null
{
    $sql = "SELECT * FROM image WHERE imgPath = '".$imgPath."'";
    return runSQLResult($sql)->fetch_assoc();
}

function getPfp($AttributeID, $table, $ID): bool|array|null
{
    $sql = "SELECT * FROM ".$table." WHERE ".$AttributeID."='".$ID."'";
    return runSQLResult($sql)->fetch_assoc();
}

function findMax($intArray) : int {
    $previousNumber = 0;
    $maxNumber = 0;
    for ($i = count($intArray); $i > 0; $i--) {
        $currentNumber = $intArray[$i-1];
        $maxNumber = max($currentNumber, $previousNumber);
        $previousNumber = $maxNumber;
    }
    return $maxNumber;
}

function idToInt($id, $idFormat): string{
    // Remove left Side of String
    $idIndex = stripos($id, $idFormat, 0);
    $desiredId = substr($id, $idIndex, strlen($id)-$idIndex);

    // Check if the desiredID is located at the end of the String
    $lengthTest1 = strlen($desiredId);
    $lengthTest2 = strlen(str_replace("_", "", $desiredId));

    if ($lengthTest1 > $lengthTest2) {
        $idIndex = stripos($desiredId, "_", 0);
    }
    elseif ($lengthTest1 == $lengthTest2) {
        $idIndex = stripos($desiredId, $id, 0) + strlen($desiredId);
    }

    // Remove the right side of String
    $desiredId = substr($desiredId, 0,$idIndex);
    $desiredId = trim($desiredId, $idFormat);
    return intval($desiredId);
}

function returnLastIDInt($id, $table, $idFormat) : int {
    $idList_1 = array();
    $lastID = 0;

    $result = runSQLResult("SELECT $id FROM $table");
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            $cltIDNumberInt = idToInt($row[$id], $idFormat);
            $idList_1[] = $cltIDNumberInt;
            $lastID = findMax($idList_1);
        }
    }

    return $lastID;
}

function autoSetID($id, $table, $idFormat) : string {
    $newIDInt = returnLastIDInt($id, $table, $idFormat) + 1;
    return $idFormat.strval($newIDInt);
}

function uploadImage($inputName, $imgCategory): void
{
    $filename = $_FILES[$inputName]["name"];
    $tempname = $_FILES[$inputName]["tmp_name"];
    $folder = "../img/".$imgCategory."/".$filename;

    $sql = "INSERT INTO image (imgID, imgPath, imgCategory) 
            VALUES ('".autoSetID('imgID', 'image', 'img')."', '".$filename."', '".$imgCategory."')";

    insertSQL($sql);

    if (move_uploaded_file($tempname, $folder)) {
        echo "<script type='text/javascript'>console.log('Image Uploaded Successfully')</script>";
    } else {
        echo "<script type='text/javascript'>console.log('Failed to upload image')</script>";
    }
}

function uploadPfp($inputName, $table, $xxxPfpName): void
{
    $fileName = $_FILES[$inputName]["name"];
    $tempName = $_FILES[$inputName]["tmp_name"];
    $folder = "../img/pfp/".$fileName;

    $sql = "UPDATE ".$table." SET ".$xxxPfpName."='".$fileName."'";

    // Execute query
    insertSQL($sql);

    if (move_uploaded_file($tempName, $folder)) {
        echo "<script type='text/javascript'>console.log('Image Uploaded Successfully')</script>";
    } else {
        echo "<script type='text/javascript'>console.log('Failed to upload image')</script>";
    }
}

function returnToHomePage($redirectPage): void
{
    if (!$_SESSION['loggedIn'] && (!$_SESSION['clientLoggedIn'] || !$_SESSION['adminLoggedIn'])) {
        echo '../php-pages/login.php';
    }
    else {
        echo $redirectPage;
    }
}

function isModerator($cltID): bool {
    $sql = "SELECT cltIsModerator FROM client WHERE cltID = '".$cltID."'";
    $result = runSQLResult($sql);
    $isModerator = $result->fetch_assoc();

    if($isModerator['cltIsModerator'] == 1) {
        return true;
    }
    else {
        return false;
    }
}

function compareIdAndToken($idToCheck, $tokenInput, $table): bool {
    if($table === 'client') {
        // CHECK IF TOKEN MATCHES NEW CLIENT ID
        $checkCltTokenSql = "SELECT cltID FROM client WHERE cltToken = '".$tokenInput."'";
        $cltResult = runSQLResult($checkCltTokenSql);
        $clientInfo = $cltResult->fetch_assoc();

        // Check if current cltID is the same as the cltID found from the token
        if($idToCheck === $clientInfo['cltID']){return true;}
        else{return false;}
    }
    elseif($table === 'admin') {
        // CHECK IF TOKEN MATCHES NEW CLIENT ID
        $checkAdmTokenSql = "SELECT admID FROM admin WHERE admToken = '".$tokenInput."'";
        $admResult = runSQLResult($checkAdmTokenSql);
        $admInfo = $admResult->fetch_assoc();

        // Check if current cltID is the same as the cltID found from the token
        if($idToCheck === $admInfo['admID']){return true;}
        else{return false;}
    }
    else {
        return false;
    }
}

function compareEmailAndToken($emailToCheck, $tokenInput, $table): bool {
    if($table === 'client') {
        // CHECK IF TOKEN MATCHES NEW CLIENT ID
        $checkCltTokenSql = "SELECT cltEmail FROM client WHERE cltToken = '".$tokenInput."'";
        $cltResult = runSQLResult($checkCltTokenSql);
        $clientInfo = $cltResult->fetch_assoc();

        // Check if current cltID is the same as the cltID found from the token
        if($emailToCheck === $clientInfo['cltEmail']){return true;}
        else{return false;}
    }
    elseif($table === 'admin') {
        // CHECK IF TOKEN MATCHES NEW CLIENT ID
        $checkAdmTokenSql = "SELECT admEmail FROM admin WHERE admToken = '".$tokenInput."'";
        $admResult = runSQLResult($checkAdmTokenSql);
        $admInfo = $admResult->fetch_assoc();

        // Check if current cltID is the same as the cltID found from the token
        if($emailToCheck === $admInfo['admEmail']){return true;}
        else{return false;}
    }
    else {
        return false;
    }
}

function returnEntityInfo(): bool|array|null
{
    $clientLoggedIn = $_SESSION['clientLoggedIn'];
    $adminLoggedIn = $_SESSION['adminLoggedIn'];
    $loggedIn = $_SESSION['loggedIn'];
    $sql = "";

    if($loggedIn) {
        if($clientLoggedIn){
            $sql = "SELECT * FROM Client WHERE cltToken = '".$_SESSION["Token"]."'";
        }
        elseif($adminLoggedIn) {
            $sql = "SELECT * FROM admin WHERE admToken = '".$_SESSION["Token"]."'";
        }
        $result = runSQLResult($sql);
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function returnEntityAttributes(): array
{
    $clientLoggedIn = $_SESSION['clientLoggedIn'];
    $adminLoggedIn = $_SESSION['adminLoggedIn'];
    $loggedIn = $_SESSION['loggedIn'];

    if($loggedIn) {
        if($clientLoggedIn) {
            return array(
                "cltID",
                "cltUsername",
                "cltFirstName",
                "cltLastName",
                "cltEmail",
                "cltPhoneNumber",
                "cltPfpName",
                "cltIsModerator",
                "cltPassword",
                "cltToken"
            );
        }
        elseif($adminLoggedIn) {
            return array (
                "admID",
                "admUsername",
                "admFirstName",
                "admLastName",
                "admEmail",
                "admPhoneNumber",
                "admPfpName",
                "admPlaceHolder",
                "admPassword",
                "admToken",
            );
        }
        else {
            return array();
        }
    }
    else {
        return array();
    }
}

function adminPage (): void
{
    $clientLoggedIn = $_SESSION['clientLoggedIn'];
    $loggedIn = $_SESSION['loggedIn'];
    if ($clientLoggedIn || !$loggedIn) {
        header("Location: ../php-pages/restricted-access.php", true,303);
        exit;
    }
}

function clientPage(): void
{
    $clientLoggedIn = $_SESSION['clientLoggedIn'];
    $adminLoggedIn = $_SESSION['adminLoggedIn'];
    $loggedIn = $_SESSION['loggedIn'];
    if(!$loggedIn && (!$adminLoggedIn || !$clientLoggedIn)) {
        header("Location: ../php-pages/login.php",true,303);
    }
}