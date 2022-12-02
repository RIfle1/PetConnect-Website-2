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

<form action="registration.php" method="post">
    <div class="form-body">

        <div class="login-form">
            <h1>Create an account</h1>
            <div>
                Username:
                <label for="username">
                    <input type="text" name="username">
                </label>
            </div>
            <div>
                First Name:
                <label for="firstName">
                    <input type="text" name="firstName">
                </label>
            </div>
            <div>
                Last Name:
                <label for="lastName">
                    <input type="text" name="lastName">
                </label>
            </div>
            <div>
                Email:
                <label for="email">
                    <input type="email" name="email">
                </label>
            </div>
            <div>
                Phone Number:
                <label for="phoneNumber">
                    <input type="number" name="phoneNumber">
                </label>
            </div>
            <div>
                Password:
                <label for="password">
                    <input type="text" name="password">
                </label>
            </div>
            <div>
                Enter your password again:
                <label for="password">
                    <input type="text" name="password">
                </label>
            </div>
            <div>
                <button type="submit">Create an Account</button>
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
    <?php
//    $newUserInfo = new Client($_GET[""])
//    echo findMax(array(1,2,3,300,5,6,7,8,9,10));
    echo idToInt('clt_001_app_002', 'app');
    ?>
</form>

<?php
include '../html/registration-footer.html';
?>

</body>
</html>