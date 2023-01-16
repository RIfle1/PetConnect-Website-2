// refreshProductListJson();
// CONSTANTS
// HARDCODED DIV IDS
const amountActiveDivID = "pr-amount-active";
const amountHiddenDivID = "pr-amount-hidden";
const amountCustomDivID = "pr-amount-custom";

const colorActiveDivID = "pr-color-active";
const colorHiddenDivID = "pr-color-hidden";

const currentImageDivID = "pr-current-image-div";
const imageInteractionDivID = "pr-image-interaction-div";

// HARDCODED BUTTON IDS
const addButtonID = "pr-interaction-add-button";
const buyButtonID = "pr-interaction-buy-button"

// HARDCODED INPUT IDS
const amountInputID = "pr-amount-input";

// HARDCODED SPAN IDS
const selectedColorSpanID = "pr-active-selected-color-span";
const selectedAmountSpanID = "pr-active-selected-amount-span";

// HARDCODED DIV ELEMENTS
const amountActiveDivElement = $("#"+amountActiveDivID);
const amountHiddenDivElement = $("#"+amountHiddenDivID);
const amountCustomDivElement = $("#"+amountCustomDivID);

const colorActiveDivElement = $("#"+colorActiveDivID);
const colorHiddenDivElement = $("#"+colorHiddenDivID);

const currentImageDivElement = $("#"+currentImageDivID);
const imageInteractionDivElement = $("#"+imageInteractionDivID);

// HARDCODED BUTTON ELEMENTS
const addButtonElement = $("#"+addButtonID);
const buyButtonElement = $("#"+buyButtonID);

// HARDCODED INPUT ELEMENTS
const amountInputElement = $("#"+amountInputID);

// HARDCODED SPAN ELEMENTS
const selectedColorSpanElement = $("#"+selectedColorSpanID);
const selectedAmountSpanElement = $("#"+selectedAmountSpanID);

// DEFINE KEY
const productJsonKey = ["0", productJson];
productJsonKey[1]['prcColor'] = selectedColorSpanElement.text().toLowerCase();
productJsonKey[1]['buyAmount'] = parseInt(selectedAmountSpanElement.text());

//ITEM LISTS
const amountHiddenItemList = [1,2,3,4,5,6,7,8,9]
let colorHiddenItemList = getColorList(productJson);
const productImageList = getImageList(productJson)

//----------------------------------------------------------------------------------------------------------------------
// ARRAY FUNCTIONS

function getImageList(productJson) {
    let imageList = [];
    Object.values(productJson['prdImg']).forEach(values => {
        imageList.push(values);
    })

    return imageList;
}

function getColorList(productJson) {
    let colorList = [];
    Object.keys(productJson['prdImg']).forEach(key => {
        colorList.push(key.charAt(0).toUpperCase() + key.slice(1));
    })

    return colorList;
}

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

function onClickSelectHiddenItem(selectActiveDivElement, selectHiddenLiElement, selectedSpanElement) {
    let selectHiddenLiText = selectHiddenLiElement.text();
    selectedSpanElement.text(selectHiddenLiText)
    selectActiveDivElement.trigger("click");

    if(selectedSpanElement === selectedColorSpanElement) {
        productJsonKey[1]['prcColor'] = selectHiddenLiText.toLowerCase();
    }
    else if(selectedSpanElement === selectedAmountSpanElement) {
        productJsonKey[1]['buyAmount'] = parseInt(selectHiddenLiText);
    }
}

function setSelectHiddenItem(selectActiveDivElement, selectHiddenLiElement, selectedSpanElement) {
    selectHiddenLiElement.click(function() {
        onClickSelectHiddenItem(selectActiveDivElement, selectHiddenLiElement, selectedSpanElement)
    })
}

function displaySelectHiddenItemList(selectActiveDivElement, selectHiddenDivElement, selectHiddenItemList, selectedSpanElement) {
    selectHiddenItemList.forEach(item => {
        let selectHiddenLiID = selectHiddenDivElement.attr("id")+"-li-"+item
        let selectHiddenUl = selectHiddenDivElement.children().first();
        selectHiddenUl.append("<li id="+selectHiddenLiID+">"+item+"</li>")

        let selectHiddenLiElement = $("#"+selectHiddenLiID);
        setSelectHiddenItem(selectActiveDivElement, selectHiddenLiElement, selectedSpanElement);
    })
}

function onHoverImageInteractionImg(imageInteractionImgElement, currentImageDivElement) {
    let imageInteractionImgSrc = imageInteractionImgElement.attr("src");
    let currentImageDivImgElement = currentImageDivElement.children().first();
    let currentImageDivImgSrc = currentImageDivImgElement.attr("src");

    if(currentImageDivImgSrc !== imageInteractionImgSrc) {
        currentImageDivImgElement.attr("src", imageInteractionImgSrc);
    }

}

function setImageInteractionImg(imageInteractionImgElement, currentImageDivElement) {
    imageInteractionImgElement.hover(function() {
        onHoverImageInteractionImg(imageInteractionImgElement, currentImageDivElement)
    })
}

function displayProductImages(currentImageDivElement, imageInteractionDivElement, productImageList) {
    productImageList.forEach(function callback(item, index, arr) {
        let imageInteractionImgID = imageInteractionDivElement.attr("id")+"-img-"+index
        if(index === 0) {
            currentImageDivElement.append(`<img src=${item} alt=${item}>`)
        }
        imageInteractionDivElement.append(`<img id=${imageInteractionImgID} src=${item} alt=${item}>`)
        let imageInteractionImgElement = $("#"+imageInteractionImgID);
        setImageInteractionImg(imageInteractionImgElement, currentImageDivElement);
    })
}

setAddToCartButton(addButtonElement, productJsonKey)

setSelectActiveDiv(amountActiveDivElement, amountHiddenDivElement);
setAmountCustomDiv(amountCustomDivElement);

setSelectActiveDiv(colorActiveDivElement, colorHiddenDivElement);

displaySelectHiddenItemList(amountActiveDivElement, amountHiddenDivElement, amountHiddenItemList, selectedAmountSpanElement);
displaySelectHiddenItemList(colorActiveDivElement, colorHiddenDivElement, colorHiddenItemList, selectedColorSpanElement);

displayProductImages(currentImageDivElement, imageInteractionDivElement, productImageList);