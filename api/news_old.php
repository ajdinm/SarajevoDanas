<?php

    $news = file("./../data/news.csv");

    header('Content-type:application/json;charset=utf-8');
    $response = '[';
    foreach($news as $news_row) {
        $response .= getNewsJson($news_row).',';
    }
    echo substr($response, 0, strlen($response) - 1).']';

/*
    if(!isset($_GET['filter'])) {
        // show all news
    }
    elseif($_GET['filter'] == 'day') {
        // show only today news
    }
    elseif($_GET['filter'] == 'week') {
        // show news from this week
    }
    elseif($_GET['filter'] == 'week') {
        // show news from this week
    }
*/

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

?>
