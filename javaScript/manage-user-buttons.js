// CALL JSON FUNCTION TO GET THE DATA ASAP
// refreshClientTableJson();
// refreshAdminTableJson();
// refreshLanguageList();

// CONSTANTS
// VOLATILE BUTTONS ID's
const promoteButtonID = "promote-button-id-";

// VOLATILE TABLE CLASSES
const commonRowClass = "mg-row-class";
const commonCellID = "mg-cell-id-";
const commonCellClass = "mg-cell-class-";

// VOLATILE BUTTON CLASSES
const deleteButtonCommonClass = "delete-button-class-";
const promoteButtonCommonClass = "promote-button-class-";
const submitButtonCommonClass = "submit-button-class-";
const messageButtonCommonClass = 'message-button-class-'

// VOLATILE BUTTON IDs
const userDeleteButtonCommonID = "delete-button-id-";
const userPromoteButtonCommonID = "promote-button-id-";
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
// let clientList
// let adminList
// let javaScriptLanguageList

let tableRowNumber = '1';

Object.entries(clientList).forEach(function(value) {displayEntity(value, 'clt')})
Object.entries(adminList).forEach(function(value) {displayEntity(value, 'adm')})

// ---------------------------------------------------------------------------------------------------------
// INITIALIZE JSONS
// function refreshClientTableJson() {
//     let clientUrl = "../php-processes/manage-user-table.php?sortBy=cltUsername&orderBy=ASC&Table=client"
//     $.getJSON(clientUrl, function(json) {
//         clientList = json.entityList;
//     })
// }
//
// function refreshAdminTableJson() {
//     let adminUrl = '../php-processes/manage-user-table.php?sortBy=admUsername&orderBy=ASC&Table=admin'
//     $.getJSON(adminUrl, function(json) {
//         adminList = json.entityList;
//     })
// }

// function refreshLanguageList() {
//     let languageUrl = "../php-processes/language-list-process.php?file=manage-user-buttons"
//     $.getJSON(languageUrl, function(json) {
//         javaScriptLanguageList = json.languageList;
//     })
// }

// ---------------------------------------------------------------------------------------------------------

function onClickUserDeleteButton(userDeleteButtonElement, value, IDLetters) {
    let entityID = value[0];
    let personalRowID = `${commonRowClass}-${entityID}`;
    let personalRowElement = $("#"+personalRowID)

    let table = '';
    let entityIDAttribute = '';
    let entityList;

    if(IDLetters === 'clt') {
        table = 'client';
        entityIDAttribute = 'cltID';
        entityList = clientList;
    }
    else if(IDLetters === 'adm') {
        table = 'admin';
        entityIDAttribute = 'admID';
        entityList = adminList;
    }
    
    // DELETE THE USER VISUALLY
    personalRowElement.remove();

    // DELETE THE USER FROM DATABASE
    $.ajax({
        type: "POST",
        url: "../php-processes/manage-user-process.php",
        data: {
            type: 'delete',
            table: table,
            entityID: entityID,
            entityIDAttribute : entityIDAttribute,
        }
    })

    // DELETE THE USER FROM THE LIST
    delete entityList[entityID];
}

function setUserDeleteButton(userDeleteButtonElement, value, IDLetters) {
    userDeleteButtonElement.click(function() {
        onClickUserDeleteButton(userDeleteButtonElement, value, IDLetters)
    })
}

function onClickUserPromoteButton(userPromoteButtonElement, value, IDLetters) {
    let entityID = value[0];

    let table = '';
    let entityIDAttribute = '';
    let entityList = '';
    let entityIsModerator = '';

    if(IDLetters === 'clt') {
        table = 'client';
        entityIDAttribute = 'cltID';
        entityList = clientList;

        entityIsModerator = parseInt(value[1]['cltIsModerator']);
    }
    else if(IDLetters === 'adm') {
        table = 'admin';
        entityIDAttribute = 'admID';
        entityList = adminList;
    }

    if(entityIsModerator) {
        // CHANGE THE VALUES IN THE LIST
        entityList[entityID]['cltIsModerator'] = "0";
        entityIsModerator = parseInt(value[1]['cltIsModerator']);
    }
    else if(!entityIsModerator) {
        // CHANGE THE VALUES IN THE LIST
        entityList[entityID]['cltIsModerator'] = "1";
        entityIsModerator = parseInt(value[1]['cltIsModerator']);
    }

    setPromoteButtonStyle(userPromoteButtonElement, entityIsModerator, entityList, entityID)

    // CHANGE THE VALUES IN THE DATABASE
    $.ajax({
        type: "POST",
        url: "../php-processes/manage-user-process.php",
        data: {
            type: 'promote',
            table: table,
            entityID: entityID,
            entityIDAttribute : entityIDAttribute,
        }
    })

}

function setUserPromoteButton(userPromoteButtonElement, value, IDLetters) {
    userPromoteButtonElement.click(function() {
        onClickUserPromoteButton(userPromoteButtonElement, value, IDLetters)
    })
}

function displayEntity(value, IDLetters) {
    let entityID = value[0];
    let entityUsername = value[1][`${IDLetters}Username`];
    let entityEmail = value[1][`${IDLetters}Email`];
    let entitySignupDate = value[1][`${IDLetters}SignupDate`];

    let tableID = "mg-table-info-"+IDLetters;
    let tableElement = $("#"+tableID)

    let personalRowClass = `${commonRowClass}-${tableRowNumber}-${IDLetters}`;
    let personalRowID = `${commonRowClass}-${entityID}`;

    let userDeleteButtonID = `${userDeleteButtonCommonID}${entityID}`;
    let userPromoteButtonID = `${userPromoteButtonCommonID}${entityID}`;

    if(tableRowNumber === '1') {tableRowNumber = '2';}
    else {tableRowNumber = '1';}

    let messageButtonHtml = '';
    let deleteButtonHtml = '';
    let promoteButtonHtml = '';
    let submitButtonHtml = '';

    if(IDLetters === 'clt' || IDLetters === 'adm') {
        deleteButtonHtml =
            `<td>` +
            "<button" +
            `        id=${userDeleteButtonID}` +
            `        name=${deleteButtonName}` +
            `        type="button"` +
            `        value=${entityID}` +
            `>${javaScriptLanguageList["Delete User"]}</button>` +
            "</td>"
        // submitButtonHtml =
        //     "\n<!--                        Submit Button-->\n" +
        //     "<td class="+personalCellClass+" id="+personalSubmitButtonRowID+">" +
        //     "<button class=" + submitButtonPersonalClass +
        //     "        id=" + submitButtonPersonalID +
        //     "        name=" + submitButtonName +
        //     "        type='button'" +
        //     "        value=" + entityID +
        //     ">"+javaScriptLanguageList["Submit Changes"]+"</button>" +
        //     "</td>"
    }

    if(IDLetters === 'clt') {
        promoteButtonHtml =
            `<td>` +
            "<button" +
            `        id=${userPromoteButtonID}` +
            `        name=${promoteButtonName}` +
            `        type="button"` +
            `        value=${entityID}` +
            `>${javaScriptLanguageList["Promote User"]}</button>` +
            "</td>"
        // messageButtonHtml =
        //     "\n<!--                        Message Button-->\n" +
        //     "<td class="+personalCellClass+" id="+personalMessageButtonRowID+">" +
        //     "<button class=" + messageButtonPersonalClass +
        //     "        id=" + messageButtonPersonalID +
        //     "        name=" + messageButtonName +
        //     "        type='button'" +
        //     "        value=" + entityID +
        //     ">Message User</button>" +
        //     "</td>"

    }

    let newSignupDate = getDateAndTime(new Date(entitySignupDate));

    $(tableElement).append(
        `<tr class=${personalRowClass} id="${personalRowID}">` +
        `<td>${entityUsername}</td>\n` +
        `<td>${entityEmail}</td>\n` +
        `<td>${newSignupDate}</td>`
        +deleteButtonHtml
        +promoteButtonHtml
        +messageButtonHtml
        +submitButtonHtml
        +`</tr>`
    );

    let userDeleteButtonElement = $("#"+userDeleteButtonID);
    let userPromoteButtonElement = $("#"+userPromoteButtonID)

    if(IDLetters === 'clt') {
        let entityList = clientList;
        let entityIsModerator = parseInt(value[1]['cltIsModerator']);
        setPromoteButtonStyle(userPromoteButtonElement, entityIsModerator, entityList, entityID)
    }

    setUserDeleteButton(userDeleteButtonElement, value, IDLetters)
    setUserPromoteButton(userPromoteButtonElement, value, IDLetters)
}

// SET PROMOTE BUTTON STYLE
function setPromoteButtonStyle(userPromoteButtonElement, entityIsModerator) {
    let fromColor = '';
    let toColor = '';
    let text = '';

    if(entityIsModerator) {
        // PROMOTE THE USER VISUALLY
        fromColor = "grey";
        toColor = '#69A6E3';
        text = javaScriptLanguageList["Promoted"];
    }
    else if(!entityIsModerator) {
        // DEMOTE THE USER VISUALLY
        fromColor = "#d9d9d9";
        toColor = '#69A6E3';
        text = javaScriptLanguageList["Promote User"];
    }

    userPromoteButtonElement
        .css("background-color", fromColor)
        .hover(function() {
            $(this).css("background-color", toColor);
        }, function(){
            $(this).css("background-color", fromColor);
        })
        .text(text);
}

// ---------------------------------------------------------------------------------------------------------
// SORTING BUTTONS STUFF
function sortTable(sortByInputElement, searchByInputElement, orderByInputElement, IDLetters) {
    const sortByInputValue = sortByInputElement.val();
    const searchByInputValue = searchByInputElement.val();
    const orderByInputValue = orderByInputElement.val();

    let pattern;
    let entityList;
    let newEntityList = [];

    if(searchByInputValue.length === 0) {
        pattern = new RegExp(".*")
    }
    else {
        pattern = new RegExp(".*"+searchByInputValue.toLowerCase()+".*")
    }

    if(IDLetters === 'clt') {
        entityList = clientList;
    }
    else if(IDLetters === 'adm') {
        entityList = adminList;
    }

    Object.entries(entityList).forEach(function(value) {
        let append = true;
        Object.values(value[1]).forEach(function(row) {
            if(!(row === null)) {
                if(row.toLowerCase().match(pattern) && append) {
                    newEntityList.push(value[1]);
                    append = false;
                }
            }

        })
    })

    newEntityList.sort(function(a, b) {
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

    let newEntityObjectList = {}

    newEntityList.forEach(function(value) {
        newEntityObjectList[value[`${IDLetters}ID`]] = value;
    })

    return newEntityObjectList;

}

function clearTable(IDLetters) {
    //Remove everything inside table
    let rowClass1 = "mg-row-class-1-"+IDLetters;
    let rowClass2 = "mg-row-class-2-"+IDLetters;

    $("tr[class*='"+rowClass1+"']").remove();
    $("tr[class*='"+rowClass2+"']").remove();
}

function setSortingButton(sortByInputElement, searchByInputElement, submitButtonElement, orderByInputElement, IDLetters, submitType) {
    submitButtonElement.click(function () {
        let newEntityObjectList = sortTable(sortByInputElement, searchByInputElement, orderByInputElement, IDLetters);
        clearTable(IDLetters);
        Object.entries(newEntityObjectList).forEach(function(value) {displayEntity(value, IDLetters)})
        }
    )
    searchByInputElement.keyup(function(e){
        if(e.keyCode === 13) {
            let newEntityObjectList = sortTable(sortByInputElement, searchByInputElement, orderByInputElement, IDLetters);
            clearTable(IDLetters);
            Object.entries(newEntityObjectList).forEach(function(value) {displayEntity(value, IDLetters)})
        }
    });
}

// SEARCH / FILTER FOR CLIENT
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
    adminSearchSubmitElement,
    adminOrderInputElement,
    'adm','click');


