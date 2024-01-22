<!-- inclusion des variables et fonctions -->
<?php
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');
?>
<?php foreach (getRecipes($recipes) as $recipe) : ?>
    <article>
        <h3><a href="recipes_read.php?id=<?php echo ($recipe['recipe_id']); ?>"><?php echo ($recipe['title']); ?></a></h3>
        <div><?php echo $recipe['recipe']; ?></div>
        <i><?php echo displayAuthor($recipe['author'], $users); ?></i>
        <?php if (isset($_SESSION['LOGGED_USER']) && $recipe['author'] === $_SESSION['LOGGED_USER']['email']) : ?>
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item"><a class="link-warning" href="recipes_update.php?id=<?php echo ($recipe['recipe_id']); ?>">Editer l'article</a></li>
                <li class="list-group-item"><a class="link-danger" href="recipes_delete.php?id=<?php echo ($recipe['recipe_id']); ?>">Supprimer l'article</a></li>
            </ul>
        <?php endif; ?>
    </article>
<?php endforeach ?>