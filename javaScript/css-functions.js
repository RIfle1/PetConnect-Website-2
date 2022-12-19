function setHeight(fromElement, toElement) {
    let divElement = document.querySelector(fromElement);
    document.getElementById(toElement).style.height = divElement.offsetHeight+"px";
}

function setMarginTop(fromElement, toElement, extraPx) {
    let divElement = document.querySelector(fromElement);
    document.getElementById(toElement).style.marginTop = divElement.offsetHeight+extraPx+"px";
}

