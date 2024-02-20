<?php
session_start();
require_once(__DIR__ . '../configuration/mysql.php');
require_once(__DIR__ . '../configuration/databaseconnect.php');
require_once(__DIR__ . '/variables/functions.php');
require_once(__DIR__ . '/variables/variables.php');

$errors = [];
$idRecette = addRecette($_POST, $mysqlClient, $_FILES)["id"];
$errors = addRecette($_POST, $mysqlClient, $_FILES)["erreur"];
?>
<!DOCTYPE html>
<html lang="fr">
<?php
require_once(__DIR__ . '/base/link.php');
?>

<body>
    <section class="container">
        <?php
        require_once(__DIR__ . '/base/header.php');
        ?>

        <main class="page">
            <section class="contact-container">
                <article>
                    <form class="form contact-form" action="" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <label for="name" class="form-label">Nom Recette</label>
                            <input type="text" name="name" id="name" class="form-input" required />
                        </div>
                        <div class="form-row">
                            <label for="name" class="form-label">Nombre de personne</label>
                            <input type="text" name="nbr" id="name" class="form-input" required />
                        </div>
                        <div class="form-row">
                            <label for="name" class="form-label">Type</label>
                            <input type="text" name="type" id="name" class="form-input" required />
                        </div>
                        <div class="form-row">
                            <label for="name" class="form-label">Temps de préparation</label>
                            <input type="text" name="temps_preparation" id="name" class="form-input" required />
                        </div>
                        <div class="form-row">
                            <label for="name" class="form-label">Temps de cuisson</label>
                            <input type="text" name="temps_cuisson" id="name" class="form-input" required />
                        </div>
                        <div class="form-row">
                            <label for="photo" for="photo" class="form-label">inserer une photo du plat :</label>
                            <input type="file" name="photo" id="photo" class="form-input " accept="image/*" required />
                        </div>
                        <div class="form-row">
                            <label for="message" class="form-label">Description de la Recette</label>
                            <textarea name="description" id="message" class="form-textarea" required></textarea>
                        </div>
                        <div class="form-row">
                            <label for="message" class="form-label">Instructions</label>
                            <textarea name="instruction_cuisson" id="message" class="form-textarea" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-block">
                            submit
                        </button>
                    </form>
                </article>
            </section>
            <!-- featured recipes -->
            
        </main>
        <!-- footer -->
        <?php
        require_once(__DIR__ . '/base/footer.php');
        ?>
    </section>
</body>


</html>