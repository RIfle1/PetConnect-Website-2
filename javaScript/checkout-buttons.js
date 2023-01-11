// CONSTANTS

// HARDCODED DIV IDS
const checkoutProductDivID = "ch-checkout-product-div";

// HARDCODED DIV ELEMENTS
const checkoutProductDivElement = $("#"+checkoutProductDivID)

// VOLATILE BUTTONS IDS
const checkoutDeleteItemImgClass = 'ch-delete-product-img';

// VOLATILE DIV IDS
const checkoutProductClass = 'ch-checkout-product';


if(basketList.length > 0) {
    basketList.forEach(function(value) {
        displayProduct(value,
            checkoutProductDivElement,
            checkoutDeleteItemImgClass,
            checkoutProductClass)
    });
}
