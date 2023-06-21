<?php

function OpenCon()
{
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $db = "appdb";
    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $db) or die("Connect failed: %s\n" . $conn->error);

    if ($conn->connect_errno) {
        die("Connection Error: " . $conn->connect_error);
    } else {
        return $conn;
    }
}

function CloseCon($conn): void
{
    $conn->close();
}

function runSQLQuery($query): bool|mysqli_result
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

    if (!$stmt->prepare($sql)) {
        die("SQL Error: " . $mysqli->error);
    }

    if ($stmt->execute()) {
        CloseCon($mysqli);
        return "Success";
    } else {
        return ($mysqli->error . " " . $mysqli->errno);
    }
}

function getImage($imgPath): string
{
    $sql = "SELECT * FROM image WHERE imgPath = '" . $imgPath . "'";
    $getImageResult = runSQLQuery($sql)->fetch_assoc();

    return "../img/" . $getImageResult['imgCategory'] . "/" . $getImageResult['imgPath'];
}

function getPfp($AttributeID, $table, $ID): string
{
    if (strlen($AttributeID) > 0 && strlen($table) > 0 && strlen($ID) > 0) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $AttributeID . "='" . $ID . "'";
        $getPfpResult =  runSQLQuery($sql);

        if (mysqli_num_rows($getPfpResult) > 0) {
            $getPfpRows = $getPfpResult->fetch_assoc();
            return "../img/pfp/" . $getPfpRows[returnEntityAttributes()['PfpName']];
        } else {
            return getImage('client.png');
        }
    } else {
        return getImage('client.png');
    }
}

function findMax($intArray): int
{
    $previousNumber = 0;
    $maxNumber = 0;
    for ($i = count($intArray); $i > 0; $i--) {
        $currentNumber = $intArray[$i - 1];
        $maxNumber = max($currentNumber, $previousNumber);
        $previousNumber = $maxNumber;
    }
    return $maxNumber;
}

function idToInt($id, $idFormat): string
{
    // Remove left Side of String
    $idIndex = stripos($id, $idFormat, 0);
    $desiredId = substr($id, $idIndex, strlen($id) - $idIndex);

    // Check if the desiredID is located at the end of the String
    $lengthTest1 = strlen($desiredId);
    $lengthTest2 = strlen(str_replace("_", "", $desiredId));

    if ($lengthTest1 > $lengthTest2) {
        $idIndex = stripos($desiredId, "_", 0);
    } elseif ($lengthTest1 == $lengthTest2) {
        $idIndex = stripos($desiredId, $id, 0) + strlen($desiredId);
    }

    // Remove the right side of String
    $desiredId = substr($desiredId, 0, $idIndex);
    $desiredId = trim($desiredId, $idFormat);
    return intval($desiredId);
}

function returnLastIDInt($id, $table, $idFormat): int
{
    $idList_1 = array();
    $lastID = 0;

    $result = runSQLQuery("SELECT $id FROM $table");
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            $cltIDNumberInt = idToInt($row[$id], $idFormat);
            $idList_1[] = $cltIDNumberInt;
            $lastID = findMax($idList_1);
        }
    }

    return $lastID;
}

function autoSetID($attributeFormat): string
{
    try {
        return $attributeFormat . bin2hex(random_bytes(16));
    } catch (Exception | \Exception $e) {
    }
}

function generateRandomString($stringLength, $type): string
{
    try {
        if ($type === 'upper') {
            return strtoupper(bin2hex(random_bytes($stringLength)));
        } else if ($type === 'lower') {
            return strtolower(bin2hex(random_bytes($stringLength)));
        } else {
            return '';
        }
    } catch (Exception $e) {
        return '';
    }
}

// DEPRECATED
function uploadImage($inputName, $imgCategory): void
{
    $filename = $_FILES[$inputName]["name"];
    $tempname = $_FILES[$inputName]["tmp_name"];
    $folder = "../img/" . $imgCategory . "/" . $filename;

    $sql = "INSERT INTO image (imgID, imgPath, imgCategory) 
            VALUES ('" . autoSetID('imgID', 'image', 'img') . "', '" . $filename . "', '" . $imgCategory . "')";

    insertSQL($sql);
}

function uploadPfp($inputName, $table, $xxxPfpName): void
{
    $fileName = $_FILES[$inputName]["name"];
    $tempName = $_FILES[$inputName]["tmp_name"];
    $folder = "../img/pfp/" . $fileName;

    $sql = "UPDATE " . $table . " SET " . $xxxPfpName . "='" . $fileName . "'";

    // Execute query
    insertSQL($sql);
}

function restrictedNoUserPage($redirectPage): void
{
    if (!$_SESSION['loggedIn'] && (!$_SESSION['clientLoggedIn'] || !$_SESSION['adminLoggedIn'])) {
        echo '../php-pages/login.php';
    } else {
        echo $redirectPage;
    }
}

function restrictedAdminPage($redirectPage): void
{
    if (!$_SESSION['loggedIn'] || $_SESSION['adminLoggedIn']) {
        $_GET['errorMsg'] = 'Please login as a client to use this page.';
        echo '../php-pages/restricted-access.php';
    } else {
        echo $redirectPage;
    }
}

function isModerator($cltID): bool
{
    $sql = "SELECT cltIsModerator FROM client WHERE cltID = '" . $cltID . "'";
    $result = runSQLQuery($sql);
    $isModerator = $result->fetch_assoc();

    if ($isModerator['cltIsModerator']) {
        return true;
    } else {
        return false;
    }
}

function compareIdAndToken($idToCheck, $tokenInput, $table): bool
{
    if ($table === 'client') {
        // CHECK IF TOKEN MATCHES NEW CLIENT ID
        $checkCltTokenSql = "SELECT cltID FROM client WHERE cltToken = '" . $tokenInput . "'";
        $cltResult = runSQLQuery($checkCltTokenSql);
        $clientInfo = $cltResult->fetch_assoc();

        // Check if current cltID is the same as the cltID found from the token
        if ($idToCheck === $clientInfo['cltID']) {
            return true;
        } else {
            return false;
        }
    } elseif ($table === 'admin') {
        // CHECK IF TOKEN MATCHES NEW CLIENT ID
        $checkAdmTokenSql = "SELECT admID FROM admin WHERE admToken = '" . $tokenInput . "'";
        $admResult = runSQLQuery($checkAdmTokenSql);
        $admInfo = $admResult->fetch_assoc();

        // Check if current cltID is the same as the cltID found from the token
        if ($idToCheck === $admInfo['admID']) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function compareEmailAndToken($emailToCheck, $tokenInput, $table): bool
{
    if ($table === 'client') {
        // CHECK IF TOKEN MATCHES NEW CLIENT ID
        $checkCltTokenSql = "SELECT cltEmail FROM client WHERE cltToken = '" . $tokenInput . "'";
        $cltResult = runSQLQuery($checkCltTokenSql);
        $clientInfo = $cltResult->fetch_assoc();

        // Check if current cltID is the same as the cltID found from the token
        if ($emailToCheck === $clientInfo['cltEmail']) {
            return true;
        } else {
            return false;
        }
    } elseif ($table === 'admin') {
        // CHECK IF TOKEN MATCHES NEW CLIENT ID
        $checkAdmTokenSql = "SELECT admEmail FROM admin WHERE admToken = '" . $tokenInput . "'";
        $admResult = runSQLQuery($checkAdmTokenSql);
        $admInfo = $admResult->fetch_assoc();

        // Check if current cltID is the same as the cltID found from the token
        if ($emailToCheck === $admInfo['admEmail']) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function returnEntityInfo(): bool|array|null
{
    $loggedIn = $_SESSION['loggedIn'];
    $clientLoggedIn = $_SESSION['clientLoggedIn'];
    $adminLoggedIn = $_SESSION['adminLoggedIn'];

    if ($loggedIn) {
        if ($clientLoggedIn) {
            $sql = "SELECT cltID, cltUsername, cltFirstName, cltLastName, cltEmail, cltPfpName, cltPhoneNumber, cltSignupDate, cltVerifiedEmail, cltIsModerator FROM client WHERE cltToken = '" . $_SESSION['Token'] . "'";
        } else if ($adminLoggedIn) {
            $sql = "SELECT admID, admUsername, admFirstName, admLastName, admEmail, admPfpName, admPhoneNumber, admSignupDate, admVerifiedEmail FROM admin WHERE admToken = '" . $_SESSION['Token'] . "'";
        }
        $result = runSQLQuery($sql);
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

    if ($clientLoggedIn || $table === 'client') {
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
    } elseif ($adminLoggedIn || $table === 'admin') {
        return array(
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
    } else {
        return array(
            "ID" => '',
            "Username" => '',
            "FirstName" => '',
            "LastName" => '',
            "Email" => '',
            "PhoneNumber" => '',
            "PfpName" => '',
            "Password" => '',
            "Token" => '',
            "Table" => '',
            "IDLetters" => '',
        );
    }
}

function returnEntityAttributesByTable($table): array
{
    if ($table === 'client') {
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
            "SignupDate" => 'cltSignupDate',
            "IsModerator" => "cltIsModerator",
        );
    } elseif ($table === 'admin') {
        return array(
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
            "SignupDate" => 'admSignupDate',
        );
    } else {
        return array(
            "ID" => '',
            "Username" => '',
            "FirstName" => '',
            "LastName" => '',
            "Email" => '',
            "PhoneNumber" => '',
            "PfpName" => '',
            "Password" => '',
            "Token" => '',
            "Table" => '',
            "IDLetters" => '',
        );
    }
}

function onlyAdminPage(): void
{
    // ONLY ADMIN CAN ACCESS THIS PAGE
    include_once "login-check.php";

    if (isset($_SESSION['clientLoggedIn']) || empty($_SESSION['loggedIn'])) {

        if ($_SESSION['clientLoggedIn'] || empty($_SESSION['loggedIn'])) {

            header("Location: ../php-pages/restricted-access.php", true, 303);
            exit();
        }
    }
}

function onlyClientPage(): void
{
    //ONLY CLIENT CAN ACCESS THIS PAGE
    include_once "login-check.php";

    if (isset($_SESSION['adminLoggedIn']) || empty($_SESSION['loggedIn'])) {
        if ($_SESSION['adminLoggedIn'] || empty($_SESSION['loggedIn'])) {
            header("Location: ../php-pages/restricted-access.php", true, 303);
            exit();
        }
    }
}

function clientAndAdminPage(): void
{
    // ONLY CLIENT AND ADMIN CAN ACCESS THIS PAGE
    include_once "login-check.php";

    if (empty($_SESSION['loggedIn'])) {
        header("Location: ../php-pages/restricted-access.php", true, 303);
        exit();
    }
}

function clientAndNoUserPage(): void
{
    // ONLY CLIENT AND NO USER CAN ACCESS THIS PAGE
    include_once "login-check.php";

    if (isset($_SESSION['adminLoggedIn'])) {
        if ($_SESSION['adminLoggedIn']) {
            header("Location: ../php-pages/restricted-access.php", true, 303);
            exit();
        }
    }
}

function date_compare($a, $b): int
{
    $t1 = strtotime($a['msgDate']);
    $t2 = strtotime($b['msgDate']);
    return $t1 - $t2;
}

function returnSessionMessages($sesMsgID): array
{

    $getClientMessagesSql = "SELECT sesMsgID, cltID,  cltUsername, cltMsgDate, cltMsgMessage FROM session_message
                             INNER JOIN client_message cm on session_message.sesMsgID = cm.Session_Message_sesMsgID
                             INNER JOIN client c on cm.Client_cltID = c.cltID                                       
                             WHERE sesMsgID = '" . $sesMsgID . "'";

    $getAdminMessagesSql = "SELECT sesMsgID, admID, admUsername, admMsgDate, admMsgMessage FROM session_message
                             INNER JOIN admin_message am on session_message.sesMsgID = am.Session_Message_sesMsgID
                             INNER JOIN admin a on am.Admin_admID = a.admID                                          
                             WHERE sesMsgID = '" . $sesMsgID . "'";


    //    echo $getSessionMessagesSql;
    $clientMessagesResult = runSQLQuery($getClientMessagesSql);
    $adminMessagesResult = runSQLQuery($getAdminMessagesSql);
    $sessionMessagesList = array();


    while ($clientMessages = $clientMessagesResult->fetch_assoc()) {
        // CHECK OWNERSHIP OF THE MESSAGES => IF THEY ARE CURRENT OR FOREIGN
        if ($_SESSION['Table'] === 'client') {
            $messageOwnership = 'current';
        } else {
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

    while ($adminMessages = $adminMessagesResult->fetch_assoc()) {
        // CHECK OWNERSHIP OF THE MESSAGES => IF THEY ARE CURRENT OR FOREIGN
        if ($_SESSION['Table'] === 'admin') {
            if ($_SESSION['ID'] === $adminMessages['admID']) {
                $messageOwnership = 'current';
            } else {
                $messageOwnership = 'foreign';
            }
        } else {
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
    $allSessionMessagesIDsResult = runSQLQuery($getAllSessionMessagesIDsSql);
    $allSessionMessagesIDsList = array();

    $allSessionMessagesList = [];

    if (mysqli_num_rows($allSessionMessagesIDsResult) > 0) {
        while ($allSessionMessagesIDs = $allSessionMessagesIDsResult->fetch_assoc()) {
            $allSessionMessagesIDsList[] = $allSessionMessagesIDs['sesMsgID'];
        }


        for ($i = 0; $i < count($allSessionMessagesIDsList); $i++) {
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

    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
        include_once '../php-processes/php-mailer.php';
        // CHANGE TOKEN WHEN LOGGING OUT
        if (isset($_SESSION['Table']) && isset($_SESSION['Token'])) {
            $entityAttributes = returnEntityAttributes();
            $token = generateToken($_SESSION["ID"]);

            $insertTokenSql = "UPDATE " . $_SESSION['Table'] . " SET " . $entityAttributes['Token'] . " = '" . $token . "' WHERE " . $entityAttributes['Token'] . " = '" . $_SESSION['Token'] . "'";

            runSQLQuery($insertTokenSql);

            setcookie("Token-cookie", "", time() + (86400 * 30), "/");
            setcookie("Table-cookie", "", time() + (86400 * 30), "/");
        }
        session_destroy();

        header('Location: ' . $page, true, 303);
        exit();
    }
}

function returnList($runSQLQuery): array
{
    // INPUT
    // OBJECT TYPE runSQLResult;

    // OUTPUT
    $outputExample = [
        [
            "prdID" => "prd1",
            "pimPath" => "iCollar_v1.png_black"
        ],
        [
            "prdID" => "prd1",
            "pimPath" => "iCollar_v1.png_blue"
        ],
        [
            "prdID" => "prd1",
            "pimPath" => "iCollar_v1.png_green"
        ],
        [
            "prdID" => "prd1",
            "pimPath" => "iCollar_v1.png_red"
        ],
        [
            "prdID" => "prd1",
            "pimPath" => "iCollar_v1.png_white"
        ],
        [
            "prdID" => "prd1",
            "pimPath" => "iCollar_v1.png_yellow"
        ],
        [
            "prdID" => "prd2",
            "pimPath" => "iCollar_v2.png_red"
        ],
        [
            "prdID" => "prd2",
            "pimPath" => "iCollar_v2.png_white"
        ],
        [
            "prdID" => "prd2",
            "pimPath" => "iCollar_v2.png_yellow"
        ],
        [
            "prdID" => "prd2",
            "pimPath" => "iCollar_v2.png_black"
        ],
        [
            "prdID" => "prd2",
            "pimPath" => "iCollar_v2.png_blue"
        ],
        [
            "prdID" => "prd2",
            "pimPath" => "iCollar_v2.png_green"
        ]

    ];

    $list = array();
    while ($listRow = $runSQLQuery->fetch_assoc()) {
        $list[] = $listRow;
    }
    return $list;
}

function returnObjectList($runSQLQuery, $objectID): array
{
    $list = array();
    while ($listRow = $runSQLQuery->fetch_assoc()) {
        $list[$listRow[$objectID]] = $listRow;
    }
    return $list;
}

function returnItem($runSQLQuery): array
{
    $list = array();
    while ($listRow = $runSQLQuery->fetch_assoc()) {
        $list = $listRow;
    }
    return $list;
}

function returnImagePathList($groupList): array
{
    $imagePathList = array();

    foreach ($groupList as $groupListKey => $groupListValue) {
        foreach ($groupListValue as $AttributeKey => $attributeValue) {
            foreach ($attributeValue as $rowValue) {
                if ($AttributeKey === 'pimPath') {
                    $imagePathList[$groupListKey][$AttributeKey][] = getImage($rowValue);
                } else {
                    $imagePathList[$groupListKey][$AttributeKey][] = $rowValue;
                }
            }
        };
    }

    return $imagePathList;
}

function returnGroupList($runSQLQuery, $groupByID): array
{
    // INPUT
    // OBJECT TYPE runSQLResult;

    // OUTPUT
    $outputExample = [
        "prd1" => [
            "prcColor" => [
                "black",
                "blue",
                "green",
                "red",
                "white",
                "yellow"
            ]
        ],
        "prd2" => [
            "prcColor" => [
                "red",
                "white",
                "yellow",
                "black",
                "blue",
                "green"
            ]
        ]

    ];

    $groupList = array();
    while ($listRow = $runSQLQuery->fetch_assoc()) {
        $valueList = array();
        foreach ($listRow as $mainKey => $mainValue) {
            if ($mainKey !== $groupByID) {
                $groupList[$listRow[$groupByID]][$mainKey][] = $mainValue;
            }
        };
    }
    return $groupList;
}

function returnAssociativeList($runSQLQuery, $groupByID): array
{
    // INPUT
    // OBJECT TYPE runSQLResult;

    // OUTPUT
    $outputExample = [
        [
            "prd1" => [
                "prdID" => "prd1",
                "prdName" => "Connected Collars for dogs v1",
                "prdPrice" => "499.99",
                "prdReleaseDate" => "2023-01-01"
            ],
            "prd2" => [
                "prdID" => "prd2",
                "prdName" => "Connected Collars for dogs v2",
                "prdPrice" => "499.99",
                "prdReleaseDate" => "2023-01-01"
            ]
        ]
    ];

    $list = array();
    while ($listRow = $runSQLQuery->fetch_assoc()) {

        $list[$listRow[$groupByID]] = $listRow;
    }
    return $list;
}

function returnMergedList($mainArray): array
{
    // INPUT
    $inputExample = [
        [
            "prd1" => [
                "prcColor" => [
                    "black",
                    "blue",
                    "green",
                    "red",
                    "white",
                    "yellow"
                ]
            ],
            "prd2" => [
                "prcColor" => [
                    "red",
                    "white",
                    "yellow",
                    "black",
                    "blue",
                    "green"
                ]
            ]
        ],
        [
            "prd1" => [
                "pimPath" => [
                    "iCollar_v1.png_black",
                    "iCollar_v1.png_blue",
                    "iCollar_v1.png_green",
                    "iCollar_v1.png_red",
                    "iCollar_v1.png_white",
                    "iCollar_v1.png_yellow"
                ]
            ],
            "prd2" => [
                "pimPath" => [
                    "iCollar_v2.png_red",
                    "iCollar_v2.png_white",
                    "iCollar_v2.png_yellow",
                    "iCollar_v2.png_black",
                    "iCollar_v2.png_blue",
                    "iCollar_v2.png_green"
                ]
            ]
        ]
    ];

    // OUTPUT
    $outputExample = [
        "prd1" => [
            "prcColor" => [
                "black",
                "blue",
                "green",
                "red",
                "white",
                "yellow"
            ],
            "pimPath" => [
                "iCollar_v1.png_black",
                "iCollar_v1.png_blue",
                "iCollar_v1.png_green",
                "iCollar_v1.png_red",
                "iCollar_v1.png_white",
                "iCollar_v1.png_yellow"
            ]
        ],
        "prd2" => [
            "prcColor" => [
                "red",
                "white",
                "yellow",
                "black",
                "blue",
                "green"
            ],
            "pimPath" => [
                "iCollar_v2.png_red",
                "iCollar_v2.png_white",
                "iCollar_v2.png_yellow",
                "iCollar_v2.png_black",
                "iCollar_v2.png_blue",
                "iCollar_v2.png_green"
            ]
        ]
    ];

    $mergedList = array();

    foreach ($mainArray as $secondArray) {

        foreach ($secondArray as $thirdArrayKey => $thirdArray) {
            foreach ($thirdArray as $rowKey => $row) {
                $mergedList[$thirdArrayKey][$rowKey] = $row;
            }
        }
    }

    return $mergedList;
}

function returnCombinedList2($mainArray, $combinedListID): array
{
    //    $orderedList = returnMergedList($mainArray);
    $AttributeList = array();
    $combinedList = array();

    foreach ($mainArray as $mainListKey => $mainListValue) {
        foreach ($mainListValue as $subListKey => $subListValue) {
            $AttributeList[$mainListKey][] = $subListKey;
        }

        foreach ($AttributeList as $mainListKey2 => $mainListValue2) {
            $keyListName = $mainListValue2[0];
            $valueListName = $mainListValue2[1];

            $keyList = $mainArray[$mainListKey2][$keyListName];
            $valueList = $mainArray[$mainListKey2][$valueListName];

            foreach ($keyList as $keyListKey => $keyListValue) {
                foreach ($valueList as $valueListKey => $valueListValue) {
                    if ($keyListKey === $valueListKey) {
                        $combinedList[$mainListKey2][$combinedListID][$keyListValue] = $valueListValue;
                    }
                }
            }
        }
    }

    return $combinedList;
}

function returnAddressList(): array
{
    $token = $_SESSION['Token'];
    $getAddressListSql = "SELECT adrID, adrAddress, adrAddressOptional, adrPostalCode, adrCity, adrDefault FROM address 
                          INNER JOIN client c on address.Client_cltID = c.cltID
                          WHERE cltToken = '" . $token . "'";

    return returnList(runSQLQuery($getAddressListSql));
}

function returnAddressInfo($adrID): array
{
    $getAddressInfoSql = "SELECT adrID, adrAddress, adrAddressOptional, adrPostalCode, adrCity, adrDefault FROM address 
                          WHERE adrID = '" . $adrID . "'";

    return returnList(runSQLQuery($getAddressInfoSql));
}

function returnProductList($optionalPrdID): array
{

    $productListSql = "SELECT * FROM product";
    if (strlen($optionalPrdID) > 0) {
        $productListSql .= " WHERE prdID ='" . $optionalPrdID . "'";
    }
    $productList = returnAssociativeList(runSQLQuery($productListSql), 'prdID');

    $prdImgListSql = "SELECT prdID, prcColor, pimPath from product
                      INNER JOIN product_color pc on product.prdID = pc.Product_prdID
                      INNER JOIN product_image pi on pc.prcID = pi.Product_Color_prcID";
    if (strlen($optionalPrdID) > 0) {
        $prdImgListSql .= " WHERE prdID ='" . $optionalPrdID . "'";
    }
    $prdImgList = returnGroupList(runSQLQuery($prdImgListSql), 'prdID');
    $prdImgList2 = returnImagePathList($prdImgList);
    $prdImgList3 = returnCombinedList2($prdImgList2, 'prdImg');

    //    ACTUAL RETURN STUFF
    $finalList = array($productList, $prdImgList3);
    return returnMergedList($finalList);
}

function deObjectifyList($objectList): array
{

    foreach ($objectList as $objectListItem) {
        $deObjectifiedList[] = $objectListItem;
    }
    return $deObjectifiedList;
}

function returnProductIntPrice($value): string
{
    return substr($value, 0, strlen($value) - 3);
}

function returnProductDecimalPrice($value): string
{
    return substr($value, strlen($value) - 2, strlen($value));
}

function returnBasketList(): array
{

    if (isset($_SESSION['Table']) || isset($_SESSION['loggedIn'])) {
        if (!$_SESSION['loggedIn'] && isset($_COOKIE['Basket-cookie'])) {

            $cookieBasketList =  json_decode($_COOKIE['Basket-cookie']);

            if (!(gettype($cookieBasketList) === "NULL")) {
                foreach ($cookieBasketList as $cookieBasketListItem) {
                    $prdID = $cookieBasketListItem[0];
                    $prdColor = $cookieBasketListItem[1];

                    $productList = returnProductList($prdID);
                    foreach ($productList as $productListItem) {
                        foreach ($productListItem as $productListItemKey => $productListItemRow) {
                            if ($productListItemKey !== $prdID) {
                                $basketItem[$productListItemKey] = $productListItemRow;
                            }
                        }
                        $basketItem['prcColor'] = $prdColor;
                    }
                    $basketList[] = $basketItem;
                }
                return $basketList;
            } else {
                return array();
            }
        } else if (isset($_SESSION['Table']) && $_SESSION['Table'] === 'client') {
            $cltID = $_SESSION['ID'];
            $getClientBasketListSql = "SELECT Product_prdID AS prdID, prcColor, prdLstID
                                   FROM client
                                   INNER JOIN basket b on client.cltID = b.Client_cltID
                                   INNER JOIN product_list pl on b.basID = pl.Basket_basID
                                   WHERE cltID = '" . $cltID . "'";
            $getClientBasketListResult = runSQLQuery($getClientBasketListSql);

            if (mysqli_num_rows($getClientBasketListResult) > 0) {
                $clientBasketList = returnList($getClientBasketListResult);

                foreach ($clientBasketList as $clientBasketListItem) {
                    $prdID = $clientBasketListItem['prdID'];
                    $additionalList = array();
                    $basketItem = array();

                    foreach ($clientBasketListItem as $clientBasketListItemKey => $clientBasketListItemRow) {
                        $basketItem[$clientBasketListItemKey] = $clientBasketListItemRow;
                    }

                    foreach (returnProductList($prdID) as $productListItem) {
                        foreach ($productListItem as $productListItemKey => $productListItemRow) {
                            if ($productListItemKey !== $prdID) {
                                $basketItem[$productListItemKey] = $productListItemRow;
                            }
                        }
                    }
                    $basketList[] = $basketItem;
                }

                return $basketList;
            } else {
                return array();
            }
        } else {
            return array();
        }
    } else {
        return array();
    }
}

function returnDevicesListByClient(): array
{
    if (isset($_SESSION['Table']) && $_SESSION['Table'] === 'client') {

        $cltID = $_SESSION['ID'];
        $getClientDevicesListSql = "SELECT * FROM device
                                    WHERE Client_cltID = '" . $cltID . "'";

        $getClientDevicesListResult = runSQLQuery($getClientDevicesListSql);

        $productsList = returnProductList('');

        if (mysqli_num_rows($getClientDevicesListResult) > 0) {
            $clientDevicesList = returnList($getClientDevicesListResult);

            foreach ($clientDevicesList as $clientDevicesListIndex => $clientDevicesListItem) {
                $prdID = $clientDevicesListItem['prdID'];
                $prcColor = $clientDevicesListItem['prcColor'];
                $prdImg = $productsList[$prdID]['prdImg'][$prcColor];
                $clientDevicesList[$clientDevicesListIndex]['prdImg'] = $prdImg;
            }

            return $clientDevicesList;
        } else {
            return array();
        }
    } else {
        return array();
    }
}

function returnDevicesList($optionalDevID): array
{
    if (strlen($optionalDevID) > 0) {
        $getClientDevicesListSql = "SELECT * FROM device WHERE devID = '" . $optionalDevID . "'";
    } else {
        $getClientDevicesListSql = "SELECT * FROM device";
    }

    $getClientDevicesListResult = runSQLQuery($getClientDevicesListSql);
    $productsList = returnProductList('');

    if (mysqli_num_rows($getClientDevicesListResult) > 0) {
        $clientDevicesList = returnList($getClientDevicesListResult);

        foreach ($clientDevicesList as $clientDevicesListIndex => $clientDevicesListItem) {
            $prdID = $clientDevicesListItem['prdID'];
            $prcColor = $clientDevicesListItem['prcColor'];
            $prdImg = $productsList[$prdID]['prdImg'][$prcColor];
            $clientDevicesList[$clientDevicesListIndex]['prdImg'] = $prdImg;
        }

        return $clientDevicesList;
    } else {
        return array();
    }
}

function returnMiscImgList(): array
{
    return array(
        'edit.png' => getImage('edit.png'),
        'cancel.png' => getImage('cancel.png'),
        'confirm.png' => getImage('confirm.png'),
        'heart.png' => getImage('heart.png'),
        'co2.png' => getImage('co2.png'),
        'thermo.png' => getImage('thermo.png'),
    );
}

function returnAssistanceList($optionalAstID, $astApproved, $type): array
{
    if (strlen($optionalAstID) === 0) {
        if (strlen($astApproved) === 0) {
            $getAssistanceListSql = "SELECT * FROM assistance";
        } else {
            $getAssistanceListSql = "SELECT * FROM assistance WHERE astApproved = '" . $astApproved . "'";
        }
    } else {
        if (strlen($astApproved === 0)) {
            $getAssistanceListSql = "SELECT * FROM assistance WHERE astID = '" . $optionalAstID . "'";
        } else {
            $getAssistanceListSql = "SELECT * FROM assistance WHERE astID = '" . $optionalAstID . "' AND astApproved = '" . $astApproved . "'";
        }
    }

    $assistanceListResult = runSQLQuery($getAssistanceListSql);

    if (mysqli_num_rows($assistanceListResult) > 0) {
        if (strlen($optionalAstID) === 0) {
            if ($type === 'object') {
                return returnObjectList($assistanceListResult, 'astID');
            } else if ($type == 'list') {
                return returnList($assistanceListResult);
            } else {
                return array();
            }
        } else {
            return returnItem($assistanceListResult);
        }
    } else {
        return array();
    }
}

function returnLastMessagesList($type): array
{
    if ($type === 'message') {
        $getActiveMessagesSql = "SELECT DISTINCT cltID, cltUsername FROM client
                             INNER JOIN client_message cm on client.cltID = cm.Client_cltID
                             INNER JOIN session_message sm on cm.Session_Message_sesMsgID = sm.sesMsgID
                             WHERE sesMsgEndDate is null 
                             ORDER BY sesMsgStartDate";

        $activeMessagesResult = runSQLQuery($getActiveMessagesSql);

        if (mysqli_num_rows($activeMessagesResult) > 0) {
            while ($activeMessages = $activeMessagesResult->fetch_assoc()) {
                $sesMsgID = $activeMessages['cltID'];

                $sessionMessages = returnSessionMessages($sesMsgID);
                $lastSessionMessage = end($sessionMessages[$sesMsgID]);

                $lastMessagesList[] = array(
                    'cltID' => $activeMessages['cltID'],
                    'cltUsername' => $activeMessages['cltUsername'],

                    'username' => $lastSessionMessage['username'],
                    'msgMessage' => $lastSessionMessage['msgMessage'],
                    'msgDate' => $lastSessionMessage['msgDate'],
                );
            }
        } else {
            $lastMessagesList = array();
        }
        return $lastMessagesList;
    } else if ($type === 'resolved') {
        $getResolvedMessagesSql = "SELECT DISTINCT sesMsgID, sesMsgStartDate ,sesMsgEndDate, cltUsername  FROM session_message 
                                   LEFT JOIN client_message cm on session_message.sesMsgID = cm.Session_Message_sesMsgID
                                   LEFT JOIN client c on cm.Client_cltID = c.cltID
                                   WHERE sesMsgID LIKE '%resolved%'
                                   ORDER BY sesMsgEndDate";

        $resolvedMessagesResult = runSQLQuery($getResolvedMessagesSql);

        if (mysqli_num_rows($resolvedMessagesResult) > 0) {
            while ($resolvedMessages = $resolvedMessagesResult->fetch_assoc()) {

                //                $sessionMessages = returnSessionMessages($resolvedMessages['sesMsgID']);
                //                $lastSessionMessage = end($sessionMessages);

                $lastMessagesList[] = array(
                    'sesMsgID' => $resolvedMessages['sesMsgID'],
                    'cltUsername' => $resolvedMessages['cltUsername'],
                    'sesMsgEndDate' => $resolvedMessages['sesMsgEndDate'],
                    'sesMsgStartDate' => $resolvedMessages['sesMsgStartDate'],

                    //                    'username' => $lastSessionMessage['username'],
                    //                    'msgMessage' => $lastSessionMessage['msgMessage'],
                    //                    'msgDate' => $lastSessionMessage['msgDate'],
                );
            }
        } else {
            $lastMessagesList = array();
        }
        return $lastMessagesList;
    } else {
        return array();
    }
}

function randFloat($start, $end, $decimals): float
{
    return mt_rand($start * pow(10, $decimals), $end * pow(10, $decimals)) / (pow(10, $decimals));
}


function generateDeviceData($devID, $v, $date, $c): void
{
    //$dapDate = date('2023-01-01 00:00:00');
    $dapDate = $date->format('Y-m-d H:i:s');
    $dapID = autoSetID('dap');
    $dapBPM = 0;
    $dapLatitude = randFloat(48, 49, 5);
    $dapLongitude = randFloat(2, 3, 5);
    $dapCO2 = 0;
    $dapDecibel = 0;
    $dapTemp = 0;

    if (hexdec($c) == 10) {
        $dapDecibel = $v;
    } elseif (hexdec($c) == 3) {
        $dapTemp = $v;
    } elseif (hexdec($c) == 4) {
        $dapCO2 = $v;
    } elseif (hexdec($c) == 5) {
        $dapTemp = $v;
    } elseif (hexdec($c) == 6) {
        $dapTemp = $v;
    }
    $insertDataSql = "INSERT INTO data_device(dapID, dapBPM, dapLatitude, dapLongitude, dapCO2, dapDecibel, dapTemp, dapDate, Device_devID) 
                          VALUES ('" . $dapID . "', '" . $dapBPM . "', '" . $dapLatitude . "', '" . $dapLongitude . "', '" . $dapCO2 . "', '" . $dapDecibel . "', '" . $dapTemp . "', '" . $dapDate . "', '" . $devID . "')";
    runSQLQuery($insertDataSql);

    //        echo $insertDataSql.'<br>';

}

function returnEntityList($table, $orderBy, $sortBy): array
{
    $entityAttributes = returnEntityAttributesByTable($table);

    $getEntityListSql = "SELECT 
    " . $entityAttributes['ID'] . ", 
    " . $entityAttributes['Username'] . ", 
    " . $entityAttributes['FirstName'] . ", 
    " . $entityAttributes['LastName'] . ", 
    " . $entityAttributes['Email'] . ", 
    " . $entityAttributes['PhoneNumber'] . ", 
    " . $entityAttributes['SignupDate'];

    if ($table === 'client') {
        $getEntityListSql .= ", cltIsModerator";
    }

    $getEntityListSql .= " FROM " . $table . " ORDER BY " . $sortBy . " " . $orderBy;
    $getEntityListResult = runSQLQuery($getEntityListSql);

    return returnObjectList($getEntityListResult, $entityAttributes['ID']);
}

function returnLanguage(): string
{
    if (empty($_COOKIE['language-cookie'])) {
        return 'English';
    } else {
        return $_COOKIE['language-cookie'];
    }
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
                "Address" => "Address",
                "Postal Code" => "Postal Code",
                "City" => "City",

                "Submit Changes" => "Submit Changes",
            ),
            "assistance" => array(
                "Assistance" => "Assistance",
                "Need help?" => "Need Help?",
                "Find the answer to all of your questions" => "Find the answer to all of your questions",
                "Frequent Questions" => "Frequent Questions",
                "Can't find your question?" => "Can't find your question?",
                "Click" => "Click",
                "here" => "here",
                "to ask a new question" => "to ask a new question",
                "No questions have been found." => "No questions have been found.",
            ),
            "assistance-answer" => array(
                "Assistance Answer" => "Assistance Answer",
            ),
            "assistance-question" => array(
                "Ask a new question" => "Ask a new question",
                "Write your question here" => "Write your question here",
                "New question" => "New question",
                "Ask question" => "Ask question",
                "Your question has been successfully sent and will be reviewed soon" => "Your question has been successfully sent and will be reviewed soon",
                "Your question could not be processed" => "Your question could not be processed",
            ),
            "assistance-manage" => array(
                "Answer Questions" => "Answer Questions",
                "Manage Questions" => "Manage Questions",
                "Control Panel" => "Control Panel",
                "Save Changes" => "Save Changes",
                "Approve Question" => "Approve Question",
                "Disapprove Question" => "Disapprove Question",
                "Delete Selected Question" => "Delete Selected Question",
                "Edit Question" => "Edit Question",
                "Answer to the question" => "Answer to the question",
            ),
            "checkout" => array(
                "Checkout" => "Checkout",
                "Start adding items to your basket!" => "Start adding items to your basket!",
                "Thank you for buying our products! An email has been sent to you with all the details." => "Thank you for buying our products! An email has been sent to you with all the details.",
                "Your Total is" => "Your Total is",
                "Buy Products" => "Buy Products",
            ),
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
                "new" => "new",
                "The connected dog collar" => "The connected dog collar",
                "See more" => "See more",
                "Buy" =>  "Buy",
                "Free" => "Free",
                "delivery" => "delivery",
                "Free delivery in Metropolitan France" => "Free delivery in <strong> Metropolitan France</strong>",
                "7-day trial" => "7-day <br> trial",
                "We accept returns within 7 days of delivery" => "We accept returns within 7 days of delivery",
                "Secure payments" => "Secure <br>payments",
                "100% encrypted payments" => "100% encrypted payments",
                "Accepted payment methods: Paypal, Visa, Mastercard or Apple Pay" => "Accepted payment methods:<strong> Paypal, Visa, Mastercard or Apple Pay</strong>",
                "2 year warranty" =>  "2 year <br>warranty",
                "We will repair or replace your product for any issues covered by the warranty for the two years following the receipt of the product" => "We will repair or replace your product for any issues covered by the warranty for the two years following the receipt of the product",
                "Our community" => "Our community",
                "Join the PetConnect community" => "Join the PetConnect community",
            ),
            "info-device" => array(
                "Account" => "Account",
                "My devices" => "My devices",
                "Device information" =>  "Device information",
                "Day" => "Day",
                "From" => "From",
                "to" => "to",
                "Temperature" => "Temperature",
                "Number of decibels" => "Number of decibels",
                "Heart rate" => "Heart rate",
                "Air quality" => "Air quality",
            ),
            "legal-notice" => array(
                "Legal Notices" => "Legal Notices",
                "Site published by PetConnect®" => "Site published by PetConnect®",
                "SA with a capital of 420 euros" => "SA with a capital of 420 euros",
                "Head office" => "Head office",
                "Intra-community VAT no." => "Intra-community VAT no.",
                "Chairmen" => "Chairmen",
                "Headquarters Location" => "Headquarters Location",
                "Tel" => "Tel",
                "Fax" => "Fax",

                "Back end programming manager" => "Back end programming manager",
                "Front end programming manager" => "Front end programming manager",
                "Design manager" => "Design manager",
                "Publication manager" => "Publication manager",
                "Human Ressources manager" => "Human Ressources manager",
                "Data analyst" => "Data analyst",
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
            "product" => array(
                "White" => "White",
                "Add to basket" => "Add to basket",
                "Buy this product" => "Buy this product",
                "Ecological Packaging" => "Ecological Packaging",
                "Delivery under 48h" => "Delivery under 48h",
                "Satisfied or reimbursed" => "Satisfied or reimbursed",
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
                "Username:" => "Username:",
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
                "Logout" => "Logout",

                "My Account" => "My Account",

                "My Devices" => "My Devices",
                "My Order History" => "My Order History",
                "My Payment Methods" => "My Payment Methods",
                "My Addresses" => "My Addresses",
                "Manage Users" => "Manage Users",
                "Answer Questions" => "Answer Questions",
                "Connection And Security" => "Connection And Security",
                "Message Center" => "Message Center",

                "Your Total is" => "Your Total is",
                "Start adding items to your basket" => "Start adding items to your basket",
                "Delete all items" => "Delete all items",
                "Go to Checkout Page" => "Go to Checkout Page",
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
                "Shop" => "Shop",
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
            "terms-of-use" => array(
                "Terms of use" => "Terms of use",
                "Welcome to the PetConnect website (the 'Site'). The Site is operated by PetConnect, LLC ('PetConnect,' 'we,' or 'us'). These Terms of Use (these 'Terms') govern your access to and use of the Site, including any content, functionality, and services offered on or through the Site."
                => "Welcome to the PetConnect website (the 'Site'). The Site is operated by PetConnect, LLC ('PetConnect,' 'we,' or 'us'). These Terms of Use (these 'Terms') govern your access to and use of the Site, including any content, functionality, and services offered on or through the Site.",
                "By accessing or using the Site, you are accepting these Terms and agreeing to be bound by them. If you do not agree to these Terms, you must not access or use the Site."
                => "By accessing or using the Site, you are accepting these Terms and agreeing to be bound by them. If you do not agree to these Terms, you must not access or use the Site.",
                "Use of the Site" => "Use of the Site",
                "You may use the Site only for lawful purposes and in accordance with these Terms. You may not use the Site"
                => "You may use the Site only for lawful purposes and in accordance with these Terms. You may not use the Site",
                "In any way that violates any applicable federal, state, local, or international law or regulation." =>
                "In any way that violates any applicable federal, state, local, or international law or regulation.",
                "For the purpose of exploiting, harming, or attempting to exploit or harm minors in any way by exposing them to inappropriate content, asking for personally identifiable information, or otherwise." =>
                "For the purpose of exploiting, harming, or attempting to exploit or harm minors in any way by exposing them to inappropriate content, asking for personally identifiable information, or otherwise.",
                "To transmit, or procure the sending of, any advertising or promotional material, including any 'junk mail,' 'chain letter,' 'spam,' or any other similar solicitation." => "To transmit, or procure the sending of, any advertising or promotional material, including any 'junk mail,' 'chain letter,' 'spam,' or any other similar solicitation.",
                "To impersonate or attempt to impersonate PetConnect, a PetConnect employee, another user, or any other person or entity." =>
                "To impersonate or attempt to impersonate PetConnect, a PetConnect employee, another user, or any other person or entity.",
                "To engage in any other conduct that restricts or inhibits anyone's use or enjoyment of the Site, or which, as determined by PetConnect, may harm PetConnect or users of the Site or expose them to liability." =>
                "To engage in any other conduct that restricts or inhibits anyone's use or enjoyment of the Site, or which, as determined by PetConnect, may harm PetConnect or users of the Site or expose them to liability.",
                "Product Sales" =>
                "Product Sales",
                "The Site may offer for sale certain smart collars for dogs ('Products'). By placing an order for a Product, you are offering to purchase the Product on and subject to these Terms. All orders are subject to availability and confirmation of the order price." =>
                "The Site may offer for sale certain smart collars for dogs ('Products'). By placing an order for a Product, you are offering to purchase the Product on and subject to these Terms. All orders are subject to availability and confirmation of the order price.",
                "Warranty Disclaimer" =>
                "Warranty Disclaimer",
                "The Site, including all content, functionality, and services offered on or through the Site, are provided 'as is,' 'as available,' and 'with all faults.' PetConnect makes no representations or warranties of any kind, express or implied, as to the operation of the Site or the information, content, materials, or products included on the Site." =>
                "The Site, including all content, functionality, and services offered on or through the Site, are provided 'as is,' 'as available,' and 'with all faults.' PetConnect makes no representations or warranties of any kind, express or implied, as to the operation of the Site or the information, content, materials, or products included on the Site.",
                "Limitation of Liability" =>
                "Limitation of Liability",
                "In no event shall PetConnect, its directors, officers, employees, agents, partners, or suppliers be liable for any damages whatsoever, including without limitation, direct, indirect, special, incidental, or consequential damages, arising out of or in connection with the use, inability to use, or performance of the Site or the products offered on the Site." =>
                "In no event shall PetConnect, its directors, officers, employees, agents, partners, or suppliers be liable for any damages whatsoever, including without limitation, direct, indirect, special, incidental, or consequential damages, arising out of or in connection with the use, inability to use, or performance of the Site or the products offered on the Site.",
                "Changes to These Terms" =>
                "Changes to These Terms",
                "PetConnect reserves the right to make changes to these Terms at any time. Your continued use of the Site following the posting of any changes to these Terms will mean you accept those changes." =>
                "PetConnect reserves the right to make changes to these Terms at any time. Your continued use of the Site following the posting of any changes to these Terms will mean you accept those changes.",
                "Contact Us" =>
                "Contact Us",
                "If you have any questions about these Terms, please contact us at petconnecttech@gmail.com." =>
                "If you have any questions about these Terms, please contact us at petconnecttech@gmail.com.",
            ),

            // PHP PROCESSES
            "checkout-process" => array(
                'Thank you for buying our products' => 'Thank you for buying our products',
            ),
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
            "product-buttons" => array(
                "white" => "White",
                "blue" => "Blue",
                "green" => "Green",
                "red" => "Red",
                "yellow" => "Yellow",
                "black" => "Black",
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
                "Address" => "Adresse",
                "Postal Code" => "Code postal",
                "City" => "Ville",
                "Submit Changes" => "Soumettre les modifications",
            ),
            "assistance" => array(
                "Assistance" => "Assistance",
                "Need help?" => "Avez-vous besoin d'aide?",
                "Find the answer to all of your questions" => "Trouvez la réponse à toutes vos questions",
                "Frequent Questions" => "Questions fréquentes",
                "Can't find your question?" => "Vous ne trouvez pas votre question?",
                "Click" => "Cliquez",
                "here" => "ici",
                "to ask a new question" => "pour poser une nouvelle question",
                "No questions have been found." => "Aucune question n'a été trouvée.",
            ),
            "assistance-answer" => array(
                "Assistance Answer" => "Réponse d'assistance",
            ),
            "assistance-question" => array(
                "Ask a new question" => "Posez une nouvelle question",
                "Write your question here" => "Écrivez votre question ici",
                "New question" => "Nouvelle question",
                "Ask question" => "Poser une question",
                "Your question has been successfully sent and will be reviewed soon" => "Votre question a été envoyée avec succès et sera bientôt examinée",
                "Your question could not be processed" => "Votre question n'a pas pu être traitée",
            ),
            "assistance-manage" => array(
                "Answer Questions" => "Répondre aux questions",
                "Manage Questions" => "Gérer les questions",
                "Control Panel" => "Panneau de contrôle",
                "Save Changes" => "Enregistrer les modifications",
                "Approve Question" => "Approuver la question",
                "Disapprove Question" => "Désapprouver la question",
                "Delete Selected Question" => "Supprimer la question sélectionnée",
                "Edit Question" => "Modifier la question",
                "Answer to the question" => "Répondre à la question",
            ),
            "checkout" => array(
                "Checkout" => "Panier",
                "Start adding items to your basket!" => "Commencez à ajouter des articles à votre panier!",
                "Thank you for buying our products! An email has been sent to you with all the details." => "Merci d'avoir acheté nos produits! Un e-mail vous a été envoyé avec tous les détails.",
                "Your Total is" => "Votre total est",
                "Buy Products" => "Acheter les produits",
            ),
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
                "Technology for your animals" => "La technologie pour vos animaux",
                "new" => "nouveau",
                "The connected dog collar" => "Le collier connecté pour chien",
                "See more" => "En savoir plus",
                "Buy" => "Acheter",
                "Free" => "Livraison",
                "delivery" => "offerte",
                "Free delivery in Metropolitan France" => "Livraison gratuite en <strong>France Métropolitaine</strong>",
                "7-day trial" => "7 jours <br>d'essai",
                "We accept returns within 7 days of delivery" => " Nous acceptons les retours dans les 7 jours après la livraison",
                "Secure payments" => "Paiements <br>sécurisés",
                "100% encrypted payments" => "Paiements 100% cryptés",
                "Accepted payment methods: Paypal, Visa, Mastercard or Apple Pay" => "Méthodes de paiement acceptées:<strong> Paypal, Visa, Mastercard ou Apple Pay</strong>",
                "2 year warranty" => "2 ans de <br>garantie",
                "We will repair or replace your product for any issues covered by the warranty for the two years following the receipt of the product" => "Nous réparons ou remplaçons votre produit pour tous problème couvert par la garantie pendant les deux années suivant la réception du produit",
                "Our community" => "Notre communauté",
                "Join the PetConnect community" => "Rejoignez la communauté PetConnect",

            ),
            "info-device" => array(
                "Account" => "Compte",
                "My devices" => "Mes appareils",
                "Device information" => "Information appareil",
                "Day" => "Jour",
                "Add" => "Ajouter",
                "From" => "Du",
                "to" => "au",
                "Temperature" => "Température",
                "Number of decibels" => "Nombre de décibels",
                "Heart rate" => "Fréquence cardiaque",
                "Air quality" => "Qualité de l'air",
            ),
            "legal-notice" => array(
                "Legal Notices" => "Mentions légales",
                "Site published by PetConnect®" => "Site publié par PetConnect®",
                "SA with a capital of 420 euros" => "SA avec un capital de 420 euros",
                "Head office" => "Siège social",
                "Intra-community VAT no." => "Numéro de TVA intra-communautaire",
                "Chairmen" => "Présidents",
                "Headquarters Location" => "Emplacement du siège social",
                "Tel" => "Tel",
                "Fax" => "Fax",
                "Back end programming manager" => "Responsable de la programmation côté serveur",
                "Front end programming manager" => "Responsable de la programmation côté client",
                "Design manager" => "Responsable de la conception",
                "Publication manager" => "Responsable de la publication",
                "Human Ressources manager" => "Responsable des ressources humaines",
                "Data analyst" => "Analyste de données",
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
            "product" => array(
                "White" => "Blanc",
                "Add to basket" => "Ajouter au panier",
                "Buy this product" => "Acheter ce produit",
                "Ecological Packaging" => "Emballage écologique",
                "Delivery under 48h" => "Livraison sous 48h",
                "Satisfied or reimbursed" => "Satisfait ou remboursé",
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
                "Username:" => "Nom d'utilisateur:",
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
                "Your email has been validated. You can now" => "Votre email a été validé, vous pouvez maintenant",
                "Login" => "vous-identifier"
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

                "My Devices" => "Mes appareils",
                "My Order History" => "Historique de mes commandes",
                "My Payment Methods" => "Mes méthodes de paiement",
                "My Addresses" => "Mes adresses",
                "Manage Users" => "Gérer les utilisateurs",
                "Answer Questions" => "Répondre aux questions",
                "Connection And Security" => "Connexion et sécurité",
                "Message Center" => "Centre de messagerie",

                "Logout" => "Déconnexion",

                "Your Total is" => "Votre total est",
                "Start adding items to your basket" => "Commencez à ajouter des articles à votre panier",
                "Delete all items" => "Supprimer tous les articles",
                "Go to Checkout Page" => "Aller à la page de paiement",

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
                "Shop" => "Magasin"
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
            "terms-of-use" => array(
                "Terms of use" => "Conditions d'utilisation",
                "Welcome to the PetConnect website (the 'Site'). The Site is operated by PetConnect, LLC ('PetConnect,' 'we,' or 'us'). These Terms of Use (these 'Terms') govern your access to and use of the Site, including any content, functionality, and services offered on or through the Site."
                => "Bienvenue sur le site web PetConnect (le 'Site'). Le Site est exploité par PetConnect, LLC ('PetConnect', 'nous' ou 'nous'). Ces conditions d'utilisation (ces 'conditions') régissent votre accès et votre utilisation du site, y compris tout contenu, fonctionnalité et services proposés sur ou via le Site.",
                "By accessing or using the Site, you are accepting these Terms and agreeing to be bound by them. If you do not agree to these Terms, you must not access or use the Site."
                => "En accédant ou en utilisant le Site, vous acceptez ces conditions et vous vous engagez à vous y soumettre. Si vous n'acceptez pas ces conditions, vous ne devez pas accéder ou utiliser le Site.",
                "Use of the Site" => "Utilisation du Site",
                "You may use the Site only for lawful purposes and in accordance with these Terms. You may not use the Site"
                => "Vous pouvez utiliser le Site uniquement à des fins légales et conformément à ces conditions. Vous ne pouvez pas utiliser le Site",
                "In any way that violates any applicable federal, state, local, or international law or regulation." =>
                "De quelconque manière qui viole toute loi ou règlement fédéral, étatique, local ou international applicable.",
                "For the purpose of exploiting, harming, or attempting to exploit or harm minors in any way by exposing them to inappropriate content, asking for personally identifiable information, or otherwise." =>
                "Dans le but d'exploiter, de nuire ou de tenter d'exploiter ou de nuire les mineurs de quelque manière que ce soit en les exposant à un contenu inapproprié, en demandant des informations personnellement identifiables ou autrement.",
                "To transmit, or procure the sending of, any advertising or promotional material, including any 'junk mail,' 'chain letter,' 'spam,' or any other similar solicitation." => "Transmettre ou faciliter l'envoi de tout matériel publicitaire ou promotionnel, y compris tout courrier indésirable, chaîne de lettres, spam ou toute autre sollicitation similaire.",
                "To impersonate or attempt to impersonate PetConnect, a PetConnect employee, another user, or any other person or entity." =>
                "Se faire passer pour ou tenter de se faire passer pour PetConnect, un employé de PetConnect, un autre utilisateur ou toute autre",
                "To engage in any other conduct that restricts or inhibits anyone's use or enjoyment of the Site, or which, as determined by PetConnect, may harm PetConnect or users of the Site or expose them to liability." =>
                "Engager dans tout autre comportement qui restreint ou inhibe l'utilisation ou le plaisir de quiconque sur le Site ou qui, comme déterminé par PetConnect, peut causer des dommages à PetConnect ou aux utilisateurs du site ou les exposer à une responsabilité.",
                "Product Sales" =>
                "Ventes de produits",
                "The Site may offer for sale certain smart collars for dogs ('Products'). By placing an order for a Product, you are offering to purchase the Product on and subject to these Terms. All orders are subject to availability and confirmation of the order price." =>
                "Le Site peut offrir à la vente certains colliers intelligents pour chiens ('Produits'). En passant une commande pour un produit, vous offrez d'acheter le produit et de vous soumettre à ces conditions. Toutes les commandes sont soumises à disponibilité et confirmation du prix de la commande.",
                "Warranty Disclaimer" =>
                "Clause de non-garantie",
                "The Site, including all content, functionality, and services offered on or through the Site, are provided 'as is,' 'as available,' and 'with all faults.' PetConnect makes no representations or warranties of any kind, express or implied, as to the operation of the Site or the information, content, materials, or products included on the Site." =>
                "Le Site, y compris tout le contenu, les fonctionnalités et les services proposés sur ou via le Site, sont fournis 'tels quels', 'tels qu'ils sont disponibles' et 'avec tous les défauts'. PetConnect ne fait aucune représentation ou garantie de quelque nature que ce soit, expresse ou implicite, quant au fonctionnement du Site ou aux informations, contenus, matériaux ou produits inclus sur le Site.",
                "Limitation of Liability" => "Limitation de responsabilité",
                "In no event shall PetConnect, its directors, officers, employees, agents, partners, or suppliers be liable for any damages whatsoever, including without limitation, direct, indirect, special, incidental, or consequential damages, arising out of or in connection with the use, inability to use, or performance of the Site or the products offered on the Site." =>
                "Dans aucun cas, PetConnect, ses directeurs, officiers, employés, agents, partenaires ou fournisseurs ne seront responsables des dommages de quelque nature que ce soit, y compris, sans limitation, les dommages directs, indirects, spéciaux, accessoires ou consécutifs, découlant de ou en relation avec l'utilisation, l'incapacité d'utiliser ou la performance du Site ou des produits proposés sur le Site.",
                "Changes to These Terms" => "Modifications de ces termes",
                "PetConnect reserves the right to make changes to these Terms at any time. Your continued use of the Site following the posting of any changes to these Terms will mean you accept those changes." => "PetConnect se réserve le droit de modifier ces termes à tout moment. Votre utilisation continue du Site après la publication de toutes les modifications apportées à ces termes signifie que vous acceptez ces modifications.",
                "Contact Us" => "Nous contacter",
                "If you have any questions about these Terms, please contact us at petconnecttech@gmail.com." => "Si vous avez des questions sur ces termes, veuillez nous contacter à petconnecttech@gmail.com.",
            ),

            // PHP PROCESSES
            "checkout-process" => array(
                "Thank you for buying our products" => "Merci d'avoir acheté nos produits",
            ),
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
            "product-buttons" => array(
                "white" => "Blanc",
                "blue" => "Bleu",
                "green" => "Vert",
                "red" => "Rouge",
                "yellow" => "Jaune",
                "black" => "Noir",
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
        //        "Russian" => array(
        //        ),

    );
}
