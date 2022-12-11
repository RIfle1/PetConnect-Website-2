<?php while($clientInfo = $result->fetch_array()): ?>
    <?php
    $commonClass =  "mg-info-row-".$clientInfo['cltID'];
    $cltID = $clientInfo['cltID'];
    if ($tableRowNumber == 1) {
        $tableRowNumber = 2;
    }
    else {
        $tableRowNumber = 1;
    }
    ?>
    <tr class="mg-table-row-<?php echo $tableRowNumber ?>">
        <td class="<?php echo $commonClass ?>"><?php echo $clientInfo['cltID'] ?></td>
        <td class="<?php echo $commonClass ?>"><?php echo $clientInfo['cltUsername'] ?></td>
        <td class="<?php echo $commonClass ?>"><?php echo $clientInfo['cltFirstName'] ?></td>
        <td class="<?php echo $commonClass ?>"><?php echo $clientInfo['cltLastName'] ?></td>
        <td class="<?php echo $commonClass ?>"><?php echo $clientInfo['cltEmail'] ?></td>
        <td class="<?php echo $commonClass ?>"><?php echo $clientInfo['cltPhoneNumber'] ?></td>
        <!--                        Delete Button-->
        <td class="<?php echo $commonClass ?>" id="mg-delete-button-div">
            <button id="delete-button-id-<?php echo $cltID ?>"
                    name="delete-button"
                    type="button"
                    value="<?php echo $cltID ?>">
                Delete User
            </button>
            <script>
                setButton("delete-button-id", "delete-button-id-<?php echo $cltID ?>", "<?php echo $cltID ?>")
            </script>
        </td>
        <!--                        Promote Button-->
        <td class="<?php echo $commonClass ?>" id="mg-promote-button-div">
            <button id="promote-button-id-<?php echo $cltID ?>"
                    name="promote-button"
                    type="button"
                    value="<?php echo $cltID ?>">Promote User</button>
            <script>
                setButton("promote-button-id", "promote-button-id-<?php echo $cltID ?>", "<?php echo $cltID ?>")
            </script>
            <?php if (isModerator($cltID)): ?>
                <script>
                    setPromoteButtonStyle('<?php echo $cltID ?>', "grey", '#69A6E3', "Promoted");
                </script>
            <?php endif; ?>
        </td>
        <!--                        Submit Button-->
        <td class="<?php echo $commonClass ?>" id="mg-submit-button-div">

            <button id="submit-button-id-<?php echo $cltID ?>"
                    name="submit-button"
                    type="button"
                    value="<?php echo $cltID ?>">
                Submit Changes
            </button>
            <script>
                setButton("submit-button-id", "submit-button-id-<?php echo $cltID ?>", "<?php echo $cltID ?>")
            </script>
        </td>
    </tr>
<?php endwhile; ?>