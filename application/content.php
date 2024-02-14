<!-- inclusion des variables et fonctions -->
<?php
require_once(__DIR__ . '/../variables/variables.php');
require_once(__DIR__ . '/../variables/functions.php');
require_once(__DIR__ . '/../configuration/databaseconnect.php');



?>
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
                echo '<a href="application/content_unique.php?id=' . $recetteImage['id_recette'] . '" class="recipe">';
                echo '<img src="../' . $recetteImage['lien_image'] . '/' . $recetteImage['nom_recette'] . '.jpeg" class="img recipe-img" alt="' . $recetteImage['nom_recette'] . '" />';
                echo '<h5>' . $recetteImage['nom_recette'] . '</h5>';
                echo '<p>Prep: ' . $recetteImage['prep_recette'] . ' min | Cook: ' . $recetteImage['cook_recette'] . ' min</p>';
                echo '</a>';
            }
            ?>
        </div>
        <!-- end of recipes list -->
    </section>
