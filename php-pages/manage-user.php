<?php
session_start();
if(empty($_SESSION['admID'])) {
    header("Location: login.php", true, 303);
    exit;
} else {
    include '../php-processes/dbConnection.php';
    include 'site-header.php';

    $sql = "SELECT * FROM client ORDER BY cltUsername";

    $result = runSQLResult($sql);
}
$tableRowNumber = 1;
$tableCell = 0;
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

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous">
    </script>

    <script src="../javaScript/css-functions.js"></script>
    <script src="../javaScript/manage-client-buttons.js"></script>

    <title>manage-client</title>
</head>
<body>
<div id="mg-main-div" class="text-font-700">

    <div id="mg-header-1-div">
        <h1>Gérer les utilisateurs</h1>
    </div>

    <div class="mg-table-separation-line"></div>

    <div id="mg-search-div">
        <form id="submit-filter" name="search-form" action="../php-processes/manage-client-table.php" method="post">
            <label for="filter-selector">Filter By</label>
            <select name="filter-selector" id="filter-selector">
                <option value="cltUsername">Client Username</option>
                <option value="cltFirstName">Client First Name</option>
                <option value="cltLastName">Client Last Name</option>
                <option value="cltEmail">Client Email</option>
            </select>

<!--            <button id="submit-filter"-->
<!--                    type="button">-->
<!--                Submit Filter-->
<!--            </button>-->

        </form>
    </div>

    <div class="mg-table-separation-line"></div>

    <div id="mg-table-div">
        <table>
            <tr>
                <th class="mg-table-header">Client ID</th>
                <th class="mg-table-header">Client Username</th>
                <th class="mg-table-header">Client First Name</th>
                <th class="mg-table-header">Client Last Name</th>
                <th class="mg-table-header">Client Email</th>
                <th class="mg-table-header">Client Phone Number</th>
                <th colspan="3" id="mg-table-control-panel">Control Panel</th>
            </tr>

            <?php while($clientInfo = $result->fetch_array()): ?>
                <?php
                $commonClass =  "mg-info-row-".$clientInfo['cltID'];
                $personalCellID = "mg-cell-";
                $cltID = $clientInfo['cltID'];
                if ($tableRowNumber == 1) {
                    $tableRowNumber = 2;
                }
                else {
                    $tableRowNumber = 1;
                }
                $tableCell ++;
                ?>
                <tr class="mg-table-row-<?php echo $tableRowNumber ?>">
                    <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>cltID-<?php echo $tableCell?>"><?php echo $clientInfo['cltID'] ?></td>
                    <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>cltUsername-<?php echo $tableCell?>"><?php echo $clientInfo['cltUsername'] ?></td>
                    <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>cltFirstName-<?php echo $tableCell?>"><?php echo $clientInfo['cltFirstName'] ?></td>
                    <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>cltLastName-<?php echo $tableCell?>"><?php echo $clientInfo['cltLastName'] ?></td>
                    <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>cltEmail-<?php echo $tableCell?>"><?php echo $clientInfo['cltEmail'] ?></td>
                    <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>cltPhoneNumber-<?php echo $tableCell?>"><?php echo $clientInfo['cltPhoneNumber'] ?></td>
                    <!--                        Delete Button-->
                    <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>delete-control-<?php echo $tableCell?>">
                        <button class="delete-button-id-<?php echo $cltID ?>"
                                id="<?php echo $personalCellID ?>deleteBtn-<?php echo $tableCell?>"
                                name="delete-button"
                                type="button"
                                value="<?php echo $cltID ?>">Delete User</button>
                        <script>
                            setButton("delete-button-id", "<?php echo $personalCellID ?>deleteBtn-<?php echo $tableCell?>")
                        </script>
                    </td>
                    <!--                        Promote Button-->
                    <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>promote-control-<?php echo $tableCell?>">
                        <button class="promote-button-id-<?php echo $cltID ?>"
                                id="<?php echo $personalCellID ?>promoteBtn-<?php echo $tableCell?>"
                                name="promote-button"
                                type="button"
                                value="<?php echo $cltID ?>">Promote User</button>
                        <script>
                            setButton("promote-button-id", "<?php echo $personalCellID ?>promoteBtn-<?php echo $tableCell?>")
                        </script>
                        <?php if (isModerator($cltID)): ?>
                            <script>
                                setPromoteButtonStyle('<?php echo $cltID ?>', "grey", '#69A6E3', "Promoted");
                            </script>
                        <?php endif; ?>
                    </td>
                    <!--                        Submit Button-->
                    <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>submit-control-<?php echo $tableCell?>">

                        <button class="submit-button-id-<?php echo $cltID ?>"
                                id="<?php echo $personalCellID ?>submitBtn-<?php echo $tableCell?>"
                                name="submit-button"
                                type="button"
                                value="<?php echo $cltID ?>">Submit Changes</button>
                        <script>
                            setButton("submit-button-id", "<?php echo $personalCellID ?>submitBtn-<?php echo $tableCell?>")
                        </script>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    </div>

    <div class="mg-table-separation-line"></div>

    <div id="mg-header-2-div">
        <h1>Gérer les administrateurs</h1>
    </div>

    <div class="mg-table-separation-line"></div>

</div>
<?php include "site-footer.php";?>
<script type="text/javascript">
    setMarginTop('.site-header-main-header', 'mg-main-div', 40)
    window.addEventListener("resize", function(event) {
        setMarginTop('.site-header-main-header', 'mg-main-div', 40)
    })
</script>
<script src="../javaScript/manage-client-buttons.js"></script>
</body>
</html>
