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

// HARDCODED INPUT IDS
const amountInputID = "pr-amount-input";

// HARDCODED DIV ELEMENTS
const amountActiveDivElement = $("#"+amountActiveDivID);
const amountHiddenDivElement = $("#"+amountHiddenDivID);
const amountCustomDivElement = $("#"+amountCustomDivID);

const colorActiveDivElement = $("#"+colorActiveDivID);
const colorHiddenDivElement = $("#"+colorHiddenDivID);

const currentImageDivElement = $("#"+currentImageDivID);
const imageInteractionDivElement = $("#"+imageInteractionDivID);

// HARDCODED INPUT ELEMENTS
const amountInputElement = $("#"+amountInputID);

//ITEM LISTS
const amountHiddenItemList = [1,2,3,4,5,6,7,8,9]
let colorHiddenItemList = getColorList(productJson);
const productImageList = getImageList(productJson)

//----------------------------------------------------------------------------------------------------------------------
// ARRAY FUNCTIONS

function getImageList(productJson) {
    let imageList = [];
    console.log(productJson);
    Object.values(productJson['prdImg']).forEach(values => {
        imageList.push(values);
    })

    return imageList;
}

function getColorList(productJson) {
    let colorList = [];
    console.log(productJson);
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

function displaySelectHiddenItemList(selectActiveDivElement, selectHiddenDivElement, selectHiddenItemList) {
    selectHiddenItemList.forEach(item => {
        let selectHiddenLiID = selectHiddenDivElement.attr("id")+"-li-"+item
        let selectHiddenUl = selectHiddenDivElement.children().first();
        selectHiddenUl.append("<li id="+selectHiddenLiID+">"+item+"</li>")

        let selectHiddenLiElement = $("#"+selectHiddenLiID);
        setSelectHiddenItem(selectActiveDivElement, selectHiddenLiElement);
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

setSelectActiveDiv(amountActiveDivElement, amountHiddenDivElement);
setAmountCustomDiv(amountCustomDivElement);

setSelectActiveDiv(colorActiveDivElement, colorHiddenDivElement);

displaySelectHiddenItemList(amountActiveDivElement, amountHiddenDivElement, amountHiddenItemList);
displaySelectHiddenItemList(colorActiveDivElement, colorHiddenDivElement, colorHiddenItemList);

displayProductImages(currentImageDivElement, imageInteractionDivElement, productImageList);