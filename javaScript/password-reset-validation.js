const validation = new JustValidate("#password-reset-form")

validation
    .addField("#newPassword-input", [
        {
            rule: "required",
            errorMessage: 'New Password is required'
        },
        {
            rule: "password"
        }
    ])
    .addField("#newPasswordConfirmation-input", [
        {
            validator: (value, fields) => {
                fields = $("#newPassword-input").val();
                return value === fields;
            },
            errorMessage: "Passwords should match"
        }
    ])
    .onSuccess((event) => {
        const captchaResponse = $("#g-recaptcha-response").val();
        // document.getElementById('password-reset-form').submit();

        if(captchaResponse.length === 0) {
            $("#sign-form-robot").css('display', 'flex')
        }
        else {
            document.getElementById('password-reset-form').submit();
        }
    });
