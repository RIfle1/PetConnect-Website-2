<?php
include 'site-header.php';

if(!empty($_SESSION['admID'])) {
    $sql = "SELECT * FROM client";
    $result = runSQLResult($sql);
}else {
    $result = '';
}
?>

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
    <link rel="stylesheet" href="../css/manage-client-styles.css">
    <script src="../javaScript/manage-client-buttons.js"></script>
    <title>manage-client</title>
</head>
<body>
<div>
    <div>
        <form name="search-form" action="" method="post">
            <label for="manage-client-search"><input id="manage-client-search" type="text"></label>
            <input type="submit" value="Submit">
        </form>
    </div>
    <div>
        <table>
            <tr>
                <th>Client ID</th>
                <th>Client Username</th>
                <th>Client First Name</th>
                <th>Client Last Name</th>
                <th>Client Email</th>
                <th>Client Phone Number</th>
            </tr>
            <?php while($clientInfo = $result->fetch_array()): ?>
                <tr>
                    <td><?php echo $clientInfo['cltID'] ?></td>
                    <td><?php echo $clientInfo['cltUsername'] ?></td>
                    <td><?php echo $clientInfo['cltFirstName'] ?></td>
                    <td><?php echo $clientInfo['cltLastName'] ?></td>
                    <td><?php echo $clientInfo['cltEmail'] ?></td>
                    <td><?php echo $clientInfo['cltPhoneNumber'] ?></td>
                    <form>
                        <td>
                            <button name="delete-button-<?php echo $clientInfo['cltID'] ?>" type="button">
                                Submit Changes
                            </button>
                        </td>
                        <td>
                            <button name="promote-button-<?php echo $clientInfo['cltID'] ?>" type="button">
                                Promote User
                            </button>
                        </td>
                        <td>
                            <button name="submit-button-<?php echo $clientInfo['cltID'] ?>" type="button">
                                Submit Changes
                            </button>
                        </td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>
<?php include "site-footer.php";?>
</body>
</html>
