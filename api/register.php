<?php

    require './../lib/password.php';

    header('Content-type:application/json;charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    $user = $_GET['user'];
    $pass = $_GET['pass'];
    $name = $_GET['name'];
    $surname = $_GET['surname'];
    $role_id = (int)$_GET['role_id'];

    echo addUser($user, $pass, $name, $surname, $role_id);


    function addUser($username, $password, $name, $surname, $role_id) {

        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
        $dbh = new PDO($dsn, DB_USER, DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query  = "insert into user ";
        $query .= "(username, password, name, surname, role_id) ";
        $query .= "values ";
        $query .= "(:username, :password, :name, :surname, :role_id)";


        $options = [
            'cost' => 11,
        ];
        $password = password_hash($password, PASSWORD_BCRYPT, $options);

        $rez = $dbh->prepare($query);
        $rez->bindParam(':username', $username);
        $rez->bindParam(':password', $password);
        $rez->bindParam(':name', $name);
        $rez->bindParam(':surname', $surname);
        $rez->bindParam(':role_id', $role_id);

        $toReturn = array();
        try{
            $rez->execute();
            $toReturn['success'] = 'true';
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            $toReturn['success'] = 'false';
        }
        return json_encode($toReturn);
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
