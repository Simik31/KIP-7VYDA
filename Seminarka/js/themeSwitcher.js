let theme;

if (getCookie("theme") == null) document.cookie = "theme=light";

function themeSwitch() {
    if(theme === "light") {
        theme = "dark";
        $("#theme")[0].href = "css/darkTheme.css";
        $("#switch")[0].style.backgroundImage = "url('img/sun.svg')";
    }
    else {
        theme = "light";
        $("#theme")[0].href = "css/lightTheme.css";
        $("#switch")[0].style.backgroundImage = "url('img/moon.svg')";
    }
    document.cookie = "theme=" + theme;
}

$(document).ready(function () {
    theme = (getCookie("theme") === "dark") ? "light" : "dark";
    themeSwitch();
    $('[data-toggle="tooltip"]').tooltip();
});


function getCookie(cname) {
    let name = cname + "=";
    let ca = decodeURIComponent(document.cookie).split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}