<?php
include 'dbConnection.php';

class Client
{
    private string $cltID;
    private string $cltUsername;
    private string $cltFirstName;
    private string $cltLastName;
    private string $cltEmail;
    private int $cltPhoneNumber;
    private string $cltPassword;

    /**
     * @param $cltID
     * @param $cltUsername
     * @param $cltFirstName
     * @param $cltLastName
     * @param $cltEmail
     * @param $cltPhoneNumber
     * @param $cltPassword
     */

    public function __construct($cltID, $cltUsername, $cltFirstName, $cltLastName, $cltEmail, $cltPhoneNumber, $cltPassword)
    {
        $this->cltID = $cltID;
        $this->cltUsername = $cltUsername;
        $this->cltFirstName = $cltFirstName;
        $this->cltLastName = $cltLastName;
        $this->cltEmail = $cltEmail;
        $this->cltPhoneNumber = $cltPhoneNumber;
        $this->cltPassword = $cltPassword;
    }

    function autoSetCltID(): void
    {
        $this->cltID = autoSetID("cltID", "Client", "clt");
    }

    /**
     * @return string
     */
    public function getCltID(): string
    {
        return $this->cltID;
    }

    /**
     * @param string $cltID
     */
    public function setCltID(string $cltID): void
    {
        $this->cltID = $cltID;
    }

    /**
     * @return string
     */
    public function getCltUsername(): string
    {
        return $this->cltUsername;
    }

    /**
     * @param string $cltUsername
     */
    public function setCltUsername(string $cltUsername): void
    {
        $this->cltUsername = $cltUsername;
    }

    /**
     * @return string
     */
    public function getCltFirstName(): string
    {
        return $this->cltFirstName;
    }

    /**
     * @param string $cltFirstName
     */
    public function setCltFirstName(string $cltFirstName): void
    {
        $this->cltFirstName = $cltFirstName;
    }

    /**
     * @return string
     */
    public function getCltLastName(): string
    {
        return $this->cltLastName;
    }

    /**
     * @param string $cltLastName
     */
    public function setCltLastName(string $cltLastName): void
    {
        $this->cltLastName = $cltLastName;
    }

    /**
     * @return string
     */
    public function getCltEmail(): string
    {
        return $this->cltEmail;
    }

    /**
     * @param string $cltEmail
     */
    public function setCltEmail(string $cltEmail): void
    {
        $this->cltEmail = $cltEmail;
    }

    /**
     * @return int
     */
    public function getCltPhoneNumber(): int
    {
        return $this->cltPhoneNumber;
    }

    /**
     * @param int $cltPhoneNumber
     */
    public function setCltPhoneNumber(int $cltPhoneNumber): void
    {
        $this->cltPhoneNumber = $cltPhoneNumber;
    }

    /**
     * @return string
     */
    public function getCltPassword(): string
    {
        return $this->cltPassword;
    }

    /**
     * @param string $cltPassword
     */
    public function setCltPassword(string $cltPassword): void
    {
        $this->cltPassword = $cltPassword;
    }

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

function runSQLResult($query) : bool|mysqli_result
{
    $conn = OpenCon();
    $result = mysqli_query($conn, $query);
    CloseCon($conn);
    return $result;
}

function returnLastIDString($id, $table, $idFormat) : string {

    $lastID = returnLastIDInt($id, $table, $idFormat);

    $result2 = runSQLResult("SELECT $id FROM $table WHERE $id LIKE '%".$lastID."'");
    if (mysqli_num_rows($result2) > 0) {
        $row2 = $result2->fetch_assoc();
        $lastCltID = $row2["cltID"];
    }
    else{
        $lastCltID = 'No Value';
    }
    return $lastCltID;
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
