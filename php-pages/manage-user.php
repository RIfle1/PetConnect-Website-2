<?php
session_start();
include '../php-processes/dbConnection.php';
include '../php-processes/manage-user-table-generator.php';
include 'site-header.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];
$clientInfo = "";
$adminInfo = "";

if ($clientLoggedIn || !$loggedIn) {
    header("Location: ../php-pages/restricted-access.php", true,303);
    exit;
}

$clientInfoSql = "SELECT * FROM client ORDER BY cltUsername";
$result = runSQLResult($clientInfoSql);

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
    <link rel="stylesheet" href="../css/manage-user-styles.css">

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

    <div class="mg-search-filter-div">
        <!--CLIENT FILTER DIV-->
        <div class="mg-filter-div">
            <label for="clt-filter-selector">Filter By</label>
            <select name="clt-filter-selector" id="clt-filter-selector">
                <option value="cltUsername">Client Username</option>
                <option value="cltFirstName">Client First Name</option>
                <option value="cltLastName">Client Last Name</option>
                <option value="cltEmail">Client Email</option>
            </select>
        </div>
        <!--CLIENT FILTER DIV-->
<!--        CLIENT SEARCH DIV-->
        <div class="mg-search-div">
            <input id="clt-search-input" name="clt-search-input" type="text" placeholder="Search in client...">
            <button></button>
        </div>
<!--        CLIENT SEARCH DIV-->
    </div>



    <div class="mg-table-separation-line"></div>

    <div class="mg-table-div">
        <table id="mg-table-info-clt">
            <tr class="mg-table-header-row">
                <th class="mg-table-header">Client ID</th>
                <th class="mg-table-header">Client Username</th>
                <th class="mg-table-header">Client First Name</th>
                <th class="mg-table-header">Client Last Name</th>
                <th class="mg-table-header">Client Email</th>
                <th class="mg-table-header">Client Phone Number</th>
                <th colspan="3" id="mg-table-control-panel">Client Control Panel</th>
            </tr>
<!--            CLIENT TABLE GENERATION-->
            <?php  generateTable('client','cltUsername','cltID','clt'); ?>
<!--            CLIENT TABLE GENERATION-->
        </table>
    </div>

    <div class="mg-table-separation-line"></div>

    <div id="mg-header-2-div">
        <h1>Gérer les administrateurs</h1>
    </div>

    <div class="mg-table-separation-line"></div>
    <div class="mg-filter-div">
        <form id="adm-submit-filter" name="search-form" action="../php-processes/manage-client-table.php" method="post">
            <label for="adm-filter-selector">Filter By</label>
            <select name="adm-filter-selector" id="adm-filter-selector">
                <option value="admUsername">Admin Username</option>
                <option value="admFirstName">Admin First Name</option>
                <option value="admLastName">Admin Last Name</option>
                <option value="admEmail">Admin Email</option>
            </select>
        </form>
    </div>

    <div class="mg-table-separation-line"></div>

    <div class="mg-table-div">
        <table>
            <tr class="mg-table-header-row">
                <th class="mg-table-header">Admin ID</th>
                <th class="mg-table-header">Admin Username</th>
                <th class="mg-table-header">Admin First Name</th>
                <th class="mg-table-header">Admin Last Name</th>
                <th class="mg-table-header">Admin Email</th>
                <th class="mg-table-header">Admin Phone Number</th>
                <th colspan="3" id="mg-table-control-panel">Admin Control Panel</th>
            </tr>
<!--            ADMIN TABLE GENERATION-->
            <?php  generateTable('admin','admUsername','admID','adm'); ?>
<!--            ADMIN TABLE GENERATION-->
        </table>
    </div>

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
