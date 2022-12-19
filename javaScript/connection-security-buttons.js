

function sendAjaxPost(entityAttribute, editInputElementValue) {
    $.ajax({
        type: "POST",
        url: "../php-processes/connection-security-process.php",
        data: {
            entityAttribute: entityAttribute,
            entityValue: editInputElementValue,
        },
        success: function(result) {
        },
        error: function(requestObject, error, errorThrown) {
            alert(error);
            alert(errorThrown);
        }
    })
}

function onClickButton(buttonID) {

    const editUsernameButtonID = '#edit-username-button';
    const editFirstNameButtonID = '#edit-firstName-button';
    const editLastNameButtonID = '#edit-lastName-button';
    const editEmailButtonID = '#edit-email-button';
    const editPhoneNumberButtonID = '#edit-phoneNumber-button';
    const editPasswordButtonID = '#edit-password-button';

    function processSuccessFunction(processSuccess, errorMsg, processAction) {
        // REMOVE THE ERROR IF ANY
        $(".cs-form-error-span").remove();

            // ONLY EMAIL BUTTONS
        // IF EMAIL IS NOT TAKEN AND CORRECT
        if(!processSuccess && processAction === 'edit-email-process') {
            buttonIDElement.css('display','none')
            emailTempElement.text(editInputElementValue);
            emailTempElement.css('display', 'block');
            editInputElement.remove();
        }
        // IF CANCEL BUTTON IS PRESSED
        else if(!processSuccess && processAction === 'edit-email-verification') {
            entityElement.css('display','block');
            buttonIDElement.css('display','block');
            personalTitleSpanElement.text("Email :");
            buttonIDElement.text('Edit');
            $("#"+editInputID).remove();
            // console.log(editInputID);

            emailTempClassElement.css('display', 'none');
            emailTempClassElement.val("");
        }
        // IF THE CONFIRM BUTTON IS PRESSED AND THE CODE IS CORRECT
        else if(processSuccess && processAction === 'edit-email-verification') {
            entityElement.text(emailTempClassElement.text());
            entityElement.css('display','block');
            personalTitleSpanElement.text("Email :");

            emailTempClassElement.css('display', 'none');
            emailTempClassElement.val("");
        }

            // ONLY PASSWORD BUTTONS
        //IF THE CANCEL BUTTON IS PRESSED
        if(!processSuccess && processAction === 'edit-password-process') {
            passwordTempClassElement.css('display', 'none');
            passwordTempClassElement.val("");

            personalTitleSpanElement.text("Password :");
            buttonIDElement.text('Edit');
            entityElement.css('display','block');
        }
        // IF CONFIRM BUTTON IS PRESSED AND THE PASSWORD HAS PASSED VERIFICATION
        else if(processSuccess && processAction === 'edit-password-process') {
            passwordTempClassElement.css('display', 'none');
            passwordTempClassElement.val("");
            personalTitleSpanElement.text("Password :");
            sendAjaxPost(entityAttribute, editPasswordValue);
        }

            // ALL THE OTHER BUTONS
        // IF CONFIRM BUTTON IS PRESSED
        if(processSuccess && processAction === 'edit-process') {
            personalTitleSpanElement.text(personalTitleSpanText.replace("New ", ""));
        }

            // COMMON TO ALL BUTTONS
        // IF PROCESS FAILED
        if(!processSuccess && processAction === '') {
            buttonIDElement.parent().prev().append("<span class="+commonErrorSpanClass+">"+errorMsg+"</span>")
        }
        // IF CONFIRM BUTTON IS PRESSED AND THE VALUE HAS PASSED VERIFICATION
        else if(processSuccess){
            editInputElement.remove();
            buttonIDElement.text('Edit');
            buttonIDElement.css('display', 'block')
            entityElement.css('display','block');
            entityElement.text(editInputElementValue);
        }
        // IF CONFIRM BUTTON IS PRESSED, VALUE HAS PASSED VERIFICATION AND PROCESS IS NOT EDIT PASSWORD
        if(processSuccess && processAction !== 'edit-password-process') {
            sendAjaxPost(entityAttribute, editInputElementValue)
        }
    }

    const buttonIDElement = $(buttonID);
    const entityAttribute = buttonIDElement.val();

    const editInputID = 'cs-form-input-'+entityAttribute;
    const editPasswordID= 'cs-form-input-'+entityAttribute+'-original';
    const editOldPasswordID = 'cs-form-input-'+entityAttribute+'-old';
    const editPasswordRepeatID = 'cs-form-input-'+entityAttribute+'-repeat';
    const passwordTempClass = 'cs-form-password-temporary-element';
    const emailTempClass = 'cs-form-email-temporary-element';
    const emailTempID = 'cs-form-email-temporary';
    const editEmailVerificationCodeID = 'cs-form-input-Email-verificationCode'
    const commonTitleSpanID = 'cs-form-title-span-';
    const commonErrorSpanClass = 'cs-form-error-span';
    const cancelEmailEditButtonID = 'cancel-email-button';


    const personalTitleSpanID = commonTitleSpanID+entityAttribute;

    const entityElement = $('#'+entityAttribute);
    const editInputElement = $('#'+editInputID);
    const editPasswordElement = $('#'+editPasswordID);
    const editOldPasswordElement = $('#'+editOldPasswordID)
    const editPasswordRepeatElement = $('#'+editPasswordRepeatID);
    const passwordTempClassElement = $('.'+passwordTempClass);
    const emailTempClassElement = $('.'+emailTempClass);
    const emailTempElement = $("#"+emailTempID);

    const personalTitleSpanElement = $('#'+personalTitleSpanID);
    const cancelEmailEditButtonElement = $('#'+cancelEmailEditButtonID);

    const editInputElementValue = editInputElement.val();
    const editPasswordValue = editPasswordElement.val();
    const editPasswordRepeatValue = editPasswordRepeatElement.val();
    const editPasswordOldValue = editOldPasswordElement.val();


    const entityElementText = entityElement.text();
    const buttonText = buttonIDElement.text()
    const personalTitleSpanText = personalTitleSpanElement.text();

    let processSuccess = false;

    if(buttonText === 'Edit') {

        buttonIDElement.text('Confirm');
        entityElement.css('display','none');

        if(buttonID !== editPasswordButtonID) {
            personalTitleSpanElement.text('New ' + personalTitleSpanText);
            buttonIDElement.parent().prev().append(
                "<input id= " + editInputID +
                "       value= '" + entityElementText +
                "'>"
            );
        }
        if(buttonID === editPasswordButtonID) {
            personalTitleSpanElement.text('Old ' + personalTitleSpanText);
            passwordTempClassElement.css('display', 'block');
            $("#cancel-password-button").click(function() {
                processSuccessFunction(false, '','edit-password-process')
            })
        }
        if(buttonID === editEmailButtonID) {
            cancelEmailEditButtonElement.css('display', 'block');
            cancelEmailEditButtonElement.click(function() {
                processSuccessFunction(false, '','edit-email-verification')
            })
        }


    }
    else if(buttonText === 'Confirm') {
        let errorMsg = '';

        if(buttonID !== editPasswordButtonID) {
            if(buttonID === editUsernameButtonID) {
                if(editInputElementValue.length < 3) {
                    errorMsg = 'Username must be at least 3 characters long'
                    processSuccess = false;
                }
                else {
                    processSuccess = true;
                }
            }
            else if(buttonID === editFirstNameButtonID) {
                if(editInputElementValue.length < 3) {
                    errorMsg = 'First Name must be at least 3 characters long'
                    processSuccess = false;
                }
                else {
                    processSuccess = true;
                }
            }
            else if(buttonID === editLastNameButtonID) {
                if(editInputElementValue.length < 3) {
                    errorMsg = 'Last Name must be at least 3 characters long'
                    processSuccess = false;
                }
                else {
                    processSuccess = true;
                }
            }

            else if(buttonID === editPhoneNumberButtonID) {
                if(editInputElementValue.match(/[a-z]/)) {
                    errorMsg = 'Must be a number'
                    processSuccess = false;
                }
                else if(editInputElementValue.length < 10) {
                    errorMsg = 'Phone number must be 10 characters long'
                    processSuccess = false;
                }
                else if(editInputElementValue.length > 10) {
                    errorMsg = 'Phone number must be 10 characters long'
                    processSuccess = false;
                }
                else {
                    processSuccess = true;
                }
            }
            processSuccessFunction(processSuccess, errorMsg, 'edit-process');
        }

        if(buttonID === editEmailButtonID) {
            const sendEmailUrl = "../php-processes/connection-security-email-validation.php?newEmail="+encodeURIComponent(editInputElementValue);
            const validateEmailUrl = "../php-processes/validate-email.php?cltEmail-input="+encodeURIComponent(editInputElementValue);
            if(!editInputElementValue.match(/@/)) {
                errorMsg = 'Input a valid email'
                processSuccessFunction(false, errorMsg, '');
            }
            else {
                $.getJSON(validateEmailUrl, function (json) {
                    let isAvailable = json.available

                    if (!isAvailable) {
                        errorMsg = 'This email is already Taken.'
                        processSuccessFunction(false, errorMsg, '');
                    } else {
                        $.getJSON(sendEmailUrl, function (json) {
                            let processValues = json.processValues
                            let emailSent = processValues['emailSent'];
                            let verificationCode = processValues['verificationCode'];

                            if (!emailSent) {
                                errorMsg = 'The email could not be sent.'
                                processSuccessFunction(false, errorMsg, '');
                            }
                            else {
                                processSuccessFunction(false, '', 'edit-email-process');
                                emailTempClassElement.css('display', 'block');

                                $("#edit-confirm-email-button").click(function() {
                                    const editEmailVerificationCodeElement = $("#"+editEmailVerificationCodeID);
                                    const editEmailVerificationCodeValue = editEmailVerificationCodeElement.val();
                                    console.log(verificationCode);
                                    if(verificationCode === editEmailVerificationCodeValue) {
                                        processSuccessFunction(true, '', 'edit-email-verification');
                                    }
                                    else {
                                        errorMsg = 'Verification code is incorrect.'
                                        processSuccessFunction(false, errorMsg, '');
                                    }
                                })

                            }
                        })
                    }
                })
            }
        }
        else if(buttonID === editPasswordButtonID) {
            const url = "../php-processes/connection-security-password-validation.php?newPassword="+
                encodeURIComponent(editPasswordOldValue);
            $.getJSON(url, function(json) {
                let samePassword = json.samePassword;
                let errorMsg;
                let sendError = true;

                if(editPasswordValue.length < 8) {
                    errorMsg = "Password must be at least 8 characters."
                }
                else if(!editPasswordValue.match(/[a-z]/)) {
                    errorMsg = "Password must contain at least one letter."
                }
                else if(!editPasswordValue.match(/[0-9]/)) {
                    errorMsg = "Password must contain at least one number.";
                }
                else if(editPasswordValue !== editPasswordRepeatValue) {
                    errorMsg = "Passwords must match.";
                }
                else if (!samePassword) {
                    errorMsg = "Your old password is incorrect.";
                }
                else if (editPasswordValue === editPasswordOldValue) {
                    errorMsg = "Your new password must be different from your old password."
                }
                else {
                    processSuccessFunction(true, '', 'edit-password-process');
                    sendError = false;
                }

                if(sendError) {
                    processSuccessFunction(false, errorMsg, '');
                }

            });

        }
    }
}

function setSecurityButton(buttonID) {
    $(buttonID).click(function() {
        onClickButton(buttonID);
    })
}

try {

}

catch (error) {
    console.log(error);
}

setSecurityButton('#edit-username-button');
setSecurityButton('#edit-firstName-button');
setSecurityButton('#edit-lastName-button');
setSecurityButton('#edit-email-button');
setSecurityButton('#edit-phoneNumber-button');
setSecurityButton('#edit-password-button');


