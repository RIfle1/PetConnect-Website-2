<?php
include 'dbConnection.php';

class Client
{
    public string $cltID;
    public string $cltUsername;
    public string $cltFirstName;
    public string $cltLastName;
    public string $cltEmail;
    public int $cltPhoneNumber;
    public string $cltPassword;
    public string $cltToken;

    /**
     * @param $cltUsername
     * @param $cltFirstName
     * @param $cltLastName
     * @param $cltEmail
     * @param $cltPhoneNumber
     * @param $cltPassword
     */

    public function __construct($cltUsername, $cltFirstName, $cltLastName, $cltEmail, $cltPhoneNumber, $cltPassword)
    {
        $this->cltID = autoSetCltID();
        $this->cltUsername = $cltUsername;
        $this->cltFirstName = $cltFirstName;
        $this->cltLastName = $cltLastName;
        $this->cltEmail = $cltEmail;
        $this->cltPhoneNumber = $cltPhoneNumber;
        $this->cltPassword = $cltPassword;
        $this->cltToken = generateToken(autoSetCltID());
    }

    /**
     * @return string
     */
    public function getCltID(): string
    {
        return $this->cltID;
    }

    /**
     * @return string
     */
    public function getCltUsername(): string
    {
        return $this->cltUsername;
    }


    /**
     * @return string
     */
    public function getCltFirstName(): string
    {
        return $this->cltFirstName;
    }


    /**
     * @return string
     */
    public function getCltLastName(): string
    {
        return $this->cltLastName;
    }

    /**
     * @return string
     */
    public function getCltEmail(): string
    {
        return $this->cltEmail;
    }

    /**
     * @return int
     */
    public function getCltPhoneNumber(): int
    {
        return $this->cltPhoneNumber;
    }

    /**
     * @return string
     */
    public function getCltPassword(): string
    {
        return $this->cltPassword;
    }

    /**
     * @return string
     */
    public function getCltToken(): string
    {
        return $this->cltToken;
    }


}

// DEPRECATED
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

function autoSetCltID(): string
{
    return autoSetID("clt");
}
