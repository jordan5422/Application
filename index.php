<?php
session_start();
require_once(__DIR__ . '/configuration/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');
?>
<!--
   Si utilisateur/trice est non identifié(e), on affiche le formulaire
-->

<!-- inclusion des variables et fonctions -->


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Site de recettes</h1>

        <!-- Formulaire de connexion -->
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
            <div class="form">
                <form action="submit_login.php" method="POST">
                    <!-- si message d'erreur on l'affiche -->
                    <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['LOGIN_ERROR_MESSAGE'];
                            unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?>
                        </div>
                    <?php endif; ?>
                    <h2>Login Here</h2>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com">
                    <div id="email-help" class="form-text">L'email utilisé lors de la création de compte.</div>

                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password">

                    <button type="submit" class="btn btn-primary btnn">Envoyer</button>
                    <p class="link">Don't have an account<br>
                        <a href="#">Sign up </a> here</a>
                    </p>
                    <p class="liw">Log in with</p>

                    <div class="icons">
                        <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                        <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                        <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                        <a href="#"><ion-icon name="logo-google"></ion-icon></a>
                        <a href="#"><ion-icon name="logo-skype"></ion-icon></a>
                    </div>
                </form>
            </div>

            <!-- Si utilisateur/trice bien connectée on affiche un message de succès -->
        <?php else : ?>
            <div class="alert alert-success" role="alert">
                Bonjour <?php echo $_SESSION['LOGGED_USER']['email']; ?> et bienvenue sur le site !
            </div>
        <?php endif; ?>
    </div>



    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>

    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js">
        (function(doc) {
            var scriptElm = doc.scripts[doc.scripts.length - 1];
            var warn = ['[ionicons] Deprecated script, please remove: ' + scriptElm.outerHTML];

            warn.push('To improve performance it is recommended to set the differential scripts in the head as follows:')

            var parts = scriptElm.src.split('/');
            parts.pop();
            parts.push('ionicons');
            var url = parts.join('/');

            var scriptElm = doc.createElement('script');
            scriptElm.setAttribute('type', 'module');
            scriptElm.src = url + '/ionicons.esm.js';
            warn.push(scriptElm.outerHTML);
            scriptElm.setAttribute('data-stencil-namespace', 'ionicons');
            doc.head.appendChild(scriptElm);


            scriptElm = doc.createElement('script');
            scriptElm.setAttribute('nomodule', '');
            scriptElm.src = url + '/ionicons.js';
            warn.push(scriptElm.outerHTML);
            scriptElm.setAttribute('data-stencil-namespace', 'ionicons');
            doc.head.appendChild(scriptElm)

            console.warn(warn.join('\n'));

        })(document);
    </script>
</body>

</html>