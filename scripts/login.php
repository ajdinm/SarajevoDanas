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

        $service_url  = 'http://sdbanas-majdin.rhcloud.com/api/login.php';
        $service_url .= '?user=' . $username . '&pass=' . $password;
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

        $login_data = file("./../data/users.csv");


        if($decoded['success'] == 'true') {
                $_SESSION['login'] = true;
                $_SESSION['role'] = $decoded['role'];
                $_SESSION['username'] = $decoded['username'];
                $_SESSION['userID'] = $decoded['id'];
                setOKmsg();
                $isOK = true;
        }
        else {
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
        $okMsg = 'Dobro dosao, ' . $_SESSION['username'] . '!';
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
