<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
<!--    <link rel="stylesheet" href="../css/signup.css">-->
    <title>PetConnect Signup</title>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="../javaScript/validation.js" defer></script>
</head>
<body>

<?php
include '../html/signup-header.html';
?>

<form name="signup-form" action="signup-process.php" id="signup-form" method="post" novalidate>
    <div class="form-body">
        <div class="signup-form">
            <h1>Create an account</h1>
            <div>
                <label for="cltUsername-input">Username:</label>
                <input type="text" id="cltUsername-input" name="cltUsername-input">
            </div>
            <div>
                <label for="cltFirstName-input">First Name:</label>
                <input type="text" id="cltFirstName-input" name="cltFirstName-input">
            </div>
            <div>
                <label for="cltLastName-input">Last Name:</label>
                <input type="text" id="cltLastName-input" name="cltLastName-input">
            </div>
            <div>
                <label for="cltEmail-input">Email:</label>
                <input type="email" id="cltEmail-input" name="cltEmail-input">
            </div>
            <div>
                <label for="cltPhoneNumber-input">Phone Number:</label>
                <input type="text" id="cltPhoneNumber-input" name="cltPhoneNumber-input">
            </div>
            <div>
                <label for="cltPassword-input">Password:</label>
                <input type="password" id="cltPassword-input" name="cltPassword-input">
            </div>
            <div>
                <label for="cltPasswordConfirmation-input">Enter your password again:</label>
                <input type="password" id="cltPasswordConfirmation-input" name="cltPasswordConfirmation-input">
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
                <p>Already have an account? <a href="login.php">Sign in &rarr;</a></p>
            </div>

        </div>

    </div>

</form>

<?php
include '../html/signup-footer.html';
?>

</body>
</html>