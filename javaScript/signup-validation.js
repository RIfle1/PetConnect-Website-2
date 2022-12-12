const validation = new JustValidate("#signup-form")

validation
    .addField("#cltUsername-input", [
        {
            rule: "required",
            errorMessage: 'Client Username is required'
        },
        {
            rule: "minLength",
            value: 3,
            errorMessage: 'Client Username must be at least 3 characters'
        }
    ])
    .addField("#cltFirstName-input", [
        {
            rule: "required",
            errorMessage: 'Client First Name is required'
        },
        {
            rule: "minLength",
            value: 3,
            errorMessage: 'Client First Name must be at least 3 characters'
        }
    ])
    .addField("#cltLastName-input", [
        {
            rule: "required",
            errorMessage: 'Client Last Name is required'
        },
        {
            rule: "minLength",
            value: 3,
            errorMessage: 'Client Last Name must be at least 3 characters'
        }
    ])
    .addField("#cltEmail-input", [
        {
            rule: "required",
            errorMessage: 'Client Email is required'
        },
        {
            rule: "email",
            errorMessage: 'Must be an email'
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
            errorMessage: "Email is already Taken"

        }
    ])
    .addField("#cltPhoneNumber-input", [
        {
            rule : "number",
            errorMessage: 'Client Phone Number must be a number'
        },
        {
            rule: "minLength",
            value: 9,
        }
    ])
    .addField("#cltPassword-input", [
        {
            rule: "required",
            errorMessage: 'Client Password is required'
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
            errorMessage: "Passwords should match"
        }
    ])
    .onSuccess((event) => {
        const captchaResponse = $("#g-recaptcha-response").val();
        document.getElementById('signup-form').submit();

        // if(captchaResponse.length === 0) {
        //     $("#sign-form-robot").css('display', 'flex')
        // }
        // else {
        //     document.getElementById('signup-form').submit();
        // }
    });
