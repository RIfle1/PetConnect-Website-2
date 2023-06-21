// CONSTANTS
// HARDCODED INPUT IDS
const questionNewQuestionInputID = 'as-question-new-question-input';

// HARDCODED BUTTON IDS
const questionNewQuestionButtonID = 'as-question-new-question-button'

// HARDCODED SPAN IDS
const questionSuccessSpanID = 'as-question-success-span';
const questionFailSpanID = 'as-question-fail-span';

// HARDCODED INPUT ELEMENTS
const questionNewQuestionInputElement = $("#"+questionNewQuestionInputID)

// HARDCODED BUTTON ELEMENTS
const questionNewQuestionButtonElement = $("#"+questionNewQuestionButtonID)

// HARDCODED SPAN ELEMENTS
const questionSuccessSpanElement = $("#"+questionSuccessSpanID)
const questionFailSpanElement = $("#"+questionFailSpanID)

function onClickQuestionNewQuestionButton() {
    let questionNewQuestionInputValue = questionNewQuestionInputElement.val();

    if(questionNewQuestionInputValue.length > 0) {
        let newQuestionAjax = $.ajax({
            url: '../php-processes/assistance-question-process.php',
            type: "POST",
            data: {
                astQuestion: questionNewQuestionInputValue,
            }
        })

        newQuestionAjax.always(function() {
            questionSuccessSpanElement.css('display', 'block');
            questionFailSpanElement.css('display', 'none');
            questionNewQuestionInputElement.val('');
        })
    }
    else {
        questionSuccessSpanElement.css('display', 'none');
        questionFailSpanElement.css('display', 'block');
    }
}

function setQuestionNewQuestionButton(questionNewQuestionElement, type) {
    if(type === 'click') {
        questionNewQuestionElement.click(function() {
            onClickQuestionNewQuestionButton();
        })
    }
    else if(type === 'keyup') {
        questionNewQuestionElement.keyup(function(e) {
            if(e.keyCode === 13) {
                onClickQuestionNewQuestionButton();
            }
        })
    }
}

setQuestionNewQuestionButton(questionNewQuestionInputElement, 'keyup')
setQuestionNewQuestionButton(questionNewQuestionButtonElement, 'click')