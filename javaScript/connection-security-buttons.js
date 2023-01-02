refreshLanguageList();
// CONSTANTS
// COMMON HARDCODED SPAN IDs
const titleSpanCommonID = "cs-form-title-span-";
const infoSpanCommonID = "cs-form-info-span-";
const infoSpan2CommonID = "cs-form-info-span2-"

// COMMON HARDCODED INPUT IDs
const inputCommonID = "cs-form-input-";

// COMMON HARDCODED BUTTON IDs
const editButtonCommonID = "cs-form-edit-button-";
const cancelButtonCommonID = "cs-form-cancel-button-"

// COMMON HARDCODED SPAN CLASSES
const tempSpanCommonClass = "cs-form-temp-span-";
const tempSpanCommonClass2 = "cs-form-temp-span2-"

// COMMON HARDCODED BUTTON CLASSES
const tempButtonCommonClass = "cs-form-temp-button-";

// COMMON HARDCODED INPUT CLASSES
const tempInputCommonClass = "cs-form-temp-input-";

// COMMON VOLATILE SPAN CLASSES
const commonErrorSpanClass = "cs-form-error-span-";


// HARDCODED BUTTON IDs
const editButtonUsernameID = "cs-form-edit-button-username";
const cancelButtonUsernameID = "cs-form-cancel-button-username";

const editButtonFirstNameID = "cs-form-edit-button-firstName";
const cancelButtonFirstNameID = "cs-form-cancel-button-firstName";

const editButtonLastNameID = "cs-form-edit-button-lastName";
const cancelButtonLastNameID = "cs-form-cancel-button-lastName";

const editButtonPhoneNumberID = "cs-form-edit-button-phoneNumber";
const cancelButtonPhoneNumberID = "cs-form-cancel-button-phoneNumber";

const editButtonEmailID = "cs-form-edit-button-email";
const cancelButtonEmailID = "cs-form-cancel-button-email";

const editButtonPasswordID = "cs-form-edit-button-password";
const cancelButtonPasswordID = "cs-form-cancel-button-password";

// HARDCODED BUTTON ELEMENTS
const editButtonUsernameElement = $("#"+editButtonUsernameID);
const cancelButtonUsernameElement = $("#"+cancelButtonUsernameID);

const editButtonFirstNameElement = $("#"+editButtonFirstNameID);
const cancelButtonFirstNameElement = $("#"+cancelButtonFirstNameID);

const editButtonLastNameElement = $("#"+editButtonLastNameID);
const cancelButtonLastNameElement = $("#"+cancelButtonLastNameID);

const editButtonPhoneNumberElement = $("#"+editButtonPhoneNumberID);
const cancelButtonPhoneNumberElement = $("#"+cancelButtonPhoneNumberID);

const editButtonEmailElement = $("#"+editButtonEmailID);
const cancelButtonEmailElement = $("#"+cancelButtonEmailID);

const editButtonPasswordElement = $("#"+editButtonPasswordID);
const cancelButtonPasswordElement = $("#"+cancelButtonPasswordID);

// HARDCODED INPUT IDs
const editInputUsernameID = "cs-form-input-username"
const editInputFirstNameID = "cs-form-input-firstName"
const editInputLastNameID = "cs-form-input-lastName"
const editInputPhoneNumberID = "cs-form-input-phoneNumber"
const editInputEmailID = "cs-form-input-email"

const editInputPasswordOldID = "cs-form-input-password-old"
const editInputPasswordOriginalID = "cs-form-input-password"
const editInputPasswordRepeatID = "cs-form-input-password-repeat"

// HARDCODED INPUT ELEMENTS
const editInputUsernameElement = $("#"+editInputUsernameID)
const editInputFirstNameElement = $("#"+editInputFirstNameID)
const editInputLastNameElement = $("#"+editInputLastNameID)
const editInputPhoneNumberElement = $("#"+editInputPhoneNumberID)
const editInputEmailElement = $("#"+editInputEmailID)

const editInputPasswordOldElement = $("#"+editInputPasswordOldID)
const editInputPasswordOriginalElement = $("#"+editInputPasswordOriginalID)
const editInputPasswordRepeatElement = $("#"+editInputPasswordRepeatID)

// JSON VARIABLES
let isAvailable;
let processValues;
let samePassword;
let languageList

// ---------------------------------------------------------------------------------------------------------
// JSON INITIALIZATION

function refreshValidateEmailJson(inputCommonElementValue) {
    const validateEmailUrl = "../php-processes/validate-email.php?email-input="+encodeURIComponent(inputCommonElementValue);
    $.getJSON(validateEmailUrl, function (json) {
        isAvailable = json.available
    })
}

function refreshSamePasswordJson(editPasswordOldValue) {
    const url = "../php-processes/connection-security-password-validation.php?newPassword="+
        encodeURIComponent(editPasswordOldValue);
    $.getJSON(url, function(json) {
        samePassword = json.samePassword
    });
}

function refreshLanguageList() {
    let languageUrl = "../php-processes/language-list-process.php?file=connection-security-buttons"
    $.getJSON(languageUrl, function(json) {
        languageList = json.languageList;
    })
}

// ---------------------------------------------------------------------------------------------------------
function sendAjaxPost(entityAttribute, entityValue) {
    $.ajax({
        type: "POST",
        url: "../php-processes/connection-security-process.php",
        data: {
            entityAttribute: entityAttribute,
            entityValue: entityValue,
        }
    })
}

function processSuccessFunction(editButtonElement, processSuccess, errorMsg, buttonAttribute, entityAttribute, entityValue) {
    let cancelButtonElement = $("#"+cancelButtonCommonID+buttonAttribute)
    $("."+commonErrorSpanClass+buttonAttribute).remove();


    if(processSuccess) {
        sendAjaxPost(entityAttribute, entityValue)
        cancelButtonElement.trigger("click");
    }
    else {
        editButtonElement.parent().prev().append("<span class="+commonErrorSpanClass+buttonAttribute+">"+errorMsg+"</span>")
    }
}

function returnElementsList(buttonAttribute) {
    return [
        $("#"+titleSpanCommonID+buttonAttribute),
        $("#"+infoSpanCommonID+buttonAttribute),
        $("#"+infoSpan2CommonID+buttonAttribute),
        $("."+tempSpanCommonClass+buttonAttribute),
        $("."+tempSpanCommonClass2+buttonAttribute),
        $("."+tempInputCommonClass+buttonAttribute),
        $("."+tempButtonCommonClass+buttonAttribute),
    ]
}

function onClickEditButton(editButtonElement) {
    let buttonName = editButtonElement.attr("name");
    let buttonAttribute = editButtonElement.attr('id').substring(20);
    let entityAttribute = editButtonElement.val()

    let elementsList = returnElementsList(buttonAttribute)
    let titleSpanElement = elementsList[0]
    let infoSpanElement =  elementsList[1]
    let infoSpan2Element = elementsList[2]

    let spanCommonElement = elementsList[3]
    let span2CommonElement = elementsList[4]
    let inputCommonElement = elementsList[5]

    let buttonCommonElement = elementsList[6]

    let inputCommonElementValue = inputCommonElement.val();

    let processSuccess = false;
    let entityValue;
    let errorMsg;

    if (buttonName === 'Edit') {
        editButtonElement.text(languageList['Confirm']);
        editButtonElement.attr("name", "Confirm");

        titleSpanElement.text(titleSpanElement.text().replace("", languageList["New"]+" "));
        infoSpanElement.css('display', 'none');

        spanCommonElement.css('display', 'block');
        inputCommonElement.css('display', 'block');

        buttonCommonElement.css("display", "block")

        if (editButtonElement !== editButtonPasswordElement) {
            inputCommonElement.val(infoSpanElement.text())
        }


    }
    else if (buttonName === 'Confirm') {
        if (editButtonElement === editButtonEmailElement) {

            refreshValidateEmailJson(inputCommonElementValue);

            setTimeout(() => {
                const sendEmailUrl = "../php-processes/connection-security-email-validation.php?newEmail=" + encodeURIComponent(inputCommonElementValue);
                $.getJSON(sendEmailUrl, function (json) {
                    processValues = json.processValues
                    if (!inputCommonElementValue.match(/@/)) {
                        errorMsg = languageList['Input a valid email']
                    }
                    else if(!isAvailable) {
                        errorMsg = languageList['This email is already Taken.']
                    }
                    else if (!processValues['emailSent']) {
                        errorMsg = languageList['The email could not be sent.']
                    }
                    else {
                            infoSpan2Element.text(inputCommonElement.val());
                            infoSpan2Element.css('display', 'block');

                            span2CommonElement.css('display', 'block');

                            inputCommonElement.val("");

                            editButtonElement.text(languageList['Confirm Code']);
                            editButtonElement.attr("name", "Confirm Code");
                            $("."+commonErrorSpanClass+buttonAttribute).remove();
                            console.log(processValues);

                            processSuccess = true;
                    }
                    if (!processSuccess) {
                       processSuccessFunction(editButtonElement, processSuccess, errorMsg, buttonAttribute, entityAttribute, entityValue)
                    }
                })
            }, 100)
        }
        else if(editButtonElement === editButtonPasswordElement) {

            let editInputPasswordOldValue = editInputPasswordOldElement.val();
            let editInputPasswordOriginalValue = editInputPasswordOriginalElement.val();
            let editInputPasswordRepeatValue = editInputPasswordRepeatElement.val();

            refreshSamePasswordJson(editInputPasswordOldValue);

            setTimeout(()=> {
                if(editInputPasswordOriginalValue.length < 8) {
                    errorMsg = languageList["Password must be at least 8 characters."]
                }
                else if(!editInputPasswordOriginalValue.match(/[a-z]/)) {
                    errorMsg = languageList["Password must contain at least one letter."]
                }
                else if(!editInputPasswordOriginalValue.match(/[0-9]/)) {
                    errorMsg = languageList["Password must contain at least one number."];
                }
                else if(editInputPasswordOriginalValue !== editInputPasswordRepeatValue) {
                    errorMsg = languageList["Passwords must match."];
                }
                else if (!samePassword) {
                    errorMsg = languageList["Your old password is incorrect."];
                }
                else if (editInputPasswordOriginalValue === editInputPasswordOldValue) {
                    errorMsg = languageList["Your new password must be different from your old password."]
                }
                else {
                    processSuccess = true;
                    entityValue = editInputPasswordOriginalValue;
                }

                processSuccessFunction(editButtonElement, processSuccess, errorMsg, buttonAttribute, entityAttribute, entityValue);


            }, 100)

        }
        else if(editButtonElement !== editButtonPasswordElement && editButtonElement !== editButtonEmailElement) {
            entityValue = inputCommonElementValue;

            if(editButtonElement === editButtonUsernameElement) {
                if(inputCommonElementValue.length < 3) {
                    errorMsg = languageList['Username must be at least 3 characters long']
                }
                else {
                    processSuccess = true;
                }
            }
            else if(editButtonElement === editButtonFirstNameElement) {
                if(inputCommonElementValue.length < 3) {
                    errorMsg = languageList['First Name must be at least 3 characters long']
                }
                else {
                    processSuccess = true;
                }
            }
            else if(editButtonElement === editButtonLastNameElement) {
                if(inputCommonElementValue.length < 3) {
                    errorMsg = languageList['Last Name must be at least 3 characters long']
                }
                else {
                    processSuccess = true;
                }
            }
            else if(editButtonElement === editButtonPhoneNumberElement) {
                if(inputCommonElementValue.match(/[a-z]/)) {
                    errorMsg = languageList['Must be a number']
                }
                // else if(inputCommonElementValue.length < 10) {
                //     errorMsg = languageList['Phone number must be 10 characters long']
                // }
                // else if(inputCommonElementValue.length > 10) {
                //     errorMsg = languageList['Phone number must be 10 characters long']
                // }
                else {
                    processSuccess = true;
                }
            }

            if(processSuccess) {
                infoSpanElement.text(entityValue);
            }

            processSuccessFunction(editButtonElement, processSuccess, errorMsg, buttonAttribute, entityAttribute, entityValue);
        }
    }
    else if (buttonName === 'Confirm Code') {
        if (inputCommonElementValue === processValues['verificationCode']) {
            entityValue = infoSpan2Element.text();
            processSuccess = true;
            infoSpanElement.text(entityValue);
            processSuccessFunction(editButtonElement, processSuccess, errorMsg, buttonAttribute, entityAttribute, entityValue)

        } else {
            errorMsg = languageList['The Confirmation Code is Incorrect.']
            processSuccessFunction(editButtonElement, processSuccess, errorMsg, buttonAttribute, entityAttribute, entityValue)
        }
    }
}

function onClickCancelButton(cancelButtonElement) {
    let buttonAttribute = cancelButtonElement.attr('id').substring(22);
    let editButtonElement = $("#"+editButtonCommonID+buttonAttribute);
    $("."+commonErrorSpanClass+buttonAttribute).remove();

    let elementsList = returnElementsList(buttonAttribute)

    let titleSpanElement = elementsList[0]
    let infoSpanElement =  elementsList[1]
    let infoSpan2Element = elementsList[2]

    let spanCommonElement = elementsList[3]
    let span2CommonElement = elementsList[4]
    let inputCommonElement = elementsList[5]

    let buttonCommonElement = elementsList[6]

    titleSpanElement.text(titleSpanElement.text().replace(languageList["New"]+" ", ""));
    infoSpanElement.css('display', 'block');
    infoSpan2Element.css('display', 'none');
    infoSpan2Element.text("")

    spanCommonElement.css('display', 'none');
    span2CommonElement.css('display', 'none');
    inputCommonElement.css('display', 'none');
    inputCommonElement.val("");

    buttonCommonElement.css("display", "none")

    editButtonElement.text(languageList["Edit"]);
    editButtonElement.attr("name", "Edit");

}

function setEditButton(editButtonElement) {
    editButtonElement.click(function() {
        onClickEditButton(editButtonElement)
    })
}

function setInputButton(inputButtonElement) {
    let buttonAttribute = inputButtonElement.attr('id').substring(14);
    let editButtonElement = $("#"+editButtonCommonID+buttonAttribute)

    inputButtonElement.keyup(function(e){
        if(e.keyCode === 13) {
            editButtonElement.trigger("click");
        }
    });
}

function setCancelButton(cancelButtonElement) {
    cancelButtonElement.click(function() {
        onClickCancelButton(cancelButtonElement)
    })
}

setEditButton(editButtonUsernameElement);
setEditButton(editButtonFirstNameElement);
setEditButton(editButtonLastNameElement);
setEditButton(editButtonPhoneNumberElement);
setEditButton(editButtonEmailElement);
setEditButton(editButtonPasswordElement);


setInputButton(editInputUsernameElement);
setInputButton(editInputFirstNameElement);
setInputButton(editInputLastNameElement);
setInputButton(editInputPhoneNumberElement);
setInputButton(editInputEmailElement);

setInputButton(editInputPasswordOldElement);
setInputButton(editInputPasswordOriginalElement);
setInputButton(editInputPasswordRepeatElement);


setCancelButton(cancelButtonUsernameElement);
setCancelButton(cancelButtonFirstNameElement);
setCancelButton(cancelButtonLastNameElement);
setCancelButton(cancelButtonPhoneNumberElement);
setCancelButton(cancelButtonEmailElement);
setCancelButton(cancelButtonPasswordElement);




