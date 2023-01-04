// JSON VARIABLES
let languageListValidationFunctions;
let emailAvailable;
let passwordAvailable;
let errorBool;

let languageUrl = "../php-processes/language-list-process.php?file=validation-functions"
$.getJSON(languageUrl, function(json) {
    languageListValidationFunctions = json.languageList;
})

function organizeMessages(messageList) {
    let tempMessageList = []
    let msg = '';

    messageList.forEach(element => {
        if(element.length > 0 && !tempMessageList.includes(element)) {
            tempMessageList.push(element);
        }
    })

    tempMessageList.forEach(element => {
        msg += element+"<br>";
    })

    return msg;
}

function displayError(inputElement, errorMsg, error) {
    $("."+errorSpanClass+"-"+inputElement.attr("name")).remove();
    if(error > 0) {
        inputElement.parent().append("<span class="+errorSpanClass+"-"+inputElement.attr("name")+">"+errorMsg+"</span>")
    }
}

function validateUsername(usernameInputValue) {
    let errorMsg = '';

    if(usernameInputValue.length === 0) {
        errorMsg = languageListValidationFunctions["Client Username is required"]
        errorBool += 1;
    }
    else if(usernameInputValue.length < 3) {
        errorMsg = languageListValidationFunctions["Client Username must be at least 3 characters"]
        errorBool += 1;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validateFirstName(firstNameInputValue) {
    let errorMsg = '';

    if(firstNameInputValue.length === 0) {
        errorMsg = languageListValidationFunctions["Client First Name is required"];
        errorBool += 1;
    }
    else if(firstNameInputValue.length < 3) {
        errorMsg = languageListValidationFunctions["Client First Name must be at least 3 characters"];
        errorBool += 1;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validateLastName(lastNameInputValue) {
    let errorMsg = '';

    if(lastNameInputValue.length === 0) {
        errorMsg = languageListValidationFunctions["Client Last Name is required"]
        errorBool += 1;

    }
    else if(lastNameInputValue.length < 3) {
        errorMsg = languageListValidationFunctions["Client Last Name must be at least 3 characters"]
        errorBool += 1;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validateEmail(emailInputValue) {
    let errorMsg = '';
    let emailTaken = false;

    if(emailInputValue.length === 0) {
        errorMsg = languageListValidationFunctions["Email is required"]
        errorBool += 1;
    }
    else if(!emailInputValue.match(/@/)) {
        errorMsg = languageListValidationFunctions["Must be an email"]
        errorBool += 1;
    }
    else {
        let emailValidationUrl = "../php-processes/validate-email.php?email-input="+encodeURIComponent(emailInputValue)
        $.getJSON(emailValidationUrl, function(json) {
            emailAvailable = json.emailAvailable
        })
        emailTaken = true;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
        emailTaken : emailTaken,
    }

}

function validateEmailTaken() {
    let errorMsg = '';
    if(!emailAvailable) {
        errorMsg = languageListValidationFunctions["Email is already Taken"];
        errorBool += 1;
    }
    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validatePhoneNumber(phoneNumberInputValue) {
    let errorMsg = '';

    if(phoneNumberInputValue.match(/[a-z]/)) {
        errorMsg = languageListValidationFunctions["Client Phone Number must be a number"]
        errorBool += 1;
    }
    else if(phoneNumberInputValue.length !== 10) {
        errorMsg = languageListValidationFunctions["Phone number must be 10 characters long"]
        errorBool += 1;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validatePassword(passwordInputValue, checkOld) {
    let errorMsg = '';
    let passwordTaken = false;

    if(passwordInputValue.length === 0) {
        errorMsg = languageListValidationFunctions["Password is required"];
        errorBool += 1;
    }
    else if(passwordInputValue.length < 8) {
        errorMsg = languageListValidationFunctions["Password must be at least 8 characters"];
        errorBool += 1;
    }
    else if(!passwordInputValue.match(/[a-z]/)) {
        errorMsg = languageListValidationFunctions["Password must contain at least one letter"];
        errorBool += 1;
    }
    else if(!passwordInputValue.match(/[0-9]/)) {
        errorMsg = languageListValidationFunctions["Password must contain at least one number"];
        errorBool += 1;
    }
    else {
        if(checkOld) {
            const url = "../php-processes/connection-security-password-validation.php?newPassword="+
                encodeURIComponent(passwordInputValue);
            $.getJSON(url, function(json) {
                passwordAvailable = json.passwordAvailable;
            });
            passwordTaken = true;
        }
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
        passwordTaken : passwordTaken,
    }
}

function validatePasswordComparison(passwordInputValue, passwordConfirmationInputValue, type) {
    let errorMsg = '';

    if(type) {
        if(passwordInputValue !== passwordConfirmationInputValue) {
            errorMsg = languageListValidationFunctions["Passwords should match"];
            errorBool += 1;
        }
    }
    else {
        if(passwordInputValue === passwordConfirmationInputValue) {
            errorMsg = languageListValidationFunctions["Your new password must be different from your old password."];
            errorBool += 1;
        }
    }
    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validatePasswordAvailable(type) {
    let errorMsg = '';
    if(type) {
        if(!passwordAvailable) {
            errorMsg = languageListValidationFunctions["Your new password must be different from your old password."];
            errorBool += 1;
        }
    }
    else {
        if(passwordAvailable) {
            errorMsg = languageListValidationFunctions["Your old password is incorrect."];
            errorBool += 1;
        }
    }
    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }

}

function validateConfirmationCode(confirmationCode, confirmationCodeInput) {
    let errorMsg = '';

    if(confirmationCode !== confirmationCodeInput) {
        errorMsg = languageListValidationFunctions["The Confirmation Code is Incorrect."];
        errorBool += 1;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

