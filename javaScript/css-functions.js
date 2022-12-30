function setHeight(fromElement, toElement) {
    let divElement = document.querySelector(fromElement);
    document.getElementById(toElement).style.height = divElement.offsetHeight+"px";
}

function setMarginTop(fromElement, toElement, extraPx) {
    let divElement = document.querySelector(fromElement);
    document.getElementById(toElement).style.marginTop = divElement.offsetHeight+extraPx+"px";
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