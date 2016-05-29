<?php

    require './../lib/password.php';

    header('Content-type:application/json;charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    $user = $_GET['user'];
    $pass = $_GET['pass'];

    echo checkLogin($user, $pass);

    function checkLogin($username, $password) {

        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
        $dbh = new PDO($dsn, DB_USER, DB_PASS);

        $query  = "select u.id id, u.username username, r.name role, u.password password ";
        $query .= "from user u, role r ";
        $query .= "where u.username = :username ";
        $query .= "and u.role_id = r.id";

        $rez = $dbh->prepare($query);
        $rez->bindParam(':username', $username);
        $rez->execute();
        $data = $rez->fetchAll(PDO::FETCH_ASSOC);

        $toReturn = array();
        $toReturn['success'] = 'false';


        if(count($data) != 1) {
            return json_encode($toReturn);
        }
        $data = $data[0];
        if(!password_verify($password, $data['password'])) {
            return json_encode($toReturn);
        }
        $toReturn['success'] = 'true';
        $toReturn['role'] = $data['role'];
        $toReturn['id'] = $data['id'];
        $toReturn['username'] = $data['username'];
        $toReturn['unReadNews'] = getUnreadNews($toReturn['id']);
        $toReturn['readNews'] = getReadNews($toReturn['id']);
        return json_encode($toReturn);
}

function getUnreadNews($author_id) {

        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
        $dbh = new PDO($dsn, DB_USER, DB_PASS);

        $query  = "select n.id id, n.title title, count(*) count ";
        $query .= "from news n, news_comment nc ";
        $query .= "where nc.news_id = n.id ";
        $query .= "and nc.isRead = 0 ";
        $query .= "and n.author_id = :author_id ";
        $query .= "group by n.id, n.title";



        $rez = $dbh->prepare($query);
        $rez->bindParam(':author_id', $author_id);
        $rez->execute();
        $data = $rez->fetchAll(PDO::FETCH_ASSOC);

        return $data;
}

function getReadNews($author_id) {

        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
        $dbh = new PDO($dsn, DB_USER, DB_PASS);


        $query  = "select n.id id, n.title title ";
        $query .= "from news n, user a ";
        $query .= "where not exists ";
        $query .= "(select * from news_comment nc where nc.news_id = n.id and nc.isRead = 0) ";
        $query .= "and a.id = :author_id";

        $rez = $dbh->prepare($query);
        $rez->bindParam(':author_id', $author_id);
        $rez->execute();
        $data = $rez->fetchAll(PDO::FETCH_ASSOC);

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


?>
