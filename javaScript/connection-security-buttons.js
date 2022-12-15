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

    function processSuccessFunction(processSuccess, errorMsg) {
        commonErrorSpanElement.remove();
        if(processSuccess) {
            buttonIDElement.text('Edit');
            personalTitleSpanElement.text(personalTitleSpanText.replace("New ", ""));
            entityElement.css('display','block')
            editInputElement.remove();
            tempClassElement.css('display', 'none');
            tempClassElement.val("");
        }
        else {
            buttonIDElement.parent().prev().append("<span class='cs-form-error-span'>"+errorMsg+"</span>")
        }
    }

    const buttonIDElement = $(buttonID);
    const entityAttribute = buttonIDElement.val();

    const editInputID = 'cs-form-input-'+entityAttribute;
    const editPasswordID= 'cs-form-input-'+entityAttribute+'-original';
    const editPasswordRepeatID = 'cs-form-input-'+entityAttribute+'-repeat';
    const tempClass = 'cs-form-temporary-element';
    const commonTitleSpanID = 'cs-form-title-span-';
    const commonErrorSpanClass = 'cs-form-error-span';

    const personalTitleSpanID = commonTitleSpanID+entityAttribute;

    const entityElement = $('#'+entityAttribute);
    const editInputElement = $('#'+editInputID);
    const editPasswordElement = $('#'+editPasswordID);
    const editPasswordRepeatElement = $('#'+editPasswordRepeatID);
    const tempClassElement = $('.'+tempClass);
    const personalTitleSpanElement = $('#'+personalTitleSpanID);
    const commonErrorSpanElement = $("."+commonErrorSpanClass);

    const editInputElementValue = editInputElement.val();

    const editPasswordValue = editPasswordElement.val();
    const editPasswordRepeatValue = editPasswordRepeatElement.val();

    const entityElementText = entityElement.text();
    const buttonText = buttonIDElement.text()
    const personalTitleSpanText = personalTitleSpanElement.text();

    let processSuccess = false;

    if(buttonText === 'Edit') {

        buttonIDElement.text('Confirm');
        entityElement.css('display','none');
        personalTitleSpanElement.text('New ' + personalTitleSpanText);

        if(buttonID !== '#edit-password-button') {
            buttonIDElement.parent().prev().append(
                "<input id= " + editInputID +
                "       value= '" + entityElementText +
                "'>"
            );
        }
        if(buttonID === '#edit-password-button') {
            tempClassElement.css('display', 'block');
            $("#cancel-password-button").click(function() {
                processSuccessFunction(true, '')
            })
        }


    }
    else if(buttonText === 'Confirm') {
        let errorMsg = '';
        if(buttonID !== '#edit-password-button') {
            if(buttonID === '#edit-username-button') {
                if(editInputElementValue.length < 3) {
                    errorMsg = 'Username must be at least 3 characters long'
                    processSuccess = false;
                }
                else {
                    processSuccess = true;
                }
            }
            else if(buttonID === '#edit-firstName-button') {
                if(editInputElementValue.length < 3) {
                    errorMsg = 'First Name must be at least 3 characters long'
                    processSuccess = false;
                }
                else {
                    processSuccess = true;
                }
            }
            else if(buttonID === '#edit-lastName-button') {
                if(editInputElementValue.length < 3) {
                    errorMsg = 'Last Name must be at least 3 characters long'
                    processSuccess = false;
                }
                else {
                    processSuccess = true;
                }
            }
            else if(buttonID === '#edit-email-button') {
                if(!editInputElementValue.match(/@/)) {
                    errorMsg = 'Input a valid email'
                    processSuccess = false;
                }
                else {
                    processSuccess = true;
                }
            }
            else if(buttonID === '#edit-phoneNumber-button') {
                if(editInputElementValue.match(/[a-z]/)) {
                    errorMsg = 'Must be a number'
                    processSuccess = false;
                }
                else if(editInputElementValue.length < 9) {
                    errorMsg = 'Phone number must be 9 characters long'
                    processSuccess = false;
                }
                else {
                    processSuccess = true;
                }
            }

            if(processSuccess) {
                entityElement.text(editInputElementValue);
                sendAjaxPost(entityAttribute, editInputElementValue)
                buttonIDElement.text('Edit');
            }

            processSuccessFunction(processSuccess, errorMsg);
            console.log(errorMsg)
        }



        if(buttonID === '#edit-password-button') {
            const url = "../php-processes/connection-security-validate-password.php?newPassword="+
                encodeURIComponent(editPasswordValue);
            $.getJSON(url, function(json) {
                    let samePassword = json.samePassword;
                    let errorMsg;

                    if(editPasswordValue.length < 8) {
                        processSuccess = false
                        errorMsg = "Password must be at least 8 characters"
                    }
                    else if(!editPasswordValue.match(/[a-z]/)) {
                        processSuccess = false
                        errorMsg = "Password must contain at least one letter"
                    }
                    else if(!editPasswordValue.match(/[0-9]/)) {
                        processSuccess = false
                        errorMsg = "Password must contain at least one number";
                    }
                    else if(editPasswordValue !== editPasswordRepeatValue) {
                        processSuccess = false
                        errorMsg = "Passwords must match";
                    }
                    else if (samePassword) {
                        processSuccess = false
                        errorMsg = "Your new password has to be different from your old password.";
                    }
                    else {
                        processSuccess = true
                    }

                    if(processSuccess) {
                        sendAjaxPost(entityAttribute, editPasswordValue)
                    }
                    processSuccessFunction(processSuccess, errorMsg);
                });

        }
    }
}

function setButton(buttonID) {
    $(buttonID).click(function() {
        onClickButton(buttonID);
    })
}

setButton('#edit-username-button');
setButton('#edit-firstName-button');
setButton('#edit-lastName-button');
setButton('#edit-email-button');
setButton('#edit-phoneNumber-button');
setButton('#edit-password-button');
