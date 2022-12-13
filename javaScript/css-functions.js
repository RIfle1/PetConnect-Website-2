function setHeight(fromElement, toElement) {
    let divElement = document.querySelector(fromElement);
    document.getElementById(toElement).style.height = divElement.offsetHeight+"px";
}

function setMarginTop(fromElement, toElement, extraPx) {
    let divElement = document.querySelector(fromElement);
    document.getElementById(toElement).style.marginTop = divElement.offsetHeight+extraPx+"px";
}

// function setMarginTopInt(toElement, minusValue, value) {
//     // console.log(document.getElementById(toElement).style.marginTop = value-minusValue+"px");
// }


// <script type="text/javascript">
//     const x = window.matchMedia("(max-width: 960px)");
//     const y = window.matchMedia("(max-width: 600px)");
//     setMarginTop(x, '.site-header-main-header', 'profile-main-div')
//     x.addListener(function () {setMarginTop(x ,'.site-header-main-header', 'profile-main-div') })
//     y.addListener(function () {setMarginTop(x ,'.site-header-main-header', 'profile-main-div') })
// </script>

// function loadDoc() {
//     var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//         if (this.readyState === 4 && this.status === 200) {
//             document.getElementById("demo").innerHTML = this.responseText;
//         }
//     };
//     xhttp.open("GET", "ajax_info.txt", true);
//     xhttp.send();
// }


// $.ajax({
//     url: "/api/getWeather",
//     data: {
//         zipcode: 97201
//     },
//     success: function( result ) {
//         $( "#weather-temp" ).html( "<strong>" + result + "</strong> degrees" );
//     }
// });