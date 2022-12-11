$.getJSON("manage-client-table.php?sortBy="+selectorValue, function(json) {
    const clientList = json.clientList;
    for(let i = 1; i < clientList.length + 1; i++) {

        //Define constants to avoid repetitions
        const cltID = clientList[i-1]['cltID'];
        const cltIDAtr = $("#mg-cell-cltID-"+i);

        const cltUsername = clientList[i-1]['cltUsername'];
        const cltUsernameAtr = $("#mg-cell-cltUsername-"+i);

        const cltFirstName = clientList[i-1]['cltFirstName'];
        const cltFirstNameAtr = $("#mg-cell-cltFirstName-"+i);

        const cltLastName = clientList[i-1]['cltLastName'];
        const cltLastNameAtr = $("#mg-cell-cltLastName-"+i);

        const cltEmail = clientList[i-1]['cltEmail'];
        const cltEmailAtr = $("#mg-cell-cltEmail-"+i);

        const cltPhoneNumber = clientList[i-1]['cltPhoneNumber'];
        const cltPhoneNumberAtr = $("#mg-cell-cltPhoneNumber-"+i);

        const cltIsModerator = clientList[i-1]['cltIsModerator'];

        const deleteButtonAtr = $("#mg-cell-deleteBtn-"+i);
        const promoteButtonAtr = $("#mg-cell-promoteBtn-"+i);
        const submitButtonAtr = $("#mg-cell-submitBtn-"+i);

        const deleteCellAtr = $("#mg-cell-delete-control-"+i);
        const promoteCellAtr = $("#mg-cell-promote-control-"+i);
        const submitCellAtr = $("#mg-cell-submit-control-"+i);

        // Change the classes and texts of each client attribute
        cltIDAtr.attr('class', "mg-info-row-"+cltID)
        cltIDAtr.text(cltID)

        cltUsernameAtr.attr('class', "mg-info-row-"+cltID)
        cltUsernameAtr.text(cltUsername)

        cltFirstNameAtr.attr('class', "mg-info-row-"+cltID)
        cltFirstNameAtr.text(cltFirstName)

        cltLastNameAtr.attr('class', "mg-info-row-"+cltID)
        cltLastNameAtr.text(cltLastName)

        cltEmailAtr.attr('class', "mg-info-row-"+cltID)
        cltEmailAtr.text(cltEmail)

        cltPhoneNumberAtr.attr('class', "mg-info-row-"+cltID)
        cltPhoneNumberAtr.text(cltPhoneNumber)

        // Change the classes of the buttons themselves
        deleteButtonAtr.attr('class', "delete-button-id-"+cltID)
        promoteButtonAtr.attr('class', "promote-button-id-"+cltID)
        submitButtonAtr.attr('class', "submit-button-id-"+cltID)

        // Change the classes of the cells where the buttons are located
        deleteCellAtr.attr('class', "mg-info-row-"+cltID)
        promoteCellAtr.attr('class', "mg-info-row-"+cltID)
        submitCellAtr.attr('class', "mg-info-row-"+cltID)

        // Change the values of the buttons
        deleteButtonAtr.attr('value', cltID)
        promoteButtonAtr.attr('value', cltID)
        submitButtonAtr.attr('value', cltID)

        if(cltIsModerator === '1') {
            setPromoteButtonStyle(cltID, "grey", '#69A6E3', "Promoted");
        }
        else if(cltIsModerator === '0') {
            setPromoteButtonStyle(cltID, "#d9d9d9", '#69A6E3', "Promote User");
        }

    }
});