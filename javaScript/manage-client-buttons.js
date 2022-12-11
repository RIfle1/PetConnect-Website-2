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
    $.ajax({
        type: "POST",
        url: "manage-client-process.php",
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
    if(buttonClass === 'delete-button-id') {
        // console.log("On Press", buttonClass, buttonID, ButtonIdClass.val())
        $(".mg-info-row-"+cltID).remove();

    }
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

$("#submit-filter").click(function () {
    const selectorValue = $('#filter-selector').val()
    // console.log(selectorValue);

    $.getJSON("manage-client-table.php?sortBy="+encodeURIComponent(selectorValue), function(json) {
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

    }
)
