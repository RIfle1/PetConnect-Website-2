// CONSTANTS
// HARDCODED DIV IDS
const mainDivID = "sh-main-div";

// HARDCODED DIV ELEMENTS
const mainDivElement = $("#"+mainDivID);

// VOLATILE BUTTON IDS
const addToCartButtonCommonID = "sh-add-to-cart-button"

productList.forEach(displayShopProduct)

function displayShopProduct(value) {
    let prdID = value['prdID'];
    let prdName = value['prdName'];

    let prdPrice = value['prdPrice'];
    let prdPriceInt = prdPrice.substring(0, prdPrice.length - 3)
    let prdPriceDecimal = prdPrice.substring(prdPrice.length - 2, prdPrice.length)

    let prdReleaseDate = value['prdReleaseDate'];
    let prdImgPath = Object.values(value['prdImg'])[0];

    value['prcColor'] = Object.keys(value['prdImg'])[0];

    let addToCartButtonID = addToCartButtonCommonID+"-"+generateString(5);

    let productHtml =
        "<div class='sh-product-div'>\n" +
        `                <a class='sh-product-image-div sh-href-container' href='../php-pages/product.php?prdID=${prdID}'>\n` +
        `                    <img class='sh-product-image' src='${prdImgPath}' alt='product image'>\n` +
        `                    <div class='sh-product-image-background'><span>Click for More Info</span></div>\n` +
        "                </a>\n" +
        "                <div class='sh-product-info-div'>\n" +
        `                    <a class='sh-info-name sh-href-container' href='../php-pages/product.php?prdID=${prdID}'>\n` +
        `                        <span>${prdName}</span>\n` +
        "                    </a>\n" +
        "                    <div class='sh-info-description text-font-300'>\n" +
        "                        <p>\n" +
        "                            GPS Location, Heart sensor, Thermal Sensor, Sound Sensor, CO2 Rate (ADD TO DB)\n" +
        "                        </p>\n" +
        "                    </div>\n" +
        "                </div>\n" +
        "                <div class='sh-price-button-div'>\n" +
        "                    <div class='sh-price-div'>\n" +
        `                        <span class='sh-price-span-1'>${prdPriceInt}€</span><span class='sh-price-span-2'>${prdPriceDecimal}</span>\n` +
        "                    </div>\n" +
        "                    <div class='sh-button-div'>\n" +
        `                        <button id='${addToCartButtonID}' type='button' >Add to cart</button>\n` +
        "                    </div>\n" +
        "                </div>\n" +
        "            </div>";

    mainDivElement.append(productHtml);
    let addToCartButtonElement = $("#"+addToCartButtonID);
    setAddToCartButton(addToCartButtonElement, value);
}