// CONSTANTS
// HARDCODED INPUT IDS
const newPasswordInputID = "newPassword-input";
const newPasswordConfirmationInputID = "newPasswordConfirmation-input";

// HARDCODED BUTTON IDS
const submitButtonID = "submit-password-reset-button";

// VOLATILE SPAN CLASSES
const errorSpanClass = "sign-form-error-span";

// HARDCODED INPUT ELEMENTS
const newPasswordInputElement = $("#"+newPasswordInputID)
const newPasswordConfirmationInputElement = $("#"+newPasswordConfirmationInputID)

// HARDCODED BUTTON ELEMENTS
const submitButtonElement = $("#"+submitButtonID)

// JSON VARIABLES
let languageList;
let isAvailable;

let languageUrl = "../php-processes/language-list-process.php?file=password-reset-validation"
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

    const passwordInputValue = newPasswordInputElement.val();
    const passwordConfirmationInputValue = newPasswordConfirmationInputElement.val();

    // CLIENT PASSWORD
    if(passwordInputValue.length === 0) {
        errorMsg = languageList["Password is required"];
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
        document.getElementById("password-reset-form").submit();

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


// refreshLanguageList();
//
// let languageList;
//
// function refreshLanguageList() {
//     let languageUrl = "../php-processes/language-list-process.php?file=password-reset-validation"
//     $.getJSON(languageUrl, function(json) {
//         languageList = json.languageList;
//     })
// }
//
// const validation = new JustValidate("#password-reset-form")
//
// validation
//     .addField("#newPassword-input", [
//         {
//             rule: "required",
//             errorMessage: languageList['New Password is required'],
//         },
//         {
//             rule: "password"
//         }
//     ])
//     .addField("#newPasswordConfirmation-input", [
//         {
//             validator: (value, fields) => {
//                 fields = $("#newPassword-input").val();
//                 return value === fields;
//             },
//             errorMessage: languageList["Passwords should match"],
//         }
//     ])
//     .onSuccess((event) => {
//         const captchaResponse = $("#g-recaptcha-response").val();
//         document.getElementById('password-reset-form').submit();
//
//         // if(captchaResponse.length === 0) {
//         //     $("#sign-form-robot").css('display', 'flex')
//         // }
//         // else {
//         //     document.getElementById('password-reset-form').submit();
//         // }
//     });
