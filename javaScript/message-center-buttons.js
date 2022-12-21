// CALL JSON FUNCTION TO GET THE DATA ASAP
refreshVolatileJson();
refreshStaticJson();

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
const messageShowActiveID = "mc-admin-show-message-button";
const messageMarkAsResolvedID = "mc-admin-mark-resolved-button";
const messageDeleteConversationID = "mc-admin-delete-message-button";

// HARDCODED DIV ELEMENTS
const messageTextDivElement = $('#'+messageTextDivID);
const messageShowActiveElement = $("#"+messageShowActiveID)
const messageMarkAsResolvedElement = $("#"+messageMarkAsResolvedID)
const messageDeleteConversationElement = $("#"+messageDeleteConversationID);
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

// HARDCODED BUTTONS
const resolvedShowActiveID = "mc-admin-show-resolved-button";
const resolvedDeleteConversationID = "mc-admin-delete-resolved-button";

// HARDCODED DIV ELEMENTS
const resolvedTextDivElement = $('#'+resolvedTextDivID);
const resolvedShowActiveElement = $("#"+resolvedShowActiveID)
// const resolvedMarkAsResolvedElement = $("#"+resolvedMarkAsResolvedID)
const resolvedDeleteConversationElement = $("#"+resolvedDeleteConversationID);
const resolvedUserDivElement = $("#"+resolvedUserDivID);
// ---------------------------------------------------------------------------------------------------------

    // COMMON CONSTANTS
// COMMON HARDCODED DIV CLASSES
const textDivClass = "mc-text-div";
const leftMenuClass = "mc-left-side-menu";
const userDivClass = "mc-user-div";

// COMMON HARDCODED DIV ELEMENTS
const textDivClassElement = $("."+textDivClass);
const leftMenuClassElement = $("."+leftMenuClass);
const userDivClassElement = $("."+userDivClass)

    // STORE JSON INFORMATION
let jsonInformation;

let getMessagesMessage;
let getMessagesResolved;
let userInfo;
let sessionMessagesList;
// ---------------------------------------------------------------------------------------------------------
// INITIALIZE JSONS
    function refreshVolatileJson() {

        const getMessagesMessageUrl = "../php-processes/message-center-process-admin.php?getMessages=message";
        $.getJSON(getMessagesMessageUrl, function(json) {
            getMessagesMessage = json.lastMessagesList
        })
        const getMessagesResolvedUrl = "../php-processes/message-center-process-admin.php?getMessages=resolved";
        $.getJSON(getMessagesResolvedUrl, function(json) {
            getMessagesResolved = json.lastMessagesList
        })
        let getSessionMessagesUrl = "../php-processes/message-center-process.php?sessionMessages=True";
        $.getJSON(getSessionMessagesUrl, function(json) {
            sessionMessagesList = json.sessionMessagesList
        })
    }

    function refreshStaticJson() {
        const getEntityInfoUrl = "../php-processes/message-center-process.php?userInfo=True";
        $.getJSON(getEntityInfoUrl, function (json) {
            userInfo = json.entityInfo
        })
    }

// ---------------------------------------------------------------------------------------------------------
// FUNCTIONALITY FUNCTIONS
    // noinspection JSJQueryEfficiency
// GET CURRENT TIME STAMP STUFF
    function getDateAndTime(date) {
        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();

        let hour = date.getHours();
        let minute = date.getMinutes();

        if(minute  < 10) {
            minute = "0"+date.getMinutes();
        }
        return `${day}-${month}-${year} / ${hour}:${minute}`;
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
            "                    <span class=\"mc-current-user-span\">\n" +
            msgMessage+
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
            "                    <span class=\"mc-foreign-user-span\">\n" +
            msgMessage+
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
    function removeActiveUserElement(entityID) {
        let activeUserElement = $("#"+messageActiveUserButtonClass+"-"+entityID)
        activeUserElement.remove();
    }

// SET TEXT CLASS DIV TO THE RIGHT POSITION AND STUFF FUNCTION
    function updateAdminTextDiv() {
        function resizeStuff() {
            if($(window).width() < 690) {
                textDivClassElement.css({
                    'width': '100%',
                    'left': '0px',
                    // 'border-left': 'none',
                })
            }
            else {
                textDivClassElement.css({
                    'width': 'calc(100% - 283px)',
                    'left': '283px',
                    // 'border-left': 'solid 1px #494848',
                })
            }
        }

        $(window).on("resize", function() {
            resizeStuff();
        })
        resizeStuff();

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

        const showActiveMessagesValue = messageShowActiveElement.val();

        let IDLetters = '';
        let ID = userInfo['ID'];
        let cltID = '';
        // CHECK IF ENTITY IS CLIENT OR ADMIN
        if (ID === 'client') {
            IDLetters = 'clt';
        } else if (ID === 'admin') {
            IDLetters = 'adm';
            cltID = showActiveMessagesValue
        }

        if((ID === 'admin' && showActiveMessagesValue.length > 0) || ID === 'client') {
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
                    type: "POST",
                    url: insertNewMessageUrl,
                    data: {
                        msgMessage: inputElementValue,
                        entityID: entityID,
                        IDLetters: IDLetters,
                        ID: ID,
                        cltID: cltID
                    },
                    success: function (result) {
                    },
                    error: function (requestObject, error, errorThrown) {
                        alert(error);
                        alert(errorThrown);
                    }
                })
                const currentTimeAndDate = getDateAndTime(new Date())
                // UPDATE ACTIVE MESSAGES WHEN NEW MESSAGE IS INPUT; -> KINDA USELESS CODE BUT MEH
                if (ID === 'admin') {
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

        setTimeout(() => {
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
        }, 200)
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

        setTimeout(() => {
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
                        "                    <span id =" + activeOwnerID + "  class=" + activeOwnerClass + ">Message Owner: " + cltUsername + "</span>\n" +
                        "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                        "                    <span id =" + activeUsernameID + " class=" + activeUsernameClass + ">" + username + "</span>\n" +
                        "                    <span id =" + activeShortMessageID + " class=" + activeShortMessageClass + ">" + msgShortMessage + "</span>\n" +
                        "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                        "                    <span id =" + activeTimeID + " class=" + activeTimeClass + ">" + editedMsgDate + "</span>\n" +
                        "                </button>"

                    const resolvedHtml =
                        "<button value=" + ID + " id=" + buttonID + " class=" + buttonClass + ">\n" +
                        "                    <span id =" + activeOwnerID + "  class=" + activeOwnerClass + ">Message Owner: " + cltUsername + "</span>\n" +
                        "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                        "                    <span id =" + activeTimeID + " class=" + activeOwnerClass + ">Start Date: " + editedSesMsgStartDate + "</span>\n" +
                        "                    <span id =" + activeTimeID + " class=" + activeOwnerClass + ">End Date: " + editedSesMsgEndDate + "</span>\n" +
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
                const noActiveMessageHtml =
                    "<div class=" + noActiveUserClass + ">\n" +
                    "                    <span  class=" + activeOwnerClass + ">No Active Messages</span>\n" +
                    "                </div>"

                userDivElement.append(noActiveMessageHtml);
            }
        }, 400)

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
            messageShowActiveElement.val(value);
            messageMarkAsResolvedElement.val(value);
            messageDeleteConversationElement.val(value);
        }
        else if(type === 'resolved') {
            resolvedShowActiveElement.val(value);
            resolvedDeleteConversationElement.val(value);
        }
    }
// ---------------------------------------------------------------------------------------------------------

    // HIDE / SHOW BUTTONS
// SET HIDE / SHOW BUTTON
    function setHideShowButton(buttonID, mainDivID, activeDivID, textDivID, buttonShowText, buttonHideText, type) {
        $(buttonID).click(function() {
            onClickHideShowButton(buttonID, mainDivID, activeDivID, textDivID, buttonShowText, buttonHideText, type)
        })
    }

// ON CLICK HIDE / SHOW BUTTON
    function onClickHideShowButton(buttonID, mainDivID, activeDivID, textDivID, buttonShowText, buttonHideText, type) {
        const buttonElement = $(buttonID);
        const mainDivElement = $(mainDivID);
        const leftSideMenuElement = $(activeDivID);
        const textDivElement = $(textDivID);
        const animationSpeed = 500;

        // REMOVE OR ADD THE ACTIVE MESSAGES TAB
        leftSideMenuElement.animate({
            width: 'toggle',
        }, animationSpeed);

        // CHANGE THE STATE OF THE BUTTON
        if(buttonElement.text() === buttonShowText) {
            buttonElement.text(buttonHideText)

            let newWidth = mainDivElement.width() - 283;

            if($(window).width() > 690) {
                // ANIMATE THE TEXT DIV ELEMENT
                textDivElement.animate({
                    left: '283px',
                    width: newWidth+'px',
                }, animationSpeed)
            }

            // PUT THE BORDER BACK
            // textDivElement.css('border-left', '1px solid #494848');

            // DISPLAY ACTIVE MESSAGES AGAIN (BASICALLY A REFRESH)
        }
        else if(buttonElement.text() === buttonHideText) {
            buttonElement.text(buttonShowText)

            // // REMOVE THE BORDER
            // setTimeout(() => {
            //     textDivElement.css('border-left', 'none');
            // }, animationSpeed)

            // ANIMATE THE TEXT DIV ELEMENT
            if($(window).width() > 690 ) {
                textDivElement.animate({
                    left: '0px',
                    width: '100%',
                }, animationSpeed)
            }

        }
    }

    // ACTIVE MESSAGES TAB FUNCTIONS
// SET HIDE/SHOW ACTIVE MESSAGES BUTTON
    setHideShowButton('#'+messageShowActiveID,
        '#'+messageMainDivID,
        '#'+messageActiveDivID,
        '#'+messageTextDivID,
        'Show Active Messages',
        'Hide Active Messages',
        'message');
// ---------------------------------------------------------------------------------------------------------

    // MARK AS RESOLVED FUNCTIONS
// MARK AS RESOLVED BUTTON
    messageMarkAsResolvedElement.click(function() {
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
                success: function(result) {
                },
                error: function(requestObject, error, errorThrown) {
                    alert(error);
                    alert(errorThrown);
                }
            })

            removeTextMessages(messageCurrentUserDivClass, messageForeignUserDivClass);
            removeActiveUserElement(markedResolvedValue);
        }

    })

// DELETE CONVERSATION BUTTON
    messageDeleteConversationElement.click(function() {
        let deleteConversationValue = $(this).val();
        let markAsResolvedUrl = "../php-processes/message-center-process-admin.php"

        if(deleteConversationValue.length > 0) {
            $.ajax({
                type: "POST",
                url: markAsResolvedUrl,
                data: {
                    sesMsgID: deleteConversationValue,
                    deleteConversation: true,
                },
                success: function(result) {
                },
                error: function(requestObject, error, errorThrown) {
                    alert(error);
                    alert(errorThrown);
                }
            })

            removeTextMessages(messageCurrentUserDivClass, messageForeignUserDivClass);
            removeActiveUserElement(deleteConversationValue);
        }

    })
// ---------------------------------------------------------------------------------------------------------

    // RESOLVED MESSAGES TAB FUNCTIONS
// SET HIDE/SHOW RESOLVED MESSAGES BUTTON
    setHideShowButton('#'+resolvedShowActiveID,
        '#'+resolvedMainDivID,
        '#'+resolvedActiveDivID,
        '#'+resolvedTextDivID,
        'Show Resolved Messages',
        'Hide Resolved Messages',
        'resolved');


    // $("#mc-admin-delete-resolved-button").click(function() {
    //     console.log(getMessagesMessage);
    // })

