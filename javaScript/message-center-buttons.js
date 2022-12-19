    // FUNCTIONALITY FUNCTIONS
// GET CURRENT TIME STAMP STUFF
    // noinspection JSJQueryEfficiency

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
    function generateCurrentUserMessageHtml (entityUsername, msgMessage, msgDate) {
        return "<div class=\"mc-current-user-message-div\">\n" +
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
    function generateForeignUserMessageHtml (entityUsername, msgMessage, msgDate) {
        return "<div class=\"mc-foreign-user-message-div\">\n" +
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
    function removeTextMessages() {
        let currentUserMessageDivElement = $('.mc-current-user-message-div');
        let foreignUserMessageDivElement = $('.mc-foreign-user-message-div');

        foreignUserMessageDivElement.remove();
        currentUserMessageDivElement.remove();
    }

// REMOVE ACTIVE USER ELEMENT
    function removeActiveUserElement(entityID) {
        let activeUserElement = $("#mc-message-active-user-button-"+entityID)
        activeUserElement.remove();
    }
// ---------------------------------------------------------------------------------------------------------

    // INPUT RELATED FUNCTIONS
// INPUT TEXT FUNCTION
    function onEnterInput(inputID) {
        const inputElement = $(inputID)
        const inputElementValue = inputElement.val()
        const showActiveMessagesElement = $("#mc-admin-show-active-button")
        const showActiveMessagesValue = showActiveMessagesElement.val();

        const messageTextDivID = 'mc-message-text-div'
        const messageTextDivElement = $('#'+messageTextDivID);
        // URL TO GET ENTITY INFO
        const getEntityInfoUrl = "../php-processes/message-center-process.php?userInfo=True";
        $.getJSON(getEntityInfoUrl, function (json) {
            let entityInfo = json.entityInfo
            let IDLetters = '';
            let ID = entityInfo['ID'];
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
                    firstName: IDLetters + "FirstName",
                    lastName: IDLetters + "LastName",
                    email: IDLetters + "Email",
                    phoneNumber: IDLetters + "PhoneNumber",
                    isModerator: IDLetters + "IsModerator",
                    signupDate: IDLetters + "SignupDate",
                };
                let entityUsername = entityInfo[attributeList.userName]
                let entityID = entityInfo[attributeList.id]
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
                        const activeUsernameClass = "mc-message-active-username";
                        const activeShortMessageClass = "mc-message-active-short-message";
                        const activeTimeClass = "mc-message-active-time";
                        const activeUsernameID = activeUsernameClass + "-" + cltID;
                        const activeShortMessageID = activeShortMessageClass + "-" + cltID;
                        const activeTimeID = activeTimeClass + "-" + cltID;
                        const activeUsernameElement = $("#" + activeUsernameID);
                        const activeShortMessageElement = $("#" + activeShortMessageID);
                        const activeTimeElement = $("#" + activeTimeID);
                        activeUsernameElement.text(entityUsername);
                        activeShortMessageElement.text(returnShortMessage(inputElementValue))
                        activeTimeElement.text(currentTimeAndDate);
                    }
                    // DISPLAY MESSAGE IN THE MESSAGE DIV
                    displayMessage(messageTextDivElement, entityUsername, inputElementValue, currentTimeAndDate, 'current');
                    inputElement.val("");
                }
            }
        })
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
    function displaySessionMessages(sesMsgID) {
    let getSessionMessagesUrl = "../php-processes/message-center-process.php?sessionMessages=True&sesMsgID="+encodeURIComponent(sesMsgID);
    let messageTextDivElement = $("#mc-message-text-div")

        removeTextMessages();

    $.getJSON(getSessionMessagesUrl, function(json) {
        let sessionMessagesList = json.sessionMessagesList

        for(let i = 0; i < sessionMessagesList.length; i++) {
            let sessionMessage = sessionMessagesList[i];
            // let sesMsgId = sessionMessage['sesMsgID'];
            // let entityID = sessionMessage['entityID'];

            let msgOwnership = sessionMessage['msgOwnership'];
            let username = sessionMessage['username'];
            let msgDate = sessionMessage['msgDate'];
            let msgMessage = sessionMessage['msgMessage'];

            const editedMsgDate = getDateAndTime(new Date(msgDate));

            if(msgOwnership === 'current') {
                displayMessage(messageTextDivElement, username, msgMessage, editedMsgDate, 'current')
            }
            else if(msgOwnership === 'foreign') {
                displayMessage(messageTextDivElement, username, msgMessage, editedMsgDate, 'foreign');
            }
        }
    })
}

// DISPLAY MESSAGE IN THE TEXT MESSAGES TAB
    function displayMessage(messageTextDivElement, entityUsername, msgMessage, msgDate, user) {
        let editedMsgMessage = '';
        const maxLength = 25;

        if(msgMessage.length > maxLength) {
            for(let i = 0; i < Math.ceil(msgMessage.length / maxLength); i++) {
                msgMessage.substring(i*maxLength, (i+1)*maxLength);
                editedMsgMessage += msgMessage.substring(i*maxLength, (i+1)*maxLength)+" ";
            }
        }
        else {
            editedMsgMessage = msgMessage;
        }

        if(user === 'current') {
            messageTextDivElement.append(generateCurrentUserMessageHtml(entityUsername, editedMsgMessage, msgDate));
        }
        else if(user === 'foreign') {
            messageTextDivElement.append(generateForeignUserMessageHtml(entityUsername, editedMsgMessage, msgDate));
        }
        messageTextDivElement.scrollTop(messageTextDivElement[0].scrollHeight);
    }

// DISPLAY ACTIVE MESSAGES IN THE ACTIVE MESSAGES TAB AND SET A BUTTON COMMAND FOR EACH
    function displayActiveMessages() {
    const getActiveMessagesUrl = "../php-processes/message-center-process-admin.php?activeMessages=True"
    const messageUserDivElement = $("#mc-message-user-div");

    const showActiveMessagesElement = $("#mc-admin-show-active-button")
    const markAsResolvedElement = $("#mc-admin-mark-resolved-button")
    const deleteConversationElement = $("#mc-admin-delete-conversation-button")

    const buttonClass = "mc-message-active-user-button";
    const activeOwnerClass = "mc-message-active-owner";
    const activeUsernameClass = "mc-message-active-username";
    const activeShortMessageClass = "mc-message-active-short-message";
    const activeTimeClass = "mc-message-active-time";
    const noActiveUserClass = "no-active-messages-div"

    const buttonClassElement = $('.'+buttonClass);
    const noActiveUserElement = $('.'+noActiveUserClass);

    noActiveUserElement.remove();
    buttonClassElement.remove();

    $.getJSON(getActiveMessagesUrl, function(json) {
        const activeMessagesList = json.activeMessagesList

        if(activeMessagesList.length > 0) {
            // DISPLAY FIRST CLIENT MESSAGE SESSION BY DEFAULT
            const firstActiveMessageCltID = activeMessagesList[0]['cltID'];
            displaySessionMessages(firstActiveMessageCltID);

            // SET BUTTONS VALUES
            showActiveMessagesElement.val(firstActiveMessageCltID);
            markAsResolvedElement.val(firstActiveMessageCltID);
            deleteConversationElement.val(firstActiveMessageCltID);

            for(let i = 0; i < activeMessagesList.length; i++) {
                const activeMessage = activeMessagesList[i];
                const cltID = activeMessage['cltID'];
                const cltUsername = activeMessage['cltUsername'];

                const buttonID = buttonClass+"-"+cltID;
                const activeOwnerID = activeOwnerClass+"-"+cltID;
                const activeUsernameID = activeUsernameClass+"-"+cltID;
                const activeShortMessageID = activeShortMessageClass+"-"+cltID;
                const activeTimeID = activeTimeClass+"-"+cltID;

                const getSessionMessagesByCltIDUrl = "../php-processes/message-center-process-admin.php?sessionMessages=True&cltID="
                    +encodeURIComponent(cltID);

                $.getJSON(getSessionMessagesByCltIDUrl, function(json){
                    const sessionMessagesList = json.sessionMessagesList
                    const lastMessage = sessionMessagesList[sessionMessagesList.length - 1];

                    const entityUsername = lastMessage['username'];
                    const msgMessage = lastMessage['msgMessage'];

                    let msgShortMessage = returnShortMessage(msgMessage);

                    const msgDate = lastMessage['msgDate'];
                    const editedMsgDate = getDateAndTime(new Date(msgDate));

                    const activeMessageHtml =
                        "<button value="+cltID+" id="+buttonID+" class="+buttonClass+">\n" +
                        "                    <span id ="+activeOwnerID+"  class="+activeOwnerClass+">Message Owner: "+cltUsername+"</span>\n" +
                        "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                        "                    <span id ="+activeUsernameID+" class="+activeUsernameClass+">"+entityUsername+"</span>\n" +
                        "                    <span id ="+activeShortMessageID+" class="+activeShortMessageClass+">"+msgShortMessage+"</span>\n" +
                        "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                        "                    <span id ="+activeTimeID+" class="+activeTimeClass+">"+editedMsgDate+"</span>\n" +
                        "                </button>"

                    messageUserDivElement.append(activeMessageHtml);
                    setActiveUserButton(buttonID);
                })
            }
        }
        else {
            // MESSAGE IN CASE THERE ARE NO ACTIVE MESSAGES
            const noActiveMessageHtml =
                "<div class="+noActiveUserClass+">\n" +
                "                    <span  class="+activeOwnerClass+">No Active Messages</span>\n" +
                "                </div>"
            messageUserDivElement.append(noActiveMessageHtml);
        }
    })
}
// ---------------------------------------------------------------------------------------------------------

    // ACTIVE MESSAGES TAB FUNCTIONS
// SET MESSAGE EXCHANGE DIV TO THE RIGHT POSITION AND STUFF FUNCTION
    function adminMessageExchangeDiv() {
        const messageExchangeDivElement = $("#mc-message-exchange-div")
        const messageTextDivElement = $("#mc-message-text-div");
        messageExchangeDivElement.css({
            'width': 'calc(100% - 245px)',
            'left': '245px',
        });
        messageTextDivElement.css({
            'border-left': 'solid 1px #494848',
        })
    }

// SET HIDE/SHOW ACTIVE MESSAGES BUTTON
    $('#mc-admin-show-active-button').click(function() {
        const messageMainDivElement = $("#mc-message-main-div");
        const activeDivElement = $("#mc-message-active-div")
        const messageExchangeDivElement = $("#mc-message-exchange-div")
        const messageTextDivElement = $("#mc-message-text-div")
        const animationSpeed = 500;

        // REMOVE OR ADD THE ACTIVE MESSAGES TAB
        activeDivElement.animate({
            width: 'toggle',
        }, animationSpeed);

        // CHANGE THE STATE OF THE BUTTON
        if($(this).text() === 'Show Active Messages') {
            $(this).text('Hide Active Messages')

            let newWidth = messageMainDivElement.width() - 245;
            $(window).on("resize", function() {
                let newWidth = messageMainDivElement.width() - activeDivElement.width();
                messageExchangeDivElement.css('width', newWidth+'px')
            })

            // PUT THE BORDER BACK
            messageTextDivElement.css('border-left', '1px solid #494848');

            // ANIMATE THE EXCHANGE DIV ELEMENT
            messageExchangeDivElement.animate({
                left: '245px',
                width: newWidth+'px',
            }, animationSpeed)

            // DISPLAY ACTIVE MESSAGES AGAIN (BASICALLY A REFRESH)
            displayActiveMessages();
        }
        else if($(this).text() === 'Hide Active Messages') {
            $(this).text('Show Active Messages')

            // REMOVE THE BORDER
            setTimeout(() => {
                messageTextDivElement.css('border-left', 'none');
            }, animationSpeed)

            // ANIMATE THE EXCHANGE DIV ELEMENT
            messageExchangeDivElement.animate({
                left: '0px',
                width: '100%',
            }, animationSpeed)
        }

    })

// SET ACTIVE USER BUTTONS IN ACTIVE MESSAGES TAB
    function setActiveUserButton(buttonID) {
    $('#'+buttonID).click(function() {
        onClickActiveUserButton(buttonID);
    })
}

// ON CLICK COMMAND OF EACH BUTTON IN ACTIVE MESSAGES TAB
    function onClickActiveUserButton(buttonID) {
        const showActiveMessagesElement = $("#mc-admin-show-active-button")
        const markAsResolvedElement = $("#mc-admin-mark-resolved-button")
        const deleteConversationElement = $("#mc-admin-delete-conversation-button")

        const buttonElement = $('#'+buttonID)
        const buttonValue = buttonElement.val();

        // SET BUTTON VALUES SO THE BUTTONS CAN DO THEIR JOB ACCORDINGLY
        showActiveMessagesElement.val(buttonValue);
        markAsResolvedElement.val(buttonValue);
        deleteConversationElement.val(buttonValue);

        displaySessionMessages(buttonValue);
    }

    // MARK AS RESOLVED FUNCTIONS
// MARK AS RESOLVED BUTTON
    $("#mc-admin-mark-resolved-button").click(function() {
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

            removeTextMessages();
            removeActiveUserElement(markedResolvedValue);
            displayActiveMessages();
        }

    })

// DELETE CONVERSATION BUTTON
    $("#mc-admin-delete-conversation-button").click(function() {
        let deleteConversationValue = $(this).val();
        let markAsResolvedUrl = "../php-processes/message-center-process-admin.php"

        if(deleteConversationValue.length > 0) {
            $.ajax({
                type: "GET",
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

            removeTextMessages();
            removeActiveUserElement(deleteConversationValue);
            displayActiveMessages();
        }

    })