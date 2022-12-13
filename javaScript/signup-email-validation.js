$("#submit-button").click(function() {
    $.getJSON("../php-processes/signup-email-validation.php", function(json) {

        const clientInfo = json.clientInfo;
        const verificationCode = clientInfo['verificationCode']
        const cltVerifiedEmail = clientInfo['cltVerifiedEmail']
        const newCltID = clientInfo['newCltID']
        const cltToken = clientInfo['cltToken']
        const verificationCodeInput = $("#verificationCode-input").val();

        console.log(verificationCode);
        console.log(typeof cltVerifiedEmail);
        // console.log(cltToken);

        if(verificationCode === verificationCodeInput) {
            console.log('cltVerified Email set to 1')
            $.ajax({
                type: "POST",
                url: "../php-processes/signup-email-validation.php",
                data: {
                    newCltID: newCltID,
                    verificationCode: verificationCode,
                    cltToken: cltToken
                },
                success: function(result) {
                },
                error: function(requestObject, error, errorThrown) {
                    alert(error);
                    alert(errorThrown);
                }
            })
            console.log('verified')
            changeSignupSuccessPage();

        }

        else {
            console.log('false code')
            $("#sign-form-validate-error").css('display', "flex");
        }

    })
});


$.getJSON("../php-processes/signup-email-validation.php", function(json) {
    const clientInfo = json.clientInfo;
    const cltVerifiedEmail = clientInfo['cltVerifiedEmail']
    if(cltVerifiedEmail === 1) {
        changeSignupSuccessPage();
    }
})

function changeSignupSuccessPage() {
    $("#sign-form-header").html('Email Validated');
    $("#sign-form-message").html('Your email has been validated. You can now <a href="../php-pages/login.php">Login<a/>.');
    $("#submit-button-div").remove();
    $("#sign-form-input-div").remove();
    $("#sign-form-validate-error").remove();
}