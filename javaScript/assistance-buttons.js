// CONSTANTS
// HARDCODED DIV IDS
const assistanceQuestionDivID = "as-assistance-question-div";

// HARDCODED INPUT IDS
const assistanceQuestionInputID = 'as-assistance-question-input';

// HARDCODED SPAN IDS
const assistanceNoQuestionSpanID = 'as-assistance-no-question-span'

// HARDCODED DIV ELEMENTS
const assistanceQuestionDivElement = $("#"+assistanceQuestionDivID);

// HARDCODED INPUT ELEMENTS
const assistanceQuestionInputElement = $("#"+assistanceQuestionInputID)

// HARDCODED SPAN ELEMENTS
const assistanceNoQuestionSpanElement = $("#"+assistanceNoQuestionSpanID)

// VOLATILE HREF CLASSES
const assistanceQuestionClass = "as-assistance-question"


if(assistanceList.length > 0) {
    assistanceList.forEach(displayAssistanceQuestion)
}
else {
    assistanceNoQuestionSpanElement.css('display', 'block');
}

function displayAssistanceQuestion(value) {
    let astID = value['astID'];
    let astQuestion = value['astQuestion'];
    let astAnswer = value['astAnswer'];
    let astDate = value['astDate'];
    let astApproved = parseInt(value['astApproved']);

    if(astApproved) {
        let assistanceQuestionID = assistanceQuestionClass+'-'+astID;
        let assistanceQuestionHtml = `<a href='../php-pages/assistance-answer.php?astID=${astID}' id="${assistanceQuestionID}" class="${assistanceQuestionClass}">${astQuestion}</a>`
        assistanceQuestionDivElement.append(assistanceQuestionHtml);
    }

}

function onClickAssistanceQuestionInput(assistanceQuestionInputElement) {
    let assistanceQuestionInputValue = assistanceQuestionInputElement.val().toLowerCase();
    let pattern = new RegExp(".*"+assistanceQuestionInputValue+".*")
    let newAssistanceList = [];

    assistanceList.forEach(function(value, index) {
        if(value['astQuestion'].toLowerCase().match(pattern)) {
            newAssistanceList.push(value);
        }
    })

    $("."+assistanceQuestionClass).remove();
    assistanceNoQuestionSpanElement.css('display', 'none');

    if(newAssistanceList.length > 0) {
        newAssistanceList.forEach(displayAssistanceQuestion);
    }
    else {
        assistanceNoQuestionSpanElement.css('display', 'block');
    }

}


function setAssistanceQuestionInput(assistanceQuestionInputElement) {
    assistanceQuestionInputElement.keyup(function(e) {
        onClickAssistanceQuestionInput(assistanceQuestionInputElement)
    })
}

setAssistanceQuestionInput(assistanceQuestionInputElement)

