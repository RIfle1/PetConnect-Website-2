// CONSTANTS

// HARDCODED DIV IDS
const checkoutProductDivID = "ch-checkout-product-div";

const checkoutTotalDivID = "ch-checkout-total-div";

// HARDCODED DIV ELEMENTS
const checkoutProductDivElement = $("#"+checkoutProductDivID)

const checkoutTotalDivElement = $("#"+checkoutTotalDivID);

// VOLATILE BUTTONS IDS
const checkoutDeleteItemImgClass = 'ch-delete-product-img';

// VOLATILE DIV IDS
const checkoutProductClass = 'ch-checkout-product';

// VOLATILE SPAN CLASSES
const checkoutPriceSpanClass = "ch-price-span";

if(basketList.length > 0) {
    basketList.forEach(function(value) {
        displayProduct(value,
            checkoutProductDivElement,
            checkoutDeleteItemImgClass,
            checkoutProductClass,
            checkoutTotalDivElement,
            checkoutPriceSpanClass)
    });
}

// RESET GLOBAL VARIABLES

basketListLength = basketList.length;
productsDisplayed = 0;
productTotal = 0;

basketList.forEach(function(value) {
    updateProductTotal(value, checkoutTotalDivElement, checkoutPriceSpanClass)
})


