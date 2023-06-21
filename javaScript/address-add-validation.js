// CONSTANTS
// HARDCODED INPUT IDS
const addressInputID = "add-form-address";
const postalCodeInputID = "add-form-postalCode";
const cityInputID = "add-form-city";

// HARDCODED BUTTON IDS
const submitAddressButtonID = "add-form-submit-button";

// HARDCODED FORM IDS
const addressFormID = "add-form";

// HARDCODED INPUT ELEMENTS
const addressInputElement = $("#"+addressInputID);
const postalCodeInputElement = $("#"+postalCodeInputID);
const cityInputElement = $("#"+cityInputID);

// HARDCODED BUTTON IDS
const submitAddressButtonElement = $("#"+submitAddressButtonID);

// HARDCODED FORM ELEMENTS
const addressFormElement = $("#"+addressFormID);


function onClickAddressSubmitButton() {
    errorBool = 0;

    // GET ALL VALUES
    let addressInputValue = addressInputElement.val();
    let postalCodeInputValue = postalCodeInputElement.val();
    let cityInputValue = cityInputElement.val();

    // GET VALIDATE VARIABLES
    let validateAddressVar = validateAddress(addressInputValue);
    let validatePostalCodeVar = validatePostalCode(postalCodeInputValue);
    let validateCityVar = validateCity(cityInputValue);

    displayError(addressInputElement, validateAddressVar.errorMsg, validateAddressVar.errorBool);
    displayError(postalCodeInputElement, validatePostalCodeVar.errorMsg, validatePostalCodeVar.errorBool);
    displayError(cityInputElement, validateCityVar.errorMsg, validateCityVar.errorBool);

    if(errorBool === 0) {
        addressFormElement.submit();
    }
}

function setSubmitAddressButton(submitAddressButtonElement) {
    submitAddressButtonElement.click(function() {
        onClickAddressSubmitButton();
    })
}

setSubmitAddressButton(submitAddressButtonElement);