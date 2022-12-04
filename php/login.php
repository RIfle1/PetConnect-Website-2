<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <!--    <link rel="stylesheet" href="../css/signup.css">-->
    <title>PetConnect Login</title>
</head>
<body>

<form name="login-form" action="login-process.php" method="post">
    <div class="form-body">
        <div class="login-form">
            <h1>Login</h1>
            <div>
                <?php if ($_GET['isInvalid'] ?? ""):?>
                    <em>Invalid Login</em>
                <?php endif; ?>
            </div>
            <div>
                <label for="lgEmail-input">Email:</label>
                <input type="email" id="lgEmail-input" name="lgEmail-input"
                       value="<?= htmlspecialchars($_GET["lgEmail-input"] ?? "") ?>" required>
            </div>
            <div>
                <label for="lgPassword-input">Password:</label>
                <input type="password" id="lgPassword-input" name="lgPassword-input" required>
            </div>
            <div>
                <button type="submit" name="submit-button">Create an Account</button>
            </div>
            <div class="separation-line-small"></div>
            <div>
                <p>Don't have an account? <a href="signup.php">Signup &rarr;</a></p>
            </div>
        </div>
    </div>
</form>



</body>
</html>
