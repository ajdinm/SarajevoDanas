<?php
    session_start();
    if(isset($_SESSION['login']) && $_SESSION['login'] == true && $_SESSION['role'] == 'regular') {
        $snippet_url = '';
        $form_url= '';
        $msg= '';
        $news_msg= '';
        $msg = "Dobro dosao, " . $_SESSION['username'] . "!";

        if(count($_SESSION['unreadNews']) > 0) {
            $news_msg = 'Imate nove komentare na sljedećim vijestima: ';
            $news_msg .= '<br>';
            foreach($_SESSION['unreadNews'] as $news) {
                $news_msg .= '<a href="./user.php?what=show&news_id=' . $news['id'] . '">' . $news['title'] . '</a><br>' ;
            }
        }
        else {
            $news_msg = "Nemate neprocitanih komentara!";
        }
        if(isset($_GET['what'])) {
            if($_GET['what'] == 'create') {
                $snippet_url = './../snippets/create_news.html';
                $form_html = file_get_contents($snippet_url);
            }
            if($_GET['what'] == 'show') {

                $id = $_GET['news_id'];
                $service_url  = 'http://sdbanas-majdin.rhcloud.com/api/news.php';
                $service_url .= '?id=' . $id;
                $curl = curl_init($service_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                debug_to_console($service_url);
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
                $form_html = $decoded['title'];
            }
            elseif($_GET['what'] == 'add') {
                if ($_GET['img_path'] == '' || $_GET['img_alt'] == '' || $_GET['text'] == '') {
                    die('Neispravan zahtjev. Vratite se na prošlu stranicu i pokušajte opet.');
                }
                else {
                    $img_path = htmlentities($_GET['img_path'], ENT_QUOTES);
                    $img_alt = htmlentities($_GET['img_alt'], ENT_QUOTES);
                    $text = htmlentities($_GET['text'], ENT_QUOTES);
                    $ccode = htmlentities($_GET['coutry_code'], ENT_QUOTES);
                    $phone = htmlentities($_GET['phone'], ENT_QUOTES);
                    $title = htmlentities($_GET['title'], ENT_QUOTES);
                    $commentable = "0";
                    $news_row = $img_path.','.$img_alt.','.time().','.$text;

                    if(isset($_GET['commentable']) && $_GET['commentable'] !=  "") {
                        $commentable = "1";
                    }
                    debug_to_console($_SESSION['userID']);

                    $service_url = 'https://restcountries.eu/rest/v1/alpha?codes=ba';
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
                    $validateCCode = false;
                    foreach($decoded as $country) {
                        foreach($country['callingCodes'] as $code) {
                            if(substr($phone, 0, strlen($code) + 1) === '+'.$code) {
                                $validateCCode = true;
                                break;
                            }
                        }
                    }
                    if(!$validateCCode) {
                        die('Nekonzistentan kod drzave i pozivni');
                    }

                    $service_url  = 'http://sdbanas-majdin.rhcloud.com/api/add_news.php';
                    $service_url .= '?text=' . $text;
                    $service_url .= '&title=' . $title;
                    $service_url .= '&picture=' . $picture;
                    $service_url .= '&alt=' . $alt;
                    $service_url .= '&author=' . $_SESSION['userID'];
                    $service_url .= '&isCommentable=' . $commentable;
                    $curl = curl_init($service_url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    debug_to_console($service_url);
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

                    $msg = " " . $_SESSION['userID'];
                    if($decoded['success'] == 'true') {
                            $msg = "Vijest uspjesno dodana.";
                    }
                    else {
                        $msg = "Doslo je do greške.";
                    }
                    $alert = "<script type='text/javascript'>alert('$msg');</script>";
                    echo $alert;


                }
            }
        }
    }
    else {
        header('Location: ./../pages/login.php');
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
