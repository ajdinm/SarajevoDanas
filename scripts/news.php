<?php
    session_start();
        if(isset($_GET['what'])) {
            if($_GET['what'] == 'show') {

                $id = $_GET['news_id'];
                $service_url  = 'http://sdbanas-majdin.rhcloud.com/api/news.php';
                $service_url .= '?id=' . $id;
                $curl = curl_init($service_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $curl_response = curl_exec($curl);
                if ($curl_response === false) {
                    $info = curl_getinfo($curl);
                    curl_close($curl);
                    die('Doslo je greske: ' . var_export($info));
                }
                curl_close($curl);
                $decoded = json_decode($curl_response, true);
                if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
                    die('error occured: ' . $decoded->response->errormessage);
                }
                $news_title = $decoded['title'];
                $news_text = $decoded['text'] . '<br>';
                $comment_html = getCommentHTML($decoded['comments'], $decoded['id']);
            }
        }
        if(isset($_GET['comment']) && isset($_GET['news_id'])) {

            $service_url  = 'http://sdbanas-majdin.rhcloud.com/api/add_news_comment.php';
            $service_url .= '?text=' . $_GET['comment'] . '&news=' . $_GET['news_id'];
            $author = "15";
            if(isset($_SESSION['login']) && $_SESSION['login'] == true) {
                $author = $_SESSION['userID'];
            }
            $service_url .= '&author=' . $author;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                curl_close($curl);
                die('Doslo je greske: ' . var_export($info));
            }
            curl_close($curl);
            $decoded = json_decode($curl_response, true);
            if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
                die('error occured: ' . $decoded->response->errormessage);
            }
            header('Location: ./../pages/news.php?what=show&news_id=' . $_GET['news_id']);
        }

        if(isset($_GET['ccomment']) && isset($_GET['comment_id'])) {

            $service_url  = 'http://sdbanas-majdin.rhcloud.com/api/add_comment_comment.php';
            $service_url .= '?text=' . $_GET['ccomment'] . '&comment=' . $_GET['comment_id'];
            $author = "15";
            if(isset($_SESSION['login']) && $_SESSION['login'] == true) {
                $author = $_SESSION['userID'];
            }
            $service_url .= '&author=' . $author;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                curl_close($curl);
                die('Doslo je greske: ' . var_export($info));
            }
            curl_close($curl);
            $decoded = json_decode($curl_response, true);
            if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
                die('error occured: ' . $decoded->response->errormessage);
            }
            header('Location: ./../pages/news.php?what=show&news_id=' . $_GET['news_id']);
        }

    function getCommentHTML($comments, $news_id) {
        $toReturn = '<br>Komentari: <br>';
        foreach ($comments as $comment) {
            $toReturn .= '<h4>' . $comment['text'] . '</h4><br>Autor: ' . '<a href="./../pages/user.php?id=' . $comment['author_id'] . '">';
            $toReturn .= $comment['username'] . '</a><br>';

            if(count($comment['comments']) > 0) {
                $toReturn .= '<style> myp {text-indent: 50px; }</style>';
            }
            foreach ($comment['comments'] as $ccomment) {
                $toReturn .= '<br>' . $ccomment['text'] . ', autor: ' . '<a href="./../pages/user.php?id=' . $ccomment['author_id'] . '">';
                $toReturn .= $ccomment['username'] . '</a>';
            }
            $toReturn .= "<br><br>Dodaj komentar na komentar: ";
            $toReturn .= '<form action="./news.php" method="GET"> <textarea name="ccomment"></textarea>';
            $toReturn .= "<input type='hidden' name='comment_id' value='" . $comment['id'] . "'>";
            $toReturn .= "<input type='hidden' name='news_id' value='" . $news_id . "'>";
            $toReturn .= "<input type='submit' value='Komentiraj'>";
            $toReturn .= "</form>";

        }
        $toReturn .= "<br><br>Dodaj komentar: ";
        $toReturn .= '<form action="./news.php" method="GET"> <textarea name="comment"></textarea>';
        $toReturn .= "<input type='hidden' name='news_id' value='" . $news_id . "'>";
        $toReturn .= "<input type='submit' value='Komentiraj'>";
        $toReturn .= "</form>";
        return $toReturn;
    }

    function debug_to_console( $data ) {
        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        echo $output;
    }    function CallAPI($method, $url, $data = false) {
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }


    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
}
?>
