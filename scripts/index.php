<?php
    session_start();
    if(isset($_SESSION['login']) && $_SESSION['login'] == true) {
        setOKmsg();
    }

    // create news html :(

    function getIndexLogoutButton() {
        $toReturn  = '';
        $toReturn .= '<form action="./pages/login.php" method="get">';
        $toReturn .= '<button type="submit" name="logout" value="true">Logout</button>';
        $toReturn .= '</form>';
        return $toReturn;
    }
    function setOKmsg() {
        global $okMsg, $nokMsg, $logoutButton;
        $okMsg = 'Dobro dosao, Admine!';
        $nokMsg = '';
        $logoutButton = getIndexLogoutButton();
    }
    function setNOKmsg() {
        global $okMsg, $nokMsg, $logoutButton;
        $okMsg = '';
        $nokMsg = 'Pogresni podaci, pokusaj ponovo.';
        $logoutButton = '';
    }
?>
