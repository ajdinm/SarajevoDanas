<?php

    require './../lib/password.php';

    header('Content-type:application/json;charset=utf-8');

    $id = $_GET['id'];

    echo getNewsByID($id);

    function getNewsByID($id) {

        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
        $dbh = new PDO($dsn, DB_USER, DB_PASS);

        $query  = "select n.id id, n.title title, n.text text, a.id author_id, a.username author_username ";
        $query .= "from news n, user a ";
        $query .= "where n.id = :id ";
        $query .= "and a.id = n.author_id";

        $rez = $dbh->prepare($query);
        $rez->bindParam(':id', $id);
        $rez->execute();
        $data = $rez->fetchAll(PDO::FETCH_ASSOC);

        if(count($data) != 1) {
            return json_encode(array());
        }

        $data = $data[0];

        $toReturn = array();
        $toReturn['id'] = $data['id'];
        $toReturn['title'] = $data['title'];
        $toReturn['author'] = array();
        $toReturn['author']['id'] = $data['author_id'];
        $toReturn['author']['username'] = $data['author_username'];
        $toReturn['comments'] = getNewsCommentsByID((int)$toReturn['id']);

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

        return $data;
}

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
