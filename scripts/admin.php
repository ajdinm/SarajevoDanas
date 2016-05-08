<?php
    session_start();
    if(isset($_SESSION['login']) && $_SESSION['login'] == true) {
        $snippet_url = '';
        $form_url= '';
        if(isset($_GET['what'])) {
            if($_GET['what'] == 'create') {
                $snippet_url = './../snippets/create_news.html';
                $form_html = file_get_contents($snippet_url);
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
                    $news_row = $img_path.','.$img_alt.','.time().','.$text;

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
                    file_put_contents('./../data/news.csv', $news_row.PHP_EOL, FILE_APPEND);
                }
            }
        }
    }
    else {
        header('Location: ./../pages/login.php');
    }

    function CallAPI($method, $url, $data = false) {
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
