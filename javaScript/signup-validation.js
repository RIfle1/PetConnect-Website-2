// CONSTANTS
// HARDCODED INPUT IDS
const usernameInputID = "cltUsername-input";
const firstNameInputID = "cltFirstName-input";
const lastNameInputID = "cltLastName-input";
const emailInputID = "cltEmail-input";
const phoneNumberInputID = "cltPhoneNumber-input";
const passwordInputID = "cltPassword-input";
const passwordConfirmationInputID = "cltPasswordConfirmation-input";

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

// JSON VARIABLES
let languageList;

let languageUrl = "../php-processes/language-list-process.php?file=signup-validation"
$.getJSON(languageUrl, function(json) {
    languageList = json.languageList;
    setSubmitButton(submitButtonElement);
    console.log("here");
})

function onClickSubmitButton() {
    // GET VALUES
    let errorMsg;



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
    }
    else if(usernameInputValue.length < 3) {
        errorMsg = languageList["Client Username must be at least 3 characters"]
    }

    // CLIENT FIRST NAME
    if(firstNameInputValue.length === 0) {
        errorMsg = languageList["Client First Name is required"]
    }
    else if(firstNameInputValue.length < 3) {
        errorMsg = languageList["Client First Name must be at least 3 characters"]
    }

    // CLIENT LAST NAME
    if(lastNameInputValue.length === 0) {
        errorMsg = languageList["Client Last Name is required"]
    }
    else if(lastNameInputValue.length < 3) {
        errorMsg = languageList["Client Last Name must be at least 3 characters"]
    }

    // CLIENT EMAIL
    if(emailInputValue.length === 0) {
        errorMsg = languageList["Client Email is required"]
    }
    else if(!emailInputValue.match(/@/)) {
        errorMsg = languageList["Must be an email"]
    }
    // else if(a)







    languageList["Email is already Taken"]
    languageList["Client Phone Number must be a number"]
    languageList["Client Password is required"]
    languageList["Passwords should match"]













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
//                 return fetch("../php-processes/validate-email.php?cltEmail-input=" +
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



