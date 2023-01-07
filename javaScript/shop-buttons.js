// CONSTANTS
// HARDCODED DIV IDS
const mainDivID = "sh-main-div";

// HARDCODED DIV ELEMENTS
const mainDivElement = $("#"+mainDivID);

Object.entries(productList).forEach(displayProduct)

function displayProduct(key) {
    let prdID = key[1]['prdID'];
    let prdName = key[1]['prdName'];

    let prdPrice = key[1]['prdPrice'];
    let prdPriceInt = prdPrice.substring(0, prdPrice.length - 3)
    let prdPriceDecimal = prdPrice.substring(prdPrice.length - 2, prdPrice.length)

    let prdReleaseDate = key[1]['prdReleaseDate'];
    let prdImgPath = Object.values(key[1]['prdImg'])[0];


    let productHtml =
        "<div class='sh-product-div'>\n" +
        `                <a class='sh-product-image-div sh-href-container' href='../php-pages/product.php?prdID=${prdID}'>\n` +
        `                    <img src='${prdImgPath}' alt='product image'>\n` +
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
        `                        <button type='button' value='${prdID}'>Add to cart</button>\n` +
        "                    </div>\n" +
        "                </div>\n" +
        "            </div>";

    mainDivElement.append(productHtml);
}