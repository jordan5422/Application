<!-- inclusion des variables et fonctions -->
<?php
require_once(__DIR__ . '/../variables/variables.php');
require_once(__DIR__ . '/../variables/functions.php');
require_once(__DIR__ . '/../configuration/databaseconnect.php');



?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b2ba396bc9.js" crossorigin="anonymous"></script>
    <!-- favicon -->
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon" />
    <!-- normalize -->
    <link rel="stylesheet" href="../final/css/normalize.css" />
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <!-- main css -->
    <link rel="stylesheet" href="../final/css/main.css" />
</head>

<main class="page">
    <!-- header -->
    <header class="hero">
        <div class="hero-container">
            <div class="hero-text">
                <h1>Recettes simples</h1>
                <h4>Pas de fioritures, juste des recettes</h4>
            </div>
        </div>
    </header>
    <!-- end of header -->
    <section class="recipes-container">
        <!-- tag container -->
        <div class="tags-container">
            <h4>Types de recettes</h4>
            <div class="tags-list">
                <?php
                foreach ($types as $type) {
                    echo '<p ' . urlencode($type['type']) . '">' . $type['type'] . ' (' . $type['count'] . ')</p>';

                }
                ?>
            </div>
        </div>
        <!-- end of tag container -->
        <!-- recipes list -->
        <div class="recipes-list">
            <?php
            // Boucle à travers les recettes récupérées de la base de données
            foreach ($recetteImages as $recetteImage) {
                echo '<a href="content_unique.php?id=' . $recetteImage['id_recette'] . '" class="recipe">';
                echo '<img src="../' . $recetteImage['lien_image'] . '/' . $recetteImage['nom_recette'] . '.jpeg" class="img recipe-img" alt="' . $recetteImage['nom_recette'] . '" />';
                echo '<h5>' . $recetteImage['nom_recette'] . '</h5>';
                echo '<p>Prep: ' . $recetteImage['prep_recette'] . ' min | Cook: ' . $recetteImage['cook_recette'] . ' min</p>';
                echo '</a>';
            }
            ?>
        </div>
        <!-- end of recipes list -->
    </section>
</main>
