// CONSTANTS

// HARDCODED DIV IDS
const checkoutProductDivID = "ch-checkout-product-div";

const checkoutTotalDivID = "ch-checkout-total-div";
const checkoutEmptyDivID = "ch-checkout-empty-div";
const checkoutButtonsDivID = "ch-checkout-buttons-div"

// HARDCODED BUTTON IDS
const checkoutBuyProductsButtonID = "ch-checkout-buy-products-button"

// HARDCODED DIV ELEMENTS
const checkoutProductDivElement = $("#"+checkoutProductDivID)

const checkoutTotalDivElement = $("#"+checkoutTotalDivID);
const checkoutEmptyDivElement = $("#"+checkoutEmptyDivID);
const checkoutButtonsDivElement = $("#"+checkoutButtonsDivID);

// HARDCODED BUTTON ELEMENTS
const checkoutBuyProductsButtonElement = $("#"+checkoutBuyProductsButtonID);

// VOLATILE BUTTONS IDS
const checkoutDeleteItemImgClass = 'ch-delete-product-img';

// VOLATILE DIV IDS
const checkoutProductClass = 'ch-checkout-product';

// VOLATILE SPAN CLASSES
const checkoutPriceSpanClass = "ch-price-span";

checkBasketContents();

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

updateProductTotal(checkoutTotalDivElement, checkoutPriceSpanClass)

checkoutBuyProductsButtonElement.click(function() {
    let buyProductsAjax = $.ajax({
        type: "GET",
        url: '../php-processes/checkout-process.php',
        data: '',
    })
    buyProductsAjax.always(function() {
        basketDeleteAllButtonElement.trigger('click');
    })
})



