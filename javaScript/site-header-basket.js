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
const basketDeleteItemImgClass = 'sih-delete-product-img'

// VOLATILE SPAN CLASSES
const basketPriceSpanClass = "sih-price-span";

// VARIABLE TO CHECK WHEN displayProduct is done
let basketListLength = basketList.length;
let productsDisplayed = 0;
let productTotal = 0;

if(basketList.length > 0) {
    basketList.forEach(function(value) {
        displayProduct(value,
            basketProductDivElement,
            basketDeleteItemImgClass,
            basketProductClass)
    });
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

        if(typeof(checkoutTotalDivElement) !== "undefined") {
            checkoutTotalDivElement.css("display", "flex");
            checkoutEmptyDivElement.css("display", "none");
            checkoutEmptySpanElement.css("display", "none");
            checkoutButtonsDivElement.css("display", "flex");
        }
    }
    else {
        basketEmptyDivElement.css("display", "flex");
        basketTotalDivElement.css("display", "none");
        basketCountSpanElement.css("display", 'none');
        basketSeparationLineElement.css("display", "none")
        basketDeleteAllButtonElement.css("display", "none")

        if(typeof(checkoutTotalDivElement) !== "undefined") {
            checkoutTotalDivElement.css("display", "none");
            checkoutEmptyDivElement.css("display", "flex");
            checkoutEmptySpanElement.css("display", "flex");
            checkoutButtonsDivElement.css("display", "none");
        }
    }
}

function updateProductTotal(productTotalDivElement, productPriceSpanClass) {
    // RESET GLOBAL VARIABLES
    basketListLength = basketList.length;
    productsDisplayed = 0;
    productTotal = 0;

    basketList.forEach(function(value) {
        productsDisplayed ++;
        productTotal += parseFloat(value['prdPrice']);

        if(productsDisplayed === basketListLength) {
            displayProductTotalSpan(productTotalDivElement, productPriceSpanClass);
        }
    })

}

function onClickDeleteItemImg(deleteItemImgElement, productElement, value) {
    let prdID = value['prdID'];
    let prcColor = value['prcColor'];
    let prdLstID = value['prdLstID'];

    // DELETE ELEMENT FROM BASKET AND CHECKOUT
    let commonProductElement = $(`div [id*='${prdLstID}']`)
    commonProductElement.remove();

    // DELETE ELEMENT FROM GLOBAL ARRAY BASKET LIST
    basketList.forEach(function(item, index) {
        if (item['prdLstID'] === prdLstID) {
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

    // RECALCULATE TOTAL PRICE
    updateProductTotal(basketTotalDivElement, basketPriceSpanClass)
    updateProductTotal(checkoutTotalDivElement, checkoutPriceSpanClass)
}

function onClickAddToCartButton(addToCartButtonElement, value) {
    let prdID = value['prdID'];
    let prcColor = value['prcColor'];

    let buyAmount = 1;
    let prdLstIDList = []

    if(typeof(value['buyAmount']) !== 'undefined') {
        buyAmount = value['buyAmount'];
    }

    for(let i = 0; i < buyAmount; i++) {
        // APPEND prdLstID TO THE NEW ARRAY
        let prdLstID = autoSetID('prdLst')
        prdLstIDList.push(prdLstID);

        let newValue = {
            prdID: prdID,
            prcColor: prcColor,
            prdLstID: prdLstID,
            prdName: value['prdName'],
            prdPrice: value['prdPrice'],
            prdReleaseDate: value['prdReleaseDate'],
            prdImg: value['prdImg'],
        }

        // ADD ELEMENT TO BASKET DIV
        displayProduct(newValue,
            basketProductDivElement,
            basketDeleteItemImgClass,
            basketProductClass);

        // ADD ELEMENT TO BASKET LIST
        basketList.push(newValue);

        // RECALCULATE TOTAL PRICE
        updateProductTotal(basketTotalDivElement, basketPriceSpanClass)

        checkBasketContents();
    }

    // ADD ELEMENT TO DATABASE / COOKIE
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

function setAddToCartButton(addToCartButtonElement, value) {
    addToCartButtonElement.click(function() {
        onClickAddToCartButton(addToCartButtonElement, value)
    })
}

function setDeleteItemImg(deleteItemImgElement, productElement, value) {
    deleteItemImgElement.click(function() {
        onClickDeleteItemImg(deleteItemImgElement, productElement, value)
    })
}

function onClickBasketDeleteAllButton() {
    // DELETE ALL ELEMENTS FROM PAGE
    $("."+basketProductClass).remove();

    if(typeof(checkoutProductClass) !== "undefined") {
        $("."+checkoutProductClass).remove();
    }

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

    // RECALCULATE TOTAL PRICE
    updateProductTotal(basketTotalDivElement, basketPriceSpanClass)
    updateProductTotal(checkoutTotalDivElement, checkoutPriceSpanClass)

}

function setBasketDeleteAllButton(deleteAllButtonElement) {
    deleteAllButtonElement.click(function() {
        onClickBasketDeleteAllButton()
    })
}

function returnProductDivHtml(productID, productClass, prdPath, prdName,
                              prdPriceInt, prdPriceDecimal, deleteItemImgID, deleteItemImgClass, type) {
    if(type === 'basket') {
        return         `                <div id='${productID}' class='${productClass}'>\n` +
            `                    <img class='sih-product-img' src='${prdPath}' alt='img'>\n` +
            `                    <span id="sih-product-name-span">${prdName}</span>\n` +
            "                    <div class='sih-product-price-div text-font-700'>\n" +
            `                        <span>${prdPriceInt}€</span><span id='sih-price-span-decimal'>${prdPriceDecimal}</span>\n` +
            "                    </div>\n" +
            `                    <img id='${deleteItemImgID}' class='${deleteItemImgClass}' src='${trashImagePath}' alt='trash'>\n` +
            "                </div>"
    }
    else if(type === 'checkout') {
        return         `        <div id='${productID}' class='${productClass}'>\n` +
            "            <a class='ch-product-image-div ch-href-container' href='../php-pages/shop.php'>\n" +
            `                <img class='ch-product-image' src='${prdPath}' alt='product image'>\n` +
            "            </a>\n" +
            "            <div class='ch-product-info-div'>\n" +
            "                <a class='ch-info-name ch-href-container' href='../php-pages/shop.php'>\n" +
            `                    <span>${prdName}</span>\n` +
            "                </a>\n" +
            "                <div class='ch-info-description text-font-300'>\n" +
            "                    <p>\n" +
            "                        GPS Location, Heart sensor, Thermal Sensor, Sound Sensor, CO2 Rate (ADD TO DB)\n" +
            "                    </p>\n" +
            "                </div>\n" +
            "            </div>\n" +
            "            <div class='ch-price-button-div'>\n" +
            "                <div class='ch-price-div'>\n" +
            `                    <span class='ch-price-span-1'>${prdPriceInt}€</span><span class='ch-price-span-2'>${prdPriceDecimal}</span>\n` +
            "                </div>\n" +
            "                <div class='ch-button-div'>\n" +
            `                    <img id='${deleteItemImgID}' class='${deleteItemImgClass}' src='${trashImagePath}' alt='trash'>\n` +
            "                </div>\n" +
            "            </div>\n" +
            "        </div>"
    }

}

function displayProduct(value, mainProductDivElement, deleteItemImgClass, productClass) {
    productsDisplayed ++;

    let prdLstID = value['prdLstID'];
    let prcColor = value['prcColor']
    let prdName = value['prdName'];

    let prdPrice = value['prdPrice'];
    let prdPriceInt = returnFormattedValueFromString(prdPrice, 'int');
    let prdPriceDecimal = returnFormattedValueFromString(prdPrice, 'decimal');

    let prdReleaseDate = value['prdReleaseDate'];
    let prdPath = value['prdImg'][prcColor];

    let deleteItemImgID = deleteItemImgClass+"-"+prdLstID
    let productID = productClass+"-"+prdLstID

    let type;

    // CHECK WHICH TYPE TO GET THE RIGHT HTML CODE
    if (mainProductDivElement === basketProductDivElement) {
        type = 'basket';
    }
    else if (mainProductDivElement === checkoutProductDivElement) {
        type = 'checkout';
    }

    // GET THE HTML CODE
    let productDivHtml = returnProductDivHtml(productID, productClass, prdPath, prdName,
        prdPriceInt, prdPriceDecimal, deleteItemImgID, deleteItemImgClass, type)


    mainProductDivElement.append(productDivHtml);

    let deleteItemImgElement = $("#"+deleteItemImgID);
    let productElement = $("#"+productID);

    // SET DELETE ITEM IMG
    setDeleteItemImg(deleteItemImgElement, productElement, value);

    updateProductTotal(basketTotalDivElement, basketPriceSpanClass)
}

function displayProductTotalSpan(productTotalDivElement, productPriceSpanClass) {
    let productTotalInt = returnFormattedValueFromNumber(productTotal, 'int');
    let productTotalDecimal = returnFormattedValueFromNumber(productTotal, 'decimal');

    // REMOVE PREVIOUS PRICE IF EXISTS
    let priceSpanClassElement = $("."+productPriceSpanClass);
    priceSpanClassElement.remove();

    let productTotalHtml =
        `<span class="${productPriceSpanClass}-normal ${productPriceSpanClass}">${productTotalInt}€</span><span id='${productPriceSpanClass}-decimal' class="${productPriceSpanClass}">${productTotalDecimal}</span>\n`

    productTotalDivElement.append(productTotalHtml);
}

setBasketDeleteAllButton(basketDeleteAllButtonElement);
