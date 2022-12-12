$("#submit-login-button").click(function() {

    const captchaResponse = $("#g-recaptcha-response").val();

    // document.getElementById('login-form').submit();

    if(captchaResponse.length === 0) {
        $("#sign-form-robot").css('display', 'flex')
    }
    else {
        document.getElementById('login-form').submit();
    }
})

$("#submit-password-recovery-button").click(function() {

    const captchaResponse = $("#g-recaptcha-response").val();

    document.getElementById('password-recovery-input-form').submit();

    // if(captchaResponse.length === 0) {
    //     $("#sign-form-robot").css('display', 'flex')
    // }
    // else {
    //     document.getElementById('password-recovery-input-form').submit();
    // }
})


