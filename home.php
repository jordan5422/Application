<?php
session_start();
require_once(__DIR__ . '/configuration/mysql.php');
require_once(__DIR__ . '/configuration/databaseconnect.php');
require_once(__DIR__ . '/variables/variables.php');
require_once(__DIR__ . '/variables/functions.php');
//require_once(__DIR__ . '/application/isConnect.php');

var_dump($_SESSION);

$usersStatement = $mysqlClient->prepare('SELECT * FROM users');
$usersStatement->execute();
$users = $usersStatement->fetchAll();


$recetteImageStatement = $mysqlClient->prepare("SELECT r.nom AS nom_recette, r.type as type_recette, r.id AS id_recette, r.temps_preparation AS prep_recette, r.temps_cuisson AS cook_recette, i.nom AS nom_image, i.id AS id_image, i.lien AS lien_image
    FROM recette r
    INNER JOIN photo i ON r.id = i.id_recette
");
$recetteImageStatement->execute();
$recetteImages = $recetteImageStatement->fetchAll(PDO::FETCH_ASSOC);


// Requête pour récupérer les types de recettes et leur nombre associé
$typesStatement = $mysqlClient->query("SELECT type, COUNT(*) AS count FROM recette GROUP BY type");
$types = $typesStatement->fetchAll(PDO::FETCH_ASSOC);


?>
<!-- inclusion des variables et fonctions -->

<!DOCTYPE html>
<html>


<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact || Final</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="./final/assets/favicon.ico" type="image/x-icon" />
    <!-- normalize -->
    <link rel="stylesheet" href="./final/css/normalize.css" />
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <!-- main css -->
    <link rel="stylesheet" href="./final/css/main.css" />
    <script src="https://kit.fontawesome.com/b2ba396bc9.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="./static/login.css">
    <link rel="stylesheet" href="./final/css/style.css">
    <link rel="stylesheet" href="./final/css//specialbtn.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <section class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/base/header.php'); ?>
        <main class="page">
            <div class="main">
                <section class="recipes-container">
                    <!-- tag container -->
                    <div class="tags-container">
                        <h4>Types de recettes</h4>
                        <div class="tags-list">

                            <?php foreach ($types as $type) : ?>
                                <button class="tag" data-type="<?= htmlspecialchars($type['type']); ?>">
                                    <?= htmlspecialchars($type['type']); ?> (
                                    <?= $type['count']; ?>)
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- end of tag container -->
                    <!-- recipes list -->
                    <div class="recipes-list">
                        <?php require_once(__DIR__ . '/filtres_recettes.php'); ?>
                    </div>
                    <!-- end of recipes list -->
                </section>
            </div>
        </main>
    </section>
    <!-- inclusion du bas de page du site -->

    <?php require_once(__DIR__ . '/base/footer.php'); ?>


    <!-- inclusion du bas de page du site -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        $(document).ready(function() {
            // Fonction pour gérer le clic sur le bouton "like"
            function handleLikeButtonClick() {
                $('.like-btn').click(function() {
                    var recetteId = $(this).data('id');

                    $.ajax({
                        url: 'toggle_like.php', // Le script PHP qui gérera le "like"
                        type: 'POST',
                        data: {
                            'id_recette': recetteId,
                            'id_user': <?php echo $_SESSION['LOGGED_USER']['user_id']; ?> // Supposons que l'ID de l'utilisateur est stocké dans $_SESSION['user_id']
                        },
                        success: function(data) {
                            var result = JSON.parse(data);
                            $('.like-count[data-id="' + recetteId + '"]').text(result.newLikeCount); // Mise à jour du nombre de "likes"
                        }
                    });
                });
            }

            // Attachez l'événement click initial du bouton "like"
            handleLikeButtonClick();

            // Gérez le clic sur les boutons de filtre de recettes
            $('.tag').click(function() {
                var type = $(this).data('type'); // Récupère le type de recette sur lequel on a cliqué

                $.ajax({
                    url: 'filtres_recettes.php', // Nom du nouveau fichier PHP à créer pour le filtrage
                    type: 'GET',
                    data: {
                        'type': type
                    },
                    success: function(data) {
                        // Met à jour la liste des recettes avec les recettes filtrées retournées par le serveur
                        $('.recipes-list').html(data);

                        // Réattachez l'événement click du bouton "like" après le chargement dynamique du contenu des recettes
                        handleLikeButtonClick();
                    }
                });
            });
        });
    </script>

</body>

</html>