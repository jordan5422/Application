<?php
session_start();
require_once(__DIR__ . '/../variables/variables.php');
require_once(__DIR__ . '/../variables/functions.php');
require_once(__DIR__ . '/../configuration/databaseconnect.php');


// Récupérer l'identifiant unique de la recette depuis $_GET
if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'] - 1;
    //var_dump($recipe_id);

    // Utilisez $recipe_id pour récupérer les détails de la recette depuis la base de données et affichez-les
}


if ($recipe_id != 0) {
    $textsql = $mysqlClient->prepare("SELECT r.id AS id_recette,r.type AS type_recette, r.nom AS nom_recette, r.temps_preparation AS prep_recette, r.temps_cuisson AS cook_recette, r.instruction_cuisson AS cook_instruction, i.id AS id_ingredient, i.nom AS nom_ingredient, i.origine AS origine_ingredient, i.quantite AS quantite_ingredient FROM recette r INNER JOIN ingredients i ON r.id = i.id_recette WHERE r.id=:idd");
    $textsql->bindParam(":idd", $recipe_id);
    $textsql->execute();
    $result = $textsql->fetchAll(PDO::FETCH_ASSOC);

    $commentaires = $mysqlClient->prepare("SELECT c.id AS id_commentaire, c.commentaire, c.heure, c.date, u.nom AS nom_utilisateur
    FROM recette r
    INNER JOIN commentaires c ON r.id = c.id_recette
    INNER JOIN users u ON c.id_users = u.id
    WHERE r.id = :idd");
    $commentaires->bindParam(":idd", $recipe_id);
    $commentaires->execute();
    $commentaire = $commentaires->fetchAll(PDO::FETCH_ASSOC);
} else {
    $recipe_id =  $recipe_id + 1;
    $textsql = $mysqlClient->prepare("SELECT r.id AS id_recette,r.type AS type_recette, r.nom AS nom_recette, r.temps_preparation AS prep_recette, r.temps_cuisson AS cook_recette, r.instruction_cuisson AS cook_instruction, i.id AS id_ingredient, i.nom AS nom_ingredient, i.origine AS origine_ingredient, i.quantite AS quantite_ingredient FROM recette r INNER JOIN ingredients i ON r.id = i.id_recette WHERE r.id=:idd");
    $textsql->bindParam(":idd", $recipe_id);
    $textsql->execute();
    $result = $textsql->fetchAll(PDO::FETCH_ASSOC);

    $commentaires = $mysqlClient->prepare("SELECT c.id AS id_commentaire, c.commentaire, c.heure, c.date, u.nom AS nom_utilisateur
    FROM recette r
    INNER JOIN commentaires c ON r.id = c.id_recette
    INNER JOIN users u ON c.id_users = u.id
    WHERE r.id = :idd");
    $commentaires->bindParam(":idd", $recipe_id);
    $commentaires->execute();
    $commentaire = $commentaires->fetchAll(PDO::FETCH_ASSOC);
}


//Test d'affichage 
//var_dump($_SESSION);

//var_dump($result);

//var_dump($recetteImages);




?>

<!DOCTYPE html>
<html>

<?php
require_once(__DIR__ . '/../base/link.php');
?>

<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/../base/header.php'); ?>
        <main class="page">
            <div class="recipe-page">
                <section class="recipe-hero">
                    <?php
                    echo '<img src="../' . $recetteImages[$recipe_id]['lien_image'] . '/' . $recetteImages[$recipe_id]['nom_recette'] . '.jpeg" class="img recipe-hero-img" alt="' . $recetteImages[$recipe_id]['nom_recette'] . '" />'; ?>
                    <article class="recipe-info">
                        <?php echo '<h2>' . $result[0]['nom_recette'] . '</h2>'; ?>
                        <p> Cette recette est de type : <?php echo '<span>' . $result[0]['type_recette'] . '</span>'; ?>
                            Shabby chic humblebrag banh mi bushwick, banjo kale chips
                            meggings. Cred selfies sartorial, cloud bread disrupt blue bottle
                            seitan. Dreamcatcher tousled bitters, health goth vegan venmo
                            whatever street art lyft shabby chic pitchfork beard. Drinking
                            vinegar poke tbh, iPhone coloring book polaroid truffaut tousled
                            ramps pug trust fund letterpress. Portland four loko austin
                            chicharrones bitters single-origin coffee. Leggings letterpress
                            occupy pour-over.
                        </p>
                        <div class="recipe-icons">
                            <article>
                                <i class="fas fa-clock"></i>
                                <h5>Prep time</h5>
                                <?php echo '<p>' . $result[0]['prep_recette'] . ' min </p>'; ?>
                            </article>
                            <article>
                                <i class="far fa-clock"></i>
                                <h5>cook time</h5>
                                <?php echo '<p>' . $result[0]['cook_recette'] . ' min </p>'; ?>
                            </article>
                        </div>
                    </article>
                </section>
                <!-- content -->
                <section class="recipe-content">
                    <article>
                        <h4>instructions</h4>
                        <!-- single instruction -->
                        <div class="single-instruction">
                            <?php echo '<p>' . $result[0]['cook_instruction'] . '</p>'; ?>
                        </div>
                        <div>
                            <!-- je veux affciher les commentaires ici -->
                            <h4>Commentaires</h4>
                            <?php foreach ($commentaire as $comment) : ?>
                                <p class="single-ingredient"><?php echo $comment['commentaire'] . ' A ' . $comment['heure'] . ' le ' . $comment['date'] . ' par ' .  $comment['nom_utilisateur']; ?></p>
                            <?php endforeach; ?>
                            <h4>Ajouter un commentaire !</h4>
                            <form id="comment-form" action="ajout_commentaire.php" method="POST">
                                <div class="form-group">
                                    <label for="comment">Commentaire:</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </form>
                        </div>
                    </article>
                    <article class="second-column">
                        <div>
                            <h4>Ingredients</h4>
                            <?php foreach ($result as $row) : ?>
                                <p class="single-ingredient"><?php echo $row['quantite_ingredient'] . ' ' . $row['nom_ingredient']; ?></p>
                            <?php endforeach; ?>
                        </div>
                    </article>

                </section>
            </div>
        </main>


        <!-- inclusion du bas de page du site -->
        <?php require_once(__DIR__ . '/../base/footer.php'); ?>
    </div>
</body>

</html>