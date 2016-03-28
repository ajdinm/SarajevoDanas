window.onload = function () {
    document.getElementById("news-test").innerHTML = getNewsHTML(all_news[0], "left-half");
    document.getElementById("news-r").innerHTML = getNewsHTML(all_news[1], "right-half");
    document.getElementById("news-lf").innerHTML = getNewsHTML(all_news[3], "left");
    document.getElementById("news-rf").innerHTML = getNewsHTML(all_news[2], "right");
    rewriteTimeStamps();

}
function filter_news(caller) {
        alert(caller.value);
}
