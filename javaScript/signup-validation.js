const validation = new JustValidate("#signup-form")

validation
    .addField("#cltUsername-input", [
        {
            rule: "required"
        },
        {
            rule: "minLength",
            value: 3,
        }
    ])
    .addField("#cltFirstName-input", [
        {
            rule: "required"
        },
        {
            rule: "minLength",
            value: 3,
        }
    ])
    .addField("#cltLastName-input", [
        {
            rule: "required"
        },
        {
            rule: "minLength",
            value: 3,
        }
    ])
    .addField("#cltEmail-input", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            validator: (value) => () => {
                return fetch("validate-email.php?cltEmail-input=" +
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
            rule : "number"
        },
        {
            rule: "minLength",
            value: 9,
        }
    ])
    .addField("#cltPassword-input", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#cltPasswordConfirmation-input", [
        {
            validator: (value, fields) => {
                return value === fields["#cltPassword-input"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ]).onSuccess((event) => {
       document.getElementById("signup-form").submit();
    });
