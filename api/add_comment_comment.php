<?php

    require './../lib/password.php';

    header('Content-type:application/json;charset=utf-8');

    $text = $_GET['text'];
    $author = $_GET['author'];
    $comment = $_GET['comment'];

    echo insertCommentComment($text, $author, $comment);

    function insertCommentComment($text, $author, $comment) {

        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
        $dbh = new PDO($dsn, DB_USER, DB_PASS);

        $query  = "insert into comment_comment ";
        $query .= "(text, author_id, comment_id, isRead) ";
        $query .= "values ";
        $query .= "(:text, :author, :comment, 0) ";

        $rez = $dbh->prepare($query);
        $rez->bindParam(':text', $text);
        $rez->bindParam(':author', $author);
        $rez->bindParam(':comment', $comment);

        $toReturn = array();
        $toReturn['success'] = $rez->execute();

        return json_encode($toReturn);
    }
?>
