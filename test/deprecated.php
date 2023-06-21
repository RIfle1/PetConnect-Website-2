<?php
//include '../php-processes/dbConnection.php';
$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

if($clientLoggedIn || !$loggedIn || !$adminLoggedIn) {
    $_SESSION['errorMsg'] = 'You do not have access to this page, if you think this is a mistake contact the web developer';
    header("Location: ../php-pages/restricted-access.php", true,303);
}

function generateTable($entityName, $orderBy, $ID, $IDLetters): void
{

$tableRowNumber = 1;
$tableCell = 0;
$entityInfoSql = "SELECT * FROM ".$entityName." ORDER BY $orderBy";
$entityResult = runSQLQuery($entityInfoSql);
?>
<!--<table>-->
<?php while($entityInfo = $entityResult->fetch_array()): ?>
    <?php
        $entityID = $entityInfo[$ID];
        $commonClass =  "mg-info-row-".$entityInfo[$ID];
        $personalCellID = "mg-cell-";

        if ($tableRowNumber == 1) {
            $tableRowNumber = 2;
        }
        else {
            $tableRowNumber = 1;
        }
        $tableCell ++;
    ?>
    <tr class="mg-table-row-<?php echo $tableRowNumber ?>">
        <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?><?php echo $IDLetters ?>ID-<?php echo $tableCell?>"><?php echo $entityInfo[$ID] ?></td>
        <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?><?php echo $IDLetters ?>Username-<?php echo $tableCell?>"><?php echo $entityInfo[$IDLetters.'Username'] ?></td>
        <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?><?php echo $IDLetters ?>FirstName-<?php echo $tableCell?>"><?php echo $entityInfo[$IDLetters.'FirstName'] ?></td>
        <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?><?php echo $IDLetters ?>LastName-<?php echo $tableCell?>"><?php echo $entityInfo[$IDLetters.'LastName'] ?></td>
        <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?><?php echo $IDLetters ?>Email-<?php echo $tableCell?>"><?php echo $entityInfo[$IDLetters.'Email'] ?></td>
        <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?><?php echo $IDLetters ?>PhoneNumber-<?php echo $tableCell?>"><?php echo $entityInfo[$IDLetters.'PhoneNumber'] ?></td>
        <!--                        Delete Button-->
        <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>delete-control-<?php echo $tableCell?>">
            <button class="delete-button-id-<?php echo $entityID ?>"
                    id="<?php echo $personalCellID ?>deleteBtn-<?php echo $tableCell?>"
                    name="delete-button"
                    type="button"
                    value="<?php echo $entityID ?>">Delete User</button>
            <script>
                setButton("delete-button-id", "<?php echo $personalCellID ?>deleteBtn-<?php echo $tableCell?>")
            </script>
        </td>
        <?php if ($entityName === 'client'):?>
            <!--                        Promote Button-->
            <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>promote-control-<?php echo $tableCell?>">
                <button class="promote-button-id-<?php echo $entityID ?>"
                        id="<?php echo $personalCellID ?>promoteBtn-<?php echo $tableCell?>"
                        name="promote-button"
                        type="button"
                        value="<?php echo $entityID ?>">Promote User</button>
                <script>
                    setButton("promote-button-id", "<?php echo $personalCellID ?>promoteBtn-<?php echo $tableCell?>")
                </script>
                <?php if (isModerator($entityID)): ?>
                    <script>
                        setPromoteButtonStyle('<?php echo $entityID ?>', "grey", '#69A6E3', "Promoted");
                    </script>
                <?php endif; ?>
            </td>
        <?php endif;?>
        <!--                        Submit Button-->
        <td class="<?php echo $commonClass ?>" id="<?php echo $personalCellID ?>submit-control-<?php echo $tableCell?>">

            <button class="submit-button-id-<?php echo $entityID ?>"
                    id="<?php echo $personalCellID ?>submitBtn-<?php echo $tableCell?>"
                    name="submit-button"
                    type="button"
                    value="<?php echo $entityID ?>">Submit Changes</button>
            <script>
                setButton("submit-button-id", "<?php echo $personalCellID ?>submitBtn-<?php echo $tableCell?>")
            </script>
        </td>
    </tr>
<?php endwhile; ?>
<!--</table>-->
<?php } ?>

<?php
//generateTable('client', 'cltUsername', 'cltID', 'clt');
//generateTable('admin', 'admUsername', 'admID', 'adm');
?>


