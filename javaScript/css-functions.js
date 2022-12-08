function setHeight(fromElement, toElement) {
    let divElement = document.querySelector(fromElement);
    console.log(divElement.offsetHeight);
    document.getElementById(toElement).style.height = divElement.offsetHeight+"px";
}

function setMarginTopSub(fromElement, toElement) {
    let divElement = document.querySelector(fromElement);
    console.log(divElement.offsetHeight);
    document.getElementById(toElement).style.marginTop = divElement.offsetHeight+"px";
}

function setMarginTop(x, fromElement, toElement) {
    if (x.matches) { // If media query matches
        setMarginTopSub(fromElement, toElement)
    } else {
        setMarginTopSub(fromElement, toElement)
    }
}


