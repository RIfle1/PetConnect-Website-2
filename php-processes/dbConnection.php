<?php

use JetBrains\PhpStorm\NoReturn;

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

function getImage($imgPath): string
{
    $sql = "SELECT * FROM image WHERE imgPath = '".$imgPath."'";
    $getImageResult = runSQLResult($sql)->fetch_assoc();

    return "../img/".$getImageResult['imgCategory']."/".$getImageResult['imgPath'];
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

function autoSetID($attributeFormat) : string {
    try {
        return $attributeFormat.bin2hex(random_bytes(16));
    } catch (Exception|\Exception $e) {
    }
}

// DEPRECATED
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

function restrictedNoUserPage($redirectPage): void
{
    if (!$_SESSION['loggedIn'] && (!$_SESSION['clientLoggedIn'] || !$_SESSION['adminLoggedIn'])) {
        echo '../php-pages/login.php';
    }
    else {
        echo $redirectPage;
    }
}

function restrictedAdminPage($redirectPage): void {
    if (!$_SESSION['loggedIn'] || $_SESSION['adminLoggedIn']) {
        $_GET['errorMsg'] = 'Please login as a client to use this page.';
        echo '../php-pages/restricted-access.php';
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
    $loggedIn = $_SESSION['loggedIn'];
    $clientLoggedIn = $_SESSION['clientLoggedIn'];
    $adminLoggedIn = $_SESSION['adminLoggedIn'];

    if($loggedIn) {
        if($clientLoggedIn) {
            $sql = "SELECT cltID, cltUsername, cltFirstName, cltLastName, cltEmail, cltPfpName, cltPhoneNumber, cltSignupDate, cltVerifiedEmail, cltIsModerator FROM client WHERE cltToken = '".$_SESSION['Token']."'";
        }
        else if($adminLoggedIn) {
            $sql = "SELECT admID, admUsername, admFirstName, admLastName, admEmail, admPfpName, admPhoneNumber, admSignupDate, admVerifiedEmail FROM admin WHERE admToken = '".$_SESSION['Token']."'";
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

    $table = $_SESSION['Table'];

    if($clientLoggedIn || $table === 'client') {
        return array(
            'ID' => "cltID",
            "Username" => "cltUsername",
            "FirstName" => "cltFirstName",
            "LastName" => "cltLastName",
            "Email" => "cltEmail",
            "PhoneNumber" => "cltPhoneNumber",
            "PfpName" => "cltPfpName",
            "Password" => "cltPassword",
            "Token" => "cltToken",
            "Table" => "client",
            "IDLetters" => 'clt',
            "IsModerator" => "cltIsModerator",
        );
    }
    elseif($adminLoggedIn|| $table === 'admin') {
        return array (
            "ID" => "admID",
            "Username" => "admUsername",
            "FirstName" => "admFirstName",
            "LastName" => "admLastName",
            "Email" => "admEmail",
            "PhoneNumber" => "admPhoneNumber",
            "PfpName" => "admPfpName",
            "Password" => "admPassword",
            "Token" => "admToken",
            "Table" => "admin",
            "IDLetters" => 'adm',
        );
    }
    else {
        return array();
    }

}

function adminPage(): void
{
    include_once "login-check.php";

    if (isset($_SESSION['clientLoggedIn']) || empty($_SESSION['loggedIn'])) {

        if($_SESSION['clientLoggedIn'] || empty($_SESSION['loggedIn'])) {

            header("Location: ../php-pages/restricted-access.php", true,303);
            exit;
        }
    }

}

function clientPage(): void
{
    include_once "login-check.php";

    if(empty($_SESSION['loggedIn'])) {
        header("Location: ../php-pages/restricted-access.php", true,303);
        exit;
    }

}

function onlyClientPage(): void {

    include_once "login-check.php";

    if (isset($_SESSION['adminLoggedIn']) || empty($_SESSION['loggedIn'])) {
        if($_SESSION['adminLoggedIn'] || empty($_SESSION['loggedIn'])) {
            header("Location: ../php-pages/restricted-access.php", true,303);
            exit;
        }
    }
}

function date_compare($a, $b): int
{
    $t1 = strtotime($a['msgDate']);
    $t2 = strtotime($b['msgDate']);
    return $t1 - $t2;
}

function returnSessionMessages($sesMsgID): array {

    $getClientMessagesSql = "SELECT sesMsgID, cltID,  cltUsername, cltMsgDate, cltMsgMessage FROM session_message
                             INNER JOIN client_message cm on session_message.sesMsgID = cm.Session_Message_sesMsgID
                             INNER JOIN client c on cm.Client_cltID = c.cltID                                       
                             WHERE sesMsgID = '".$sesMsgID."'";

    $getAdminMessagesSql = "SELECT sesMsgID, admID, admUsername, admMsgDate, admMsgMessage FROM session_message
                             INNER JOIN admin_message am on session_message.sesMsgID = am.Session_Message_sesMsgID
                             INNER JOIN admin a on am.Admin_admID = a.admID                                          
                             WHERE sesMsgID = '".$sesMsgID."'";


//    echo $getSessionMessagesSql;
    $clientMessagesResult = runSQLResult($getClientMessagesSql);
    $adminMessagesResult = runSQLResult($getAdminMessagesSql);
    $sessionMessagesList = array();


    while($clientMessages = $clientMessagesResult->fetch_assoc()) {
        // CHECK OWNERSHIP OF THE MESSAGES => IF THEY ARE CURRENT OR FOREIGN
        if($_SESSION['Table'] === 'client') {
            $messageOwnership = 'current';
        }
        else {
            $messageOwnership = 'foreign';
        }

        $sessionMessagesList[] = array(
//            'sesMsgID' => $clientMessages['sesMsgID'],
            'entityID' => $clientMessages['cltID'],
            'username' => $clientMessages['cltUsername'],
            'msgDate' => $clientMessages['cltMsgDate'],
            'msgMessage' => $clientMessages['cltMsgMessage'],
            'msgOwnership' => $messageOwnership,
        );



    }

    while($adminMessages = $adminMessagesResult->fetch_assoc()) {
        // CHECK OWNERSHIP OF THE MESSAGES => IF THEY ARE CURRENT OR FOREIGN
        if($_SESSION['Table'] === 'admin') {
            if($_SESSION['ID'] === $adminMessages['admID']) {
                $messageOwnership = 'current';
            }
            else {
                $messageOwnership = 'foreign';
            }
        }
        else {
            $messageOwnership = 'foreign';
        }

        $sessionMessagesList[] = array(
//            'sesMsgID' => $adminMessages['sesMsgID'],
            'entityID' => $adminMessages['admID'],
            'username' => $adminMessages['admUsername'],
            'msgDate' => $adminMessages['admMsgDate'],
            'msgMessage' => $adminMessages['admMsgMessage'],
            'msgOwnership' => $messageOwnership,
        );

    }

    usort($sessionMessagesList, 'date_compare');
    $allSessionMessagesList[$sesMsgID] = $sessionMessagesList;

//    $sessionMessagesList['test'] = 'test';

    return $allSessionMessagesList;
}

function returnAllSessionMessages(): array
{

    $getAllSessionMessagesIDsSql = "SELECT sesMsgID FROM session_message";
    $allSessionMessagesIDsResult = runSQLResult($getAllSessionMessagesIDsSql);
    $allSessionMessagesIDsList = array();

    if(mysqli_num_rows($allSessionMessagesIDsResult) > 0) {
        while($allSessionMessagesIDs = $allSessionMessagesIDsResult ->fetch_assoc()) {
            $allSessionMessagesIDsList[] = $allSessionMessagesIDs['sesMsgID'];
        }


        for($i = 0; $i < count($allSessionMessagesIDsList); $i++) {
            $sesMsgID = $allSessionMessagesIDsList[$i];
            $allSessionMessagesList[$sesMsgID] = returnSessionMessages($sesMsgID)[$sesMsgID];
        }
    }


    return $allSessionMessagesList;
}

function generateID($idLength): string
{
    try {
        return bin2hex(random_bytes($idLength));
    } catch (Exception $e) {
    }
}

function logoutAndRedirect($page): void
{
    session_start();
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
        include_once '../php-processes/php-mailer.php';
        // CHANGE TOKEN WHEN LOGGING OUT
        if(isset($_SESSION['Table']) && isset($_SESSION['Token'])) {
            $entityAttributes = returnEntityAttributes();
            $token = generateToken($_SESSION["ID"]);
            echo $token;

            $insertTokenSql = "UPDATE ".$_SESSION['Table']." SET ".$entityAttributes['Token']." = '".$token."' WHERE ".$entityAttributes['Token']." = '".$_SESSION['Token']."'";

            runSQLResult($insertTokenSql);

            setcookie("Token-cookie", "", time() + (86400 * 30), "/");
            setcookie("Table-cookie", "", time() + (86400 * 30), "/");
        }
        session_destroy();

        header('Location: '.$page, true, 303);
        exit;
    }
    session_destroy();

}

function returnList($runSQLResult): array {
    $list = array();

    while($listRow = $runSQLResult->fetch_assoc()) {
        $list[] = $listRow;
    }

    return $list;
}

function returnAddressList(): array {
    $token = $_SESSION['Token'];
    $getAddressListSql = "SELECT adrID, adrAddress, adrAddressOptional, adrPostalCode, adrCity, adrDefault FROM address 
                          INNER JOIN client c on address.Client_cltID = c.cltID
                          WHERE cltToken = '".$token."'";

    return returnList(runSQLResult($getAddressListSql));
}

function returnAddressInfo($adrID) : array {
    $getAddressInfoSql = "SELECT adrID, adrAddress, adrAddressOptional, adrPostalCode, adrCity, adrDefault FROM address 
                          WHERE adrID = '".$adrID."'";

    return returnList(runSQLResult($getAddressInfoSql));
}

function countBasket(): string
{
    $cltID = $_SESSION["ID"];
    $result = runSQLResult('SELECT * FROM Basket WHERE Client_cltID = "' .   $cltID  . '"');
    $result = mysqli_num_rows($result);
    return $result;
}

// Couleur > 0 dans le panier
function getColorProduct(): array
{
    $cltID = $_SESSION["ID"];
    $result = runSQLResult('SELECT * FROM Basket INNER JOIN Product_List ON (Basket.basID = Product_List.Basket_basID) INNER JOIN Product ON (Product_List.Product_prdID = Product.prdID) WHERE Client_cltID = "' .   $cltID  . '"');


    $couleurs = array();
    $blanc = $bleu = $rose = $jaune = $vert = $noir = 0;
    while ($color = $result->fetch_assoc()) {


        if ($color["prdColour"] == "blanc") {
            $blanc += 1;
            $couleurs['blanc'] = $blanc;
        } elseif ($color["prdColour"] == "bleu") {
            $bleu += 1;
            $couleurs['bleu'] = $bleu;
        } elseif ($color["prdColour"] == "jaune") {
            $jaune += 1;
            $couleurs['jaune'] = $jaune;
        } elseif ($color["prdColour"] == "Rose") {
            $rose += 1;
            $couleurs['Rose'] = $rose;
        } elseif ($color["prdColour"] == "vert") {
            $vert += 1;
            $couleurs['vert'] = $vert;
        } else {
            $noir += 1;
            $couleurs['noir'] = $noir;
        }
    }
    $nProduct = $couleurs;
    return  $nProduct;
}

function returnLanguage(): string {
    if(empty($_COOKIE['language-cookie'])) {
        return 'English';
    }
    else {
        return $_COOKIE['language-cookie'];
    }
}

function countBasket(): string
{
    $cltID = $_SESSION["ID"];
    $result = runSQLResult('SELECT * FROM Basket WHERE Client_cltID = "' .   $cltID  . '"');
    $result = mysqli_num_rows($result);
    return $result;
}

// Couleur > 0 dans le panier
function getColorProduct(): array
{
    $cltID = $_SESSION["ID"];
    $result = runSQLResult('SELECT * FROM Basket INNER JOIN Product_List ON (Basket.basID = Product_List.Basket_basID) INNER JOIN Product ON (Product_List.Product_prdID = Product.prdID) WHERE Client_cltID = "' .   $cltID  . '"');


    $couleurs = array();
    $blanc = $bleu = $rose = $jaune = $vert = $noir = 0;
    while ($color = $result->fetch_assoc()) {


        if ($color["prdColour"] == "blanc") {
            $blanc += 1;
            $couleurs['blanc'] = $blanc;
        } elseif ($color["prdColour"] == "bleu") {
            $bleu += 1;
            $couleurs['bleu'] = $bleu;
        } elseif ($color["prdColour"] == "jaune") {
            $jaune += 1;
            $couleurs['jaune'] = $jaune;
        } elseif ($color["prdColour"] == "Rose") {
            $rose += 1;
            $couleurs['Rose'] = $rose;
        } elseif ($color["prdColour"] == "vert") {
            $vert += 1;
            $couleurs['vert'] = $vert;
        } else {
            $noir += 1;
            $couleurs['noir'] = $noir;
        }
    }
    $nProduct = $couleurs;
    return  $nProduct;
}

function returnLanguageList(): array
{
    return array(
        "English" => array(
            // PHP PAGES
            "address" => array(
                "Addresses" => "Addresses",
                "Add an address" => "Add an address",
            ),
            "address-add" => array(
                "Add a new address" => "Add a new address",
                "Modify Address" => "Modify Address",
                "Add new address" => "Add new address",
                "Street address or P.O. Box" => "Street address or P.O. Box",
                "Apt, suit, unit, building, floor, etc." => "Apt, suit, unit, building, floor, etc.",
                "Address" =>"Address",
                "Postal Code" =>"Postal Code",
                "City" =>"City",

                "Submit Changes" => "Submit Changes",
            ),
            "assistance" => array(),
            "connection-security" => array(
                "Connection and Security" => "Connection and Security",
                "Username :" => "Username :",
                "First Name :" => "First Name :",
                "Last Name :" => "Last Name :",
                "Phone Number :" => "Phone Number :",
                "Email :" => "Email :",
                "Password :" => "Password :",
                "Old Password :" => "Old Password :",
                "Repeat New Password :" => "Repeat New Password :",

                "A verification code has been sent to your new email address." =>
                    "A verification code has been sent to your new email address.",
                "Input the confirmation code :" =>
                    "Input the confirmation code :",

                "Done" => "Done",
                "Cancel" => "Cancel",
                "Edit" => "Edit",
            ),
            "home" => array(
                "Technology for your animals" => "Technology for your animals",
            ),
            "login" => array(
                "Sign in" => "Sign in",
                "Email" => "Email",
                "Password" => "Password",
                "Login" => "Login",
                "Invalid Login" => "Invalid Login",
                "Forgot Password" => "Forgot Password",
                "Don't have an account?" => "Don't have an account?",
                "Signup" => "Signup",
            ),
            "manage-user" => array(
                "Manage Clients" => "Manage Clients",
                "Manage Administrators" => "Manage Administrators",
                "Filter By" => "Filter By",
                "Ascending" => "Ascending",
                "Descending" => "Descending",
                "Submit Search" => "Submit Search",
                "Delete User" => "Delete User",
                "Promote User" => "Promote User",
                "Submit Changes" => "Submit Changes",

                "Client Username" => "Client Username",
                "Client Email" => "Client Email",
                "Client Signup Date" => "Client Signup Date",
                "Client Control Panel" => "Client Control Panel",
                "Search in client..." => "Search in client...",

                "Admin Username" => "Admin Username",
                "Admin Email" => "Admin Email",
                "Admin Signup Date" => "Admin Signup Date",
                "Admin Control Panel" => "Admin Control Panel",
                "Search in admin..." => "Search in admin...",

            ),
            "message-center" => array(
                "Active Messages" => "Active Messages",
                "No Active Messages" => "No Active Messages",
                "Type a message..." => "Type a message...",

                "Hide Active Messages" => "Hide Active Messages",
                "Show Active Messages" => "Show Active Messages",
                "Mark As Resolved" => "Mark As Resolved",

                "Resolved Messages" => "Resolved Messages",
                "No Resolved Messages" => "No Resolved Messages",
                "Show Resolved Messaged" => "Show Resolved Messaged",
                "Hide Resolved Messages" => "Hide Resolved Messages",
                "Manage Resolved Messages" => "Manage Resolved Messages",
                "Delete Resolved Messages By" => "Delete Resolved Messages By",
                "Resolved Start Date" => "Resolved Start Date",
                "Resolved End Date" => "Resolved End Date",
                "Between" => "Between",
                "Before" => "Before",
                "After" => "After",
                "Select Start Date:" => "Select Start Date:",
                "Select End Date:" => "Select End Date:",
                "Delete Selected Messages" => "Delete Selected Messages",

                "Control Panel" => "Control Panel",
                "Delete Current Conversation" => "Delete Current Conversation",

            ),
            "password-recovery-input" => array(
                "Password Recovery" => "Password Recovery",
                "Email:" => "Email:",
                "Send Verification Link" => "Send Verification Link",
            ),
            "password-recovery-output" => array(
                "Password Recovery" => "Password Recovery",
                "Sign in" => "Sign in",
            ),
            "password-reset" => array(
                "Reset your password" => "Reset your password",
                "New Password:" => "New Password:",
                "Enter your new password again:" => "Enter your new password again:",
                "Your new password has to be different from your old password." =>
                    "Your new password has to be different from your old password.",
                "Change Password" => "Change Password",
                "The Link you are using to reset your password has expired or has already been used" =>
                "The Link you are using to reset your password has expired or has already been used",
                "We don't know what you want to reset." =>
                    "We don't know what you want to reset.",
            ),
            "password-reset-success" => array(
                "Reset your password" => "Reset your password",
                "Your account password has been successfully changed." => "Your account password has been successfully changed.",
                "Your account password could not be changed." => "Your account password could not be changed.",
                "You can now" => "You can now",
                "login" => "login",
            ),
            "profile" => array(
                "Select Image" => "Select Image",
                "Upload Image" => "Upload Image",
                "Your account" => "Your account",
                "Devices" => "Devices",
                "Order History" => "Order History",
                "Payment Method" => "Payment Method",
                "Addresses" => "Addresses",
                "Manage Users" => "Manage Users",
                "Answer Questions" => "Answer Questions",
                "Connection And Security" => "Connection And Security",
                "Message Center" => "Message Center",
                "Manage Data" => "Manage Data",
            ),
            "restricted-access" => array(
                "An Error has occurred" => "An Error has occurred",
                "Try to" => "Try to",
                "login" => "login",
            ),
            "signup" => array(
                "Create an account" => "Create an account",
                "Username:" => "Username:" ,
                "First Name:" => "First Name:",
                "Last Name:" => "Last Name:",
                "Email:" => "Email:",
                "Phone Number:" => "Phone Number:",
                "Password:" => "Password:",
                "Enter your password again:" => "Enter your password again:",

                "Create an Account" => "Create an Account",
                "By creating an account, you agree to PetConnect's" => "By creating an account, you agree to PetConnect's",
                "Conditions of Use" => "Conditions of Use",
                "and" => "and",
                "Privacy Notice" => "Privacy Notice",
                "Already have an account?" => "Already have an account?",
                "Sign in" => "Sign in",

            ),
            "signup-success" => array(
                "Validate your email" => "Validate your email",
                "Verification Code:" => "Verification Code:",
                "The verification code is incorrect." => "The verification code is incorrect.",
                "Validate Email" => "Validate Email",
                "Your email has been validated. You can now" => "Your email has been validated. You can now",
                "Login" => "Login",
            ),
            "site-footer" => array(

                "GIFT CARDS" => "GIFT CARDS",
                "FIND A STORE" => "FIND A STORE",
                "PetConnect Journal" => "PetConnect Journal",
                "BECOME A MEMBER" => "BECOME A MEMBER",
                "STUDENT DISCOUNT" => "STUDENT DISCOUNT",
                "COMMENTS" => "COMMENTS",
                "PROMO CODES" => "PROMO CODES",

                "HELP" => "HELP",
                "Order Status" => "Order Status",
                "Shipping and deliveries" => "Shipping and deliveries",
                "Returns" => "Returns",
                "Payment methods" => "Payment methods",
                "Contact us" => "Contact us",
                "Help - Promo codes" => "Help - Promo codes",

                "ABOUT US" => "ABOUT US",
                "News" => "News",
                "Careers" => "Careers",
                "Investors" => "Investors",
                "Sustainable development" => "Sustainable development",
                "Mobile app" => "Mobile app",
                "Informative quiz" => "Informative quiz",

                "Guides" => "Guides",
                "Terms of Use" => "Terms of Use",
                "General conditions of sale" => "General conditions of sale",
                "Legal notices" => "Legal notices",

                "Paris, France" => "Paris, France",

                "© 2022 PetConnect, Inc. All rights reserved" => "© 2022 PetConnect, Inc. All rights reserved",
                "Privacy and Cookies Policy" => "Privacy and Cookies Policy",
                "Cookie settings" => "Cookie settings",

            ),
            "site-header" => array(
                "Sign in" => "Sign in",
                "Signup." => "Signup.",
                "New Client?" => "New Client?",

                "Home Page" => "Home Page",
                "Shop" => "Shop",
                "Assistance" => "Assistance",
                "Hello" => "Hello",
                "My Account" => "My Account",
                "My Orders" => "My Orders",
                "My Devices" => "My Devices",
                "Logout" => "Logout",
            ),
                        "order-history" => array(
                "Account" => "Account",
                "Order History" => "Order History",
                "Purchase date" => "Purchase date",
                "Color" => "Color",
                "Price" => "Price",
                "Status: <strong>In transit</strong> " => "Status: <strong>In transit</strong>",
            ),
            "shop" => array(
                "Connected dog collar" => "Connected dog collar",
                "Color" => "Color",
                "In stock" => "In stock",
                "Yellow" => "Yellow",
                "Green" => "Green",
                "Pink" => "Pink",
                "Blue" =>  "Blue",
                "Black" => "Black",
                "White" => "White",
                "Add to cart" => "Add to cart",
                "Buy now" => "Buy now",
                "GPS localisation" => "GPS localisation",
                "Heart rate sensor" => "Heart rate sensor",
                "Thermal sensor" => "Thermal sensor",
                "Sound sensor" => "Sound sensor",
                "CO2 concentration" => "CO2 concentration",
            ),
            "payment-method" => array(
                "Account" => "Account",
                "Payment method" => "Payment method",
                "Add payment method" => "Add payment method",
                "Bank card" => "Bank card",
            ),
            "devices" => array(
                "Account" => "Account",
                "My devices" => "My devices",
                "Success " => "Success ",
                "Device added" => "Device added",
                "Error " => "Error ",
                "Device already associated" => "Device already associated",
                "Wrong number" => "Wrong number",
                "Deleted device" => "Deleted device",
                "Good" => "Good",
                "See more" => "See more",
                "delete" => "delete",
                "Collar number" => "Collar number",
                "Add" => "Add",
            ),
            "info-device" => array(
                "Account" => "Account",
                "My devices" => "My devices",
                "Device information" =>  "Device information",
                "Good" => "Good",
                "Day" => "Day",
                "Week" => "Week",
                "Month" => "Month",
                "Add" => "Add",

            ),

            // PHP PROCESSES
            "dbConnection" => array(
                "Please login as a client to use this page." =>
                    "Please login as a client to use this page.",
            ),
            "login-process" => array(
                "Your account has been created but your email is still not validated. 
                A code has been sent to your email to validate your account" =>
                    "Your account has been created but your email is still not validated. 
                A code has been sent to your email to validate your account",
                "A validation code could not be sent to your email, please contact a web developer" =>
                    "A validation code could not be sent to your email, please contact a web developer",

            ),
            "password-recovery-process" => array(
                "We got a request from you to reset your Password!." =>
                    "We got a request from you to reset your Password!.",
                "Please click this link to reset your password" =>
                    "Please click this link to reset your password",
                "Password Reset" => "Password Reset",
                "A recovery link has been sent to" => "A recovery link has been sent to",
                "please follow the link to reset your password." =>
                    "please follow the link to reset your password.",
                "The recovery link could not be sent to" =>
                    "The recovery link could not be sent to",
                "Contact a web developer if you think this is a mistake." =>
                    "Contact a web developer if you think this is a mistake.",
            ),
            "php-mailer" => array(
                "Verification code is:" => "Verification code is:",
                "Email Verification" => "Email Verification",
            ),
            "signup-email-validation" => array(
                "The new Client ID does not match the cltID fetched with the token. Review signup-email-validation" =>
                    "The new Client ID does not match the cltID fetched with the token. Review signup-email-validation"
            ),
            "signup-process" => array(
                "Signup Successful, Please verify your email address" =>
                    "Signup Successful, Please verify your email address",
            ),

            "common-strings" => array(
                "You do not have access to this page, if you think this is a mistake contact the web developer" =>
                    "You do not have access to this page, if you think this is a mistake contact the web developer",
                "Please verify that you are not a robot." =>
                    "Please verify that you are not a robot.",
            ),

            // JAVASCRIPT
            "address-buttons" => array(
                "Default address" => "Default address",
                "Modify" => "Modify",
                "Delete" => "Delete",
                "Set as default" => "Set as default",
            ),
            "connection-security-buttons" => array(
                "New" => "New",

                "Edit" => "Edit",
                "Confirm" => "Confirm",
                "Confirm Code" => "Confirm Code",
            ),
            "manage-user-buttons" => array(
                "Promote User" => "Promote User",
                "Promoted" => "Promoted",
                "Delete User" => "Delete User",
                "Submit Changes" => "Submit Changes",
            ),
            "message-center-buttons" => array(
                "Message Owner:" => "Message Owner:",
                "Start Date:" => "Start Date:",
                "End Date:" => "End Date:",

                "Hide Active Messages" => "Hide Active Messages",
                "Show Active Messages" => "Show Active Messages",

                "Show Resolved Messages" => "Show Resolved Messages",
                "Hide Resolved Messages" => "Hide Resolved Messages",

                "Select Start Date:" => "Select Start Date:",
                "Select Date:" => "Select Date:",

                "Resolved messages before" => "Resolved messages before",
                "Resolved messages after" => "Resolved messages after",
                "Resolved messages between" => "Resolved messages between",
                "and" => "and",
                "have been deleted." => "have been deleted.",
                "Please input a Date." => "Please input a Date.",
                "Please input a Start Date and an End Date." => "Please input a Start Date and an End Date.",


            ),
            "password-reset-validation" => array(
                "New Password is required" => "New Password is required",
                "Passwords should match" => "Passwords should match",
            ),
            "validation-functions" => array(
                "Client Username is required" => "Client Username is required",
                "Client Username must be at least 3 characters" => "Client Username must be at least 3 characters",
                "Client First Name is required" => "Client First Name is required",
                "Client First Name must be at least 3 characters" => "Client First Name must be at least 3 characters",
                "Client Last Name is required" => "Client Last Name is required",
                "Client Last Name must be at least 3 characters" => "Client Last Name must be at least 3 characters",
                "Email is required" => "Email is required",
                "Must be an email" => "Must be an email",
                "Email is already Taken" => "Email is already Taken",
                "Client Phone Number must be a number" => "Client Phone Number must be a number",
                "Phone number must be 10 characters long" => "Phone number must be 10 characters long",
                "Password is required" => "Client Password is required",

                "Password must be at least 8 characters" => "Password must be at least 8 characters",
                "Password must contain at least one letter" => "Password must contain at least one letter",
                "Password must contain at least one number" => "Password must contain at least one number",

                "Passwords should match" => "Passwords should match",
                "Your new password must be different from your old password." => "Your new password must be different from your old password.",
                "Your old password is incorrect." => "Your old password is incorrect.",
                "The Confirmation Code is Incorrect." => "The Confirmation Code is Incorrect.",

                "Address is Required" => "Address is Required",
                "Postal Code is Required" => "Postal Code is Required",
                "City is Required" => "City is Required",

            ),

        ),
        "French" => array(
            // PHP PAGES
            "address" => array(
                "Addresses" => "Adresses",
                "Add an address" => "Ajouter une adresse",
            ),
            "address-add" => array(
                "Add a new address" => "Ajouter une nouvelle adresse",
                "Modify Address" => "Modifier l'adresse",
                "Add new address" => "Ajouter l'adresse",
                "Street address or P.O. Box" => "Adresse de rue ou boîte postale",
                "Apt, suit, unit, building, floor, etc." => "Appartement, suite, unité, bâtiment, étage, etc.",
                "Address" =>"Adresse",
                "Postal Code" =>"Code postal",
                "City" =>"Ville",
                "Submit Changes" => "Soumettre les modifications",
            ),
            "assistance" => array(),
            "connection-security" => array(
                "Connection and Security" => "Connexion et sécurité",
                "Username :" => "Nom d'utilisateur :",
                "First Name :" => "Prénom :",
                "Last Name :" => "Nom de famille :",
                "Phone Number :" => "Numéro de téléphone :",
                "Email :" => "Email :",
                "Password :" => "Mot de passe :",
                "Old Password :" => "Ancien mot de passe :",
                "Repeat New Password :" => "Répéter le nouveau mot de passe :",

                "A verification code has been sent to your new email address." =>
                    "Un code de vérification a été envoyé à votre nouvelle adresse email.",
                "Input the confirmation code :" =>
                    "Entrez le code de confirmation :",

                "Done" => "Terminé",
                "Cancel" => "Annuler",
                "Edit" => "Modifier",
            ),
            "home" => array(
                "Technology for your animals" => "Technologie pour vos animaux",
            ),
            "login" => array(
                "Sign in" => "Identifiez-vous",
                "Email" => "Email",
                "Password" => "Mot de passe",
                "Login" => "Connexion",
                "Invalid Login" => "Identifiants non valides",
                "Forgot Password" => "Mot de passe oublié",
                "Don't have an account?" => "Vous n'avez pas de compte?",
                "Signup" => "S'inscrire",
            ),
            "manage-user" => array(
                "Manage Clients" => "Gérer les clients",
                "Manage Administrators" => "Gérer les administrateurs",
                "Filter By" => "Filtrer par",
                "Ascending" => "Croissant",
                "Descending" => "Décroissant",
                "Submit Search" => "Envoyer la recherche",
                "Delete User" => "Supprimer l'utilisateur",
                "Promote User" => "Promouvoir l'utilisateur",
                "Submit Changes" => "Envoyer les modifications",

                "Client Username" => "Nom d'utilisateur du client",
                "Client Email" => "Email du client",
                "Client Signup Date" => "Date d'inscription du client",
                "Client Control Panel" => "Panneau de contrôle du client",
                "Search in client..." => "Rechercher dans le client...",

                "Admin Username" => "Nom d'utilisateur de l'admin",
                "Admin Email" => "Email de l'admin",
                "Admin Signup Date" => "Date d'inscription de l'admin",
                "Admin Control Panel" => "Panneau de contrôle de l'admin",
                "Search in admin..." => "Rechercher dans l'admin...",

        ),
            "message-center" => array(
                "Active Messages" => "Messages actifs",
                "No Active Messages" => "Aucun message actif",
                "Type a message..." => "Tapez un message...",

                "Hide Active Messages" => "Masquer les messages actifs",
                "Show Active Messages" => "Afficher les messages actifs",
                "Mark As Resolved" => "Marquer comme résolu",

                "Resolved Messages" => "Messages résolus",
                "No Resolved Messages" => "Aucun message résolu",
                "Show Resolved Messaged" => "Afficher les messages résolus",
                "Hide Resolved Messages" => "Masquer les messages résolus",
                "Manage Resolved Messages" => "Gérer les messages résolus",
                "Delete Resolved Messages By" => "Supprimer les messages résolus par",
                "Resolved Start Date" => "Date de début de résolution",
                "Resolved End Date" => "Date de fin de résolution",
                "Between" => "Entre",
                "Before" => "Avant",
                "After" => "Après",
                "Select Start Date:" => "Sélectionner la date de début:",
                "Select End Date:" => "Sélectionner la date de fin:",
                "Delete Selected Messages" => "Supprimer les messages sélectionnés",

                "Control Panel" => "Panneau de contrôle",
                "Delete Current Conversation" => "Supprimer la conversation actuelle",

        ),
            "password-recovery-input" => array(
                "Password Recovery" => "Récupération de mot de passe",
                "Email:" => "Email:",
                "Send Verification Link" => "Envoyer le lien de vérification",
            ),
            "password-recovery-output" => array(
                "Password Recovery" => "Récupération de mot de passe",
                "Sign in" => "Identifiez-vous",
            ),
            "password-reset" => array(
                "Reset your password" => "Réinitialiser votre mot de passe",
                "New Password:" => "Nouveau mot de passe:",
                "Enter your new password again:" => "Entrez à nouveau votre nouveau mot de passe:",
                "Your new password has to be different from your old password." =>
                    "Votre nouveau mot de passe doit être différent de votre ancien mot de passe.",
                "Change Password" => "Changer de mot de passe",
                "The Link you are using to reset your password has expired or has already been used" =>
                    "Le lien que vous utilisez pour réinitialiser votre mot de passe a expiré ou a déjà été utilisé",
                "We don't know what you want to reset." =>
                    "Nous ne savons pas ce que vous souhaitez réinitialiser.",
            ),
            "password-reset-success" => array(
                "Reset your password" => "Réinitialiser votre mot de passe",
                "Your account password has been successfully changed." => "Votre mot de passe a été modifié avec succès.",
                "Your account password could not be changed." => "Votre mot de passe de compte n'a pas pu être modifié.",
                "You can now" => "Vous pouvez maintenant",
                "login" => "vous-identifiez",
            ),
            "profile" => array(
                "Select Image" => "Sélectionner une image",
                "Upload Image" => "Télécharger une image",
                "Your account" => "Votre compte",
                "Devices" => "Appareils",
                "Order History" => "Historique des commandes",
                "Payment Method" => "Moyen de paiement",
                "Addresses" => "Adresses",
                "Manage Users" => "Gérer les utilisateurs",
                "Answer Questions" => "Répondre aux questions",
                "Connection And Security" => "Connexion et sécurité",
                "Message Center" => "Centre de messagerie",
                "Manage Data" => "Gérer les données",
            ),
            "restricted-access" => array(
                "An Error has occurred" => "Une erreur s'est produite",
                "Try to" => "Essayez de",
                "login" => "vous-identifiez",
            ),
            "signup" => array(
                "Create an account" => "Créer un compte",
                "Username:" => "Nom d'utilisateur:" ,
                "First Name:" => "Prénom:",
                "Last Name:" => "Nom de famille:",
                "Email:" => "Adresse électronique:",
                "Phone Number:" => "Numéro de téléphone:",
                "Password:" => "Mot de passe:",
                "Enter your password again:" => "Entrez à nouveau votre mot de passe:",
                "Create an Account" => "Créer un compte",
                "By creating an account, you agree to PetConnect's" => "En créant un compte, vous acceptez les Conditions d'utilisation de PetConnect",
                "Conditions of Use" => "et la politique de confidentialité",
                "and" => "et",
                "Privacy Notice" => "Avis de confidentialité",
                "Already have an account?" => "Vous avez déjà un compte?",
                "Sign in" => "Identifiez-vous",

                "Client Username is required" => "Le nom d'utilisateur du client est requis",
                "Client Username must be at least 3 characters" => "Le nom d'utilisateur du client doit comporter au moins 3 caractères",
                "Client First Name is required" => "Le prénom du client est requis",
                "Client First Name must be at least 3 characters" => "Le prénom du client doit comporter au moins 3 caractères",
                "Client Last Name is required" => "Le nom de famille du client est requis",
                "Client Last Name must be at least 3 characters" => "Le nom de famille du client doit comporter au moins 3 caractères",
                "Email is required" => "L'adresse électronique du client est requise",
                "Must be an email" => "Doit être une adresse électronique valide",
                "Email is already Taken" => "L'adresse électronique est déjà utilisée",
                "Client Phone Number must be a number" => "Le numéro de téléphone du client doit être un nombre",
                "Client Password is required" => "Le mot de passe du client est requis",
                "Passwords should match" => "Les mots de passe doivent correspondre",
            ),
            "signup-success" => array(
                "Validate your email" => "Validez votre adresse électronique",
                "Verification Code:" => "Code de vérification:",
                "The verification code is incorrect." => "Le code de vérification est incorrect.",
                "Validate Email" => "Valider l'adresse électronique",
                "Your email has been validated. You can now" => "Votre email a été validé, vous pouvez maintenant vous",
                "Login" => "connecter"
            ),
            "site-footer" => array(
                "GIFT CARDS" => "CARTES CADEAUX",
                "FIND A STORE" => "TROUVER UN MAGASIN",
                "PetConnect Journal" => "Journal PetConnect",
                "BECOME A MEMBER" => "DEVENIR MEMBRE",
                "STUDENT DISCOUNT" => "REMISE ÉTUDIANTE",
                "COMMENTS" => "COMMENTAIRES",
                "PROMO CODES" => "CODES PROMOTIONNELS",
                "HELP" => "AIDE",
                "Order Status" => "État de la commande",
                "Shipping and deliveries" => "Expédition et livraisons",
                "Returns" => "Retours",
                "Payment methods" => "Modes de paiement",
                "Contact us" => "Nous contacter",
                "Help - Promo codes" => "Aide - Codes promotionnels",
                "ABOUT US" => "À PROPOS DE NOUS",
                "News" => "Actualités",
                "Careers" => "Carrières",
                "Investors" => "Investisseurs",
                "Sustainable development" => "Développement durable",
                "Mobile app" => "Application mobile",
                "Informative quiz" => "Quiz informatif",
                "Guides" => "Guides",
                "Terms of Use" => "Conditions d'utilisation",
                "General conditions of sale" => "Conditions générales de vente",
                "Legal notices" => "Mentions légales",
                "Paris, France" => "Paris, France",
                "© 2022 PetConnect, Inc. All rights reserved" => "© 2022 PetConnect, Inc. Tous droits réservés",
                "Privacy and Cookies Policy" => "Politique de confidentialité et de cookies",
                "Cookie settings" => "Paramètres de cookies",
            ),
            "site-header" => array(
                "Sign in" => "Identifiez-vous",
                "Signup." => "S'inscrire.",
                "New Client?" => "Nouveau client?",
                "Home Page" => "Page d'accueil",
                "Shop" => "Boutique",
                "Assistance" => "Assistance",
                "Hello" => "Bonjour",
                "My Account" => "Mon compte",
                "My Orders" => "Mes commandes",
                "My Devices" => "Mes appareils",
                "Logout" => "Déconnexion",
            ),
            "order-history" => array(
                "Account" => "Compte",
                "Order History" => "Historique de Commandes",
                "Purchase date" => "Date d'achat",
                "Color" => "Couleur",
                "Price" => "Prix",
                "Status: <strong>In transit</strong> " => "Statut: <strong>En cours de livraison</strong>",
            ),
            "shop" => array(
                "Connected dog collar" => "Collier connecté pour chien",
                "Color" => "Couleur",
                "In stock" => "En stock",
                "Yellow" => "Jaune",
                "Green" => "Vert",
                "Pink" => "Rose",
                "Blue" => "Bleu",
                "Black" => "Noir",
                "White" => "Blanc",
                "Add to cart" => "Ajouter au panier",
                "Buy now" => "Acheter maintenant",
                "GPS localisation" => "Localisation GPS",
                "Heart rate sensor" => "Capteur cardiaque",
                "Thermal sensor" => "Capteur thermique",
                "Sound sensor" => "Capteur sonore",
                "CO2 concentration" => "Taux de CO2",
            ),
            "payment-method" => array(
                "Account" => "Compte",
                "My devices" => "Mes appareils",
                "Add payment method" => "Enregistrer un mode de paiement",
                "Bank card" => "Carte Bancaire",
            ),
            "devices" => array(
                "Account" => "Compte",
                "My devices" => "Mes appareils",
                "Success " => "Succès ",
                "Device added" => "Appareil ajouté",
                "Error " => "Erreur ",
                "Deleted device" => "Appareil supprimé",
                "Device already associated" => "Appareil déjà associé",
                "Wrong number" => "Numéro incorrect",
                "Good" => "Bon",
                "See more" => "Plus d'informations",
                "delete" => "supprimer",
                "Collar number" => "Numéro du collier",
                "Add" => "Ajouter",

            ),
            "info-device" => array(
                "Account" => "Compte",
                "My devices" => "Mes appareils",
                "Device information" => "Information appareil",
                "Good" => "Bon",
                "Day" => "Jour",
                "Week" => "Semaine",
                "Month" => "Mois",
                "Add" => "Ajouter",

            ),


            // PHP PROCESSES
            "dbConnection" => array(
                "Please login as a client to use this page." =>
                    "Veuillez vous connecter en tant que client pour utiliser cette page.",
            ),
            "login-process" => array(
                "Your account has been created but your email is still not validated.
                 A code has been sent to your email to validate your account" =>
                    "Votre compte a été créé mais votre adresse électronique n'a pas encore été validée.
                Un code a été envoyé à votre adresse électronique pour valider votre compte",
                "A validation code could not be sent to your email, please contact a web developer" =>
                    "Impossible d'envoyer un code de validation à votre adresse électronique, veuillez contacter un développeur web",
            ),
            "password-recovery-process" => array(
                "We got a request from you to reset your Password!." =>
                    "Nous avons reçu une demande de votre part de réinitialiser votre mot de passe!",
                "Please click this link to reset your password" =>
                    "Veuillez cliquer sur ce lien pour réinitialiser votre mot de passe",
                "Password Reset" => "Réinitialisation du mot de passe",
                "A recovery link has been sent to" => "Un lien de récupération a été envoyé à",
                "please follow the link to reset your password." =>
                    "veuillez suivre le lien pour réinitialiser votre mot de passe.",
                "The recovery link could not be sent to" =>
                    "Impossible d'envoyer le lien de récupération à",
                "Contact a web developer if you think this is a mistake." =>
                    "Contactez un développeur web si vous pensez qu'il s'agit d'une erreur.",
            ),
            "php-mailer" => array(
                "Verification code is:" => "Le code de vérification est :",
                "Email Verification" => "Vérification de l'adresse électronique",
            ),
            "signup-email-validation" => array(
                "The new Client ID does not match the cltID fetched with the token. Review signup-email-validation" =>
                    "L'ID de nouveau client ne correspond pas à l'ID de client récupéré avec le jeton. Vérifiez signup-email-validation",
            ),
            "signup-process" => array(
                "Signup Successful, Please verify your email address" =>
                    "Inscription réussie, veuillez vérifier votre adresse électronique",
            ),

            "common-strings" => array(
                "You do not have access to this page, if you think this is a mistake contact the web developer" =>
                    "Vous n'avez pas accès à cette page, si vous pensez qu'il s'agit d'une erreur, contactez le développeur web",
                "Please verify that you are not a robot." =>
                    "Veuillez vérifier que vous n'êtes pas un robot.",
            ),

            // JAVASCRIPT
            "address-buttons" => array(
                "Default address" => "Adresse par défaut",
                "Modify" => "Modifier",
                "Delete" => "Supprimer",
                "Set as default" => "Définir par défaut",
            ),
            "connection-security-buttons" => array(
                "New" => "Nouveau",
                "Edit" => "Modifier",
                "Confirm" => "Confirmer",
                "Confirm Code" => "Confirmer le code",

                "Username must be at least 3 characters long" =>
                    "Le nom d'utilisateur doit comporter au moins 3 caractères",
                "First Name must be at least 3 characters long" =>
                    "Le prénom doit comporter au moins 3 caractères",
                "Last Name must be at least 3 characters long" =>
                    "Le nom de famille doit comporter au moins 3 caractères",

                "Must be a number" => "Doit être un nombre",

                "Input a valid Email" => "Entrez une adresse e-mail valide",
                "A confirmation code has been sent to your new email address."
                => "Un code de confirmation a été envoyé à votre nouvelle adresse e-mail.",
                "Input the confirmation code :" => "Entrez le code de confirmation :",
                "This email is already Taken." => "Cette adresse e-mail est déjà prise.",
                "The email could not be sent." => "L'e-mail n'a pas pu être envoyé.",
                "The Confirmation Code is Incorrect." => "Le code de confirmation est incorrect.",

                "Password must be at least 8 characters." => "Le mot de passe doit comporter au moins 8 caractères.",
                "Password must contain at least one letter." => "Le mot de passe doit contenir au moins une lettre.",
                "Password must contain at least one number." => "Le mot de passe doit contenir au moins un chiffre.",
                "Passwords must match." => "Les mots de passe doivent être identiques.",
                "Your old password is incorrect." => "Votre ancien mot de passe est incorrect.",
                "Your new password must be different from your old password." => "Votre nouveau mot de passe doit être différent de votre ancien mot de passe.",
            ),
            "manage-user-buttons" => array(
                "Promote User" => "Promouvoir",
                "Promoted" => "Promu",
                "Delete User" => "Supprimer",
                "Submit Changes" => "Modifier",
            ),
            "message-center-buttons" => array(
                "Message Owner:" => "Propriétaire du message :",
                "Start Date:" => "Date de début :",
                "End Date:" => "Date de fin :",
                "Hide Active Messages" => "Masquer les messages actifs",
                "Show Active Messages" => "Afficher les messages actifs",

                "Show Resolved Messages" => "Afficher les messages résolus",
                "Hide Resolved Messages" => "Masquer les messages résolus",

                "Select Start Date:" => "Sélectionner la date de début :",
                "Select Date:" => "Sélectionner la date :",

                "Resolved messages before" => "Messages résolus avant",
                "Resolved messages after" => "Messages résolus après",
                "Resolved messages between" => "Messages résolus entre",
                "and" => "et",
                "have been deleted." => "ont été supprimés.",
                "Please input a Date." => "Veuillez entrer une date.",
                "Please input a Start Date and an End Date." => "Veuillez entrer une date de début et une date de fin.",
        ),
            "password-reset-validation" => array(
                "New Password is required" => "New Password is required",
                "Passwords should match" => "Passwords should match",
            ),
            "validation-functions" => array(
                "Client Username is required" => "Nom d'utilisateur du client requis",
                "Client Username must be at least 3 characters" => "Le nom d'utilisateur du client doit comporter au moins 3 caractères",
                "Client First Name is required" => "Prénom du client requis",
                "Client First Name must be at least 3 characters" => "Le prénom du client doit comporter au moins 3 caractères",
                "Client Last Name is required" => "Nom de famille du client requis",
                "Client Last Name must be at least 3 characters" => "Le nom de famille du client doit comporter au moins 3 caractères",
                "Email is required" => "Adresse e-mail du client requise",
                "Must be an email" => "Doit être une adresse e-mail",
                "Email is already Taken" => "L'adresse e-mail est déjà utilisée",
                "Client Phone Number must be a number" => "Le numéro de téléphone du client doit être un nombre",
                "Phone number must be 10 characters long" => "Le numéro de téléphone doit comporter 10 caractères",
                "Password is required" => "Mot de passe du client requis",

                "Password must be at least 8 characters" => "Le mot de passe doit comporter au moins 8 caractères",
                "Password must contain at least one letter" => "Le mot de passe doit contenir au moins une lettre",
                "Password must contain at least one number" => "Le mot de passe doit contenir au moins un nombre",

                "Passwords should match" => "Les mots de passe doivent correspondre",
                "Your new password must be different from your old password." => "Votre nouveau mot de passe doit être différent de votre ancien mot de passe.",
                "Your old password is incorrect." => "Votre ancien mot de passe est incorrect.",
                "The Confirmation Code is Incorrect." => "Le code de confirmation est incorrect.",

                "Address is Required" => "L'adresse est requise",
                "Postal Code is Required" => "Le code postal est requis",
                "City is Required" => "La ville est requise"
            ),

        ),
        "Russian" => array(),
    );
}
