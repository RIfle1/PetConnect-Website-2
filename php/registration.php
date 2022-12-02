<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/registration.css">
    <title>PetConnect</title>
</head>
<body>

<?php
include '../html/registration-header.html';
include 'entities.php';
?>

<form name="form" action="registration.php" method="post">
    <div class="form-body">
        <div class="login-form">
            <h1>Create an account</h1>
            <div>
                Username:
                <label for="cltUsername-input">
                    <input type="text" name="cltUsername-input">
                </label>
            </div>
            <div>
                First Name:
                <label for="cltFirstName-input">
                    <input type="text" name="cltFirstName-input">
                </label>
            </div>
            <div>
                Last Name:
                <label for="cltLastName-input">
                    <input type="text" name="cltLastName-input">
                </label>
            </div>
            <div>
                Email:
                <label for="cltEmail-input">
                    <input type="email" name="cltEmail-input">
                </label>
            </div>
            <div>
                Phone Number:
                <label for="cltPhoneNumber-input">
                    <input type="number" name="cltPhoneNumber-input">
                </label>
            </div>
            <div>
                Password:
                <label for="cltPassword-input">
                    <input type="password" name="cltPassword-input">
                </label>
            </div>
            <div>
                Enter your password again:
                <label for="cltPasswordVer-input">
                    <input type="password" name="cltPasswordVer-input">
                </label>
            </div>
            <div>
                <button type="submit" name="submit-button">Create an Account</button>
            </div>
            <div>
                <p>By creating an account, you agree to PetConnect's <a href="#">Conditions of Use</a> and <a href="#">Privacy
                        Notice</a>.</p>
            </div>
            <div class="separation-line-small"></div>
            <div>
                <p>Already have an account? <a href="#">Sign in &rarr;</a></p>
            </div>

        </div>

    </div>

</form>

<?php

$inputList =
    ["cltUsername-input",
        "cltFirstName-input",
        "cltLastName-input",
        "cltEmail-input",
        "cltPhoneNumber-input",
        "cltPassword-input"
    ];

// Returns True if one of the fields is empty
function checkEmptyInput($inputList): string
{
    $itemBoolList = array();
    $itemBoolListSum = 0;

    for ($index = 0; $index < count($inputList); $index++ ) {
        $item = $inputList[$index];
        $itemBool = !(empty($_POST[$item]));
        if($itemBool == 0) {
            $itemBoolList[] = 0;
        }
        else{
            $itemBoolList[] = 1;
        }
    }
    for ($index = 0; $index < count($itemBoolList); $index++) {
        $itemBoolListSum += $itemBoolList[$index];
    }


    if ($itemBoolListSum < count($itemBoolList)) {
        return "True";
    }
    else {
        return "False";
    }
}


if(checkEmptyInput($inputList) == "False") {
    $newUserInfo = new Client
    (
        $_GET["cltUsername-input"],
        $_GET["cltFirstName-input"],
        $_GET["cltLastName-input"],
        $_GET["cltEmail-input"],
        $_GET["cltPhoneNumber-input"],
        $_GET["cltPassword-input"]
    );

    echo $newUserInfo->getCltID(),
    $newUserInfo->getCltUsername(),
    $newUserInfo->getCltFirstName(),
    $newUserInfo->getCltLastName(),
    $newUserInfo->getCltUsername(),
    $newUserInfo->getCltEmail(),
    $newUserInfo->getCltPhoneNumber(),
    $newUserInfo->getCltPassword();
}

?>

<?php
include '../html/registration-footer.html';
?>

</body>
</html>