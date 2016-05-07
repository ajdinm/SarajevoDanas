 <!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SarajevoDanas</title>

        <link rel="shortcut icon" type="image/png" href="./../images/favicon.png"/>

        <link rel="stylesheet" type="text/css" href="./../styles/contact.css">
        <link rel="stylesheet" type="text/css" href="./../styles/header.css">
        <link rel="stylesheet" type="text/css" href="./../styles/logo-scaled.css">

        <script src="./../scripts/validation.js"></script>
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
        <div class="navbar" id="index-navbar">
            <table>
                <tr>
                    <td>
                        <a href="./../index.php">
                         Naslovnica
                     </td>
                    <td>
                        <a href="./../pages/stat.php">
                        Statistika
                    </td>
                    <td>
                        <a href="./../pages/about.php">
                        O nama
                    </td>
                    <td class="active">
                        <a>
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
        <div class="form-wrapper">
            <form>
                <table>
                    <tr>
                        <td>
                            <label for="name">Ime i prezime: </label>
                        </td>
                        <td>
                            <!-- validacija: ime mora biti sacinjeno od tacno dvije rijeci, i to da obja pocinju
                                             velikim slovom -->
                            <input onkeyup="return checkName(this)" id="name_field" class "input-validate" type="text" on id="name" name="name"required pattern="[A-Z][a-z]* [A-Z][a-z]*">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <!-- multiple validacija: ako je uneseno ime, ne mora mail -->
                            <label for="email">Email: </label>
                        </td>
                        <td>
                            <input onkeyup="return checkMail(this)" id="email_field" type="email" id="email" name="email" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="comment">Komentar: </label>
                        </td>
                        <td>
                            <textarea id="comment" name="comment" required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td class="button-cell">
                            <button type="button">Pošalji</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
