<!-- inclusion des variables et fonctions -->
<?php
require_once(__DIR__ . '/../variables/variables.php');
//require_once(__DIR__ . '/../variables/functions.php');
require_once(__DIR__ . '/../configuration/databaseconnect.php');

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
<!-- end of header -->
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
        <?php require_once(__DIR__ . '/filtres_recettes.php'); ?>
    </div>
    <!-- end of recipes list -->
</section>
<!-- JavaScript pour le filtre des recettes par type -->