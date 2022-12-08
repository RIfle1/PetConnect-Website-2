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



// <script type="text/javascript">
//     const x = window.matchMedia("(max-width: 960px)");
//     const y = window.matchMedia("(max-width: 600px)");
//     setMarginTop(x, '.site-header-main-header', 'profile-main-div')
//     x.addListener(function () {setMarginTop(x ,'.site-header-main-header', 'profile-main-div') })
//     y.addListener(function () {setMarginTop(x ,'.site-header-main-header', 'profile-main-div') })
// </script>


