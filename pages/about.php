<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SarajevoDanas</title>

        <link rel="shortcut icon" type="image/png" href="./../images/favicon.png"/>

        <link rel="stylesheet" type="text/css" href="./../styles/header.css">
        <link rel="stylesheet" type="text/css" href="./../styles/about.css">
        <link rel="stylesheet" type="text/css" href="./../styles/logo-scaled.css">
    </head>

    <body>

        <?php include('./../scripts/session.php') ?>

            <table class="index-header" id="header">
            <tr>
                <td>
                    <h1>SarajevoDanas - saznaj šta se dešava u tvom gradu!</h1>
                </td>
                <td id="logo-cell">
                    <div class="logo-scaled-wrapper" id="index-logo">
                        <div class="logo-scaled-line-top"></div>
                        <div class="logo-scaled-base"></div>
                        <div class="logo-scaled-line-bot"></div>
                        <div class="logo-scaled-line-behind"></div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="navbar">
            <table>
                <tr>
                    <td>
                        <a href="./../index.php">
                            Naslovnica
                        </a>
                    </td>
                    <td>
                        <a href="./../pages/stat.php">
                            Statistika
                        </a>
                    </td>
                    <td class="active">
                        O nama
                    </td>
                    <td>
                        <a href="./../pages/contact.php">
                            Kontakt
                        </a>
                    </td>
                    <td>
                        <a href="./../pages/login.php">
                            Login
                        </a>
                    </td>
                    <td>
                        <a href="./../pages/admin.php">
                            Admin panel
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <div id="admin-text">
            <?php
                echo $okMsg;
                echo $logoutButton;
            ?>
        </div>
        <div>
            <ul>
                <li>
                    <a href="https://www.github.com" target="_blank">Github</a>
                </li>
                <li>
                    <a href="http://www.w3schools.com" target="_blank">W3Schools</a>
                </li>
                <li>
                    <a href="https://www.youtube.com" target="_blank">Youtube</a>
                </li>
            </ul>
        </div>

</html>
