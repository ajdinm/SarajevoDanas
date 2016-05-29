<?php

    require './../lib/password.php';

    header('Content-type:application/json;charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    $id = $_GET['autor'];
    $limit = $_GET['x'];


    echo getNewsByID($id, $limit);

    function getNewsByID($id, $limit) {

        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
        $dbh = new PDO($dsn, DB_USER, DB_PASS);

        $query  = "select n.id id, n.title title, n.text text, a.id author_id, a.username author_username, n.isCommentable isCommentable, ";
        $query .= "n.picture picture, n.alt alt, n.text text, unix_timestamp(n.timestamp) ts ";
        $query .= "from news n, user a ";
        $query .= "where a.id = n.author_id ";
        $query .= "and a.id = :id";

        $rez = $dbh->prepare($query);
        $rez->bindParam(':id', $id);
        $rez->execute();
        $data = $rez->fetchAll(PDO::FETCH_ASSOC);

        $toReturn = array_map(function ($el) {

                $item = array();
                $item['id'] = $el['id'];
                $item['text'] = $el['text'];
                $item['timestamp'] = $el['ts'];
                $item['img'] = array();
                $item['img']['src'] = $el['picture'];
                $item['img']['alt'] = $el['alt'];
                $item['title'] = $el['title'];
                $item['isCommentable'] = $el['isCommentable'];
                $item['author'] = array();
                $item['author']['id'] = $el['author_id'];
                $item['author']['username'] = $el['author_username'];
                $item['comments'] = getNewsCommentsByID((int)$el['id']);
                return $item;
        }, $data);

        return json_encode(array_slice($toReturn, 0, $limit));
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

        foreach ($data as $comment) {
            $comment['comments'] = array();
            foreach($ccomments as $ccomment) {
                if($ccomment['comment_id'] == $comment['id']) {
                    array_push($comment['comments'], $ccomment);
                }
            }
            array_push($toReturn, $comment);
        }
        return $toReturn;
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
