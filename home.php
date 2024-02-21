<?php
session_start();
require_once(__DIR__ . '/configuration/mysql.php');
require_once(__DIR__ . '/configuration/databaseconnect.php');
require_once(__DIR__ . '/variables/variables.php');
require_once(__DIR__ . '/variables/functions.php');
//require_once(__DIR__ . '/application/isConnect.php');


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

<?php require_once(__DIR__ . '/base/link.php'); ?>


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
    <script>
        $(document).ready(function () {
            $('.like-btn').click(function () {
                console.log("je suis la");
                var recetteId = $(this).data('id');

                $.ajax({
                    url: '/application/toggle_like.php', // Le script PHP qui gérera le "like"
                    type: 'POST',
                    dataType: 'json', // Ajoutez cette ligne pour s'assurer que la réponse est traitée comme du JSON
                    data: {
                        'id_recette': recetteId,
                        'id_user': <?php echo $_SESSION['LOGGED_USER']['id']; ?> // Supposons que l'ID de l'utilisateur est stocké dans $_SESSION['user_id']
                    },
                    success: function (result) { // La réponse est automatiquement parsée en tant qu'objet JSON
                        console.log("je suis la dans toogle");
                        $('.like-count[data-id="' + recetteId + '"]').text(result.newLikeCount); // Mise à jour du nombre de "likes"
                    }
                });
            });
        });
    </script>

</body>

</html>