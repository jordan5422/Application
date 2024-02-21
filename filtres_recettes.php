<?php
require_once(__DIR__ . '/configuration/mysql.php');
require_once(__DIR__ . '/configuration/databaseconnect.php');
require_once(__DIR__ . '/variables/variables.php');
require_once(__DIR__ . '/variables/functions.php');


$typeFilter = isset($_GET['type']) && $_GET['type'] ? $_GET['type'] : null;

// Si aucun type n'est spécifié, récupérez toutes les recettes.
if ($typeFilter === null) {
    $recetteImageStatement = $mysqlClient->query("SELECT r.nom AS nom_recette, r.type as type_recette, r.id AS id_recette, r.temps_preparation AS prep_recette, r.temps_cuisson AS cook_recette, i.nom AS nom_image, i.id AS id_image, i.lien AS lien_image FROM recette r INNER JOIN photo i ON r.id = i.id_recette");
} else {
    $recetteImageStatement = $mysqlClient->prepare("SELECT r.nom AS nom_recette, r.type as type_recette, r.id AS id_recette, r.temps_preparation AS prep_recette, r.temps_cuisson AS cook_recette, i.nom AS nom_image, i.id AS id_image, i.lien AS lien_image FROM recette r INNER JOIN photo i ON r.id = i.id_recette WHERE r.type = :type_recette");
    $recetteImageStatement->bindParam(':type_recette', $typeFilter);
}

$recetteImageStatement->execute();
$recetteImages = $recetteImageStatement->fetchAll(PDO::FETCH_ASSOC);


foreach ($recetteImages as $recetteImage) {
    // Générez ici le HTML pour les recettes filtrées, similaire à ce que vous avez déjà dans votre code PHP principal.
    // Par exemple :
    // Récupération du nombre de likes pour la recette
    $likesStatement = $mysqlClient->prepare('SELECT COUNT(*) FROM likes WHERE id_recette = ?');
    $likesStatement->execute([$recetteImage['id_recette']]);
    $likesCount = $likesStatement->fetchColumn();

    echo '<div class="" style="width: 18rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">';
    echo '<a href="/application/content_unique.php?id=' . $recetteImage['id_recette'] . '" class="recipe">';
    echo '<img src="./' . $recetteImage['lien_image'] . '/' . $recetteImage['nom_recette'] . '.jpeg" class="img recipe-img" alt="' . htmlspecialchars($recetteImage['nom_recette']) . '" />';
    echo '</a>';
    echo '</h5>';
    echo '<p class="card-text">';
    echo '<a href="/application/content_unique.php?id=' . $recetteImage['id_recette'] . '" class="recipe">';
    echo '<h5>' . htmlspecialchars($recetteImage['nom_recette']) . '</h5>';
    echo '</a>';
    echo '<p>Prep: ' . $recetteImage['prep_recette'] . ' min | Cook: ' . $recetteImage['cook_recette'] . ' min</p>';
    echo '</p>';
    echo '<div class="recipe">';
    echo '<button class="like-btn" data-id="' . $recetteImage['id_recette'] . '"> <ion-icon name="heart"></ion-icon></button>';
    echo '&nbsp;';
    echo '<span class="like-count" data-id="' . $recetteImage['id_recette'] . '">' . $likesCount . '</span>';
    echo '</div>';
    echo '</div>';
    echo '</div>';


}

