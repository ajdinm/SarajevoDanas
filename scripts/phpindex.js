var shown_news, all_news;
var sort_criterion;

window.onload = function() {

    rewriteTimeStamps();

    sort_criterion = compareNewsByPostTime;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        var codeOK = false;
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            all_news = JSON.parse(xhttp.responseText);
            shown_news = all_news;
        }
    };
    var url = "./../api/news.php";
    xhttp.open("GET", url, true);
    xhttp.send();

}

function checked_ab(caller) {
    if (caller.checked) {
        var newLocation = "./../index.php?sort=alpha";
        window.location = newLocation;
    } else {
        var newLocation = "./../index.php";
        window.location = newLocation;
    }
}

function filter_news(caller) {
    var allowed_timeframe = 0; //in sec
    if (caller.value == "day") {
        allowed_timeframe = 24 * 60 * 60;
    } else if (caller.value == "week") {
        allowed_timeframe = 7 * 24 * 60 * 60;
    } else if (caller.value == "month") {
        allowed_timeframe = 4 * 7 * 24 * 60 * 60; // assume month is 4 weeks
    }
    if (allowed_timeframe == 0) {
        shown_news = all_news;
        showNews();
        return;
    }
    shown_news = all_news.filter(
        news => {
            return getDifferenceInSec(news.timestamp * 1000) <= allowed_timeframe; // * 1000 => php timestamp is in seconds
        }
    );
    showNews();
    return;
}

function compareNewsByPostTime(news, news1) {
    return news.timestamp < news1.timestamp;
}

function compareNewsAlphabetically(news, news1) {
    return news.text[0] > news1.text[0];
}

function sortNews() {

    var cb = document.getElementById("cb");
    if(cb.checked) {
        sort_criterion = compareNewsAlphabetically;
    }
    else {
        sort_criterion = compareNewsByPostTime;
    }
    shown_news = shown_news.sort(sort_criterion);
}

function showNews() {
    sortNews();
    var containter = document.getElementsByClassName("news-container");
    containter[0].innerHTML = "";
    var newHTML = "";
    var layout = ['left-half', 'right-half', 'left', 'right'];
    var j = 0;
    for (var i = 0; i < shown_news.length; i++) {
        if (j == 0) {
            newHTML += getDiv("news-row");
        }
        newHTML += getDiv() + getNewsHTML(shown_news[i], layout[j]) + closeDiv();
        if (j == 1) {
            newHTML += closeDiv();
        }
        j = (j + 1) % 4;
    }
    containter[0].innerHTML = newHTML;
    rewriteTimeStamps();
    return;
}

function filter_news(caller) {
    var allowed_timeframe = 0; //in sec
    if (caller.value == "day") {
        allowed_timeframe = 24 * 60 * 60;
    } else if (caller.value == "week") {
        allowed_timeframe = 7 * 24 * 60 * 60;
    } else if (caller.value == "month") {
        allowed_timeframe = 4 * 7 * 24 * 60 * 60; // assume month is 4 weeks
    }
    if (allowed_timeframe == 0) {
        shown_news = all_news;
        showNews();
        return;
    }
    shown_news = all_news.filter(
        news => {
            return getDifferenceInSec(news.timestamp * 1000) <= allowed_timeframe; // * 1000 => php timestamp is in seconds
        }
    );
    showNews();
    return;
}
