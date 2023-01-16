//CONSTANTS
// HARDCODED DIV IDS
const disapprovedQuestionsDivID = "am-disapproved-question-div";
const approvedQuestionsDivID = "am-approved-question-div";

// HARDCODED BUTTON IDS
const disapprovedSaveButtonID = 'am-disapproved-save-button'
const disapprovedSwitchButtonID = 'am-disapproved-switch-button'
const disapprovedDeleteButtonID = 'am-disapproved-delete-button'

const approvedSaveButtonID = 'am-approved-save-button'
const approvedSwitchButtonID = 'am-approved-switch-button'
const approvedDeleteButtonID = 'am-approved-delete-button'

// HARDCODED TEXT AREA IDS
const disapprovedQuestionTextAreaID = 'am-disapproved-question-textarea'
const disapprovedAnswerTextAreaID = 'am-disapproved-answer-textarea'

const approvedQuestionTextAreaID = 'am-approved-question-textarea'
const approvedAnswerTextAreaID = 'am-approved-answer-textarea'

// HARDCODED DIV ELEMENTS
const disapprovedQuestionsDivElement = $("#"+disapprovedQuestionsDivID);
const approvedQuestionsDivElement = $("#"+approvedQuestionsDivID);

// HARDCODED BUTTON ELEMENTS
const disapprovedSaveButtonElement = $("#"+disapprovedSaveButtonID);
const disapprovedSwitchButtonElement = $("#"+disapprovedSwitchButtonID);
const disapprovedDeleteButtonElement = $("#"+disapprovedDeleteButtonID);

const approvedSaveButtonElement = $("#"+approvedSaveButtonID);
const approvedSwitchButtonElement = $("#"+approvedSwitchButtonID);
const approvedDeleteButtonElement = $("#"+approvedDeleteButtonID);

// HARDCODED TEXT AREA ELEMENTS
const disapprovedQuestionTextAreaElement = $("#"+disapprovedQuestionTextAreaID)
const disapprovedAnswerTextAreaElement = $("#"+disapprovedAnswerTextAreaID)

const approvedQuestionTextAreaElement = $("#"+approvedQuestionTextAreaID)
const approvedAnswerTextAreaElement = $("#"+approvedAnswerTextAreaID)

// VOLATILE SPAN CLASSES
const disapprovedQuestionSpanClass = 'am-disapproved-question-span';
const approvedQuestionSpanClass = 'am-approved-question-span';

let displayedAssistanceItems = 0;

Object.entries(assistanceList).forEach(displayAssistanceManageQuestions)

function displayAssistanceManageQuestions(value) {
    displayedAssistanceItems ++;

    let astID = value[1]['astID'];
    let astQuestion = value[1]['astQuestion'];
    let astAnswer = value[1]['astAnswer'];
    let astApproved = parseInt(value[1]['astApproved']);

    let questionHtml;
    let questionSpanID;
    let questionsDivElement;

    if(astApproved) {
        questionSpanID = approvedQuestionSpanClass+'-'+astID
        questionHtml = `<span id='${questionSpanID}' class='${approvedQuestionSpanClass} am-question-span'>${astQuestion}</span>\n`
        questionsDivElement = approvedQuestionsDivElement;
    }
    else {
        questionSpanID = disapprovedQuestionSpanClass+'-'+astID
        questionHtml = `<span id='${questionSpanID}' class='${disapprovedQuestionSpanClass} am-question-span'>${astQuestion}</span>\n`
        questionsDivElement = disapprovedQuestionsDivElement;
    }

    questionsDivElement.append(questionHtml);
    let questionSpanElement = $("#"+questionSpanID);
    setQuestionSpanButton(questionSpanElement, value, astID)


    if(displayedAssistanceItems === Object.keys(assistanceList).length) {
        approvedQuestionsDivElement.children().first().trigger('click');
        disapprovedQuestionsDivElement.children().first().trigger('click');
    }
}

function onClickQuestionSpanButton(questionSpanElement, value, astID) {
    if(parseInt(value[1]['astApproved'])) {
        $("."+approvedQuestionSpanClass).css('border-color', '#9E9E9E')

        approvedSaveButtonElement.val(astID)
        approvedSwitchButtonElement.val(astID)
        approvedDeleteButtonElement.val(astID)

        approvedQuestionTextAreaElement.val(value[1]['astQuestion'])
        approvedAnswerTextAreaElement.val(value[1]['astAnswer'])
    }
    else {
        $("."+disapprovedQuestionSpanClass).css('border-color', '#9E9E9E')

        disapprovedSaveButtonElement.val(astID)
        disapprovedSwitchButtonElement.val(astID)
        disapprovedDeleteButtonElement.val(astID)

        disapprovedQuestionTextAreaElement.val(value[1]['astQuestion'])
        disapprovedAnswerTextAreaElement.val(value[1]['astAnswer'])
    }

    questionSpanElement.css('border-color', '#69A6E3')
}

function setQuestionSpanButton(questionSpanElement, value, astID) {
    questionSpanElement.click(function() {
        onClickQuestionSpanButton(questionSpanElement, value, astID)
    })
}

function onClickSaveButton(saveButtonElement) {
    let astID = saveButtonElement.val();

    let questionTextAreaElement;
    let answerTextAreaElement;

    if(saveButtonElement === disapprovedSaveButtonElement) {
        questionTextAreaElement = disapprovedQuestionTextAreaElement;
        answerTextAreaElement = disapprovedAnswerTextAreaElement;
    }
    else if(saveButtonElement === approvedSaveButtonElement) {
        questionTextAreaElement = approvedQuestionTextAreaElement;
        answerTextAreaElement = approvedAnswerTextAreaElement;
    }

    let astQuestion = questionTextAreaElement.val();
    let astAnswer = answerTextAreaElement.val();

    // UPDATE NEW VALUES IN THE DATABASE
    let saveAssistanceAjax = $.ajax({
        url: '../php-processes/assistance-manage-process.php',
        type: 'POST',
        data: {
            type: 'save',
            astID: astID,
            astQuestion: astQuestion,
            astAnswer: astAnswer,
        }
    })

    saveAssistanceAjax.always(function() {
        let questionSpanID;
        let questionSpanElement;

        if(saveButtonElement === disapprovedSaveButtonElement) {
            questionSpanID = disapprovedQuestionSpanClass+'-'+astID
            questionSpanElement = $("#"+questionSpanID)
        }
        else if(saveButtonElement === approvedSaveButtonElement) {
            questionSpanID = approvedQuestionSpanClass+'-'+astID
            questionSpanElement = $("#"+questionSpanID)
        }

        // UPDATE NEW VALUES VISUALLY
        questionSpanElement.text(astQuestion);

        // UPDATE NEW VALUES IN THE LOCAL OBJECT LIST
        assistanceList[astID]['astQuestion'] = astQuestion;
        assistanceList[astID]['astAnswer'] = astAnswer;
    })
}

function onClickSwitchButton(switchButtonElement) {
    let astID = switchButtonElement.val();

    // UPDATE NEW VALUES IN THE DATABASE
    let switchAssistanceAjax = $.ajax({
        url: '../php-processes/assistance-manage-process.php',
        type: 'POST',
        data: {
            type: 'switch',
            astID: astID,
        }
    })

    switchAssistanceAjax.always(function() {
        let questionSpanID;
        let questionSpanElement;
        let questionsDivElement;

        let answerTextAreaElement;
        let questionTextAreaElement;

        if(switchButtonElement === disapprovedSwitchButtonElement) {
            questionsDivElement = disapprovedQuestionsDivElement;
            answerTextAreaElement = disapprovedAnswerTextAreaElement;
            questionTextAreaElement = disapprovedQuestionTextAreaElement;

            questionSpanID = disapprovedQuestionSpanClass+'-'+astID
            questionSpanElement = $("#"+questionSpanID)
        }
        else if(switchButtonElement === approvedSwitchButtonElement) {
            questionsDivElement = approvedQuestionsDivElement;
            answerTextAreaElement = approvedAnswerTextAreaElement;
            questionTextAreaElement = approvedQuestionTextAreaElement;

            questionSpanID = approvedQuestionSpanClass+'-'+astID
            questionSpanElement = $("#"+questionSpanID)
        }

        // UPDATE NEW VALUES IN THE LOCAL OBJECT LIST
        if(parseInt(assistanceList[astID]['astApproved']) === 1) {
            assistanceList[astID]['astApproved'] = 0;
        }
        else if(parseInt(assistanceList[astID]['astApproved']) === 0) {
            assistanceList[astID]['astApproved'] = 1;
        }

        // UPDATE NEW VALUES VISUALLY
        questionSpanElement.remove();
        answerTextAreaElement.val('')
        questionTextAreaElement.val('')

        let value = [
            assistanceList[astID]['astID'],
            assistanceList[astID]
        ]
        displayAssistanceManageQuestions(value);

        questionsDivElement.children().first().trigger('click');
    })
}

function onClickDeleteButton(deleteButtonElement) {
    let astID = deleteButtonElement.val();

    // UPDATE NEW VALUES IN THE DATABASE
    let deleteAssistanceAjax = $.ajax({
        url: '../php-processes/assistance-manage-process.php',
        type: 'POST',
        data: {
            type: 'delete',
            astID: astID,
        }
    })

    deleteAssistanceAjax.always(function() {
        let questionSpanID;
        let questionSpanElement;
        let questionsDivElement;

        let answerTextAreaElement;
        let questionTextAreaElement;

        if(deleteButtonElement === disapprovedDeleteButtonElement) {
            questionsDivElement = disapprovedQuestionsDivElement;
            answerTextAreaElement = disapprovedAnswerTextAreaElement;
            questionTextAreaElement = disapprovedQuestionTextAreaElement;

            questionSpanID = disapprovedQuestionSpanClass+'-'+astID
            questionSpanElement = $("#"+questionSpanID)
        }
        else if(deleteButtonElement === approvedDeleteButtonElement) {
            questionsDivElement = approvedQuestionsDivElement;
            answerTextAreaElement = approvedAnswerTextAreaElement;
            questionTextAreaElement = approvedQuestionTextAreaElement;

            questionSpanID = approvedQuestionSpanClass+'-'+astID
            questionSpanElement = $("#"+questionSpanID)
        }

        // UPDATE NEW VALUES IN THE LOCAL OBJECT LIST
        delete assistanceList[astID];

        // UPDATE NEW VALUES VISUALLY
        questionSpanElement.remove();
        answerTextAreaElement.val('')
        questionTextAreaElement.val('')

        questionsDivElement.children().first().trigger('click');
    })

}

function setSaveButton(saveButtonElement) {
    saveButtonElement.click(function() {
        onClickSaveButton(saveButtonElement);
    })
}

function setSwitchButton(switchButtonElement) {
    switchButtonElement.click(function() {
        onClickSwitchButton(switchButtonElement);
    })
}

function setDeleteButton(deleteButtonElement) {
    deleteButtonElement.click(function() {
        onClickDeleteButton(deleteButtonElement);
    })
}

setSaveButton(approvedSaveButtonElement);
setSwitchButton(approvedSwitchButtonElement);
setDeleteButton(approvedDeleteButtonElement);

setSaveButton(disapprovedSaveButtonElement);
setSwitchButton(disapprovedSwitchButtonElement);
setDeleteButton(disapprovedDeleteButtonElement);