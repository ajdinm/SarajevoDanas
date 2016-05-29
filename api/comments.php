<?php

    require './../lib/password.php';

    header('Content-type:application/json;charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    $id = $_GET['id'];

    echo getUnreadCommentsByAuthorID($id);

    function getUnreadCommentsByAuthorID($id) {

        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
        $dbh = new PDO($dsn, DB_USER, DB_PASS);

        $query  = "select n.id id, n.title title, count(distinct n.id) count ";
        $query .= "from news n, news_comment nc ";
        $query .= "where nc.news_id = n.id ";
        $query .= "and nc.isRead = 0 ";
        $query .= "and n.author_id = :author_id ";
        $query .= "group by n.id, n.title";



        $rez = $dbh->prepare($query);
        $rez->bindParam(':author_id', $id);
        $rez->execute();
        $data = $rez->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($data);
    }

?>
