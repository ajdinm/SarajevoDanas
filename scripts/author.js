var shown_news, all_news;
var sort_criterion;
window.onload = function() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            all_news = JSON.parse(xhttp.responseText);
            alert(xhttp.responseText);
            shown_news = all_news;
            sort_criterion = compareNewsByPostTime;
            showNews();
        }
    };
    var queryParams = getQueryParams(location.search);
    xhttp.open("GET", api_info.url + "author_news.php?autor=" + queryParams.id, true);
    xhttp.send();
}
function getQueryParams(qs) {
    qs = qs.split('+').join(' ');

    var params = {},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
    }

    return params;
}

function compareNewsByPostTime(news, news1) {
    return news.timestamp > news1.timestamp;
}

function compareNewsAlphabetically(news, news1) {
    return news.title < news1.title;
}

function sortNews() {
    for (var j = 0; j < shown_news.length - 1; j++) {
        var indexMin = j;
        for (var i = j + 1; i < shown_news.length; i++) {
            if (shown_news[i].timestamp < shown_news[indexMin].timestamp) {
                indexMin = i;
            }
        }
            if (indexMin != j) {
                showNews[j] = [showNews[indexMin], showNews[indexMin] = showNews[j]][0];
            }
        }
        //    shown_news = shown_news.sort();
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

    function checked_ab(caller) {
        if (caller.checked) {
            sort_criterion = compareNewsAlphabetically;
        } else {
            sort_criterion = compareNewsByPostTime;
        }
        showNews();
    }
