function setPromoteButtonStyle(cltID, fromColor, toColor, text) {
    $(".promote-button-id-"+cltID)
        .css("background-color", fromColor)
        .hover(function() {
            $(this).css("background-color", toColor);
        }, function(){
            $(this).css("background-color", fromColor);
        })
        .text(text);
}

function onClickButton(buttonClass, buttonID) {

    const ButtonIdClass = $('#'+buttonID);
    const cltID = ButtonIdClass.val()
    // EXECUTE BUTTON CODE IN THE DATABASE
    $.ajax({
        type: "POST",
        url: "../php-processes/manage-client-process.php",
        data: {
            buttonClass: buttonClass,
            buttonID: buttonID,
            cltID: cltID
        },
        success: function(result) {
        },
        error: function(requestObject, error, errorThrown) {
            alert(error);
            alert(errorThrown);
        }
    })
    // DELETE ROW FROM THE TABLE
    if(buttonClass === 'delete-button-id') {
        // console.log("On Press", buttonClass, buttonID, ButtonIdClass.val())
        $(".mg-info-row-"+cltID).remove();

    }
    // PROMOTES A USER ON THE TABLE --> CHANGES TEXT AND COLOR OF THE BUTTON
    else if(buttonClass === 'promote-button-id') {
        // console.log("On Press", buttonClass, buttonID, ButtonIdClass.val())

        // const ButtonIdClass2 = document.getElementById(buttonID).textContent;
        // console.log(typeof(ButtonIdClass.text()));
        // console.log(ButtonIdClass.text())
        // console.log("-----------------------------")
        // console.log(typeof(ButtonIdClass2));
        // console.log(ButtonIdClass2);
        // console.log("-----------------------------")
        if(ButtonIdClass.text() === 'Promote User') {
            // console.log(cltID+"should be promoted")
            setPromoteButtonStyle(cltID, "grey", '#69A6E3', "Promoted");

        }
        else if(ButtonIdClass.text() === 'Promoted') {
            // console.log(cltID+"should be demoted")
            // $("#promote-button-id-"+cltID).css("background-color", '#d9d9d9').text("Promote User");
            setPromoteButtonStyle(cltID, "#d9d9d9", '#69A6E3', "Promote User");
        }

    }
}

function setButton(buttonClass, buttonID) {
    const button = document.getElementById(buttonID);
    button.addEventListener('click', function(){onClickButton(buttonClass, buttonID)})
}

function sortingButton(inputElementID, action, IDLetters) {
    const elementValue = $(inputElementID).val()
    // console.log(elementValue);
    let url;

    // Check which action needs to be performed
    if (action === 'filter') {
        if(IDLetters === 'clt') {
            url = "../php-processes/manage-client-table.php?sortBy=" + encodeURIComponent(elementValue) + "&action=filter&ID=client";
        }
        else if(IDLetters === 'adm') {
            url = "../php-processes/manage-client-table.php?sortBy=" + encodeURIComponent(elementValue) + "&action=filter&ID=admin";
        }
    } else if (action === 'search') {
        if(IDLetters === 'clt') {
            url = "../php-processes/manage-client-table.php?searchBy=" + encodeURIComponent(elementValue) + "&action=search&ID=client";
        }
        else if(IDLetters === 'adm') {
            url = "../php-processes/manage-client-table.php?searchBy=" + encodeURIComponent(elementValue) + "&action=search&ID=admin";
        }
    } else {
        url = "";
    }

    // Define attributes according to IDLetters
    let attributeList = {
        id: IDLetters + "ID",
        userName: IDLetters + "Username",
        firstName: IDLetters + "FirstName",
        lastName: IDLetters + "LastName",
        email: IDLetters + "Email",
        phoneNumber: IDLetters + "PhoneNumber",
        isModerator: IDLetters + "IsModerator",
    };

    let cellList = {
        idCell: "#mg-cell-"+IDLetters+"ID-",
        userNameCell: "#mg-cell-"+IDLetters+"Username-",
        firstNameCell: "#mg-cell-"+IDLetters+"FirstName-",
        lastNameCell: "#mg-cell-"+IDLetters+"LastName-",
        emailCell: "#mg-cell-"+IDLetters+"Email-",
        phoneNumberCell: "#mg-cell-"+IDLetters+"PhoneNumber-",
    }

    const commonClass = "mg-info-row-";

    const deleteButtonCommonID = "#mg-cell-deleteBtn-";
    const promoteButtonCommonID = "#mg-cell-promoteBtn-";
    const submitButtonCommonID = "#mg-cell-submitBtn-";

    const deleteButtonCommonClass = "delete-button-id-";
    const promoteButtonCommonClass = "promote-button-id-";
    const submitButtonCommonClass = "submit-button-id-";

    const deleteCellCommonID = "#mg-cell-delete-control-";
    const promoteCellCommonID = "#mg-cell-promote-control-";
    const submitCellCommonID = "#mg-cell-submit-control-";

    $.getJSON(url, function(json) {
        const entityList = json.entityList;
        for(let i = 1; i < entityList.length + 1; i++) {

            //Define constants to avoid repetitions
            const entityID = entityList[i-1][attributeList.id];
            const entityIDAtr = $(cellList.idCell+i);

            const entityUsername = entityList[i-1][attributeList.userName];
            const entityUsernameAtr = $(cellList.userNameCell+i);

            const entityFirstName = entityList[i-1][attributeList.firstName];
            const entityFirstNameAtr = $(cellList.firstNameCell+i);

            const entityLastName = entityList[i-1][attributeList.lastName];
            const entityLastNameAtr = $(cellList.lastNameCell+i);

            const entityEmail = entityList[i-1][attributeList.email];
            const entityEmailAtr = $(cellList.emailCell+i);

            const entityPhoneNumber = entityList[i-1][attributeList.phoneNumber];
            const entityPhoneNumberAtr = $(cellList.phoneNumberCell+i);

            const entityIsModerator = entityList[i-1][attributeList.isModerator];

            const deleteButtonAtr = $(deleteButtonCommonID+i);
            const promoteButtonAtr = $(promoteButtonCommonID+i);
            const submitButtonAtr = $(submitButtonCommonID+i);

            const deleteCellAtr = $(deleteCellCommonID+i);
            const promoteCellAtr = $(promoteCellCommonID+i);
            const submitCellAtr = $(submitCellCommonID+i);

            // Change the classes and texts of each client attribute
            entityIDAtr.attr('class', commonClass+entityID);
            entityIDAtr.text(entityID);

            entityUsernameAtr.attr('class', commonClass+entityID);
            entityUsernameAtr.text(entityUsername);

            entityFirstNameAtr.attr('class', commonClass+entityID);
            entityFirstNameAtr.text(entityFirstName);

            entityLastNameAtr.attr('class', commonClass+entityID);
            entityLastNameAtr.text(entityLastName);

            entityEmailAtr.attr('class', commonClass+entityID);
            entityEmailAtr.text(entityEmail);

            entityPhoneNumberAtr.attr('class', commonClass+entityID);
            entityPhoneNumberAtr.text(entityPhoneNumber);

            // Change the classes of the buttons themselves
            deleteButtonAtr.attr('class', deleteButtonCommonClass+entityID);
            promoteButtonAtr.attr('class', promoteButtonCommonClass+entityID);
            submitButtonAtr.attr('class', submitButtonCommonClass+entityID);

            // Change the classes of the cells where the buttons are located
            deleteCellAtr.attr('class', commonClass+entityID);
            promoteCellAtr.attr('class', commonClass+entityID);
            submitCellAtr.attr('class', commonClass+entityID);

            // Change the values of the buttons
            deleteButtonAtr.attr('value', entityID);
            promoteButtonAtr.attr('value', entityID);
            submitButtonAtr.attr('value', entityID);

            if(entityIsModerator === '1') {
                setPromoteButtonStyle(entityID, "grey", '#69A6E3', "Promoted");
            }
            else if(entityIsModerator === '0') {
                setPromoteButtonStyle(entityID, "#d9d9d9", '#69A6E3', "Promote User");
            }

        }
    });
}

function setSortingButton(inputElementID, submitElementID, action, IDLetters, submitType) {
    if(submitType === 'click') {
        $(submitElementID).click(function () {
                sortingButton(inputElementID, action, IDLetters);
            }
        )
    } else if (submitType === 'keyup') {
        $(submitElementID).keyup(function(e){
            if(e.keyCode === 13) {
                sortingButton(inputElementID, action, IDLetters);
            }
        });
    }

}

setSortingButton('#clt-filter-selector','#clt-filter-selector','filter','clt','click');
setSortingButton('#clt-search-input','#clt-search-input','search','clt','keyup');

