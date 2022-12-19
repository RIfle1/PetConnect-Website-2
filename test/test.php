
<div class="cs-form-elem">
    <div class="cs-form-elem-content">
        <span id="cs-form-title-span-<?php echo $IDLetters ?>Email">Email :</span>
        <span id="<?php echo $IDLetters ?>Email"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes[4]];} ?></span>
                        <span class="cs-form-email-temporary-element">A verification code has been sent to your new email address.</span>
                        <span class="cs-form-email-temporary-element">Verification code :</span>
                        <input class="cs-form-email-temporary-element" type='password' id="cs-form-input-<?php echo $IDLetters ?>Password-repeat">
    </div>
</div>
<div class="cs-form-elem-button">
    <button type="button" value="<?php echo $IDLetters ?>Email" class="edit-button" id="edit-email-button">Edit</button>
    <!--                <button type="button" value="--><?php //echo $IDLetters ?><!--Email" class="cs-form-email-temporary-element" id="edit-confirm-email-button">Confirm Code</button>-->
</div>
</div>
