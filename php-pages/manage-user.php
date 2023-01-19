<?php
session_start();
include '../php-processes/dbConnection.php';
onlyAdminPage();
include 'site-header.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];
$clientInfo = "";
$adminInfo = "";

$languageList = returnLanguageList()[returnLanguage()]['manage-user'];
$javaScriptLanguageList = returnLanguageList()[returnLanguage()]['manage-user-buttons'];

?>
<!doctype html>
<html lang="en">
<head>

    <link rel="stylesheet" href="../css/manage-user-styles.css">
    <title><?php echo $languageList["Manage Clients"]?></title>
</head>
<body>

<script>
    let javaScriptLanguageList = <?php echo json_encode($javaScriptLanguageList) ?>;
    let adminList = <?php echo json_encode(returnEntityList('admin','ASC', 'admUsername')) ?>;
    let clientList = <?php echo json_encode(returnEntityList('client','ASC', 'cltUsername')) ?>;
</script>

<div id="mg-main-div" class="text-font-700">

    <div id="mg-header-1-div">
        <h1><?php echo $languageList["Manage Clients"]?></h1>
    </div>

    <div class="separation-line-2"></div>

    <div class="mg-search-filter-div">
        <label for="clt-filter-input"><?php echo $languageList["Filter By"]?></label>
        <select name="clt-filter-input" id="clt-filter-input">
            <option value="cltUsername"><?php echo $languageList["Client Username"]?></option>
            <option value="cltEmail"><?php echo $languageList["Client Email"]?></option>
            <option value="cltSignupDate"><?php echo $languageList["Client Signup Date"]?></option>
        </select>
        <select name="clt-order-input" id="clt-order-input">
            <option value="ASC"><?php echo $languageList["Ascending"]?></option>
            <option value="DESC"><?php echo $languageList["Descending"]?></option>
        </select>
        <input id="clt-search-input" name="clt-search-input" type="text" placeholder="<?php echo $languageList['Search in client...']?>">
        <button id="clt-search-submit" name="clt-search-submit" type="button"><?php echo $languageList["Submit Search"]?></button>
    </div>

    <div class="separation-line-2"></div>

    <div class="mg-table-flex-div">
        <div class="mg-table-div">
            <table id="mg-table-info-clt">
                <tbody>
                <tr class="mg-table-header-row">
                    <th class="mg-table-header"><?php echo $languageList["Client Username"]?></th>
                    <th class="mg-table-header"><?php echo $languageList["Client Email"]?></th>
                    <th class="mg-table-header"><?php echo $languageList["Client Signup Date"]?></th>
                    <th id="mg-table-header-control-clt" colspan="3"><?php echo $languageList["Client Control Panel"]?></th>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mg-table-control-div">

        </div>
    </div>

    <div class="separation-line-2"></div>

    <div id="mg-header-2-div">
        <h1><?php echo $languageList["Manage Administrators"]?></h1>
    </div>

    <div class="separation-line-2"></div>

    <div class="mg-search-filter-div">
        <label for="adm-filter-input"><?php echo $languageList["Filter By"]?></label>
        <select name="adm-filter-input" id="adm-filter-input">
            <option value="admUsername"><?php echo $languageList["Admin Username"]?></option>
            <option value="admEmail"><?php echo $languageList["Admin Email"]?></option>
            <option value="admSignupDate"><?php echo $languageList["Admin Signup Date"]?></option>
        </select>
        <select name="adm-order-input" id="adm-order-input">
            <option value="ASC"><?php echo $languageList["Ascending"]?></option>
            <option value="DESC"><?php echo $languageList["Descending"]?></option>
        </select>
        <input id="adm-search-input" name="adm-search-input" type="text" placeholder="<?php echo $languageList['Search in admin...']?>">
        <button id="adm-search-submit" name="adm-search-submit" type="button"><?php echo $languageList["Submit Search"]?></button>
    </div>

    <div class="separation-line-2"></div>

    <div class="mg-table-flex-div">
        <div class="mg-table-div">
            <table id="mg-table-info-adm">
                <tbody>
                <tr class="mg-table-header-row">
                    <th class="mg-table-header"><?php echo $languageList["Admin Username"]?></th>
                    <th class="mg-table-header"><?php echo $languageList["Admin Email"]?></th>
                    <th class="mg-table-header"><?php echo $languageList["Admin Signup Date"]?></th>
                    <th id="mg-table-header-control-adm" colspan="2"><?php echo $languageList["Admin Control Panel"]?></th>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mg-table-control-div">

        </div>
    </div>

</div>

<?php include '../php-pages/site-footer.php' ?>

<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'mg-main-div', 'id', 40)
    setMarginTopFooter('mg-main-div', 'id', 'site-footer-main-div', 'id', 0)
</script>

<script src="../javaScript/manage-user-buttons.js"></script>

</body>
</html>
