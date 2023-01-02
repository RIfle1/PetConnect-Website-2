// CONSTANTS
// HARDCODED INPUT IDS
const usernameInputID = "username-input";
const firstNameInputID = "firstName-input";
const lastNameInputID = "lastName-input";
const emailInputID = "email-input";
const phoneNumberInputID = "phoneNumber-input";
const passwordInputID = "password-input";
const passwordConfirmationInputID = "passwordConfirmation-input";

// HARDCODED BUTTON IDS
const submitButtonID = "sign-submit-button";

// VOLATILE SPAN CLASSES
const errorSpanClass = "sign-form-error-span";

// HARDCODED INPUT ELEMENTS
const usernameInputElement = $("#"+usernameInputID)
const firstNameInputElement = $("#"+firstNameInputID)
const lastNameInputElement = $("#"+lastNameInputID)
const emailInputElement = $("#"+emailInputID)
const phoneNumberInputElement = $("#"+phoneNumberInputID)
const passwordInputElement = $("#"+passwordInputID)
const passwordConfirmationInputElement = $("#"+passwordConfirmationInputID)

// HARDCODED BUTTON ELEMENTS
const submitButtonElement = $("#"+submitButtonID)

// JSON VARIABLES
let languageList;
let isAvailable;

let languageUrl = "../php-processes/language-list-process.php?file=signup-validation"
$.getJSON(languageUrl, function(json) {
    languageList = json.languageList;
    setSubmitButton(submitButtonElement);
})

function displayError(inputElement, errorMsg, error) {
    $("."+errorSpanClass+"-"+inputElement.attr("name")).remove();
    if(error) {
        inputElement.parent().append("<span class="+errorSpanClass+"-"+inputElement.attr("name")+">"+errorMsg+"</span>")
    }
}

function onClickSubmitButton() {
    // GET VALUES
    let errorMsg = '';

    const usernameInputValue = usernameInputElement.val();
    const firstNameInputValue = firstNameInputElement.val();
    const lastNameInputValue = lastNameInputElement.val();
    const emailInputValue = emailInputElement.val();
    const phoneNumberInputValue = phoneNumberInputElement.val();
    const passwordInputValue = passwordInputElement.val();
    const passwordConfirmationInputValue = passwordConfirmationInputElement.val();


    // CLIENT USERNAME
    if(usernameInputValue.length === 0) {
        errorMsg = languageList["Client Username is required"]
        displayError(usernameInputElement, errorMsg, true);
    }
    else if(usernameInputValue.length < 3) {
        errorMsg = languageList["Client Username must be at least 3 characters"]
        displayError(usernameInputElement, errorMsg, true);
    }
    else {
        displayError(usernameInputElement, '', false);
    }

    // CLIENT FIRST NAME
    if(firstNameInputValue.length === 0) {
        errorMsg = languageList["Client First Name is required"]
        displayError(firstNameInputElement, errorMsg, true, true);
    }
    else if(firstNameInputValue.length < 3) {
        errorMsg = languageList["Client First Name must be at least 3 characters"]
        displayError(firstNameInputElement, errorMsg, true);
    }
    else {
        displayError(firstNameInputElement, '', false);
    }

    // CLIENT LAST NAME
    if(lastNameInputValue.length === 0) {
        errorMsg = languageList["Client Last Name is required"]
        displayError(lastNameInputElement, errorMsg, true);
    }
    else if(lastNameInputValue.length < 3) {
        errorMsg = languageList["Client Last Name must be at least 3 characters"]
        displayError(lastNameInputElement, errorMsg, true);
    }
    else {
        displayError(lastNameInputElement, '', false);
    }

    // CLIENT EMAIL
    if(emailInputValue.length === 0) {
        errorMsg = languageList["Client Email is required"]
        displayError(emailInputElement, errorMsg, true);
    }
    else if(!emailInputValue.match(/@/)) {


        errorMsg = languageList["Must be an email"]
        displayError(emailInputElement, errorMsg, true);
    }
    else {
        let emailValidationUrl = "../php-processes/validate-email.php?email-input="+encodeURIComponent(emailInputValue)
        $.getJSON(emailValidationUrl, function(json) {
            isAvailable = json.available

            if(!isAvailable) {
                errorMsg = languageList["Email is already Taken"];
                displayError(emailInputElement, errorMsg, true);
            }
            else {
                displayError(emailInputElement, "", false);
            }

        })
    }

    // CLIENT PHONE NUMBER
    if(phoneNumberInputValue.match(/[a-z]/)) {
        errorMsg = languageList["Client Phone Number must be a number"]
        displayError(phoneNumberInputElement, errorMsg, true);
    }
    else if(phoneNumberInputValue.length !== 10) {
        errorMsg = languageList["Phone number must be 10 characters long"]
        displayError(phoneNumberInputElement, errorMsg, true);
    }
    else {
        displayError(phoneNumberInputElement, "", false);
    }

    // CLIENT PASSWORD
    if(passwordInputValue.length === 0) {
        errorMsg = languageList["Client Password is required"];
        displayError(passwordInputElement, errorMsg, true);
    }
    else if(passwordInputValue.length < 8) {
        errorMsg = languageList["Password must be at least 8 characters"];
        displayError(passwordInputElement, errorMsg, true);
    }
    else if(!passwordInputValue.match(/[a-z]/)) {
        errorMsg = languageList["Password must contain at least one letter"];
        displayError(passwordInputElement, errorMsg, true);
    }
    else if(!passwordInputValue.match(/[0-9]/)) {
        errorMsg = languageList["Password must contain at least one number"];
        displayError(passwordInputElement, errorMsg, true);
    }
    else {
        displayError(passwordInputElement, "", false);
    }

    if(passwordInputValue !== passwordConfirmationInputValue) {
        errorMsg = languageList["Passwords should match"];
        displayError(passwordConfirmationInputElement, errorMsg, true);
    }
    else {
        displayError(passwordConfirmationInputElement, "", false);
    }

    if(errorMsg.length === 0) {
        const captchaResponse = $("#g-recaptcha-response").val();
        document.getElementById("signup-form").submit();

        // if(captchaResponse.length === 0) {
        //     $("#sign-form-robot").css("display", "flex")
        // }
        // else {
        //     document.getElementById("signup-form").submit();
        // }
    }

}

function setSubmitButton(buttonElement) {
    buttonElement.click(function() {
        onClickSubmitButton();
    })
}


// const validation = new JustValidate("#signup-form")
// validation
//     .addField("#cltUsername-input", [
//         {
//             rule: "required",
//             errorMessage: languageList["Client Username is required"],
//         },
//         {
//             rule: "minLength",
//             value: 3,
//             errorMessage: languageList["Client Username must be at least 3 characters"],
//         }
//     ])
//     .addField("#cltFirstName-input", [
//         {
//             rule: "required",
//             errorMessage: languageList["Client First Name is required"],
//         },
//         {
//             rule: "minLength",
//             value: 3,
//             errorMessage: languageList["Client First Name must be at least 3 characters"],
//         }
//     ])
//     .addField("#cltLastName-input", [
//         {
//             rule: "required",
//             errorMessage: languageList["Client Last Name is required"],
//         },
//         {
//             rule: "minLength",
//             value: 3,
//             errorMessage: languageList["Client Last Name must be at least 3 characters"],
//         }
//     ])
//     .addField("#cltEmail-input", [
//         {
//             rule: "required",
//             errorMessage: languageList["Client Email is required"],
//         },
//         {
//             rule: "email",
//             errorMessage: languageList["Must be an email"],
//         },
//         {
//             validator: (value) => () => {
//                 return fetch("../php-processes/validate-email.php?email-input=" +
//                     encodeURIComponent(value))
//                     .then(function(response) {
//                         return response.json();
//                     })
//                     .then(function(json) {
//                         return json.available;
//                     });
//             },
//             errorMessage: languageList["Email is already Taken"],
//
//         }
//     ])
//     .addField("#cltPhoneNumber-input", [
//         {
//             rule : "number",
//             errorMessage: languageList["Client Phone Number must be a number"],
//         },
//         {
//             rule: "minLength",
//             value: 10,
//         },
//         {
//             rule: "maxLength",
//             value: 10,
//         }
//     ])
//     .addField("#cltPassword-input", [
//         {
//             rule: "required",
//             errorMessage: languageList["Client Password is required"],
//         },
//         {
//             rule: "password"
//         }
//     ])
//     .addField("#cltPasswordConfirmation-input", [
//         {
//             validator: (value, fields) => {
//                 fields = $("#cltPassword-input").val();
//                 return value === fields;
//             },
//             errorMessage: languageList["Passwords should match"],
//         }
//     ])
//     .onSuccess((event) => {
//         const captchaResponse = $("#g-recaptcha-response").val();
//         document.getElementById("signup-form").submit();
//
//         // if(captchaResponse.length === 0) {
//         //     $("#sign-form-robot").css("display", "flex")
//         // }
//         // else {
//         //     document.getElementById("signup-form").submit();
//         // }
//     });
//
//
//
