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

                    $news_row = $img_path.','.$img_alt.','.time().','.$text;

                    file_put_contents('./../data/test.csv', $news_row. PHP_EOL, FILE_APPEND);
                }
            }
        }
    }
    else {
        header('Location: ./../pages/login.php');
    }
?>
