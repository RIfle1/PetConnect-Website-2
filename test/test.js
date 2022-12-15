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
        if(processSuccess) {
            commonErrorSpanElement.remove();
            buttonIDElement.text('Edit');
            personalTitleSpanElement.text(personalTitleSpanText.replace("New ", ""));
            entityElement.css('display','block')

            console.log(editInputID)
            editInputElement.remove();
            editInputElement2.remove();
            tempClassElement.remove();

            commonCancelButtonElement.css('display', 'none');
        }
        else {
            commonErrorSpanElement.remove();
            buttonIDElement.parent().prev().append("<span class='cs-form-error-span'>"+errorMsg+"</span>")
        }
    }

    const buttonIDElement = $(buttonID);
    const entityAttribute = buttonIDElement.val();

    const editInputID = 'cs-form-input-'+entityAttribute;
    const editInputID2 = 'cs-form-input-'+entityAttribute+'-repeat';
    const tempClass = 'cs-form-temporary-element';
    const commonTitleSpanID = 'cs-form-title-span-';
    const commonCancelButtonID = 'cancel-password-button';
    const commonErrorSpanClass = 'cs-form-error-span';

    const personalTitleSpanID = commonTitleSpanID+entityAttribute;

    const entityElement = $('#'+entityAttribute);
    const editInputElement = $('#'+editInputID);
    const editInputElement2 = $('#'+editInputID2);
    const tempClassElement = $('.'+tempClass);
    const personalTitleSpanElement = $('#'+personalTitleSpanID);
    const commonCancelButtonElement = $('#'+commonCancelButtonID);
    const commonErrorSpanElement = $("."+commonErrorSpanClass);

    const editInputElementValue = editInputElement.val();
    const editInputElementValue2 = editInputElement2.val();

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
            buttonIDElement.parent().prev().append(
                "<input type='password' id= " + editInputID + ">"+
                "<span class="+ tempClass +">Repeat New Password :</span>\n" +
                "<input type='password' id= " + editInputID2 + ">"
            )
            commonCancelButtonElement.css('display', 'block');
            $("#cancel-password-button").click(function() {
                processSuccessFunction(true, "")
            })
        }


    }
    else if(buttonText === 'Confirm') {
        let errorMsg = '';
        console.log(buttonID);
        if(buttonID !== '#edit-password-button') {
            sendAjaxPost(entityAttribute, editInputElementValue)
            entityElement.text(editInputElementValue);
            buttonIDElement.text('Edit');
            processSuccess = true;
        }

        if(buttonID === '#edit-password-button') {
            if(editInputElementValue.length < 8) {
                processSuccess = false
                errorMsg = "Password must be at least 8 characters"
            }
            else if(!editInputElementValue.match(/[a-z]/)) {
                processSuccess = false
                errorMsg = "Password must contain at least one letter"
            }
            else if(!editInputElementValue.match(/[0-9]/)) {
                processSuccess = false
                errorMsg = "Password must contain at least one number"
            }
            else if(editInputElementValue !== editInputElementValue2) {
                processSuccess = false
                errorMsg = "Passwords must match"
            }
            else {
                processSuccess = true
            }

            if(processSuccess) {
                console.log(editInputElementValue2);
                sendAjaxPost(entityAttribute, editInputElementValue2)
            }
        }

        processSuccessFunction(processSuccess, errorMsg);

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







