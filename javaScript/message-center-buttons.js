// CALL JSON FUNCTION TO GET THE DATA ASAP
// refreshMessagesMessageJson();
// refreshMessagesResolvedJson();
// refreshSessionMessagesListJson();
// refreshStaticJson();
// refreshLanguageList();

    // CONSTANTS FOR MESSAGING SYSTEM
// VOLATILE BUTTONS / DIVS / SPANS
const messageActiveUserButtonClass = "mc-message-active-user-button";
const messageActiveOwnerClass = "mc-message-active-owner";
const messageActiveUsernameClass = "mc-message-active-username";
const messageActiveShortMessageClass = "mc-message-active-short-message";
const messageActiveTimeClass = "mc-message-active-time";
const messageNoActiveUserClass = "no-message-active-div"

// VOLATILE DIV CLASSES
const messageCurrentUserDivClass = "mc-current-user-message-div";
const messageForeignUserDivClass = "mc-foreign-user-message-div";

// HARDCODED DIV ID'S
const messageMainDivID = "mc-message-main-div";
const messageActiveDivID = "mc-message-active-div";
const messageTextDivID = 'mc-message-text-div'
const messageUserDivID = "mc-message-user-div";

// HARDCODED BUTTONS
const messageShowHideButtonID = "mc-admin-show-message-button";
const messageMarkAsResolvedButtonID = "mc-admin-mark-resolved-button";
const messageDeleteConversationButtonID = "mc-admin-delete-message-button";

// HARDCODED DIV ELEMENTS
// const messageTextDivElement = $('#'+messageTextDivID);
const messageShowHideButtonElement = $("#"+messageShowHideButtonID)
const messageMarkAsResolvedButtonElement = $("#"+messageMarkAsResolvedButtonID)
const messageDeleteConversationButtonElement = $("#"+messageDeleteConversationButtonID);

const messageMainDivElement = $("#"+messageMainDivID);
const messageActiveDivElement = $("#"+messageActiveDivID);
const messageTextDivElement = $("#"+messageTextDivID);
const messageUserDivElement = $("#"+messageUserDivID);

// ---------------------------------------------------------------------------------------------------------

    // CONSTANTS FOR RESOLVED MESSAGES SYSTEM (ARCHIVED)
// VOLATILE BUTTONS / DIVS / SPANS
const resolvedActiveUserButtonClass = "mc-resolved-active-user-button";
const resolvedActiveOwnerClass = "mc-resolved-active-owner";
const resolvedActiveUsernameClass = "mc-resolved-active-username";
const resolvedActiveShortMessageClass = "mc-resolved-active-short-message";
const resolvedActiveTimeClass = "mc-resolved-active-time";
const resolvedNoActiveUserClass = "no-resolved-active-div"

// VOLATILE DIV CLASSES
const resolvedCurrentUserDivClass = "mc-current-user-resolved-div";
const resolvedForeignUserDivClass = "mc-foreign-user-resolved-div";

// HARDCODED DIV ID'S
const resolvedMainDivID = "mc-resolved-main-div";
const resolvedActiveDivID = "mc-resolved-active-div";
const resolvedTextDivID = 'mc-resolved-text-div'
const resolvedUserDivID = "mc-resolved-user-div";

// HARDCODED LABEL ID'S
const resolvedInputLabelStartID = "mc-admin-input-label-start";
const resolvedInputLabelEndID = "mc-admin-input-label-end";

// HARDCODED INPUT ID'S
const resolvedInputDateStartID = "mc-admin-input-date-start";
const resolvedInputDateEndID = "mc-admin-input-date-end";

// HARDCODED BUTTONS
const resolvedShowHideButtonID = "mc-admin-show-resolved-button";
const resolvedDeleteConversationButtonID = "mc-admin-delete-resolved-button";
const resolvedDeleteIntervalButtonID = "mc-admin-delete-interval-button";

// HARDCODED SELECTTs
const resolvedSelectIntervalID = "mc-admin-select-interval";
const resolvedSelectDateID = "mc-admin-select-date";

// HARDCODED SPANS
const resolvedDeleteNotificationSpanID = "mc-admin-delete-notification-span";

// HARDCODED BUTTON ELEMENTS
const resolvedShowHideButtonElement = $("#"+resolvedShowHideButtonID)
const resolvedDeleteConversationButtonElement = $("#"+resolvedDeleteConversationButtonID);
const resolvedDeleteIntervalButtonElement = $("#"+resolvedDeleteIntervalButtonID);

// HARDCODED SELECT ELEMENTS
const resolvedSelectIntervalElement = $("#"+resolvedSelectIntervalID);
const resolvedSelectDateElement = $("#"+resolvedSelectDateID);

// HARDCODED DIV ELEMENTS

const resolvedMainDivElement = $("#"+resolvedMainDivID);
const resolvedActiveDivElement = $("#"+resolvedActiveDivID);
const resolvedTextDivElement = $("#"+resolvedTextDivID);
const resolvedUserDivElement = $("#"+resolvedUserDivID);

// HARDCODED LABEL ELEMENTS
const resolvedInputLabelStartElement = $("#"+resolvedInputLabelStartID);
const resolvedInputLabelEndElement = $("#"+resolvedInputLabelEndID);

// HARDCODED INPUT ELEMENTS
const resolvedInputDateStartElement = $("#"+resolvedInputDateStartID);
const resolvedInputDateEndElement = $("#"+resolvedInputDateEndID);

// HARDCODED SPAN ELEMENTS
const resolvedDeleteNotificationSpanElement = $("#"+resolvedDeleteNotificationSpanID);

// ---------------------------------------------------------------------------------------------------------

    // COMMON CONSTANTS
// COMMON HARDCODED DIV CLASSES
const textDivClass = "mc-text-div";
const mainDivClass = "mc-main-div";
const leftSideMenuDivClass = "mc-left-side-menu"

// COMMON HARDCODED DIV ELEMENTS
const textDivClassElement = $("."+textDivClass);
const mainDivClassElement = $("."+mainDivClass);
const leftSideMenuDivClassElement = $("."+leftSideMenuDivClass)

    // STORE JSON INFORMATION
// let getMessagesMessage;
// let getMessagesResolved;
// let userInfo;
// let sessionMessagesList;
// let language;
// let javaScriptLanguageList;
let getMessagesResolvedJsonProcess

    // MISC
const animationSpeed = 500;
// ---------------------------------------------------------------------------------------------------------
// INITIALIZE JSONS

    // function refreshMessagesMessageJson() {
    //     const getMessagesMessageUrl = "../php-processes/message-center-process-admin.php?getMessages=message";
    //     $.getJSON(getMessagesMessageUrl, function(json) {
    //         getMessagesMessage = json.lastMessagesList
    //     })
    // }

    function refreshMessagesResolvedJson() {
        const getMessagesResolvedUrl = "../php-processes/message-center-process-admin.php?getMessages=resolved";
        getMessagesResolvedJsonProcess = $.getJSON(getMessagesResolvedUrl, function(json) {
            getMessagesResolved = json.lastMessagesList
        })
    }

    function refreshSessionMessagesListJson() {
        let getSessionMessagesUrl = "../php-processes/message-center-process.php?sessionMessages=True";
        $.getJSON(getSessionMessagesUrl, function(json) {
            sessionMessagesList = json.sessionMessagesList
        })
    }

    // function refreshStaticJson() {
    //     const getEntityInfoUrl = "../php-processes/message-center-process.php?userInfo=True";
    //     $.getJSON(getEntityInfoUrl, function (json) {
    //         userInfo = json.entityInfo
    //     })
    // }

    // function refreshLanguageList() {
    //     let languageUrl = "../php-processes/language-list-process.php?file=message-center-buttons"
    //     $.getJSON(languageUrl, function(json) {
    //         javaScriptLanguageList = json.languageList;
    //     })
    // }

// ---------------------------------------------------------------------------------------------------------
// FUNCTIONALITY FUNCTIONS
    // noinspection JSJQueryEfficiency

// GET CURRENT TIME STAMP FOR DATABASE
    function getDateAndTimeDB(date) {
        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();

        let hour = date.getHours();
        let minute = date.getMinutes();
        let second = date.getSeconds();

        if(minute  < 10) {
            minute = "0"+minute;
        }

        if(second  < 10) {
            second = "0"+second;
        }

        return `${year}-${month}-${day} ${hour}:${minute}:${second}`;
    }

// GENERATE HTML FUNCTIONS
    function generateCurrentUserMessageHtml (currentUserDivClass, entityUsername, msgMessage, msgDate) {
        return "<div class="+currentUserDivClass+">\n" +
            "                <div>\n" +
            "                    <div class=\"mc-user-info-div\">\n" +
            "                        <span class=\"mc-user-username-span\">"+entityUsername+"</span>\n" +
            "                        <div class=\"mc-user-divider-element\"></div>\n" +
            "                        <span class=\"mc-user-time-span\">"+msgDate+"</span>\n" +
            "                    </div>\n" +
            "                    <span class=\"mc-current-user-span\">\n" +msgMessage+
            "                    </span>\n" +
            "                </div>\n" +
            "            </div>"
    }
    function generateForeignUserMessageHtml (foreignUserDivClass, entityUsername, msgMessage, msgDate) {
        return "<div class="+foreignUserDivClass+">\n" +
            "                <div>\n" +
            "                    <div class=\"mc-user-info-div\">\n" +
            "                        <span class=\"mc-user-username-span\">"+entityUsername+"</span>\n" +
            "                        <div class=\"mc-user-divider-element\"></div>\n" +
            "                        <span class=\"mc-user-time-span\">"+msgDate+"</span>\n" +
            "                    </div>\n" +
            "                    <span class=\"mc-foreign-user-span\">\n" +msgMessage+
            "                    </span>\n" +
            "                </div>\n" +
            "            </div>"

    }

// RETURN SHORT MESSAGE FUNCTION
    function returnShortMessage(msgMessage) {
        if(msgMessage.length > 20) {
            return msgMessage.substring(0, 20)+"...".toLowerCase();
        }
        else {
            return msgMessage.toLowerCase();
        }
    }

// REMOVE TEXT MESSAGES
    function removeTextMessages(currentUserDivClass, foreignUserDivClass) {
        let currentUserMessageDivElement = $('.'+currentUserDivClass);
        let foreignUserMessageDivElement = $('.'+foreignUserDivClass);

        foreignUserMessageDivElement.remove();
        currentUserMessageDivElement.remove();
    }

// REMOVE ACTIVE USER ELEMENT
    function removeActiveUserElement(entityID, type) {
        let activeUserElement
        if(type === "message") {
            activeUserElement = $("#"+messageActiveUserButtonClass+"-"+entityID)
        }
        else if(type === 'resolved') {
            activeUserElement = $("#"+resolvedActiveUserButtonClass+"-"+entityID)
        }

        activeUserElement.remove();
    }

// ANIMATION FUNCTIONS
    function observerFunction(mainDivElement, textDivElement, leftSideMenuElement) {

        let observer = new ResizeObserver(() => {
            let leftSideMenuDivWidth = leftSideMenuElement.width();
            let textDivWidth = mainDivElement.width() - leftSideMenuElement.width();

            if(mainDivElement.width() < 650) {
                textDivElement.css({
                    'width': '100%',
                    'left': '0px',
                })
            }
            else {
                textDivElement.css({
                    'width': textDivWidth+'px',
                    'left': leftSideMenuDivWidth+'px',
                })
            }
        });

        observer.observe(leftSideMenuElement[0])
        observer.observe(mainDivElement[0])
    }

    function updateAdminTextDiv() {

        let mainDivClassElementObserver = new ResizeObserver(() => {
            if(mainDivClassElement.width() < 650) {
                if(typeof(javaScriptLanguageList) !== "undefined") {

                    if(messageShowHideButtonElement.attr("name") === 'Hide') {
                        messageShowHideButtonElement.trigger('click');
                    }
                    if(resolvedShowHideButtonElement.attr("name") === 'Hide') {
                        resolvedShowHideButtonElement.trigger('click');
                    }
                }

            }

            // else if(mainDivClassElement.width() > 650) {
            //     if(messageShowHideButtonElement.attr("name") === 'hidden') {
            //         messageShowHideButtonElement.trigger('click');
            //     }
            //     if(resolvedShowHideButtonElement.attr("name") === 'hidden') {
            //         resolvedShowHideButtonElement.trigger('click');
            //     }
            // }
        });
        mainDivClassElementObserver.observe(mainDivClassElement[0])
    }

// DISPLAY MESSAGE IN THE TEXT MESSAGES TAB
function displayMessage(currentUserDivClass, foreignUserDivClass, textDivID, entityUsername, msgMessage, msgDate, user) {
    let editedMsgMessage = '';
    const maxLength = 25;

    const textDivElement = $("#"+textDivID)
    msgMessage = msgMessage.split(' ');

    for(let i = 0; i < msgMessage.length; i++) {
        let currentMessage = msgMessage[i]
        if(currentMessage.length > maxLength) {
            for(let i = 0; i < Math.ceil(currentMessage.length / maxLength); i++) {
                currentMessage.substring(i*maxLength, (i+1)*maxLength);
                editedMsgMessage += currentMessage.substring(i*maxLength, (i+1)*maxLength)+" ";
            }
        }
        else {
            editedMsgMessage += currentMessage+" ";
        }
    }

    if(user === 'current') {
        textDivElement.append(generateCurrentUserMessageHtml(currentUserDivClass, entityUsername, editedMsgMessage, msgDate));
    }
    else if(user === 'foreign') {
        textDivElement.append(generateForeignUserMessageHtml(foreignUserDivClass, entityUsername, editedMsgMessage, msgDate));
    }
    textDivElement.scrollTop(textDivElement[0].scrollHeight);
}

// ---------------------------------------------------------------------------------------------------------

    // INPUT RELATED FUNCTIONS
// INPUT TEXT FUNCTION
    function onEnterInput(inputID) {
        const inputElement = $(inputID)
        const inputElementValue = inputElement.val()

        const showActiveMessagesValue = messageShowHideButtonElement.val();

        let IDLetters = '';
        let Table = userInfo['Table'];
        let cltID = '';
        // CHECK IF ENTITY IS CLIENT OR ADMIN
        if (Table === 'client') {
            IDLetters = 'clt';
        } else if (Table === 'admin') {
            IDLetters = 'adm';
            cltID = showActiveMessagesValue
        }

        if((Table === 'admin' && showActiveMessagesValue.length > 0) || Table === 'client') {
            // ATTRIBUTE LIST TO MAKE MY LIFE EASIER
            let attributeList = {
                id: IDLetters + "ID",
                userName: IDLetters + "Username",
            };
            let entityUsername = userInfo[attributeList.userName]
            let entityID = userInfo[attributeList.id]
            if (inputElementValue.length > 0) {
                const insertNewMessageUrl = "../php-processes/message-center-process.php?"
                $.ajax({
                    type: "GET",
                    url: insertNewMessageUrl,
                    data: {
                        msgMessage: inputElementValue,
                        entityID: entityID,
                        IDLetters: IDLetters,
                        Table: Table,
                        ID: cltID
                    }
                })
                const currentTimeAndDate = getDateAndTime(new Date())
                // UPDATE ACTIVE MESSAGES WHEN NEW MESSAGE IS INPUT; -> KINDA USELESS CODE BUT MEH
                if (Table === 'admin') {
                    const activeUsernameID = messageActiveUsernameClass + "-" + cltID;
                    const activeShortMessageID = messageActiveShortMessageClass + "-" + cltID;
                    const activeTimeID = messageActiveTimeClass + "-" + cltID;

                    const activeUsernameElement = $("#" + activeUsernameID);
                    const activeShortMessageElement = $("#" + activeShortMessageID);
                    const activeTimeElement = $("#" + activeTimeID);

                    activeUsernameElement.text(entityUsername);
                    activeShortMessageElement.text(returnShortMessage(inputElementValue))
                    activeTimeElement.text(currentTimeAndDate);
                }
                // DISPLAY MESSAGE IN THE MESSAGE DIV
                displayMessage(messageCurrentUserDivClass, messageForeignUserDivClass ,messageTextDivID, entityUsername, inputElementValue, currentTimeAndDate, 'current');
                inputElement.val("");
            }
        }
    }

// SET INPUT BUTTON FUNCTION
    function setInputMessageButton(inputID) {
        $(inputID).keyup(function(e) {
            if(e.keyCode === 13) {
                onEnterInput(inputID);
            }
        });
    }

// INITIALIZE INPUT BUTTON
    setInputMessageButton('#mc-input-message');
// ---------------------------------------------------------------------------------------------------------

    // DISPLAY MESSAGES FUNCTIONS
// DISPLAY ALL MESSAGES IN THE TEXT MESSAGES TAB
    function displaySessionMessages(sesMsgID, textDivID, currentUserDivClass, foreignUserDivClass) {

        removeTextMessages(currentUserDivClass, foreignUserDivClass);

        let sessionMessages = sessionMessagesList[sesMsgID];

        for (let i = 0; i < sessionMessages.length; i++) {

            let sessionMessage = sessionMessages[i]

            let msgOwnership = sessionMessage['msgOwnership'];
            let username = sessionMessage['username'];
            let msgDate = sessionMessage['msgDate'];
            let msgMessage = sessionMessage['msgMessage'];

            const editedMsgDate = getDateAndTime(new Date(msgDate));

            if (msgOwnership === 'current') {
                displayMessage(currentUserDivClass, foreignUserDivClass, textDivID, username, msgMessage, editedMsgDate, 'current')
            } else if (msgOwnership === 'foreign') {
                displayMessage(currentUserDivClass, foreignUserDivClass, textDivID, username, msgMessage, editedMsgDate, 'foreign');
            }
        }
    }

// DISPLAY ACTIVE MESSAGES IN THE ACTIVE MESSAGES TAB AND SET A BUTTON COMMAND FOR EACH
    function displayActives(type) {

        let buttonClassElement;
        let noActiveUserElement;
        let userDivElement;
        let textDivID;

        let message;
        let resolved;

        let buttonClass;
        let activeOwnerClass;
        let activeUsernameClass;
        let activeShortMessageClass;
        let activeTimeClass;
        let noActiveUserClass

        let currentUserDivClass;
        let foreignUserDivClass;

        // SET VOLATILE ELEMENTS
        if (type === 'message') {
            buttonClass = messageActiveUserButtonClass;
            activeOwnerClass = messageActiveOwnerClass;
            activeUsernameClass = messageActiveUsernameClass;
            activeShortMessageClass = messageActiveShortMessageClass;
            activeTimeClass = messageActiveTimeClass;
            noActiveUserClass = messageNoActiveUserClass;

            userDivElement = messageUserDivElement;
            textDivID = messageTextDivID;

            currentUserDivClass = messageCurrentUserDivClass;
            foreignUserDivClass = messageForeignUserDivClass;

            message = true;
            resolved = false;
        } else if (type === 'resolved') {
            buttonClass = resolvedActiveUserButtonClass;
            activeOwnerClass = resolvedActiveOwnerClass;
            activeUsernameClass = resolvedActiveUsernameClass;
            activeShortMessageClass = resolvedActiveShortMessageClass;
            activeTimeClass = resolvedActiveTimeClass;
            noActiveUserClass = resolvedNoActiveUserClass;

            userDivElement = resolvedUserDivElement;
            textDivID = resolvedTextDivID;

            currentUserDivClass = resolvedCurrentUserDivClass;
            foreignUserDivClass = resolvedForeignUserDivClass;

            message = false;
            resolved = true;
        }

        // REMOVE OLD BUTTONS AND NO ACTIVE USER ELEMENTS

        buttonClassElement = $('.' + buttonClass);
        noActiveUserElement = $('.' + noActiveUserClass);

        noActiveUserElement.remove();
        buttonClassElement.remove();

        let lastMessagesList

        if (message) {
            lastMessagesList = getMessagesMessage;
        } else if (resolved) {
            lastMessagesList = getMessagesResolved;
        }

        if (lastMessagesList.length > 0) {
            // DISPLAY FIRST CLIENT MESSAGE SESSION BY DEFAULT
            let firstID;

            if (message) {
                firstID = lastMessagesList[0]['cltID'];
            } else if (resolved) {
                firstID = lastMessagesList[0]['sesMsgID'];
            }

            displaySessionMessages(firstID, textDivID, currentUserDivClass, foreignUserDivClass)

            // SET BUTTONS VALUES
            setButtonValues(type, firstID)

            for (let i = 0; i < lastMessagesList.length; i++) {
                const lastMessage = lastMessagesList[i];
                let buttonID;
                let activeOwnerID;
                let activeUsernameID;
                let activeShortMessageID;
                let activeTimeID;

                let ID;

                let username;
                let msgMessage;
                let msgShortMessage;
                let msgDate;
                let editedMsgDate;

                let sesMsgEndDate
                let sesMsgStartDate
                let editedSesMsgEndDate
                let editedSesMsgStartDate

                if (message) {
                    ID = lastMessage['cltID'];
                    username = lastMessage['username'];

                    msgMessage = lastMessage['msgMessage'];
                    msgShortMessage = returnShortMessage(msgMessage);

                    msgDate = lastMessage['msgDate'];
                    editedMsgDate = getDateAndTime(new Date(msgDate));

                } else if (resolved) {
                    ID = lastMessage['sesMsgID'];
                    sesMsgEndDate = lastMessage['sesMsgEndDate'];
                    sesMsgStartDate = lastMessage['sesMsgStartDate'];
                    editedSesMsgEndDate = getDateAndTime(new Date(sesMsgEndDate));
                    editedSesMsgStartDate = getDateAndTime(new Date(sesMsgStartDate));
                }


                const cltUsername = lastMessage['cltUsername'];


                buttonID = buttonClass + "-" + ID;
                activeOwnerID = activeOwnerClass + "-" + ID;
                activeUsernameID = activeUsernameClass + "-" + ID;
                activeShortMessageID = activeShortMessageClass + "-" + ID;
                activeTimeID = activeTimeClass + "-" + ID;


                const messageHtml =
                    "<button value=" + ID + " id=" + buttonID + " class=" + buttonClass + ">\n" +
                    "                    <span id =" + activeOwnerID + "  class=" + activeOwnerClass + ">"+javaScriptLanguageList['Message Owner:']+" "+ cltUsername + "</span>\n" +
                    "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                    "                    <span id =" + activeUsernameID + " class=" + activeUsernameClass + ">" + username + "</span>\n" +
                    "                    <span id =" + activeShortMessageID + " class=" + activeShortMessageClass + ">" + msgShortMessage + "</span>\n" +
                    "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                    "                    <span id =" + activeTimeID + " class=" + activeTimeClass + ">" + editedMsgDate + "</span>\n" +
                    "                </button>"

                const resolvedHtml =
                    "<button value=" + ID + " id=" + buttonID + " class=" + buttonClass + ">\n" +
                    "                    <span id =" + activeOwnerID + "  class=" + activeOwnerClass + ">"+javaScriptLanguageList['Message Owner:']+" "+ cltUsername + "</span>\n" +
                    "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                    "                    <span id =" + activeTimeID + " class=" + activeOwnerClass + ">"+javaScriptLanguageList['Start Date:']+" "+ editedSesMsgStartDate + "</span>\n" +
                    "                    <span id =" + activeTimeID + " class=" + activeOwnerClass + ">"+javaScriptLanguageList['End Date:']+" "+ editedSesMsgEndDate + "</span>\n" +
                    "                </button>"

                if (message) {
                    userDivElement.append(messageHtml);
                } else if (resolved) {
                    userDivElement.append(resolvedHtml);
                }

                setActiveUserButton(buttonID, textDivID, currentUserDivClass, foreignUserDivClass, type);


            }
        } else {
            // MESSAGE IN CASE THERE ARE NO ACTIVE MESSAGES
            let text;
            if(message) {
                text = "No Active Messages";
            }
            else if(resolved) {
                text = "No Resolved Messages";
            }

            const noActiveMessageHtml =
                "<div class=" + noActiveUserClass + ">\n" +
                "                    <span  class=" + activeOwnerClass + ">"+text+"</span>\n" +
                "                </div>"

            userDivElement.append(noActiveMessageHtml);
        }

    }
// ---------------------------------------------------------------------------------------------------------

    // SET BUTTONS STUFF I DONT KNOW WHAT TO CALL THIS ANYMORE
// SET ACTIVE USER BUTTONS IN ACTIVE / RESOLVED  MESSAGES TAB
    function setActiveUserButton(buttonID, textDivID, currentUserDivClass, foreignUserDivClass, type) {
        $('#'+buttonID).click(function() {
            onClickActiveUserButton(buttonID, textDivID, currentUserDivClass, foreignUserDivClass, type);
        })
    }

// ON CLICK COMMAND OF EACH BUTTON IN MESSAGE / RESOLVED MESSAGES TAB
    function onClickActiveUserButton(buttonID, textDivID, currentUserDivClass, foreignUserDivClass, type) {

        const buttonElement = $('#'+buttonID)
        const buttonValue = buttonElement.val();

        setButtonValues(type, buttonValue);

        displaySessionMessages(buttonValue, textDivID, currentUserDivClass, foreignUserDivClass);
    }

// SET BUTTON VALUES SO THE BUTTONS CAN DO THEIR JOB ACCORDINGLY
    function setButtonValues(type, value) {

        if(type === 'message') {
            messageShowHideButtonElement.val(value);
            messageMarkAsResolvedButtonElement.val(value);
            messageDeleteConversationButtonElement.val(value);
        }
        else if(type === 'resolved') {
            resolvedShowHideButtonElement.val(value);
            resolvedDeleteConversationButtonElement.val(value);
        }
    }
// ---------------------------------------------------------------------------------------------------------

    // HIDE / SHOW BUTTONS
// SET HIDE / SHOW BUTTON
    function setHideShowButton(buttonElement, leftSideMenuElement, buttonShowText, buttonHideText) {
        buttonElement.click(function() {
            onClickHideShowButton(buttonElement, leftSideMenuElement, buttonShowText, buttonHideText)
        })
    }

// ON CLICK HIDE / SHOW BUTTON
    function onClickHideShowButton(buttonElement, leftSideMenuElement, buttonShowText, buttonHideText) {

        if(buttonElement.attr("name") === "Hide") {
            buttonElement.attr("name", "Show")

            // try {
            //     buttonElement.text(languageList[buttonHideText])
            // }
            // catch(err) {}

            buttonElement.text(javaScriptLanguageList[buttonShowText])

            leftSideMenuElement.animate({
                width: '0px',
            }, animationSpeed);

        }
        else if(buttonElement.attr("name") === "Show") {
            buttonElement.attr("name", "Hide")

            // try {
            //     buttonElement.text(languageList[buttonShowText]);
            // } catch(err) {}

            buttonElement.text(javaScriptLanguageList[buttonHideText]);

            leftSideMenuElement.animate({
                width: '283px',
            }, animationSpeed);

        }
    }

    // MARK AS RESOLVED FUNCTIONS
// MARK AS RESOLVED BUTTON
    messageMarkAsResolvedButtonElement.click(function() {
        let markedResolvedValue = $(this).val();
        let markAsResolvedUrl = "../php-processes/message-center-process-admin.php"

        if(markedResolvedValue.length > 0) {
            $.ajax({
                type: "POST",
                url: markAsResolvedUrl,
                data: {
                    sesMsgID: markedResolvedValue,
                    markResolved: true,
                },
                success: function() {
                    refreshMessagesResolvedJson();
                    refreshSessionMessagesListJson();
                    getMessagesResolvedJsonProcess.always(function() {
                        displayActives('resolved');
                    })
                }
            })

            removeTextMessages(messageCurrentUserDivClass, messageForeignUserDivClass);
            removeActiveUserElement(markedResolvedValue, 'message');
        }
    })

// DELETE CONVERSATION BUTTON
    function onClickDeleteConversationButton(buttonElement, type) {
        let deleteConversationValue = buttonElement.val();
        let markAsResolvedUrl = "../php-processes/message-center-process-admin.php"

        if(deleteConversationValue.length > 0) {
            $.ajax({
                type: "POST",
                url: markAsResolvedUrl,
                data: {
                    sesMsgID: deleteConversationValue,
                    deleteConversation: true,
                }
            })

            if(type === 'message') {
                removeTextMessages(messageCurrentUserDivClass, messageForeignUserDivClass);
                removeActiveUserElement(deleteConversationValue, 'message');
            }
            else if (type ==='resolved') {
                removeTextMessages(resolvedCurrentUserDivClass, resolvedForeignUserDivClass);
                removeActiveUserElement(deleteConversationValue, 'resolved');
            }
        }
    }

    function setDeleteConversationButton(buttonElement, type) {
        $(buttonElement).click(function() {
            onClickDeleteConversationButton(buttonElement, type)
        })
    }

    setDeleteConversationButton(messageDeleteConversationButtonElement, 'message');

// ---------------------------------------------------------------------------------------------------------



// DELETE RESOLVED CONVERSATION
    setDeleteConversationButton(resolvedDeleteConversationButtonElement, 'resolved');

// SELECT RESOLVED MESSAGES DELETION INTERVAL
    resolvedSelectIntervalElement.click(function() {
        let resolvedSelectIntervalValue = resolvedSelectIntervalElement.val();

        if(resolvedSelectIntervalValue === "before" || resolvedSelectIntervalValue === "after") {
            resolvedInputLabelStartElement.text( javaScriptLanguageList["Select Date:"]);

            resolvedInputLabelEndElement.css("display", "none");
            resolvedInputDateEndElement.css("display", "none");
        }
        else if(resolvedSelectIntervalValue === "between") {
            resolvedInputLabelStartElement.text( javaScriptLanguageList["Select Start Date:"]);

            resolvedInputLabelEndElement.css("display", "block");
            resolvedInputDateEndElement.css("display", "block");
        }

        resolvedDeleteNotificationSpanElement.css('display', "none");
        resolvedInputDateStartElement.val('');
        resolvedInputDateEndElement.val('');
    })

// DELETE SELECTED MESSAGES BUTTON
    resolvedDeleteIntervalButtonElement.click(function() {
        let markAsResolvedUrl = "../php-processes/message-center-process-admin.php"
        let resolvedSelectIntervalValue = resolvedSelectIntervalElement.val();
        let resolvedSelectDateValue = resolvedSelectDateElement.val();

        let resolvedInputDateStartValue = resolvedInputDateStartElement.val();
        let resolvedInputDateEndValue = resolvedInputDateEndElement.val();

        let startDate;
        let endDate;
        let ajax = false;
        let errorMsg;

        resolvedDeleteNotificationSpanElement.css('display', "block");

        if(resolvedSelectIntervalValue === 'before') {
            if(resolvedInputDateStartValue.length > 0) {
                endDate = resolvedInputDateStartValue;
                startDate = new Date('0-0-0');
                errorMsg =
                    javaScriptLanguageList["Resolved messages before"]
                    +" "+getDateAndTime(new Date(resolvedInputDateStartValue))
                    +" "+javaScriptLanguageList["have been deleted."]

                ajax = true;
            }
            else {
                errorMsg = javaScriptLanguageList['Please input a Date.'];
            }

        }
        else if(resolvedSelectIntervalValue === 'after') {
            if(resolvedInputDateStartValue.length > 0) {
                startDate = resolvedInputDateStartValue;
                endDate = getDateAndTimeDB(new Date());
                errorMsg =
                    javaScriptLanguageList["Resolved messages after"]
                    +" "+getDateAndTime(new Date(resolvedInputDateStartValue))
                    +" "+javaScriptLanguageList["have been deleted."]

                ajax = true;
            }
            else {
                errorMsg = javaScriptLanguageList['Please input a Date.'];
            }
        }
        else if(resolvedSelectIntervalValue === 'between') {
            if(resolvedInputDateStartValue.length > 0 && resolvedInputDateEndValue.length > 0) {
                startDate = resolvedInputDateStartValue;
                endDate = resolvedInputDateEndValue;
                errorMsg =
                    javaScriptLanguageList["Resolved messages between"]
                    +" "+getDateAndTime(new Date(resolvedInputDateStartValue))
                    +" "+javaScriptLanguageList["and"]
                    +" "+getDateAndTime(new Date(resolvedInputDateEndValue))
                    +" "+javaScriptLanguageList["have been deleted."]
                ajax = true;
            }
            else {
                errorMsg = javaScriptLanguageList['Please input a Start Date and an End Date.'];
            }
        }

        if(ajax) {
            $.ajax({
                type: "POST",
                url: markAsResolvedUrl,
                data: {
                    deleteInterval: true,
                    sesMsgDate: resolvedSelectDateValue,
                    startDate: startDate,
                    endDate: endDate,
                }
            })

            resolvedInputDateStartElement.val('');
            resolvedInputDateEndElement.val('');

            refreshMessagesResolvedJson();
            getMessagesResolvedJsonProcess.always(function() {
                displayActives('resolved');
            })
        }
        resolvedDeleteNotificationSpanElement.text(errorMsg);
    })


// ---------------------------------------------------------------------------------------------------------

// SET HIDE/SHOW BUTTONS


setHideShowButton(resolvedShowHideButtonElement,
    resolvedActiveDivElement,
    'Show Resolved Messages',
    'Hide Resolved Messages');


setHideShowButton(messageShowHideButtonElement,
    messageActiveDivElement,
    'Show Active Messages',
    'Hide Active Messages');