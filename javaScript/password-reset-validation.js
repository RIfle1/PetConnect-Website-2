refreshLanguageList();

let languageList;

function refreshLanguageList() {
    let languageUrl = "../php-processes/language-list-process.php?file=password-reset-validation"
    $.getJSON(languageUrl, function(json) {
        languageList = json.languageList;
    })
}

const validation = new JustValidate("#password-reset-form")

validation
    .addField("#newPassword-input", [
        {
            rule: "required",
            errorMessage: languageList['New Password is required'],
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
            errorMessage: languageList["Passwords should match"],
        }
    ])
    .onSuccess((event) => {
        const captchaResponse = $("#g-recaptcha-response").val();
        document.getElementById('password-reset-form').submit();

        // if(captchaResponse.length === 0) {
        //     $("#sign-form-robot").css('display', 'flex')
        // }
        // else {
        //     document.getElementById('password-reset-form').submit();
        // }
    });
