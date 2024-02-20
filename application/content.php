<!-- inclusion des variables et fonctions -->
<?php
require_once(__DIR__ . '/../variables/variables.php');
//require_once(__DIR__ . '/../variables/functions.php');
require_once(__DIR__ . '/../configuration/databaseconnect.php');

//var_dump($_SESSION['LOGGED_USER']);

//var_dump($_SESSION['LOGGED_USER']['user_id']);


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
        <?php foreach ($types as $type) : ?>
            <button class="tag" data-type="<?= htmlspecialchars($type['type']); ?>">
                <?= htmlspecialchars($type['type']); ?> (<?= $type['count']; ?>)
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script>
    $(document).ready(function() {
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
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
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
    });
</script>