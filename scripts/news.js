function getNewsHTML(news_obj, align) {
    var timestampHTML = '<a class="news-timestamp">' + news_obj.timestamp + '</a>';
    var toReturn = getDiv("news news-" + align)
            toReturn += getDiv("img-" + align + "-cont");
                toReturn += getImgHTML(news_obj.img, "img-" + align)
            toReturn += closeDiv();
            toReturn += getParagraphHTML(news_obj.text);
            toReturn += getParagraph(timestampHTML, "news-time") + closeParagraph();
    toReturn += closeDiv();
    return toReturn;
}
function getParagraph(text, classes) {
    var classText = "";
    if(classes) {
        classText = 'class = "' + classes + '"';
    }
    return '<p ' + classText + '>' + text;
}

function closeParagraph() {
    return '</p>';
}

function getImgHTML(img, classes) {
    return '<img class="' + classes + '" src="' + img.src + '" alt= "' + img.alt + '">';
}

function getDiv(classes) {
    return '<div class="' + classes + '">';
}
function closeDiv() {
    return '</div>';
}
function getParagraphHTML(texts) {
    var toReturn = "";
    for(i = 0; i < texts.length; i++) {
        toReturn += getParagraph(texts[i], "") + closeParagraph();
    }
    return toReturn;
}
/* LEGACY FUNCTIONS
    function getLeftNewsHTML(news_obj) {
        var timestampHTML = '<a class="news-timestamp">' + news_obj.timestamp + '</a>';
        var toReturn = getDiv("news news-left")
                toReturn += getDiv("img-left-cont");
                    toReturn += getImgHTML(news_obj.img, "img-left")
                toReturn += closeDiv();
                toReturn += getParagraphHTML(news_obj.text);
                toReturn += getParagraph(timestampHTML, "news-time") + closeParagraph();
        toReturn += closeDiv();
        return toReturn;
    }
    function getRightNewsHTML(news_obj) {
        var timestampHTML = '<a class="news-timestamp">' + news_obj.timestamp + '</a>';
        var toReturn = getDiv("news news-right")
                toReturn += getDiv("img-right-cont");
                    toReturn += getImgHTML(news_obj.img, "img-right")
                toReturn += closeDiv();
                toReturn += getParagraphHTML(news_obj.text);
                toReturn += getParagraph(timestampHTML, "news-time") + closeParagraph();
        toReturn += closeDiv();
        return toReturn;
    }


    function getLeftHalfNewsHTML(news_obj) {
        var timestampHTML = '<a class="news-timestamp">' + news_obj.timestamp + '</a>';
        var toReturn = getDiv("news news-left-half")
                toReturn += getDiv("img-left-half-cont");
                    toReturn += getImgHTML(news_obj.img, "img-left-half")
                toReturn += closeDiv();
                toReturn += getParagraphHTML(news_obj.text);
                toReturn += getParagraph(timestampHTML, "news-time") + closeParagraph();
        toReturn += closeDiv();
        return toReturn;
    }
    function getRightHalfNewsHTML(news_obj) {
        var timestampHTML = '<a class="news-timestamp">' + news_obj.timestamp + '</a>';
        var toReturn = getDiv("news news-right-half")
                toReturn += getDiv("img-right-half-cont");
                    toReturn += getImgHTML(news_obj.img, "img-right-half")
                toReturn += closeDiv();
                toReturn += getParagraphHTML(news_obj.text);
                toReturn += getParagraph(timestampHTML, "news-time") + closeParagraph();
        toReturn += closeDiv();
        return toReturn;
    }
*/
