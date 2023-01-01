// CALL JSON FUNCTION TO GET THE DATA ASAP
refreshClientTableJson();
refreshAdminTableJson();
refreshLanguageList();

// CONSTANTS
// VOLATILE BUTTONS ID's
const promoteButtonID = "promote-button-id-";

// VOLATILE TABLE CLASSES
const commonRowClass = "mg-row-class-";
const commonCellID = "mg-cell-id-";
const commonCellClass = "mg-cell-class-";

// VOLATILE BUTTON CLASSES
const deleteButtonCommonClass = "delete-button-class-";
const promoteButtonCommonClass = "promote-button-class-";
const submitButtonCommonClass = "submit-button-class-";
const messageButtonCommonClass = 'message-button-class-'

// VOLATILE BUTTON IDs
const deleteButtonCommonID = "delete-button-id-";
const promoteButtonCommonID = "promote-button-id-";
const submitButtonCommonID = "submit-button-id-";
const messageButtonCommonID = "message-button-id-"

// HARDCODED BUTTON NAMES
const deleteButtonName = "delete-button";
const promoteButtonName = "promote-button";
const submitButtonName = "submit-button";
const messageButtonName = "message-button";

// HARDCODED BUTTON IDs
const clientFilterInputID = 'clt-filter-input';
const clientSearchInputID = 'clt-search-input';
const clientSearchSubmitID = 'clt-search-submit';
const clientOrderInputID = 'clt-order-input';

const adminFilterInputID = 'adm-filter-input';
const adminSearchInputID = 'adm-search-input';
const adminSearchSubmitID = 'adm-search-submit';
const adminOrderInputID = 'adm-order-input';

// HARDCODED BUTTON ELEMENTS
const clientFilterInputElement = $('#'+clientFilterInputID);
const clientSearchInputElement = $('#'+clientSearchInputID);
const clientSearchSubmitElement = $('#'+clientSearchSubmitID);
const clientOrderInputElement = $('#'+clientOrderInputID);

const adminFilterInputElement = $('#'+adminFilterInputID);
const adminSearchInputElement = $('#'+adminSearchInputID);
const adminSearchSubmitElement = $('#'+adminSearchSubmitID);
const adminOrderInputElement = $('#'+adminOrderInputID);

// STORE JSON INFORMATION
let getClientTable
let getAdminTable
let languageList

// ---------------------------------------------------------------------------------------------------------
// INITIALIZE JSONS
function refreshClientTableJson() {
    let clientUrl = "../php-processes/manage-user-table.php?sortBy=cltUsername&orderBy=ASC&ID=client"
    $.getJSON(clientUrl, function(json) {
        getClientTable = json.entityList;
    })
}

function refreshAdminTableJson() {
    let adminUrl = '../php-processes/manage-user-table.php?sortBy=admUsername&orderBy=ASC&ID=admin'
    $.getJSON(adminUrl, function(json) {
        getAdminTable = json.entityList;
    })
}

function refreshLanguageList() {
    let languageUrl = "../php-processes/language-list-process.php?file=manage-user-buttons"
    $.getJSON(languageUrl, function(json) {
        languageList = json.languageList;
    })
}

// ---------------------------------------------------------------------------------------------------------

// SET PROMOTE BUTTON STYLE
function setPromoteButtonStyle(cltID, fromColor, toColor, text) {
    $("#"+promoteButtonID+cltID)
        .css("background-color", fromColor)
        .hover(function() {
            $(this).css("background-color", toColor);
        }, function(){
            $(this).css("background-color", fromColor);
        })
        .text(text);
}

// RETURN ATTRIBUTE LIST BASED ON ID LETTERS
function returnAttributeList(IDLetters){
    return {
        id: IDLetters + "ID",
        userName: IDLetters + "Username",
        firstName: IDLetters + "FirstName",
        lastName: IDLetters + "LastName",
        email: IDLetters + "Email",
        phoneNumber: IDLetters + "PhoneNumber",
        isModerator: IDLetters + "IsModerator",
        signupDate: IDLetters + "SignupDate",
    }
}

// FUNCTION WHEN THE BUTTONS ARE CLICKED
function onClickButton(buttonName, buttonID) {
    const buttonElement = $('#'+buttonID);
    const entityID = buttonElement.val();
    let entity;
    let entityIDAttribute;
    let client = false;
    let admin = false;

    if (entityID.substring(0,3) === 'clt') {
        entity = 'client';
        client = true;
        entityIDAttribute = 'cltID';
    }
    else if (entityID.substring(0,3) === 'adm') {
        entity = 'admin';
        entityIDAttribute = 'admID';
        admin = true;
    }
    // EXECUTE BUTTON CODE IN THE DATABASE
    $.ajax({
        type: "POST",
        url: "../php-processes/manage-user-process.php",
        data: {
            buttonName: buttonName,
            buttonID: buttonID,
            entity: entity,
            entityID: entityID,
            entityIDAttribute : entityIDAttribute,
        },
        success: function(result) {
        },
        error: function(requestObject, error, errorThrown) {
            alert(error);
            alert(errorThrown);
        }
    })
    // DELETE ROW FROM THE TABLE
    if(buttonName === 'delete-button') {
        $(".mg-cell-class-"+entityID).parent().remove();
        if(client) {
            removeObject(getClientTable, entityID);
        }
        else if(admin) {
            removeObject(getAdminTable, entityID);
        }

    }
    // PROMOTES A USER ON THE TABLE --> CHANGES TEXT AND COLOR OF THE BUTTON
    else if(buttonName === 'promote-button') {
        if(buttonElement.text() === languageList["Promote User"]) {
            setPromoteButtonStyle(entityID, "grey", '#69A6E3', languageList["Promoted"]);

        }
        else if(buttonElement.text() === languageList["Promoted"]) {

            setPromoteButtonStyle(entityID, "#d9d9d9", '#69A6E3', languageList["Promote User"]);
        }

    }
}

// SET THE FUNCTION FOR EACH BUTTON
function setManageUserButton(buttonName, buttonID) {
    $("#"+buttonID).click(function(){
        onClickButton(buttonName, buttonID)
    })
}

// PRINT TABLE FUNCTION

function printTable(IDLetters, table) {
    let attributeList = returnAttributeList(IDLetters)

    let tableID = "#mg-table-info-"+IDLetters;

    //Remove everything inside table
    const rowClass1 = "mg-row-class-1-"+IDLetters;
    const rowClass2 = "mg-row-class-2-"+IDLetters;

    $("tr[class*='"+rowClass1+"']").remove();
    $("tr[class*='"+rowClass2+"']").remove();

    let entityList = table;
    let tableRowNumber = 1;

    for(let i = 1; i < entityList.length + 1; i++) {
        // Table row number rotation
        if(tableRowNumber === 1) {tableRowNumber = 2;}
        else {tableRowNumber = 1;}

        let entityID = entityList[i-1][attributeList.id];
        let entityUsername = entityList[i-1][attributeList.userName];
        let entityFirstName = entityList[i-1][attributeList.firstName];
        let entityLastName = entityList[i-1][attributeList.lastName];
        let entityEmail = entityList[i-1][attributeList.email];
        let entityPhoneNumber = entityList[i-1][attributeList.phoneNumber];
        let entityIsModerator = entityList[i-1][attributeList.isModerator];
        let entitySignupDate = entityList[i-1][attributeList.signupDate];

        const personalRowClass = commonRowClass+tableRowNumber+"-"+IDLetters+"-"+i;

        const cellPersonalClass = commonCellClass+entityID

        const personalIDID = commonCellID+IDLetters+"ID-"+i;
        const personalUsernameID = commonCellID+IDLetters+"Username-"+i;
        const personalFirstNameID = commonCellID+IDLetters+"FirstName-"+i;
        const personalLastNameID = commonCellID+IDLetters+"LastName-"+i;
        const personalEmailID = commonCellID+IDLetters+"Email-"+i;
        const personalPhoneNumberID = commonCellID+IDLetters+"PhoneNumber-"+i;
        const personalSignupDateID = commonCellID+IDLetters+"SignupDate-"+i;

        const personalDeleteButtonRowID = commonCellID+IDLetters+"-"+deleteButtonName+"-"+i;
        const personalPromoteButtonRowID = commonCellID+IDLetters+"-"+promoteButtonName+"-"+i;
        const personalSubmitButtonRowID = commonCellID+IDLetters+"-"+submitButtonName+"-"+i;
        const personalMessageButtonRowID = commonCellID+IDLetters+"-"+messageButtonName+"-"+i;


        const deleteButtonPersonalClass = deleteButtonCommonClass+i;
        const promoteButtonPersonalClass = promoteButtonCommonClass+i;
        const submitButtonPersonalClass = submitButtonCommonClass+i;
        const messageButtonPersonalClass = messageButtonCommonClass+i;

        const deleteButtonPersonalID = deleteButtonCommonID+entityID;
        const promoteButtonPersonalID = promoteButtonCommonID+entityID;
        const submitButtonPersonalID = submitButtonCommonID+entityID;
        const messageButtonPersonalID = messageButtonCommonID+entityID;

        let messageButtonHtml;
        let deleteButtonHtml;
        let promoteButtonHtml;
        let submitButtonHtml;

        if(IDLetters === 'clt' || IDLetters === 'adm') {
            deleteButtonHtml =
                "\n<!--                        Delete Button-->\n" +
                "<td class="+cellPersonalClass+" id="+personalDeleteButtonRowID+">" +
                "<button class=" + deleteButtonPersonalClass +
                "        id=" + deleteButtonPersonalID +
                "        name=" + deleteButtonName +
                "        type='button'" +
                "        value=" + entityID +
                ">"+languageList["Delete User"]+"</button>" +
                "</td>"
            submitButtonHtml =
                "\n<!--                        Submit Button-->\n" +
                "<td class="+cellPersonalClass+" id="+personalSubmitButtonRowID+">" +
                "<button class=" + submitButtonPersonalClass +
                "        id=" + submitButtonPersonalID +
                "        name=" + submitButtonName +
                "        type='button'" +
                "        value=" + entityID +
                ">"+languageList["Submit Changes"]+"</button>" +
                "</td>"
        } else {
            deleteButtonHtml = '';
            submitButtonHtml = '';
        }


        if(IDLetters === 'clt') {
            promoteButtonHtml =
                "\n<!--                        Promote Button-->\n" +
                "<td class="+cellPersonalClass+" id="+personalPromoteButtonRowID+">" +
                "<button class=" + promoteButtonPersonalClass +
                "        id=" + promoteButtonPersonalID +
                "        name=" + promoteButtonName +
                "        type='button'" +
                "        value=" + entityID +
                ">"+languageList["Promote User"]+"</button>" +
                "</td>"
            // messageButtonHtml =
            //     "\n<!--                        Message Button-->\n" +
            //     "<td class="+cellPersonalClass+" id="+personalMessageButtonRowID+">" +
            //     "<button class=" + messageButtonPersonalClass +
            //     "        id=" + messageButtonPersonalID +
            //     "        name=" + messageButtonName +
            //     "        type='button'" +
            //     "        value=" + entityID +
            //     ">Message User</button>" +
            //     "</td>"

        } else{
            promoteButtonHtml = '';
            messageButtonHtml = '';
        }

        let newSignupDate = getDateAndTime(new Date(entitySignupDate));

        $(tableID).append("<tr class="+personalRowClass+">");
        $('.'+personalRowClass).append(
            // "<td class="+cellPersonalClass+" id="+personalIDID+">"+entityID+"</td>\n" +
            "<td class="+cellPersonalClass+" id="+personalUsernameID+">"+entityUsername+"</td>\n" +
            // "<td class="+cellPersonalClass+" id="+personalFirstNameID+">"+entityFirstName+"</td>\n" +
            // "<td class="+cellPersonalClass+" id="+personalLastNameID+">"+entityLastName+"</td>\n" +
            "<td class="+cellPersonalClass+" id="+personalEmailID+">"+entityEmail+"</td>\n" +
            // "<td class="+cellPersonalClass+" id="+personalPhoneNumberID+">"+entityPhoneNumber+"</td>" +
            "<td class="+cellPersonalClass+" id="+personalSignupDateID+">"+newSignupDate+"</td>"
            +deleteButtonHtml
            +promoteButtonHtml
            +messageButtonHtml
            +submitButtonHtml
        ).css('display', 'none').fadeIn(300*i);

        setManageUserButton(deleteButtonName, deleteButtonPersonalID);
        if(IDLetters === 'clt') {
            setManageUserButton(promoteButtonName, promoteButtonPersonalID);
        }

        // setButton(submitButtonName, submitButtonPersonalID);

        if(entityIsModerator === '1') {
            setPromoteButtonStyle(entityID, "grey", '#69A6E3', languageList["Promoted"]);
        }
        else if(entityIsModerator === '0') {
            setPromoteButtonStyle(entityID, "#d9d9d9", '#69A6E3', languageList["Promote User"]);
        }
    }

}
// ---------------------------------------------------------------------------------------------------------

// REMOVE AN OBJECT FROM A LIST BY ENTITY ID
function removeObject(table, entityID) {
    let breakVar = false;

    for(let i=0; i < table.length; i++) {
        for (const key in table[i]) {
            if(breakVar) {break;}
            if(key.substring(3) === "ID") {
                if(table[i][key] === entityID) {
                    table.splice(i, 1)
                    breakVar = true;
                }
            }
        }
    }
}

// SORTING BUTTONS STUFF
function sortTable(sortByInputElement, searchByInputElement, orderByInputElement, IDLetters) {
    const sortByInputValue = sortByInputElement.val();
    const searchByInputValue = searchByInputElement.val();
    const orderByInputValue = orderByInputElement.val();

    let pattern;
    let table;
    let newTable = [];

    if(searchByInputValue.length === 0) {
        pattern = new RegExp(".*")
    }
    else {
        pattern = new RegExp(".*"+searchByInputValue+".*")
    }

    if(IDLetters === 'clt') {
        table = getClientTable;
    }
    else if(IDLetters === 'adm') {
        table = getAdminTable;
    }

    for(let i=0; i < table.length; i++) {
        for (const key in table[i]) {
            if(table[i][key].match(pattern)) {
                newTable = newTable.concat(table[i])
                break;
            }
        }
    }

    newTable.sort(function(a, b) {
        let x = a[sortByInputValue];
        let y = b[sortByInputValue];
        if(sortByInputValue.substring(3) === "SignupDate") {
            x = new Date(x)
            y = new Date(y);
        }
        else {
            x = x.toLowerCase();
            y = y.toLowerCase();
        }

        if(orderByInputValue === 'ASC') {
            if (x < y) {return -1;}
            if (x > y) {return 1;}
        }
        else if(orderByInputValue === 'DESC') {
            if (x < y) {return 1;}
            if (x > y) {return -1;}
        }
    })

    return newTable;

}

function setSortingButton(sortByInputElement, searchByInputElement, submitButtonElement, orderByInputElement, IDLetters, submitType) {
    if(submitType === 'click') {
        submitButtonElement.click(function () {
                printTable(IDLetters, sortTable(sortByInputElement, searchByInputElement, orderByInputElement, IDLetters));
            }
        )
    } else if (submitType === 'keyup') {
        submitButtonElement.keyup(function(e){
            if(e.keyCode === 13) {
                printTable(IDLetters, sortTable(sortByInputElement, searchByInputElement, orderByInputElement, IDLetters));
            }
        });
    }
}

// SEARCH / FILTER FOR CLIENT
setSortingButton(
    clientFilterInputElement,
    clientSearchInputElement,
    clientSearchInputElement,
    clientOrderInputElement,
    'clt','keyup');
setSortingButton(
    clientFilterInputElement,
    clientSearchInputElement,
    clientSearchSubmitElement,
    clientOrderInputElement,
    'clt','click');

// SEARCH / FILTER FOR ADMIN
setSortingButton(
    adminFilterInputElement,
    adminSearchInputElement,
    adminSearchInputElement,
    adminOrderInputElement,
    'adm','keyup');
setSortingButton(
    adminFilterInputElement,
    adminSearchInputElement,
    adminSearchSubmitElement,
    adminOrderInputElement,
    'adm','click');


// CLIENT AND ADMIN TABLE GENERATION
setTimeout(()=> {
    printTable('clt', getClientTable)
    printTable('adm', getAdminTable)
}, 100)

