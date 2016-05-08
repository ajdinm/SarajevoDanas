 <!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SarajevoDanas</title>

        <link rel="shortcut icon" type="image/png" href="./../images/favicon.png"/>

        <link rel="stylesheet" type="text/css" href="./../styles/login.css">
        <link rel="stylesheet" type="text/css" href="./../styles/header.css">
        <link rel="stylesheet" type="text/css" href="./../styles/logo-scaled.css">

        <script src="./../scripts/validation.js"></script>
    </head>

    <body>

        <?php include('./../scripts/login.php') ?>

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
        <div class="navbar" id="index-navbar">
            <table>
                <tr>
                    <td>
                        <a href="./../index.php">
                         Naslovnica
                     </td>
                    <td>
                        <a href="./../pages/stat.php"> Statistika
                    </td>
                    <td>
                        <a href="./../pages/about.php">
                        O nama
                    </td>
                    <td>
                        <a href="./../pages/contact.php">
                            Kontakt
                        </a>
                    </td>
                    <td class="active">
                        <a>
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
        <div class="form-wrapper">
            <form action="login.php" method="post">
                <table id="login-table">
                    <tr>
                        <td>
                            <label for="name">Username: </label>
                        </td>
                        <td>
                            <input id="username_field" type="text" name="username">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email">Password: </label>
                        </td>
                        <td>
                            <input id="password_field" type="password" name="password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td class="button-cell">
                            <button type="submit" name="login">Pošalji</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                                echo $nokMsg;
                            ?>
                        </td>
                    </tr>
                </table>

            </form>
        </div>
    </body>
</html>
