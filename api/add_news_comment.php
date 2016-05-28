<?php

    require './../lib/password.php';

    header('Content-type:application/json;charset=utf-8');

    $text = $_GET['text'];
    $author = $_GET['author'];
    $news = $_GET['news'];

    echo insertNewsComment($text, $author, $news);

    function insertNewsComment($text, $author, $news) {

        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
        $dbh = new PDO($dsn, DB_USER, DB_PASS);

        $query  = "insert into news_comment ";
        $query .= "(text, author_id, news_id, isRead) ";
        $query .= "values ";
        $query .= "(:text, :author, :news, 0) ";

        $rez = $dbh->prepare($query);
        $rez->bindParam(':text', $text);
        $rez->bindParam(':author', $author);
        $rez->bindParam(':news', $news);

        $toReturn = array();
        $toReturn['success'] = $rez->execute();

        return json_encode($toReturn);
    }
    function getNewsCommentsByID($id) {

        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
        $dbh = new PDO($dsn, DB_USER, DB_PASS);

        $query  = "select nc.id id, nc.text text, a.username username, a.id author_id ";
        $query .= "from news_comment nc, user a, news n ";
        $query .= "where n.id = :id ";
        $query .= "and nc.news_id = n.id ";
        $query .= "and a.id = nc.author_id";

        $rez = $dbh->prepare($query);
        $rez->bindParam(':id', $id);
        $rez->execute();
        $data = $rez->fetchAll(PDO::FETCH_ASSOC);


        //set comments as read

        $placeholders = str_repeat('?, ', count($data) - 1) . '?';

        $query  = "update news_comment ";
        $query .= "set isRead = 1 ";
        $query .= "where id in ($placeholders)";

        $ids = array_map(create_function('$arr', 'return $arr["id"];'), $data);
        $rez = $dbh->prepare($query);
        $rez->execute($ids);

        $query  = "select cc.id id, cc.text text, cc.comment_id comment_id, a.username username, a.id author_id ";
        $query .= "from comment_comment cc, news_comment nc, user a ";
        $query .= "where cc.comment_id = nc.id ";
        $query .= "and a.id = cc.author_id ";
        $query .= "and cc.comment_id in ($placeholders)";

        $rez = $dbh->prepare($query);
        $rez->execute($ids);

        $ccomments = $rez->fetchAll(PDO::FETCH_ASSOC);

        $data = array_map(function($comment) use ($ccomments) {

            $id = $comment['id'];
            $comment['comments'] = array_filter($ccomments, function($ccomment) use($id){
                return strcmp($ccomment['comment_id'], $id);
            });
            return $comment;
        }, $data);

        return $data;
}

function addCComent($comment, $ccoments) {

    var_dump($ccomments);

    $id = $comment['comment_id'];
    $comment['comments'] = array_filter($ccoments, function($ccoment) use($id){
        return $ccomment['comment_id'] == $id;
    });
    return $comment;
}
?>
