// JSON VARIABLES
let languageList;

let languageUrl = "../php-processes/language-list-process.php?file=signup-validation"
$.getJSON(languageUrl, function(json) {
    languageList = json.languageList;
})

function validateUsername(usernameInputValue) {
    let errorMsg = '';
    let errorBool = false;

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
    let errorBool = false;

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
    let errorBool = false;

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
    let errorBool = false;
    let isAvailable;

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

            console.log(isAvailable);

            if(!isAvailable) {
                errorMsg = languageList["Email is already Taken"];
                errorBool = true;
            }

        })
    }

    console.log(fetch("../php-processes/validate-email.php?email-input=" +
                            encodeURIComponent(emailInputValue))
                            .then(function(response) {
                                return response.json();
                            })
                            .then(function(json) {
                                return json.available;
                            }));


    return {
        errorMsg : errorMsg,
        errorBool : errorBool,
    }


}

