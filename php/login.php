<?php include '../php/site-header.php' ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/sign-styles.css">
    <title>PetConnect Login</title>
</head>
<body>

<form name="login-form" action="login-process.php" method="post">
    <div id="sign-form-body" class="text-font-700">
        <div id="sign-form-body-div">
            <div class="sign-form-elem"><h1>Sign in</h1></div>
            <div id="login-Invalid">
                <?php if ($_GET['isInvalid'] ?? ""): ?>
                    <em>Invalid Login</em>
                <?php endif; ?>
            </div>
            <div class="sign-form-elem">
                <label for="lgEmail-input">Email:</label>
                <input type="email" id="lgEmail-input" name="lgEmail-input"
                       value="<?= htmlspecialchars($_GET["lgEmail-input"] ?? "") ?>" required>
            </div>
            <div class="sign-form-elem">
                <label for="lgPassword-input">Password:</label>
                <input type="password" id="lgPassword-input" name="lgPassword-input" required>
            </div>
            <div class="sign-form-elem">
                <button type="submit" name="submit-button">Login</button>
            </div>
            <div class="sign-separation-line-small"></div>
            <div class="sign-form-elem">
                <p>Don't have an account? <a href="signup.php">Signup &rarr;</a></p>
            </div>
        </div>
    </div>
</form>

<?php include '../php/site-footer.php' ?>
</body>
</html>
