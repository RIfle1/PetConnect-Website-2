function getElement(ElementID, ElementIDType) {
    let element;

    if(ElementIDType === "id") {
        element = $("#"+ElementID);
    }
    else if(ElementIDType === "class") {
        element = $("."+ElementID);
    }

    return element
}

function setWidth(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {

    let fromElement = getElement(fromElementID, fromElementIDType)
    let toElement = getElement(toElementID, toElementIDType)

    let fromElementWidth = fromElement.width();
    toElement.css("width", fromElementWidth+extraPx+"px");

    $(window).on("resize", function() {
        let fromElementWidth = fromElement.width();
        toElement.css("width", fromElementWidth+extraPx+"px");
    })

}

function setHeight(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {

    let fromElement = getElement(fromElementID, fromElementIDType)
    let toElement = getElement(toElementID, toElementIDType)

    let fromElementHeight = fromElement.height();
    toElement.css("height", fromElementHeight+extraPx+"px");

    $(window).on("resize", function() {
        let fromElementHeight = fromElement.height();
        toElement.css("height", fromElementHeight+extraPx+"px");
    })

}

function setHeightAndWidthFunction(fromElement, toElement, extraPx) {
    let fromElementHeight = fromElement.height();
    let fromElementWidth = fromElement.width();
    toElement.css({
        "height": fromElementHeight+extraPx+"px",
        "width": fromElementWidth+extraPx+"px",
    });
}

function setHeightAndWidth(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {
    let fromElement = getElement(fromElementID, fromElementIDType)
    let toElement = getElement(toElementID, toElementIDType)

    $(window).ready(function() {
        setHeightAndWidthFunction(fromElement, toElement, extraPx)
    })

    $(window).on("resize", function() {
        setHeightAndWidthFunction(fromElement, toElement, extraPx)
    })

}

function setMarginFunction(fromElement, toElement, extraPx) {
    let fromElementMargin = parseInt(fromElement.css("margin").replace("px", ""));
    toElement.css({
        "margin": fromElementMargin+extraPx+"px",
    });
}

function setMargin(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {

    let fromElement = getElement(fromElementID, fromElementIDType)
    let toElement = getElement(toElementID, toElementIDType)

    $(window).ready(function() {
        setMarginFunction(fromElement, toElement, extraPx)
    })

    $(window).on("resize", function() {
        setMarginFunction(fromElement, toElement, extraPx)
    })

}

function setMarginTopFunction(fromElement, toElement, extraPx) {
    let fromElementHeight = fromElement.height();
    let fromElementMarginTop = parseInt(fromElement.css("margin-top").replace("px", ""));
    let fromElementMarginBottom = parseInt(fromElement.css("margin-bottom").replace("px", ""));
    let newMarginTop =
        fromElementHeight
        +fromElementMarginTop
        +fromElementMarginBottom
        +extraPx+"px"

    toElement.css("margin-top", newMarginTop);
}

function setMarginTop(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {

    let fromElement = getElement(fromElementID, fromElementIDType)
    let toElement = getElement(toElementID, toElementIDType)

    setMarginTopFunction(fromElement, toElement, extraPx)

    $(window).ready(function() {
        setMarginTopFunction(fromElement, toElement, extraPx)
    })

    $(window).on("resize", function() {
        setMarginTopFunction(fromElement, toElement, extraPx)
    })

}

function setMarginTopFooterFunction(fromElement, toElement, extraPx) {
    let fromElementHeight = fromElement.height();
    let fromElementMarginTop = parseInt(fromElement.css("margin-top").replace("px", ""));
    let fromElementMarginBottom = parseInt(fromElement.css("margin-bottom").replace("px", ""));
    let newMarginTop =
        fromElementHeight
        +fromElementMarginTop
        +fromElementMarginBottom
        +extraPx

    if(newMarginTop < $(window).height()) {
        newMarginTop = $(window).height()
    }

    newMarginTop += "px";

    toElement.css({
        "margin-top": newMarginTop,
        "top": 0,
    });
}

function setMarginTopFooter(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {
    let fromElement = getElement(fromElementID, fromElementIDType)
    let toElement = getElement(toElementID, toElementIDType)

    $(window).ready(function() {
        setMarginTopFooterFunction(fromElement, toElement, extraPx);
    })

    $(window).on("resize", function() {
        setMarginTopFooterFunction(fromElement, toElement, extraPx);
    })
}

function setToWindowHeightFunction(toElement, extraPx) {
    let newHeight = window.innerHeight+extraPx+"px";
    toElement.css({"height" : newHeight})
}

function setToWindowHeight(toElementID, toElementIDType, extraPx) {
    let toElement = getElement(toElementID, toElementIDType)

    $(window).ready(function() {
        setToWindowHeightFunction(toElement, extraPx)
    })

    $(window).on("resize", function() {
        setToWindowHeightFunction(toElement, extraPx)
    })
}

// GET DATE AND TIME IN EUROPEAN FORMAT
function getDateAndTime(date) {
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

    let hour = date.getHours();
    let minute = date.getMinutes();

    if(minute  < 10) {
        minute = "0"+minute;
    }
    return `${day}-${month}-${year} / ${hour}:${minute}`;
}

function returnFormattedValueFromString(value, toType) {
    if(toType === 'str') {
        return (Math.round(parseInt(value) * 100)/100).toFixed(2);
    }
    else if (toType === 'int') {
        return Math.floor(parseInt(value));
    }
    else if (toType === 'decimal') {
        let valueStr = (Math.round( parseFloat(value)* 100)/100).toFixed(2);
        return valueStr.substring(valueStr.length - 2, valueStr.length)
    }
}

function returnFormattedValueFromNumber(value, toType) {
    if(toType === 'str') {
        return (Math.round(value * 100)/100).toFixed(2);
    }
    else if (toType === 'int') {
        return Math.floor(value);
    }
    else if (toType === 'decimal') {
        let valueStr = (Math.round( value* 100)/100).toFixed(2);
        return valueStr.substring(valueStr.length - 2, valueStr.length)
    }
}

function generateString(length) {
    const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = ' ';
    const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result.replace(/\s/g, "");
}

function autoSetID(attributeFormat) {
    return `${attributeFormat}${generateString(32)}`
}

function checkIfNumber(char){
    let lastChar = parseInt(char.charAt(char.length-1))
    return Number.isNaN(lastChar);
}