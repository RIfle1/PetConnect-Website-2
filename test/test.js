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
    if(type === 'message') {
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
    }
    else if(type === 'resolved') {
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

    buttonClassElement = $('.'+buttonClass);
    noActiveUserElement = $('.'+noActiveUserClass);

    noActiveUserElement.remove();
    buttonClassElement.remove();

    const getMessagesUrl = "../php-processes/message-center-process-admin.php?getMessages="+type;
    $.getJSON(getMessagesUrl, function(json) {
        let messagesList;

        if(message) {
            messagesList = json.activeMessagesList
        }
        else if(resolved) {
            messagesList = json.resolvedMessagesList
        }

        if(messagesList.length > 0) {
            // DISPLAY FIRST CLIENT MESSAGE SESSION BY DEFAULT
            let firstID;

            if(message) {
                firstID = messagesList[0]['cltID'];
            }
            else if(resolved) {
                firstID = messagesList[0]['sesMsgID'];
            }

            displaySessionMessages(firstID, textDivID, currentUserDivClass, foreignUserDivClass)

            // SET BUTTONS VALUES
            setButtonValues(type, firstID)

            for(let i = 0; i < messagesList.length; i++) {
                const activeMessage = messagesList[i];
                let ID;

                let buttonID;
                let activeOwnerID;
                let activeUsernameID;
                let activeShortMessageID;
                let activeTimeID;

                let sesMsgEndDate
                let sesMsgStartDate
                let editedSesMsgEndDate
                let editedSesMsgStartDate

                if(message) {
                    ID = activeMessage['cltID'];
                }
                else if(resolved) {
                    ID = activeMessage['sesMsgID'];
                    sesMsgEndDate = activeMessage['sesMsgEndDate'];
                    sesMsgStartDate = activeMessage['sesMsgStartDate'];
                    editedSesMsgEndDate = getDateAndTime(new Date(sesMsgEndDate));
                    editedSesMsgStartDate = getDateAndTime(new Date(sesMsgStartDate));
                }
                const cltUsername = activeMessage['cltUsername'];

                buttonID = buttonClass+"-"+ID;
                activeOwnerID = activeOwnerClass+"-"+ID;
                activeUsernameID = activeUsernameClass+"-"+ID;
                activeShortMessageID = activeShortMessageClass+"-"+ID;
                activeTimeID = activeTimeClass+"-"+ID;

                const getSessionMessagesByCltIDUrl = "../php-processes/message-center-process-admin.php?sessionMessages=True&ID="
                    +encodeURIComponent(ID);

                $.getJSON(getSessionMessagesByCltIDUrl, function(json){
                    const sessionMessagesList = json.sessionMessagesList
                    const lastMessage = sessionMessagesList[sessionMessagesList.length - 1];

                    const entityUsername = lastMessage['username'];
                    const msgMessage = lastMessage['msgMessage'];

                    let msgShortMessage = returnShortMessage(msgMessage);

                    const msgDate = lastMessage['msgDate'];
                    const editedMsgDate = getDateAndTime(new Date(msgDate));

                    const messageHtml =
                        "<button value="+ID+" id="+buttonID+" class="+buttonClass+">\n" +
                        "                    <span id ="+activeOwnerID+"  class="+activeOwnerClass+">Message Owner: "+cltUsername+"</span>\n" +
                        "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                        "                    <span id ="+activeUsernameID+" class="+activeUsernameClass+">"+entityUsername+"</span>\n" +
                        "                    <span id ="+activeShortMessageID+" class="+activeShortMessageClass+">"+msgShortMessage+"</span>\n" +
                        "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                        "                    <span id ="+activeTimeID+" class="+activeTimeClass+">"+editedMsgDate+"</span>\n" +
                        "                </button>"

                    const resolvedHtml =
                        "<button value="+ID+" id="+buttonID+" class="+buttonClass+">\n" +
                        "                    <span id ="+activeOwnerID+"  class="+activeOwnerClass+">Message Owner: "+cltUsername+"</span>\n" +
                        "                    <div class=\"mc-message-active-separation-line\"></div>\n" +
                        "                    <span id ="+activeTimeID+" class="+activeOwnerClass+">Start Date: "+editedSesMsgStartDate+"</span>\n" +
                        "                    <span id ="+activeTimeID+" class="+activeOwnerClass+">End Date: "+editedSesMsgEndDate+"</span>\n" +
                        "                </button>"

                    if(message) {
                        userDivElement.append(messageHtml);
                    }
                    else if(resolved) {
                        userDivElement.append(resolvedHtml);
                    }

                    setActiveUserButton(buttonID, textDivID, currentUserDivClass, foreignUserDivClass, type);

                })
            }
        }
        else {
            // MESSAGE IN CASE THERE ARE NO ACTIVE MESSAGES
            const noActiveMessageHtml =
                "<div class="+noActiveUserClass+">\n" +
                "                    <span  class="+activeOwnerClass+">No Active Messages</span>\n" +
                "                </div>"

            userDivElement.append(noActiveMessageHtml);
        }
    })
}