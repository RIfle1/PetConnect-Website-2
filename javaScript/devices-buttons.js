// CONSTANTS
// HARDCODED DIV IDS
const devicesProductDivID = 'dv-devices-product-div'

// HARDCODED DIV ELEMENTS
const devicesProductDivElement = $("#"+devicesProductDivID)

// VOLATILE DIV CLASSES
const devicesProductClass = 'dv-devices-product';

// VOLATILE SPAN CLASSES
const devicesNameSpanClass = 'dv-name-span';

// VOLATILE INPUT CLASSES
const devicesNameInputClass = 'dv-name-input';

// VOLATILE IMAGE BUTTON CLASSES
const devicesNameEditImgClass = 'dv-name-edit-img';
const devicesNameCancelImgClass = 'dv-name-cancel-img';
const devicesNameConfirmImgClass = 'dv-name-confirm-img';

// VOLATILE BUTTON CLASSES
const devicesMoreInfoButtonClass = 'dv-more-info-button';

devicesList.forEach(displayDevice);

function displayDevice(value) {
    let devID = value['devID'];
    let devName = value['devName'];
    let prdImg = value['prdImg'];

    let devicesProductID = devicesProductClass+'-'+devID;

    let devicesNameSpanID = devicesNameSpanClass+'-'+devID;
    let devicesNameInputID = devicesNameInputClass+'-'+devID;

    let devicesNameEditImgID = devicesNameEditImgClass+'-'+devID;
    let devicesNameCancelImgID = devicesNameCancelImgClass+'-'+devID;
    let devicesNameConfirmImgID = devicesNameConfirmImgClass+'-'+devID;

    let devicesMoreInfoButtonID = devicesMoreInfoButtonClass+'-'+devID;

    let devicesProductHtml =
        `<div id='${devicesProductID}' class='${devicesProductClass}'>\n` +
        "    <div class='dv-product-image-div'>\n" +
        "        <div class='dv-image-name-div'>\n" +
        `            <span id="${devicesNameSpanID}" class='${devicesNameSpanClass}'>${devName}</span>\n` +
        `            <input id="${devicesNameInputID}" class='${devicesNameInputClass}' type='text'>\n` +
        `            <img id="${devicesNameEditImgID}" class='${devicesNameEditImgClass} dv-name-img' src='${miscImgList['edit.png']}' alt='edit'>\n` +
        `            <img id="${devicesNameConfirmImgID}" class='${devicesNameConfirmImgClass} dv-name-img' src='${miscImgList['confirm.png']}' alt='confirm'>\n` +
        `            <img id="${devicesNameCancelImgID}" class='${devicesNameCancelImgClass} dv-name-img' src='${miscImgList['cancel.png']}' alt='cancel'>\n` +
        "        </div>\n" +
        `        <img class='div-image-device' src='${prdImg}' alt='device img'>\n` +
        "    </div>\n" +
        "\n" +
        "    <div class='dv-product-info-div'>\n" +
        "        <div class='dv-info-container'>\n" +
        `            <img class='dv-container-image' src='${miscImgList['heart.png']}' alt='heart img'>\n` +
        "            <span class='dv-container-span'>Something</span>\n" +
        "        </div>\n" +
        "        <div class='dv-info-container'>\n" +
        `            <img class='dv-container-image' src='${miscImgList['co2.png']}' alt='heart img'>\n` +
        "            <span class='dv-container-span'>Something</span>\n" +
        "        </div>\n" +
        "        <div class='dv-info-container'>\n" +
        `            <img class='dv-container-image' src='${miscImgList['thermo.png']}' alt='heart img'>\n` +
        "            <span class='dv-container-span'>Something</span>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "    <div class='dv-product-button-div'>\n" +
        `        <button id="${devicesMoreInfoButtonID}" class='${devicesMoreInfoButtonClass}' type='button'>More information</button>\n` +
        "    </div>\n" +
        "</div>"

    devicesProductDivElement.append(devicesProductHtml);

    let devicesNameEditImgElement = $("#"+devicesNameEditImgID);
    let devicesNameCancelImgElement = $("#"+devicesNameCancelImgID);
    let devicesNameConfirmImgElement = $("#"+devicesNameConfirmImgID);

    setNameEditImgButton(devicesNameEditImgElement, devID);
    setNameCancelImgButton(devicesNameCancelImgElement, devID);
    setNameConfirmImgButton(devicesNameConfirmImgElement, devID);
}

function onClickNameConfirmImgButton(devicesNameConfirmNameElement, devID) {
    let devicesNameSpanElement = $("#"+devicesNameSpanClass+'-'+devID);
    let devicesNameInputElement = $("#"+devicesNameInputClass+'-'+devID);

    let devicesNameCancelImgElement = $("#"+devicesNameCancelImgClass+'-'+devID);

    let newDevName = devicesNameInputElement.val();
    let oldDevName = devicesNameSpanElement.text();

    if(newDevName.length > 0 && newDevName !== oldDevName) {
        devicesNameSpanElement.text(newDevName);

        let changeNameAjax = $.ajax({
            url: '../php-processes/devices-process.php',
            type: 'POST',
            data: {
                devID: devID,
                newDevName: newDevName,
            },
        })
        changeNameAjax.always(function() {
            devicesNameCancelImgElement.trigger('click');
        })
    }
}

function onClickNameCancelImgButton(devicesNameCancelImgElement, devID) {
    let devicesNameSpanElement = $("#"+devicesNameSpanClass+'-'+devID);
    let devicesNameInputElement = $("#"+devicesNameInputClass+'-'+devID);

    let devicesNameEditImgElement = $("#"+devicesNameEditImgClass+'-'+devID);
    let devicesNameConfirmImgElement = $("#"+devicesNameConfirmImgClass+'-'+devID);

    devicesNameSpanElement.css("display", "block");
    devicesNameInputElement.css("display", "none");

    devicesNameEditImgElement.css('display', 'block');
    devicesNameCancelImgElement.css('display', 'none');
    devicesNameConfirmImgElement.css('display', 'none')
}

function onClickNameEditImgButton(devicesNameEditImgElement, devID) {
    let devicesNameSpanElement = $("#"+devicesNameSpanClass+'-'+devID);
    let devicesNameInputElement = $("#"+devicesNameInputClass+'-'+devID);

    let devicesNameCancelImgElement = $("#"+devicesNameCancelImgClass+'-'+devID);
    let devicesNameConfirmImgElement = $("#"+devicesNameConfirmImgClass+'-'+devID);

    let devicesNameSpanText = devicesNameSpanElement.text()
    devicesNameInputElement.val(devicesNameSpanText);

    devicesNameSpanElement.css("display", "none");
    devicesNameInputElement.css("display", "block");

    devicesNameEditImgElement.css('display', 'none');
    devicesNameCancelImgElement.css('display', 'block');
    devicesNameConfirmImgElement.css('display', 'block')

}

function setNameEditImgButton(devicesNameEditNameElement, devID) {
    devicesNameEditNameElement.click(function() {
        onClickNameEditImgButton(devicesNameEditNameElement, devID)
    })
}

function setNameCancelImgButton(devicesNameCancelNameElement, devID) {
    devicesNameCancelNameElement.click(function() {
        onClickNameCancelImgButton(devicesNameCancelNameElement, devID)
    })
}

function setNameConfirmImgButton(devicesNameConfirmNameElement, devID) {
    devicesNameConfirmNameElement.click(function() {
        onClickNameConfirmImgButton(devicesNameConfirmNameElement, devID)
    })
}