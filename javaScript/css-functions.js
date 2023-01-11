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

function setHeightAndWidth(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {

    let fromElement = getElement(fromElementID, fromElementIDType)
    let toElement = getElement(toElementID, toElementIDType)

    let fromElementHeight = fromElement.height();
    let fromElementWidth = fromElement.width();

    toElement.css({
        "height": fromElementHeight+extraPx+"px",
        "width": fromElementWidth+extraPx+"px",
    });

    setTimeout(() => {
        let fromElementHeight = fromElement.height();
        let fromElementWidth = fromElement.width();
        toElement.css({
            "height": fromElementHeight+extraPx+"px",
            "width": fromElementWidth+extraPx+"px",
        });
    }, 100)

    $(window).on("resize", function() {
        let fromElementHeight = fromElement.height();
        let fromElementWidth = fromElement.width();
        toElement.css({
            "height": fromElementHeight+extraPx+"px",
            "width": fromElementWidth+extraPx+"px",
        });
    })

}

function setMargin(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {

    let fromElement = getElement(fromElementID, fromElementIDType)
    let toElement = getElement(toElementID, toElementIDType)

    let fromElementMargin = parseInt(fromElement.css("margin").replace("px", ""));
    toElement.css({
        "margin": fromElementMargin+extraPx+"px",
    });

    setTimeout(() => {
        toElement.css({
            "margin": fromElementMargin+extraPx+"px",
        });
    }, 100)

    $(window).on("resize", function() {
        let fromElementMargin = parseInt(fromElement.css("margin").replace("px", ""));
        toElement.css({
            "margin": fromElementMargin+extraPx+"px",
        });
    })

}

function setMarginTop(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {

    let fromElement = getElement(fromElementID, fromElementIDType)
    let toElement = getElement(toElementID, toElementIDType)

    let fromElementHeight = fromElement.height();
    let fromElementMarginTop = parseInt(fromElement.css("margin-top").replace("px", ""));
    let fromElementMarginBottom = parseInt(fromElement.css("margin-bottom").replace("px", ""));
    let newMarginTop =
        fromElementHeight
        +fromElementMarginTop
        +fromElementMarginBottom
        +extraPx+"px"

    toElement.css("margin-top", newMarginTop);

    $(window).on("resize", function() {
        fromElementHeight = fromElement.height();
        fromElementMarginTop = parseInt(fromElement.css("margin-top").replace("px", ""));
        fromElementMarginBottom = parseInt(fromElement.css("margin-bottom").replace("px", ""));

        newMarginTop =
            fromElementHeight
            +fromElementMarginTop
            +fromElementMarginBottom
            +extraPx+"px"
        toElement.css("margin-top", newMarginTop);
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
        "top": 0,
    })

    toElement.css({
        "margin-top": newMarginTop,
    });
}

function setMarginTopFooter(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {
    let fromElement = getElement(fromElementID, fromElementIDType)
    let toElement = getElement(toElementID, toElementIDType)

    setMarginTopFooterFunction(fromElement, toElement, extraPx);

    setTimeout(() => {
        setMarginTopFooterFunction(fromElement, toElement, extraPx);
    }, 10)

    $(window).on("resize", function() {
        setMarginTopFooterFunction(fromElement, toElement, extraPx);
    })

}

function setToWindowHeight(toElementID, toElementIDType, extraPx) {
    let toElement = getElement(toElementID, toElementIDType)
    let newHeight = window.innerHeight+extraPx+"px";

    toElement.css({"height" : newHeight})

    setTimeout(() => {
        toElement.css({"height" : newHeight});
    }, 20)

    $(window).on("resize", function() {
        newHeight = $(window).height()+extraPx+"px";

        toElement.css({"height" : newHeight})
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