// JSON VARIABLES
let languageList;
let isAvailable = true;
let errorBool;

let languageUrl = "../php-processes/language-list-process.php?file=validation-function"
$.getJSON(languageUrl, function(json) {
    languageList = json.languageList;
})

function validateUsername(usernameInputValue) {
    let errorMsg = '';

    if(usernameInputValue.length === 0) {
        errorMsg = languageList["Client Username is required"]
        errorBool = true;
    }
    else if(usernameInputValue.length < 3) {
        errorMsg = languageList["Client Username must be at least 3 characters"]
        errorBool = true;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validateFirstName(firstNameInputValue) {
    let errorMsg = '';

    if(firstNameInputValue.length === 0) {
        errorMsg = languageList["Client First Name is required"];
        errorBool = true;
    }
    else if(firstNameInputValue.length < 3) {
        errorMsg = languageList["Client First Name must be at least 3 characters"];
        errorBool = true;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validateLastName(lastNameInputValue) {
    let errorMsg = '';

    if(lastNameInputValue.length === 0) {
        errorMsg = languageList["Client Last Name is required"]
        errorBool = true;

    }
    else if(lastNameInputValue.length < 3) {
        errorMsg = languageList["Client Last Name must be at least 3 characters"]
        errorBool = true;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validateEmail(emailInputValue) {
    let errorMsg = '';

    if(emailInputValue.length === 0) {
        errorMsg = languageList["Client Email is required"]
        errorBool = true;
    }
    else if(!emailInputValue.match(/@/)) {
        errorMsg = languageList["Must be an email"]
        errorBool = true;
    }
    else {
        let emailValidationUrl = "../php-processes/validate-email.php?email-input="+encodeURIComponent(emailInputValue)
        $.getJSON(emailValidationUrl, function(json) {
            isAvailable = json.available
        })
        errorBool = false;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }

}

function validateEmailTaken() {
    let errorMsg = '';

    if(!isAvailable) {
        errorMsg = languageList["Email is already Taken"];
        errorBool = true;
    }
    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validatePhoneNumber(phoneNumberInputValue) {
    let errorMsg = '';

    if(phoneNumberInputValue.match(/[a-z]/)) {
        errorMsg = languageList["Client Phone Number must be a number"]
        errorBool = true;
    }
    else if(phoneNumberInputValue.length !== 10) {
        errorMsg = languageList["Phone number must be 10 characters long"]
        errorBool = true;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

function validatePassword(passwordInputValue, passwordConfirmationInputValue) {
    let errorMsg = '';

    if(passwordInputValue.length === 0) {
        errorMsg = languageList["Password is required"];
        errorBool = true;
    }
    else if(passwordInputValue.length < 8) {
        errorMsg = languageList["Password must be at least 8 characters"];
        errorBool = true;
    }
    else if(!passwordInputValue.match(/[a-z]/)) {
        errorMsg = languageList["Password must contain at least one letter"];
        errorBool = true;
    }
    else if(!passwordInputValue.match(/[0-9]/)) {
        errorMsg = languageList["Password must contain at least one number"];
        errorBool = true;
    }
    else if(passwordInputValue !== passwordConfirmationInputValue) {
        errorMsg = languageList["Passwords should match"];
        errorBool = true;
    }

    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }
}

