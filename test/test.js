function onClickButton(buttonElement) {

    function processSuccessFunction(processSuccess, errorMsg, processAction) {
        // REMOVE THE ERROR IF ANY
        $(".cs-form-error-span").remove();

        // ONLY EMAIL BUTTONS
        // IF EMAIL IS NOT TAKEN AND CORRECT
        if(!processSuccess && processAction === 'edit-email-process') {
            buttonElement.css('display','none')
            emailTempElement.text(editInputElementValue);
            emailTempElement.css('display', 'block');
            editInputElement.remove();
        }
        // IF CANCEL BUTTON IS PRESSED
        else if(!processSuccess && processAction === 'edit-email-verification') {
            entityElement.css('display','block');
            buttonElement.css('display','block');
            personalTitleSpanElement.text("Email :");
            buttonElement.text('Edit');
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
            buttonElement.text('Edit');
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
        if(!processSuccess && processAction) {
            buttonElement.parent().prev().append("<span class="+commonErrorSpanClass+">"+errorMsg+"</span>")
        }
        // IF CONFIRM BUTTON IS PRESSED AND THE VALUE HAS PASSED VERIFICATION
        else if(processSuccess){
            editInputElement.remove();
            buttonElement.text('Edit');
            buttonElement.css('display', 'block')
            entityElement.css('display','block');
            entityElement.text(editInputElementValue);
        }
        // IF CONFIRM BUTTON IS PRESSED, VALUE HAS PASSED VERIFICATION AND PROCESS IS NOT EDIT PASSWORD
        if(processSuccess && processAction !== 'edit-password-process') {
            sendAjaxPost(entityAttribute, editInputElementValue)
        }
    }

    const entityAttribute = buttonElement.val();

    const editInputID = 'cs-form-input-'+entityAttribute;
    const editPasswordID= 'cs-form-input-'+entityAttribute+'-original';
    const editOldPasswordID = 'cs-form-input-'+entityAttribute+'-old';
    const editPasswordRepeatID = 'cs-form-input-'+entityAttribute+'-repeat';

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
    const buttonText = buttonElement.text()
    const personalTitleSpanText = personalTitleSpanElement.text();

    let processSuccess = false;

    // REFRESH NECESSARY JSONs
    refreshValidateEmailJson(editInputElementValue);
    refreshSendEmailJson(editInputElementValue);

    if(buttonText === 'Edit') {

        buttonElement.text('Confirm');
        entityElement.css('display','none');

        if(buttonElement !== editPasswordButtonElement) {
            personalTitleSpanElement.text('New ' + personalTitleSpanText);
            buttonElement.parent().prev().append(
                "<input id= " + editInputID +
                "       value= '" + entityElementText +
                "'>"
            );
        }
        if(buttonElement === editPasswordButtonElement) {
            personalTitleSpanElement.text('Old ' + personalTitleSpanText);
            passwordTempClassElement.css('display', 'block');
            $("#cancel-password-button").click(function() {
                processSuccessFunction(buttonElement,buttonElement, false, '','edit-password-process')
            })
        }
        if(buttonElement === editEmailButtonElement) {
            cancelEmailEditButtonElement.css('display', 'block');
            cancelEmailEditButtonElement.click(function() {
                processSuccessFunction(buttonElement,buttonElement,false, '','edit-email-verification')
            })
        }


    }

    setTimeout(()=> {
        if(buttonText === 'Confirm') {
            let errorMsg = '';

            if(buttonElement === editEmailButtonElement) {
                if(!editInputElementValue.match(/@/)) {
                    errorMsg = 'Input a valid email'
                    processSuccessFunction(buttonElement,false, errorMsg, '');
                }
                else {
                    if (!isAvailable) {
                        errorMsg = 'This email is already Taken.'
                        processSuccessFunction(buttonElement,false, errorMsg, '');
                    } else {
                        let emailSent = processValues['emailSent'];

                        if (!emailSent) {
                            errorMsg = 'The email could not be sent.'
                            processSuccessFunction(buttonElement,false, errorMsg, '');
                        }
                        else {
                            processSuccessFunction(buttonElement,false, '', 'edit-email-process');
                            emailTempClassElement.css('display', 'block');
                        }

                    }

                }
            }
            else if(buttonElement === editPasswordButtonElement) {
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
                        processSuccessFunction(buttonElement,true, '', 'edit-password-process');
                        sendError = false;
                    }

                    if(sendError) {
                        processSuccessFunction(buttonElement,false, errorMsg, '');
                    }

                });

            }
            else if(buttonElement !== editPasswordButtonElement && buttonElement !== editEmailButtonElement) {
                if(buttonElement === editUsernameButtonElement) {
                    if(editInputElementValue.length < 3) {
                        errorMsg = 'Username must be at least 3 characters long'
                        processSuccess = false;
                    }
                    else {
                        processSuccess = true;
                    }
                }
                else if(buttonElement === editFirstNameButtonElement) {
                    if(editInputElementValue.length < 3) {
                        errorMsg = 'First Name must be at least 3 characters long'
                        processSuccess = false;
                    }
                    else {
                        processSuccess = true;
                    }
                }
                else if(buttonElement === editLastNameButtonElement) {
                    if(editInputElementValue.length < 3) {
                        errorMsg = 'Last Name must be at least 3 characters long'
                        processSuccess = false;
                    }
                    else {
                        processSuccess = true;
                    }
                }
                else if(buttonElement === editPhoneNumberButtonElement) {
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
                processSuccessFunction(buttonElement,processSuccess, errorMsg, 'edit-process');
            }
        }
    }, 100)

}