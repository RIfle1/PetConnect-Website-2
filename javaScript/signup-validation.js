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

function onClickSubmitButton() {
    // VARIABLES
    let validateUsernameVar;
    let validateFirstNameVar;
    let validateLastNameVar;
    let validateEmailVar;
    let validatePhoneNumberVar;
    let validatePasswordVar;
    let validatePasswordConfirmationVar;


    errorBool = 0;

    const usernameInputValue = usernameInputElement.val();
    const firstNameInputValue = firstNameInputElement.val();
    const lastNameInputValue = lastNameInputElement.val();
    const emailInputValue = emailInputElement.val();
    const phoneNumberInputValue = phoneNumberInputElement.val();
    const passwordInputValue = passwordInputElement.val();
    const passwordConfirmationInputValue = passwordConfirmationInputElement.val();

    // CLIENT USERNAME
    validateUsernameVar = validateUsername(usernameInputValue)
    displayError(usernameInputElement, validateUsernameVar.errorMsg, validateUsernameVar.errorBool)

    // CLIENT FIRST NAME
    validateFirstNameVar = validateFirstName(firstNameInputValue);
    displayError(firstNameInputElement, validateFirstNameVar.errorMsg, validateFirstNameVar.errorBool);

    // CLIENT LAST NAME
    validateLastNameVar = validateLastName(lastNameInputValue)
    displayError(lastNameInputElement, validateLastNameVar.errorMsg, validateLastNameVar.errorBool);

    // CLIENT EMAIL
    validateEmailVar = validateEmail(emailInputValue)
    displayError(emailInputElement, validateEmailVar.errorMsg, validateEmailVar.errorBool);

    // CLIENT PHONE NUMBER
    validatePhoneNumberVar = validatePhoneNumber(phoneNumberInputValue)
    displayError(phoneNumberInputElement, validatePhoneNumberVar.errorMsg, validatePhoneNumberVar.errorBool);

    // CLIENT PASSWORD
    validatePasswordVar = validatePassword(passwordInputValue, false)
    displayError(passwordInputElement, validatePasswordVar.errorMsg, validatePasswordVar.errorBool);

    validatePasswordConfirmationVar = validatePasswordComparison(passwordInputValue, passwordConfirmationInputValue, true)
    displayError(passwordConfirmationInputElement, validatePasswordConfirmationVar.errorMsg, validatePasswordConfirmationVar.errorBool);

    setTimeout(()=> {
        if(validateEmailVar.emailTaken) {
            validateEmailVar = validateEmailTaken();
            displayError(emailInputElement, validateEmailVar.errorMsg, validateEmailVar.errorBool);
        }

        // IF NO ERRORS
        if(errorBool === 0) {
            const captchaResponse = $("#g-recaptcha-response").val();

            document.getElementById("signup-form").submit();

            // if(captchaResponse.length === 0) {
            //     $("#sign-form-robot").css("display", "flex")
            // }
            // else {
            //     document.getElementById("signup-form").submit();
            // }
        }

    }, 100)

}

function setSubmitButton(buttonElement) {
    buttonElement.click(function() {
        onClickSubmitButton();
    })
}

