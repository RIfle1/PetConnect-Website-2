refreshLanguageList();
refreshAddressList();
// CONSTANTS
// HARDCODED DIV IDS
const addressMainDivID = "ad-main-div";

// VOLATILE BUTTON IDS
const addressDeleteButtonCommonID = "ad-delete-button-";
const addressDefaultButtonCommonID = "ad-default-button-";

// VOLATILE DIV IDS
const addressDivCommonID = "ad-address-div-"

// HARDCODED DIV CLASSES
const addressDivClass = "ad-address-div-2";

// HARDCODED DIV ELEMENTS
const addressMainDivElement = $("#"+addressMainDivID);

// JSON VARIABLES
let addressList;
let languageList;

function refreshLanguageList() {
    let languageUrl = "../php-processes/language-list-process.php?file=address-buttons"
    $.getJSON(languageUrl, function(json) {
        languageList = json.languageList;
    })
}

function refreshAddressList() {
    let addressListUrl = "../php-processes/address-process.php"
    $.getJSON(addressListUrl, function(json) {
        addressList = json.addressList;
        setTimeout(()=> {
            addressList.forEach(displayAddress)
        }, 100)
    })
}

function displayAddress(item, index, arr){
    let adrID = item['adrID'];
    let adrAddress = item["adrAddress"];
    let adrAddressOptional = item["adrAddressOptional"];
    let adrPostalCode = item["adrPostalCode"];
    let adrCity = item["adrCity"];
    let adrDefault = parseInt(item["adrDefault"]);

    let addressDeleteButtonID = addressDeleteButtonCommonID+index;
    let addressDefaultButtonID = addressDefaultButtonCommonID+index;
    let addressDivID = addressDivCommonID+index;

    let addressDefaultDiv = '';

    let modifyAddressHref =
        "../php-pages/address-add.php?type=modifyAddress&adrID="+adrID
    if(adrDefault) {
        addressDefaultDiv =
            "            <div class='ad-default-div'>\n" +
            "                <span class='text-font-500'>"+languageList['Default address']+"</span>\n" +
            "            </div>"
    }

    let addressDivHtml =
        "        <div id="+addressDivID+" class='ad-address-div ad-address-div-2'>\n" +
                        addressDefaultDiv+
        "            <div class='ad-info-div-no-default'>\n" +
        "                <span class='text-font-700'>"+adrAddress+"</span>\n" +
        "                <span class='text-font-500'>"+adrAddressOptional+"</span>\n" +
        "                <span class='text-font-500'>"+adrPostalCode+"</span>\n" +
        "                <span class='text-font-500'>"+adrCity+"</span>\n" +
        "            </div>\n" +
        "\n" +
        "            <div class='ad-button-div'>\n" +
        "                <a class='text-font-500' href='"+modifyAddressHref+"'>"+languageList['Modify']+"</a>\n" +
        "                <div class='ad-vertical-line-small'></div>\n" +
        "                <button class='text-font-500' type='button' id="+addressDeleteButtonID+">"+languageList['Delete']+"</button>\n" +
        "                <div class='ad-vertical-line-small'></div>\n" +
        "                <button class='text-font-500' type='button' id="+addressDefaultButtonID+">"+languageList['Set as default']+"</button>\n" +
        "            </div>\n" +
        "\n" +
        "        </div>"

    addressMainDivElement.append(addressDivHtml);
    let addressDeleteButtonElement = $("#"+addressDeleteButtonID)
    let addressDefaultButtonElement = $("#"+addressDefaultButtonID)

    let addressDivElement = $("#"+addressDivID);
    setAddressDeleteButton(addressDeleteButtonElement, addressDivElement, adrID);
    setAddressDefaultButton(addressDefaultButtonElement, addressDivElement, adrID);
}

function sendAddressAjaxPost(adrID, type) {
    let addressDeleteUrl = '../php-processes/address-process.php'
    $.ajax({
        type: "POST",
        url: addressDeleteUrl,
        data: {
            adrID: adrID,
            type: type
        }
    })
}

function onClickAddressDeleteButton(addressDivElement, adrID){
    addressDivElement.remove();
    sendAddressAjaxPost(adrID, 'delete');
}

function setAddressDeleteButton(addressDeleteButtonElement, addressDivElement, adrID) {
    addressDeleteButtonElement.click(function() {
        onClickAddressDeleteButton(addressDivElement, adrID);
    })
}

function onClickAddressDefaultButton(addressDefaultButtonElement, addressDivElement, adrID) {
    sendAddressAjaxPost(adrID, 'default');
    setTimeout(()=> {
        let addressDivClassElement = $("."+addressDivClass);
        addressDivClassElement.remove()
        refreshAddressList();
    }, 100)

}

function setAddressDefaultButton(addressDefaultButtonElement, addressDivElement, adrID) {
    addressDefaultButtonElement.click(function() {
        onClickAddressDefaultButton(addressDefaultButtonElement, addressDivElement, adrID)
    })
}





