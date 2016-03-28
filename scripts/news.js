/*    <div class="news news-left-half">
                    <div class="img-left-half-cont">
                        <img class="img-left-half" src="./../images/img2.jpg" alt="none">
                    </div>
                    <p>
                        Donec maximus, magna non varius mattis, quam velit sagittis velit, sit amet porta nunc lorem sit amet nisi. Sed sodales, lectus vitae pharetra finibus, justo velit lacinia ligula, eu volutpat ante ipsum a enim. Suspendisse potenti. Vivamus aliquam ultrices nulla a finibus. Maecenas porta mattis laoreet. Morbi et rhoncus urna. Phasellus pulvinar porttitor scelerisque. Nam et nunc nec sem pharetra sollicitudin at vel nunc. Maecenas ut porta nulla. Aenean finibus orci et tempus consectetur. Suspendisse cursus pretium arcu id imperdiet.
                    </p>
                        <p class="news-time"><a class="news-timestamp">1459112770088</a> </p>
                </div>
*/
    var news_obj = {
        img: {
            src: "./../images/img2.jpg",
            alt: "none"
        },
        text: "Donec maximus, magna non varius mattis, quam velit sagittis velit, sit amet porta nunc lorem sit amet nisi. Sed sodales, lectus vitae pharetra finibus, justo velit lacinia ligula, eu volutpat ante ipsum a enim. Suspendisse potenti. Vivamus aliquam ultrices nulla a finibus. Maecenas porta mattis laoreet. Morbi et rhoncus urna. Phasellus pulvinar porttitor scelerisque. Nam et nunc nec sem pharetra sollicitudin at vel nunc. Maecenas ut porta nulla. Aenean finibus orci et tempus consectetur. Suspendisse cursus pretium arcu id imperdiet.",
        timestamp: "1459112770088"
    }


    function getLeftHalfNewsHTML(news_obj) {
        var timestampHTML = '<a class="news-timestamp">' + news_obj.timestamp + '</a>';
        var toReturn = getDiv("news news-left-half")
                toReturn += getDiv("img-left-half-cont");
                    toReturn += getImgHTML(news_obj.img, "img-left-half")
                toReturn += closeDiv();
                toReturn += getParagraph(news_obj.text, "") + closeParagraph();
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
