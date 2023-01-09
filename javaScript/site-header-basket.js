// CONSTANTS
// HARDCODED DIV IDS
const basketProductDivID = 'sih-basket-product-div'

const basketTotalDivID = "sih-basket-total-div";
const basketEmptyDivID = "sih-basket-empty-div"

const basketSeparationLineID = "sih-basket-separation-line";

// HARDCODED SPAN IDS
const basketCountSpanID = "sih-basket-count-span";

// HARDCODED BUTTON IDS
const basketDeleteAllButtonID = "sih-basket-delete-all-button";

// HARDCODED DIV CLASSES
const basketProductClass = 'sih-basket-product'

// HARDCODED DIV ELEMENTS
const basketProductDivElement = $("#"+basketProductDivID);

const basketTotalDivElement = $("#"+basketTotalDivID);
const basketEmptyDivElement = $("#"+basketEmptyDivID);

const basketSeparationLineElement = $("#"+basketSeparationLineID);

// HARDCODED SPAN ELEMENTS
const basketCountSpanElement = $("#"+basketCountSpanID);

// HARDCODED BUTTON ELEMENTS
const basketDeleteAllButtonElement = $("#"+basketDeleteAllButtonID);

// VOLATILE BUTTON IDS
const basketDeleteItemImgCommonID = 'sih-delete-item-img'

// VOLATILE SPAN CLASSES
const priceSpanClass = "sih-price-span";

// VARIABLE TO CHECK WHEN displayBasketProduct is done
let basketListLength = basketList.length;
let productsDisplayed = 0;
let basketTotal = 0;

if(basketList.length > 0) {
    Object.entries(basketList).forEach(displayBasketProduct);
}

checkBasketContents();

function checkBasketContents() {
    if(basketList.length > 0) {
        basketTotalDivElement.css("display", "flex");
        basketEmptyDivElement.css("display", "none");
        basketCountSpanElement.css("display", 'block');
        basketSeparationLineElement.css("display", "block")
        basketDeleteAllButtonElement.css("display", "block")
        basketCountSpanElement.text(basketList.length);
    }
    else {
        basketEmptyDivElement.css("display", "flex");
        basketTotalDivElement.css("display", "none");
        basketCountSpanElement.css("display", 'none');
        basketSeparationLineElement.css("display", "none")
        basketDeleteAllButtonElement.css("display", "none")
    }
}

function updateBasketTotal(key) {
    productsDisplayed ++;

    let prdPrice = key[1]['prdPrice'];
    basketTotal += parseFloat(prdPrice);


    if(productsDisplayed === basketListLength) {
        displayBasketTotalDiv(basketTotal);
    }
}

function onClickDeleteItemImg(deleteItemImgElement, basketProductElement, key, prdLstID) {
    let prdID = key[1]['prdID'];
    let prcColor = key[1]['prcColor'];

    // DELETE ELEMENT FROM PAGE
    basketProductElement.remove();

    // DELETE ELEMENT FROM GLOBAL ARRAY BASKET LIST
    let removeItem = true;
    basketList.forEach(function(item, index) {
        if (item['prdID'] === prdID  && removeItem) {
            removeItem = false;
            basketList.splice(index, 1);
        }
    })

    checkBasketContents();

    // DELETE ELEMENT FROM DATABASE / COOKIE
    let deleteFromCartUrl = "../php-processes/site-header-processes.php?"
    $.ajax({
        type: "POST",
        url: deleteFromCartUrl,
        data: {
            prdID: prdID,
            prcColor: prcColor,
            prdLstID: prdLstID,
            type: 'delete',
        }
    })

    // RESET GLOBAL VARIABLES
    basketListLength = basketList.length;
    productsDisplayed = 0;
    basketTotal = 0;

    // RECALCULATE TOTAL PRICE
    Object.entries(basketList).forEach(updateBasketTotal);
}

function onClickAddToCartButton(addToCartButtonElement, key) {
    let prdID = key[1]['prdID'];
    let prcColor = key[1]['prcColor'];

    let buyAmount = 1;
    let prdLstIDList = []

    if(typeof(key[1]['buyAmount']) !== 'undefined') {
        buyAmount = key[1]['buyAmount'];
    }

    for(let i = 0; i < buyAmount; i++) {
        // APPEND prdLstID TO THE NEW ARRAY
        let prdLstID = autoSetID('prdLst')
        prdLstIDList.push(prdLstID);
        key[1]['prdLstID']= prdLstID;

        // ADD ELEMENT TO BASKET PAGE
        displayBasketProduct(key);

        // ADD ELEMENT TO BASKET LIST
        basketList.push(key[1]);

        // RESET GLOBAL VARIABLES
        basketListLength = basketList.length;
        productsDisplayed = 0;
        basketTotal = 0;

        // RECALCULATE TOTAL PRICE
        Object.entries(basketList).forEach(updateBasketTotal);

        checkBasketContents();

        // ADD ELEMENT TO DATABASE / COOKIE
    }

    let addToCartUrl = "../php-processes/shop-processes.php"
    $.ajax({
        type: "POST",
        url: addToCartUrl,
        data: {
            prdID: prdID,
            prcColor: prcColor,
            prdLstIDList: prdLstIDList,
            buyAmount: buyAmount,
        }
    })
}

function setAddToCartButton(addToCartButtonElement, key) {
    addToCartButtonElement.click(function() {
        onClickAddToCartButton(addToCartButtonElement, key)
    })
}

function setDeleteItemImg(deleteItemImgElement, basketProductElement, key, prdLstID) {
    deleteItemImgElement.click(function() {
        onClickDeleteItemImg(deleteItemImgElement, basketProductElement, key, prdLstID)
    })
}

function onClickBasketDeleteAllButton() {
    // DELETE ALL ELEMENTS FROM PAGE
    $("."+basketProductClass).remove();

    // DELETE ALL ELEMENT FROM GLOBAL ARRAY BASKET LIST
    basketList = [];

    checkBasketContents();

    // DELETE ALL ELEMENT FROM DATABASE / COOKIE
    let deleteFromCartUrl = "../php-processes/site-header-processes.php?"
    $.ajax({
        type: "POST",
        url: deleteFromCartUrl,
        data: {
            type: 'deleteAll',
        }
    })

    // RESET GLOBAL VARIABLES
    basketListLength = basketList.length;
    productsDisplayed = 0;
    basketTotal = 0;

    // RECALCULATE TOTAL PRICE
    Object.entries(basketList).forEach(updateBasketTotal);
}

function setBasketDeleteAllButton(deleteAllButtonElement) {
    deleteAllButtonElement.click(function() {
        onClickBasketDeleteAllButton()
    })
}

function displayBasketProduct(key) {
    productsDisplayed ++;

    let prdLstID = key[1]['prdLstID']
    let prcColor = key[1]['prcColor']

    let prdName = key[1]['prdName'];

    let prdPrice = key[1]['prdPrice'];
    let prdPriceInt = returnFormattedValueFromString(prdPrice, 'int');
    let prdPriceDecimal = returnFormattedValueFromString(prdPrice, 'decimal');

    let prdReleaseDate = key[1]['prdReleaseDate'];
    let prdPath = key[1]['prdImg'][prcColor];

    let deleteItemImgID = basketDeleteItemImgCommonID+"-"+generateString(5)
    let basketProductDivID = basketProductClass+"-"+generateString(5)

    let basketProductDiv =
        `                <div id='${basketProductDivID}' class='${basketProductClass}'>\n` +
        `                    <img class='sih-product-img-1' src='${prdPath}' alt='img'>\n` +
        `                    <span id="sih-product-name-span">${prdName}</span>\n` +
        "                    <div class='sih-product-price-div text-font-700'>\n" +
        `                        <span>${prdPriceInt}€</span><span id='sih-price-span-decimal'>${prdPriceDecimal}</span>\n` +
        "                    </div>\n" +
        `                    <img id='${deleteItemImgID}' class='sih-product-img-2' src='${trashImagePath}' alt='trash'>\n` +
        "                </div>"




    basketProductDivElement.append(basketProductDiv);

    let deleteItemImgElement = $("#"+deleteItemImgID);
    let basketProductElement = $("#"+basketProductDivID);

    setDeleteItemImg(deleteItemImgElement, basketProductElement, key, prdLstID);

    basketTotal += parseFloat(prdPrice);

    if(productsDisplayed === basketListLength) {
        displayBasketTotalDiv(basketTotal);
    }
}

function displayBasketTotalDiv(basketTotal) {
    let basketTotalInt = returnFormattedValueFromNumber(basketTotal, 'int');
    let basketTotalDecimal = returnFormattedValueFromNumber(basketTotal, 'decimal');

    // REMOVE PREVIOUS PRICE IF EXISTS
    let priceSpanClassElement = $("."+priceSpanClass);
    priceSpanClassElement.remove();

    let basketTotalHtml =
        `<span class="sih-price-span-normal ${priceSpanClass}">${basketTotalInt}€</span><span id='sih-price-span-decimal' class="${priceSpanClass}">${basketTotalDecimal}</span>\n`

    basketTotalDivElement.append(basketTotalHtml);
}

setBasketDeleteAllButton(basketDeleteAllButtonElement);
