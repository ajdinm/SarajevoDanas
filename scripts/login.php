<?php
//    register_user('admin', 'a');
    require './../lib/password.php';
    session_start();
    $username = $password_hash = $error = '';
    $okMsg = '';
    $nokMsg = '';
    $logoutButton = '';
    if(isset($_GET['logout']) && isset($_SESSION['login'])) {
        unset($_SESSION['login']);
    }
    if(isset($_SESSION['login']) && $_SESSION['login'] == true) {
        setOKmsg();
    }
    if(isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $login_data = file("./../data/users.csv");


        $isOK = false;
        foreach($login_data as $user) {
            $temp = explode(',', $user);
                if($temp[0] == $username && password_verify($password, $temp[1])) {
                $_SESSION['login'] = true;
                setOKmsg();
                $isOK = true;
                break;
            }
        }
        if(! $isOK) {
            setNOKmsg();
        }
    }
    else {
//        echo 'nozz';
    }
    function debug_to_console( $data ) {
        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        echo $output;
    }

    function register_user($username, $password) {
        $options = [
            'cost' => 11,
        ];
        $hash = password_hash($password, PASSWORD_BCRYPT, $options);
        $user = $username.','.$hash;
        file_put_contents('./../data/users.csv', $user);
    }

    function getIndexLogoutButton() {
        $toReturn  = '';
        $toReturn .= '<form action="./pages/login.php" method="get">';
        $toReturn .= '<button type="submit" name="logout" value="true">Logout</button>';
        $toReturn .= '</form>';
        return $toReturn;
    }
    function getLogoutButton() {
        $toReturn  = '';
        $toReturn .= '<form action="login.php" method="get">';
        $toReturn .= '<button type="submit" name="logout" value="true">Logout</button>';
        $toReturn .= '</form>';
        return $toReturn;
    }
    function setOKmsg() {
        global $okMsg, $nokMsg, $logoutButton;
        $okMsg = 'Dobro dosao, Admine!';
        $nokMsg = '';
        $logoutButton = getLogoutButton();
    }
    function setNOKmsg() {
        global $okMsg, $nokMsg, $logoutButton;
        $okMsg = '';
        $nokMsg = 'Pogresni podaci, pokusaj ponovo.';
        $logoutButton = '';
    }
?>
