function setPromoteButtonStyle(cltID, fromColor, toColor, text) {
    $("#promote-button-id-"+cltID)
        .css("background-color", fromColor)
        .hover(function() {
        $(this).css("background-color", toColor);
    }, function(){
        $(this).css("background-color", fromColor);
    })
        .text(text);
}

function onClickButton(buttonName, buttonID) {
    const ButtonIdClass = $('#'+buttonID);
    const entityID = ButtonIdClass.val();
    let entity;
    let entityIDAttribute;
    if (entityID.substring(0,3) === 'clt') {
        entity = 'client';
        entityIDAttribute = 'cltID';
    }
    else if (entityID.substring(0,3) === 'adm') {
        entity = 'admin';
        entityIDAttribute = 'admID';
    }
    console.log(entity);
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

    }
    // PROMOTES A USER ON THE TABLE --> CHANGES TEXT AND COLOR OF THE BUTTON
    else if(buttonName === 'promote-button') {
        if(ButtonIdClass.text() === 'Promote User') {
            setPromoteButtonStyle(entityID, "grey", '#69A6E3', "Promoted");

        }
        else if(ButtonIdClass.text() === 'Promoted') {
            setPromoteButtonStyle(entityID, "#d9d9d9", '#69A6E3', "Promote User");
        }

    }
}

function setButton(buttonName, buttonID) {
    $("#"+buttonID).click(function(){
        onClickButton(buttonName, buttonID)
    })
}

function printTable(IDLetters, url) {
    let attributeList = {
        id: IDLetters + "ID",
        userName: IDLetters + "Username",
        firstName: IDLetters + "FirstName",
        lastName: IDLetters + "LastName",
        email: IDLetters + "Email",
        phoneNumber: IDLetters + "PhoneNumber",
        isModerator: IDLetters + "IsModerator",
    };

    const tableID = "#mg-table-info-"+IDLetters;

    const commonRowClass = "mg-row-class-";

    const commonCellID = "mg-cell-id-";
    const commonCellClass = "mg-cell-class-";

    const deleteButtonCommonClass = "delete-button-class-";
    const promoteButtonCommonClass = "promote-button-class-";
    const submitButtonCommonClass = "submit-button-class-";

    const deleteButtonCommonID = "delete-button-id-";
    const promoteButtonCommonID = "promote-button-id-";
    const submitButtonCommonID = "submit-button-id-";

    const deleteButtonName = "delete-button";
    const promoteButtonName = "promote-button";
    const submitButtonName = "submit-button";

    //Remove everything inside table
    const rowClass1 = "mg-row-class-1-"+IDLetters;
    const rowClass2 = "mg-row-class-2-"+IDLetters;

    $("tr[class*='"+rowClass1+"']").fadeOut(300);
    $("tr[class*='"+rowClass2+"']").fadeOut(300);

    setTimeout(() => {
        $("tr[class*='"+rowClass1+"']").remove();
        $("tr[class*='"+rowClass2+"']").remove();
    }, 300)


    setTimeout(() => {
        $.getJSON(url, function(json) {
            const entityList = json.entityList;
            // console.log(entityList);
            let tableRowNumber = 1;
            for(let i = 1; i < entityList.length + 1; i++) {
                // Table row number rotation
                if(tableRowNumber === 1) {
                    tableRowNumber = 2;
                }
                else {
                    tableRowNumber = 1;
                }

                let entityID = entityList[i-1][attributeList.id];
                let entityUsername = entityList[i-1][attributeList.userName];
                let entityFirstName = entityList[i-1][attributeList.firstName];
                let entityLastName = entityList[i-1][attributeList.lastName];
                let entityEmail = entityList[i-1][attributeList.email];
                let entityPhoneNumber = entityList[i-1][attributeList.phoneNumber];
                let entityIsModerator = entityList[i-1][attributeList.isModerator];

                const personalRowClass = commonRowClass+tableRowNumber+"-"+IDLetters+"-"+i;

                const cellPersonalClass = commonCellClass+entityID

                const personalIDID = commonCellID+IDLetters+"ID-"+i;
                const personalUsernameID = commonCellID+IDLetters+"Username-"+i;
                const personalFirstNameID = commonCellID+IDLetters+"FirstName-"+i;
                const personalLastNameID = commonCellID+IDLetters+"LastName-"+i;
                const personalEmailID = commonCellID+IDLetters+"Email-"+i;
                const personalPhoneNumberID = commonCellID+IDLetters+"PhoneNumber-"+i;

                const personalDeleteButtonRowID = commonCellID+IDLetters+"-"+deleteButtonName+"-"+i;
                const personalPromoteButtonRowID = commonCellID+IDLetters+"-"+promoteButtonName+"-"+i;
                const personalSubmitButtonRowID = commonCellID+IDLetters+"-"+submitButtonName+"-"+i;

                const deleteButtonPersonalClass = deleteButtonCommonClass+i;
                const promoteButtonPersonalClass = promoteButtonCommonClass+i;
                const submitButtonPersonalClass = submitButtonCommonClass+i;

                const deleteButtonPersonalID = deleteButtonCommonID+entityID;
                const promoteButtonPersonalID = promoteButtonCommonID+entityID;
                const submitButtonPersonalID = submitButtonCommonID+entityID;

                let promoteButtonHtml;
                if(IDLetters === 'clt') {
                    promoteButtonHtml =
                        "\n<!--                        Promote Button-->\n" +
                        "<td class="+cellPersonalClass+" id="+personalPromoteButtonRowID+">" +
                        "<button class=" + promoteButtonPersonalClass +
                        "        id=" + promoteButtonPersonalID +
                        "        name=" + promoteButtonName +
                        "        type='button'" +
                        "        value=" + entityID +
                        ">Promote User</button>" +
                        "</td>"
                } else{
                    promoteButtonHtml = '';
                }

                let submitButtonHtml;
                if(IDLetters === 'aaa') {
                    submitButtonHtml =
                        "\n<!--                        Submit Button-->\n" +
                        "<td class="+cellPersonalClass+" id="+personalSubmitButtonRowID+">" +
                        "<button class=" + submitButtonPersonalClass +
                        "        id=" + submitButtonPersonalID +
                        "        name=" + submitButtonName +
                        "        type='button'" +
                        "        value=" + entityID +
                        ">Submit Changes</button>" +
                        "</td>"
                } else {
                    submitButtonHtml = '';
                }

                $(tableID).append("<tr class="+personalRowClass+">");
                $('.'+personalRowClass).append(
                    "<td class="+cellPersonalClass+" id="+personalIDID+">"+entityID+"</td>\n" +
                    "<td class="+cellPersonalClass+" id="+personalUsernameID+">"+entityUsername+"</td>\n" +
                    "<td class="+cellPersonalClass+" id="+personalFirstNameID+">"+entityFirstName+"</td>\n" +
                    "<td class="+cellPersonalClass+" id="+personalLastNameID+">"+entityLastName+"</td>\n" +
                    "<td class="+cellPersonalClass+" id="+personalEmailID+">"+entityEmail+"</td>\n" +
                    "<td class="+cellPersonalClass+" id="+personalPhoneNumberID+">"+entityPhoneNumber+"</td>" +
                    "\n<!--                        Delete Button-->\n" +
                    "<td class="+cellPersonalClass+" id="+personalDeleteButtonRowID+">" +
                    "<button class=" + deleteButtonPersonalClass +
                    "        id=" + deleteButtonPersonalID +
                    "        name=" + deleteButtonName +
                    "        type='button'" +
                    "        value=" + entityID +
                    ">Delete User</button>" +
                    "</td>"
                    +promoteButtonHtml
                    +submitButtonHtml
                ).css('display', 'none').fadeIn(300);

                setButton(deleteButtonName, deleteButtonPersonalID);
                if(IDLetters === 'clt') {
                    setButton(promoteButtonName, promoteButtonPersonalID);
                }

                // setButton(submitButtonName, submitButtonPersonalID);

                if(entityIsModerator === '1') {
                    setPromoteButtonStyle(entityID, "grey", '#69A6E3', "Promoted");
                }
                else if(entityIsModerator === '0') {
                    setPromoteButtonStyle(entityID, "#d9d9d9", '#69A6E3', "Promote User");
                }

            }
        });
    }, "1000")

}


function getTableUrl (sortByInputElementID, searchByInputElement, IDLetters) {
    const sortByInputValue = $(sortByInputElementID).val()
    const searchByInputValue = $(searchByInputElement).val()
    let url;

    // Check which action needs to be performed
    if(IDLetters === 'clt') {
        url = "../php-processes/manage-user-table.php?sortBy=" + encodeURIComponent(sortByInputValue) +"&searchBy="+encodeURIComponent(searchByInputValue)+"&ID=client";
    }
    else if(IDLetters === 'adm') {
        url = "../php-processes/manage-user-table.php?sortBy=" + encodeURIComponent(sortByInputValue) +"&searchBy="+encodeURIComponent(searchByInputValue)+ "&ID=admin";
    }
    else {
    url = "";
    }
    // console.log(url);
    return url;
}


function setSortingButton(sortByInputElementID, searchByInputElementID, submitElementID, IDLetters, submitType) {
    if(submitType === 'click') {
        $(submitElementID).click(function () {
                printTable(IDLetters, getTableUrl(sortByInputElementID, searchByInputElementID, IDLetters));
            }
        )
    } else if (submitType === 'keyup') {
        $(submitElementID).keyup(function(e){
            if(e.keyCode === 13) {
                printTable(IDLetters, getTableUrl(sortByInputElementID, searchByInputElementID, IDLetters));
            }
        });
    }

}

// // FILTER
// setSortingButton('#clt-filter-input','#clt-search-input','#clt-filter-input','clt','click');

// SEARCH / FILTER FOR CLIENT
setSortingButton( '#clt-filter-input', '#clt-search-input','#clt-search-input','clt','keyup');
setSortingButton( '#clt-filter-input','#clt-search-input','#clt-search-submit','clt','click');

// SEARCH / FILTER FOR ADMIN
setSortingButton( '#adm-filter-input', '#adm-search-input','#adm-search-input','adm','keyup');
setSortingButton( '#adm-filter-input','#adm-search-input','#adm-search-submit','adm','click');
