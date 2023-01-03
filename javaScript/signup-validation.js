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

setSubmitButton(submitButtonElement);

function displayError(inputElement, errorMsg, error) {
    $("."+errorSpanClass+"-"+inputElement.attr("name")).remove();
    if(error) {
        inputElement.parent().append("<span class="+errorSpanClass+"-"+inputElement.attr("name")+">"+errorMsg+"</span>")
    }
}

function onClickSubmitButton() {
    // GET VALUES
    let validateVar;

    const usernameInputValue = usernameInputElement.val();
    const firstNameInputValue = firstNameInputElement.val();
    const lastNameInputValue = lastNameInputElement.val();
    const emailInputValue = emailInputElement.val();
    const phoneNumberInputValue = phoneNumberInputElement.val();
    const passwordInputValue = passwordInputElement.val();
    const passwordConfirmationInputValue = passwordConfirmationInputElement.val();

    // CLIENT USERNAME
    validateVar = validateUsername(usernameInputValue)
    displayError(usernameInputElement, validateVar.errorMsg, validateVar.errorBool)

    // CLIENT FIRST NAME
    validateVar = validateFirstName(firstNameInputValue);
    displayError(firstNameInputElement, validateVar.errorMsg, validateVar.errorBool);

    // CLIENT LAST NAME
    validateVar = validateLastName(lastNameInputValue)
    displayError(lastNameInputElement, validateVar.errorMsg, validateVar.errorBool);

    // CLIENT EMAIL
    validateVar = validateEmail(emailInputValue)
    displayError(emailInputElement, validateVar.errorMsg, validateVar.errorBool);

    setTimeout(()=> {
        validateVar = validateEmail(emailInputValue);
        if(!validateVar.errorBool) {
            validateVar = validateEmailTaken();
            displayError(emailInputElement, validateVar.errorMsg, validateVar.errorBool);
        }
    }, 100)

    // CLIENT PHONE NUMBER
    validateVar = validatePhoneNumber(phoneNumberInputValue)
    displayError(phoneNumberInputElement, validateVar.errorMsg, validateVar.errorBool);

    // CLIENT PASSWORD
    validateVar = validatePassword(passwordInputValue, passwordConfirmationInputValue)
    displayError(passwordInputElement, validateVar.errorMsg, validateVar.errorBool);

    // IF NO ERRORS
    if(!errorBool) {
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
