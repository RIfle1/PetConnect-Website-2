<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];
$clientInfo = "";
$adminInfo = "";

adminPage();
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
    <script src="../javaScript/manage-user-buttons.js"></script>

    <title>USER MANAGEMENT</title>
</head>
<body>

<div id="mg-main-div" class="text-font-700">

    <div id="mg-header-1-div">
        <h1>Gérer les utilisateurs</h1>
    </div>

    <div class="mg-table-separation-line"></div>

    <div class="mg-search-filter-div">
        <!--CLIENT FILTER -->
        <div class="mg-filter-div">
            <label for="clt-filter-input">Filter By</label>
            <select name="clt-filter-input" id="clt-filter-input">
                <option value="cltUsername">Client Username</option>
                <option value="cltFirstName">Client First Name</option>
                <option value="cltLastName">Client Last Name</option>
                <option value="cltEmail">Client Email</option>
                <option value="cltSignupDate">Client Signup Date</option>
            </select>
            <select name="clt-order-input" id="clt-order-input">
                <option value="ASC">Ascending</option>
                <option value="DESC">Descending</option>
            </select>
        </div>
        <!--CLIENT FILTER -->
<!--        CLIENT SEARCH -->
        <div class="mg-search-div">
            <input id="clt-search-input" name="clt-search-input" type="text" placeholder="Search in client...">
            <button id="clt-search-submit" name="clt-search-submit" type="button">Submit Search</button>
        </div>
<!--        CLIENT SEARCH -->
    </div>

    <div class="mg-table-separation-line"></div>

    <div class="mg-table-div">
        <table id="mg-table-info-clt">
            <tr class="mg-table-header-row">
<!--                <th class="mg-table-header">Client ID</th>-->
                <th class="mg-table-header">Client Username</th>
                <th class="mg-table-header">Client First Name</th>
                <th class="mg-table-header">Client Last Name</th>
                <th class="mg-table-header">Client Email</th>
                <th class="mg-table-header">Client Phone Number</th>
                <th class="mg-table-header">Client Signup Date</th>
                <th class="mg-table-header" id="mg-table-header-control" colspan="3">Client Control Panel</th>
            </tr>
<!--            CLIENT TABLE GENERATION-->
            <script>
                printTable('clt',"../php-processes/manage-user-table.php?sortBy=cltUsername&orderBy=ASC&ID=client")
            </script>
<!--            CLIENT TABLE GENERATION-->

        </table>
    </div>

    <div class="mg-table-separation-line"></div>

    <div id="mg-header-2-div">
        <h1>Gérer les administrateurs</h1>
    </div>

    <div class="mg-table-separation-line"></div>

    <div class="mg-search-filter-div">
        <!--ADMIN FILTER -->
        <div class="mg-filter-div">
            <label for="adm-filter-input">Filter By</label>
            <select name="adm-filter-input" id="adm-filter-input">
                <option value="admUsername">Admin Username</option>
                <option value="admFirstName">Admin First Name</option>
                <option value="admLastName">Admin Last Name</option>
                <option value="admEmail">Admin Email</option>
                <option value="admSignupDate">Admin Signup Date</option>
            </select>
            <select name="adm-order-input" id="adm-order-input">
                <option value="ASC">Ascending</option>
                <option value="DESC">Descending</option>
            </select>
        </div>
        <!--ADMIN FILTER -->
        <!--        ADMIN SEARCH -->
        <div class="mg-search-div">
            <input id="adm-search-input" name="adm-search-input" type="text" placeholder="Search in admin...">
            <button id="adm-search-submit" name="adm-search-submit" type="button">Submit Search</button>
        </div>
        <!--        ADMIN SEARCH -->
    </div>

    <div class="mg-table-separation-line"></div>

    <div class="mg-table-div">
        <table id="mg-table-info-adm">
            <tr class="mg-table-header-row">
<!--                <th class="mg-table-header">Admin ID</th>-->
                <th class="mg-table-header">Admin Username</th>
                <th class="mg-table-header">Admin First Name</th>
                <th class="mg-table-header">Admin Last Name</th>
                <th class="mg-table-header">Admin Email</th>
                <th class="mg-table-header">Admin Phone Number</th>
                <th class="mg-table-header">Admin Signup Date</th>
                <th class="mg-table-header" id="mg-table-header-control" colspan="2">Admin Control Panel</th>
            </tr>
<!--            ADMIN TABLE GENERATION-->
            <script>
                printTable('adm','../php-processes/manage-user-table.php?sortBy=admUsername&orderBy=ASC&ID=admin')
            </script>
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
<script src="../javaScript/manage-user-buttons.js"></script>

</body>
</html>
