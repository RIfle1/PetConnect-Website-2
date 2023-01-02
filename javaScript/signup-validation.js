let languageUrl = "../php-processes/language-list-process.php?file=signup-validation"
$.getJSON(languageUrl, function(json) {
    let languageList = json.languageList;
    const validation = new JustValidate("#signup-form")

    validation
        .addField("#cltUsername-input", [
            {
                rule: "required",
                errorMessage: languageList["Client Username is required"],
            },
            {
                rule: "minLength",
                value: 3,
                errorMessage: languageList["Client Username must be at least 3 characters"],
            }
        ])
        .addField("#cltFirstName-input", [
            {
                rule: "required",
                errorMessage: languageList["Client First Name is required"],
            },
            {
                rule: "minLength",
                value: 3,
                errorMessage: languageList["Client First Name must be at least 3 characters"],
            }
        ])
        .addField("#cltLastName-input", [
            {
                rule: "required",
                errorMessage: languageList["Client Last Name is required"],
            },
            {
                rule: "minLength",
                value: 3,
                errorMessage: languageList["Client Last Name must be at least 3 characters"],
            }
        ])
        .addField("#cltEmail-input", [
            {
                rule: "required",
                errorMessage: languageList["Client Email is required"],
            },
            {
                rule: "email",
                errorMessage: languageList["Must be an email"],
            },
            {
                validator: (value) => () => {
                    return fetch("../php-processes/validate-email.php?cltEmail-input=" +
                        encodeURIComponent(value))
                        .then(function(response) {
                            return response.json();
                        })
                        .then(function(json) {
                            return json.available;
                        });
                },
                errorMessage: languageList["Email is already Taken"],

            }
        ])
        .addField("#cltPhoneNumber-input", [
            {
                rule : "number",
                errorMessage: languageList["Client Phone Number must be a number"],
            },
            {
                rule: "minLength",
                value: 10,
            },
            {
                rule: "maxLength",
                value: 10,
            }
        ])
        .addField("#cltPassword-input", [
            {
                rule: "required",
                errorMessage: languageList["Client Password is required"],
            },
            {
                rule: "password"
            }
        ])
        .addField("#cltPasswordConfirmation-input", [
            {
                validator: (value, fields) => {
                    fields = $("#cltPassword-input").val();
                    return value === fields;
                },
                errorMessage: languageList["Passwords should match"],
            }
        ])
        .onSuccess((event) => {
            const captchaResponse = $("#g-recaptcha-response").val();
            document.getElementById("signup-form").submit();

            // if(captchaResponse.length === 0) {
            //     $("#sign-form-robot").css("display", "flex")
            // }
            // else {
            //     document.getElementById("signup-form").submit();
            // }
        });
})



