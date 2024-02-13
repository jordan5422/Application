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
                <h1>simply recipes</h1>
                <h4>no fluff, just recipes</h4>
            </div>
        </div>
    </header>
    <!-- end of header -->
    <section class="recipes-container">
        <!-- tag container -->
        <div class="tags-container">
            <h4>recipes</h4>
            <div class="tags-list">
                <a href="tag-template.html">Beef (1)</a>
                <a href="tag-template.html">Breakfast (2)</a>
                <a href="tag-template.html">Carrots (3)</a>
                <a href="tag-template.html">Food (4)</a>
            </div>
        </div>
        <!-- end of tag container -->
        <!-- recipes list -->
        <div class="recipes-list">
            <!-- Boucle foreach pour afficher les images dynamiquement -->
            <?php foreach ($images as $item) : ?>
                <a href="recipe.php?id=<?= $item['id_image'] ?>" class="recipe">
                    <img src="<?= "../static/images/" . $item['nom_image'] ?>" class="img recipe-img" alt="<?= $item['nom_image'] ?>">
                    <h5><?= $item['nom_recette'] ?></h5>
                    <p>Prep : 15min | Cook : 5min</p>
                </a>
            <?php endforeach; ?>
            <!-- Fin de la boucle foreach -->
        </div>
        <!-- end of recipes list -->

    </section>
</main>