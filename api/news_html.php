<?php
    ini_set("display_errors", 1);
    $okMsg = $logoutButton = "";
    $news_html = "";
    $all_news = json_decode(getAllNewsArray());
    $shown_news1 = [];
    $shown_news1 = $all_news;
    $compareBy = 'compareByTimestamp';
    $checked = "";


    if(!isset($_GET['sort'])) {
        // sort by timestamp
        global $compareBy;

        $compareBy = 'compareByTimestamp';
        showNews();
    }
    elseif($_GET['sort'] == 'alpha') {
        // sort alphabetically

        global $compareBy, $checked;

        $compareBy = 'compareAlphabetically';
        $checked = "checked";
        showNews();
    }

    function showNews() {
        sortNews();
        global $news_html, $shown_news1, $all_news;

        $layout = ['left-half', 'right-half', 'left', 'right'];
        $j = 0;
        for($i = 0; $i < count($shown_news1); $i++) {
            if($j == 0) {
                $news_html .= getDiv("news-row");
            }
            $news_html .= getDiv("") . getNewsHTML($shown_news1[$i], $layout[$j]) . closeDiv("");
            if($j == 1) {
                $news_html .= closeDiv();
            }
            $j = ($j + 1) % 4;
        }
//        rewriteTimeStamps();
        return;
    }

    function getNewsJson($string) {
        $news = explode(',', $string, 4);

        $toReturn = array(
            'img' => array(
                'src' => './../images/'.$news[0],
                'alt' => $news[1]
            ),
            'timestamp' => $news[2],
            'text' => array($news[3])
        );

        return json_encode($toReturn);
    }

    function getNewsHTML($news_obj_param, $align) {
        $news_obj = get_object_vars($news_obj_param);
        $timestampHTML = "<a class=\"news-timestamp\">" . $news_obj['timestamp'] . "<a>";
        $toReturn = getDiv("news news-" . $align);
        $toReturn .= getDiv("img-" . $align . "-cont");
        $toReturn .= getImgHTML($news_obj['img'], "img-" . $align);
        $toReturn .= closeDiv();
        $toReturn .= getParagraphHTML($news_obj['text'][0]);
        $toReturn .= getParagraph($timestampHTML, "news-time") . closeParagraph();
        $toReturn .= closeDiv();
        return $toReturn;
}
function getParagraph($text, $classes) {
    $classText = "";
    if($classes != "") {
        $classText = 'class = "' . $classes . '"';
    }
    return '<p ' . $classText . '>' . $text;
}

function closeParagraph() {
    return '</p>';
}

function getImgHTML($img_param, $classes) {
    $img = get_object_vars($img_param);
    return "<img class=\"" . $classes . "\" src=\"" . $img['src'] . "\" alt= \"" . $img['alt'] . "\">";
}

function getDiv($classes) {
    return "<div class=\"" . $classes . "\">";
}
function closeDiv() {
    return '</div>';
}
function getParagraphHTML($text) {

    $toReturn = getParagraph($text, "") . closeParagraph();
    return $toReturn;
}
function getAllNewsArray() {
    $news = file("./data/news.csv");
    $toReturn = '[';
    foreach($news as $news_row) {
        $toReturn .= getNewsJson($news_row).',';
    }
    return substr($toReturn, 0, strlen($toReturn) - 1).']';
}

function compareByTimestamp($news, $news1) {
    $news = get_object_vars($news);
    $news1 = get_object_vars($news1);
    return $news['timestamp'] < $news1['timestamp'];
}
function compareAlphabetically($news, $news1) {
    $news = get_object_vars($news);
    $news1 = get_object_vars($news1);
    return strcmp($news['text'][0], $news1['text'][0]) > 0;
}

function sortNews() {
    global $shown_news1, $compareBy;
    usort($shown_news1, $compareBy);
}

?>
