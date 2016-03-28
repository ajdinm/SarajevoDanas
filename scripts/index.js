var shown_news;
window.onload = function () {
/*    document.getElementById("news-test").innerHTML = getNewsHTML(all_news[0], "left-half");
    document.getElementById("news-r").innerHTML = getNewsHTML(all_news[1], "right-half");
    document.getElementById("news-lf").innerHTML = getNewsHTML(all_news[3], "left");
    document.getElementById("news-rf").innerHTML = getNewsHTML(all_news[2], "right");
*/
    shown_news = all_news;
    showNews();

}
function compareNewsByPostTime(news, news1) {
    return news.timestamp < news1.timestamp;
}
function sortNews() {
    shown_news = shown_news.sort(compareNewsByPostTime);
}
    function showNews() {
        sortNews();
        var containter = document.getElementsByClassName("news-container");
        containter[0].innerHTML = "";
        var newHTML = "";
        var layout = ['left-half', 'right-half', 'left', 'right'];
        var j = 0;
        for(var i = 0; i < shown_news.length; i++) {
            if(j == 0) {
                newHTML += getDiv("news-row");
            }
            newHTML += getDiv() + getNewsHTML(shown_news[i], layout[j]) + closeDiv();
            if(j == 1) {
                newHTML += closeDiv();
            }
            j = (j+1) % 4;
        }
        containter[0].innerHTML = newHTML;
        rewriteTimeStamps();
        return;
    }
    function filter_news(caller) {
        var allowed_timeframe = 0; //in sec
        if(caller.value == "day") {
            allowed_timeframe = 24 * 60 * 60;
        }
        else if(caller.value == "week") {
            allowed_timeframe = 7 * 24 * 60 * 60;
        }
        else if(caller.value == "month") {
            allowed_timeframe = 4 * 7 *24 * 60 * 60; // assume month is 4 weeks
        }
        if(allowed_timeframe == 0) {
            shown_news = all_news;
        }
        shown_news = all_news.filter(
            news => {
                return getDifferenceInSec(news.timestamp) <= allowed_timeframe;
            }
        );
        showNews();
        return;
    }
