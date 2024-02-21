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

sessionMAJ(getAllUsers($mysqlClient));
$userCourant = $_SESSION['LOGGED_USER'];

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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
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

                            <?php foreach ($types as $type): ?>
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
                        <?php require_once(__DIR__ . '/application/filtres_recettes.php'); ?>
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


</body>

</html>