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

function onClickSubmitButton() {
    // GET VALUES
    errorBool = 0;

    let validatePasswordVar;
    let validatePasswordConfirmationVar;

    const passwordInputValue = newPasswordInputElement.val();
    const passwordConfirmationInputValue = newPasswordConfirmationInputElement.val();

    validatePasswordVar = validatePassword(passwordInputValue, true)
    displayError(newPasswordInputElement, validatePasswordVar.errorMsg, validatePasswordVar.errorBool);

    validatePasswordConfirmationVar = validatePasswordComparison(passwordInputValue, passwordConfirmationInputValue, true)
    displayError(newPasswordConfirmationInputElement, validatePasswordConfirmationVar.errorMsg, validatePasswordConfirmationVar.errorBool);

    setTimeout(()=> {
        if(validatePasswordVar.passwordTaken && errorBool === 0) {
            validatePasswordVar = validatePasswordAvailable(true);
            displayError(newPasswordConfirmationInputElement, validatePasswordVar.errorMsg, validatePasswordVar.errorBool);

            if(errorBool === 0) {
                const captchaResponse = $("#g-recaptcha-response").val();
                console.log("VALIDATED")

                document.getElementById("password-reset-form").submit();

                // if(captchaResponse.length === 0) {
                //     $("#sign-form-robot").css("display", "flex")
                // }
                // else {
                //     document.getElementById("password-reset-form").submit();
                // }
            }
        }


        console.log(errorBool)

    }, 100)

}

function setSubmitButton(buttonElement) {
    buttonElement.click(function() {
        onClickSubmitButton();
    })
}

setSubmitButton(submitButtonElement);

