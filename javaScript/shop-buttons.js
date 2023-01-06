// CONSTANTS
// HARDCODED DIV IDS
const amountActiveDivID = "sh-amount-active";
const amountHiddenDivID = "sh-amount-hidden";
const amountCustomDivID = "sh-amount-custom";

const colorActiveDivID = "sh-color-active";
const colorHiddenDivID = "sh-color-hidden";

// HARDCODED INPUT IDS
const amountInputID = "sh-amount-input";

// HARDCODED DIV ELEMENTS
const amountActiveDivElement = $("#"+amountActiveDivID);
const amountHiddenDivElement = $("#"+amountHiddenDivID);
const amountCustomDivElement = $("#"+amountCustomDivID);

const colorActiveDivElement = $("#"+colorActiveDivID);
const colorHiddenDivElement = $("#"+colorHiddenDivID);

// HARDCODED INPUT ELEMENTS
const amountInputElement = $("#"+amountInputID);

//ITEM LISTS
const amountHiddenItemList = [1,2,3,4,5,6,7,8,9]
const colorHiddenItemList = [
    'Black',
    'Blue',
    'Green',
    'Red',
    'White',
    'Yellow',
]

//----------------------------------------------------------------------------------------------------------------------

function onClickSelectActiveDiv(selectActiveDivElement, selectHiddenDivElement) {
    selectActiveDivElement.click(function() {
        let selectHiddenDivState = selectHiddenDivElement.attr("state");
        selectHiddenDivElement.animate({
            "height": "toggle",
        }, 300, function() {
            if(selectHiddenDivState === "visible") {
                selectHiddenDivElement.attr("state", "hidden");

                selectActiveDivElement.css({
                    "border-bottom-right-radius" : "10px",
                    "border-bottom-left-radius" : "10px",
                })
            }
        });

        if(selectHiddenDivState === "hidden") {
            selectHiddenDivElement.attr("state", "visible");

            selectActiveDivElement.css({
                "border-bottom-right-radius" : "0",
                "border-bottom-left-radius" : "0",
            })

        }
    })
}

function setSelectActiveDiv(selectActiveDivElement, selectHiddenDivElement) {
    onClickSelectActiveDiv(selectActiveDivElement, selectHiddenDivElement);
}

function onClickAmountCustomDiv() {
    amountActiveDivElement.css("display", "none");
    amountHiddenDivElement.css("display", "none");
    amountInputElement.css("display", "block")
}

function setAmountCustomDiv(amountCustomDivElement) {
    amountCustomDivElement.click(function() {
        onClickAmountCustomDiv(amountCustomDivElement)
    })
}

function onClickSelectHiddenItem(selectActiveDivElement, selectHiddenLiElement) {
    let selectHiddenLiText = selectHiddenLiElement.text();
    selectActiveDivElement.children().first().text(selectHiddenLiText)
    selectActiveDivElement.trigger("click");
}

function setSelectHiddenItem(selectActiveDivElement, selectHiddenLiElement) {
    selectHiddenLiElement.click(function() {
        onClickSelectHiddenItem(selectActiveDivElement, selectHiddenLiElement)
    })
}

function setSelectHiddenItemList(selectActiveDivElement, selectHiddenDivElement, selectHiddenItemList) {
    selectHiddenItemList.forEach(item => {
        let selectHiddenLiID = selectHiddenDivElement.attr("id")+"-li-"+item
        let selectHiddenUl = selectHiddenDivElement.children().first();
        selectHiddenUl.append("<li id="+selectHiddenLiID+">"+item+"</li>")

        let selectHiddenLiElement = $("#"+selectHiddenLiID);
        setSelectHiddenItem(selectActiveDivElement, selectHiddenLiElement);
    })
}

setSelectActiveDiv(amountActiveDivElement, amountHiddenDivElement);
setAmountCustomDiv(amountCustomDivElement);

setSelectActiveDiv(colorActiveDivElement, colorHiddenDivElement);

setSelectHiddenItemList(amountActiveDivElement, amountHiddenDivElement, amountHiddenItemList);
setSelectHiddenItemList(colorActiveDivElement, colorHiddenDivElement, colorHiddenItemList);