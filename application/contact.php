<?php
session_start();
require_once(__DIR__ . '/../configuration/databaseconnect.php');
require_once(__DIR__ . '/../variables/variables.php');
require_once(__DIR__ . '/../variables/functions.php');
?>



<!DOCTYPE html>
<html lang="fr">

<?php
require_once(__DIR__ . '/../base/link.php');
?>


<body>
    <!-- nav  -->
    <section class="container">
        <?php
        require_once(__DIR__ . '/../base/header.php');
        ?>

        <!-- end of nav -->
        <main class="page">
            <section class="contact-container">
                <article class="contact-info">
                    <h3>Want To Get In Touch?</h3>
                    <p>
                        Four dollar toast biodiesel plaid salvia actually pickled banjo
                        bespoke mlkshk intelligentsia edison bulb synth.
                    </p>
                    <p>Cardigan prism bicycle rights put a bird on it deep v.</p>
                    <p>
                        Hashtag swag health goth air plant, raclette listicle fingerstache
                        cold-pressed fanny pack bicycle rights cardigan poke.
                    </p>
                </article>
                <article>
                    <form class="form contact-form">
                        <div class="form-row">
                            <label html="name" class="form-label">your name</label>
                            <input type="text" name="name" id="name" class="form-input" />
                        </div>
                        <div class="form-row">
                            <label html="email" class="form-label">your email</label>
                            <input type="text" name="email" id="email" class="form-input" />
                        </div>
                        <div class="form-row">
                            <label html="message" class="form-label">message</label>
                            <textarea name="message" id="message" class="form-textarea"></textarea>
                        </div>
                        <button type="submit" class="btn btn-block">
                            submit
                        </button>
                    </form>
                </article>
            </section>
            <!-- featured recipes -->
            <section class="featured-recipes">
                <h5 class="featured-title">Look At This Awesomesouce!</h5>
                <div class="recipes-list">
                    <!-- single recipe -->
                    <a href="single-recipe.html" class="recipe">
                        <img src="../final/assets/recipes/recipe-1.jpeg" class="img recipe-img" alt="" />
                        <h5>Carne Asada</h5>
                        <p>Prep : 15min | Cook : 5min</p>
                    </a>
                    <!-- end of single recipe -->
                    <!-- single recipe -->
                    <a href="single-recipe.html" class="recipe">
                        <img src="../final/assets/recipes/recipe-2.jpeg" class="img recipe-img" alt="" />
                        <h5>Greek Ribs</h5>
                        <p>Prep : 15min | Cook : 5min</p>
                    </a>
                    <!-- end of single recipe -->
                    <!-- single recipe -->
                    <a href="single-recipe.html" class="recipe">
                        <img src="../final/assets/recipes/recipe-3.jpeg" class="img recipe-img" alt="" />
                        <h5>Vegetable Soup</h5>
                        <p>Prep : 15min | Cook : 5min</p>
                    </a>
                    <!-- end of single recipe -->
                </div>
            </section>
        </main>
        <!-- footer -->
        <?php
        require_once(__DIR__ . '/../base/footer.php');
        ?>
    </section>
</body>

</html>