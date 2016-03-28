var all_news = [
    {
        img: {
            src: "./../images/img2.jpg",
            alt: "none"
        },
        text: ["Donec maximus, magna non varius mattis, quam velit sagittis velit, sit amet porta nunc lorem sit amet nisi. Sed sodales, lectus vitae pharetra finibus, justo velit lacinia ligula, eu volutpat ante ipsum a enim. Suspendisse potenti. Vivamus aliquam ultrices nulla a finibus. Maecenas porta mattis laoreet. Morbi et rhoncus urna. Phasellus pulvinar porttitor scelerisque. Nam et nunc nec sem pharetra sollicitudin at vel nunc. Maecenas ut porta nulla. Aenean finibus orci et tempus consectetur. Suspendisse cursus pretium arcu id imperdiet."],
        timestamp: "1459112770088"
    },
    {
        img: {
            src: "./../images/img2.jpg",
            alt: "none"
        },
        text: ["Donec maximus, magna non varius mattis, quam velit sagittis velit, sit amet porta nunc lorem sit amet nisi. Sed sodales, lectus vitae pharetra finibus, justo velit lacinia ligula, eu volutpat ante ipsum a enim. Suspendisse potenti. Vivamus aliquam ultrices nulla a finibus. Maecenas porta mattis laoreet. Morbi et rhoncus urna. Phasellus pulvinar porttitor scelerisque. Nam et nunc nec sem pharetra sollicitudin at vel nunc. Maecenas ut porta nulla. Aenean finibus orci et tempus consectetur. Suspendisse cursus pretium arcu id imperdiet."],
        timestamp: "1459116248900"
    },
    {
        img: {
            src: "./../images/img2.jpg",
            alt: "none"
        },
        text: ["Donec maximus, magna non varius mattis, quam velit sagittis velit, sit amet porta nunc lorem sit amet nisi. Sed sodales, lectus vitae pharetra finibus, justo velit lacinia ligula, eu volutpat ante ipsum a enim. Suspendisse potenti. Vivamus aliquam ultrices nulla a finibus. Maecenas porta mattis laoreet. Morbi et rhoncus urna. Phasellus pulvinar porttitor scelerisque. Nam et nunc nec sem pharetra sollicitudin at vel nunc. Maecenas ut porta nulla. Aenean finibus orci et tempus consectetur. Suspendisse cursus pretium arcu id imperdiet.",
                "Etiam lobortis, turpis at elementum vulputate, urna diam consequat enim, eget efficitur nisl dolor sed eros. Vestibulum et nunc libero. Pellentesque vitae lacus et est auctor tristique. Sed faucibus nec justo quis iaculis. Fusce in tellus arcu. Vestibulum nisi arcu, interdum ac ante vitae, hendrerit porttitor lectus. Fusce vel sem enim. Mauris interdum, nunc ac pellentesque posuere, sem enim accumsan justo, eget consectetur arcu urna a felis. Nam volutpat nisl ac sem posuere, ut dapibus risus viverra. Nunc hendrerit facilisis odio a congue."
              ],
        timestamp: "1458857728379"
    },
    {
        img: {
            src: "./../images/img1.jpg",
            alt: "none"
        },
        text: ["Donec maximus, magna non varius mattis, quam velit sagittis velit, sit amet porta nunc lorem sit amet nisi. Sed sodales, lectus vitae pharetra finibus, justo velit lacinia ligula, eu volutpat ante ipsum a enim. Suspendisse potenti. Vivamus aliquam ultrices nulla a finibus. Maecenas porta mattis laoreet. Morbi et rhoncus urna. Phasellus pulvinar porttitor scelerisque. Nam et nunc nec sem pharetra sollicitudin at vel nunc. Maecenas ut porta nulla. Aenean finibus orci et tempus consectetur. Suspendisse cursus pretium arcu id imperdiet.",
                "Etiam lobortis, turpis at elementum vulputate, urna diam consequat enim, eget efficitur nisl dolor sed eros. Vestibulum et nunc libero. Pellentesque vitae lacus et est auctor tristique. Sed faucibus nec justo quis iaculis. Fusce in tellus arcu. Vestibulum nisi arcu, interdum ac ante vitae, hendrerit porttitor lectus. Fusce vel sem enim. Mauris interdum, nunc ac pellentesque posuere, sem enim accumsan justo, eget consectetur arcu urna a felis. Nam volutpat nisl ac sem posuere, ut dapibus risus viverra. Nunc hendrerit facilisis odio a congue."
              ],
        timestamp: "1459102030759"
    }
];
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
