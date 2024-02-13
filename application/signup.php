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
        <main class="page ">
            <section class="">
                <article class="inscription">
                    <form class="form contact-form" method="post" action="submit/submit_signup.php">
                        <div class="form-row">
                            <label html="name" class="form-label">Votre nom</label>
                            <input type="text" name="nom" id="name" class="form-input" />
                        </div>
                        <div class="form-row">
                            <label html="email" class="form-label">Votre e-mail</label>
                            <input type="text" name="email" id="email" class="form-input" />
                        </div>
                        <div class="form-row">
                            <label html="Mot de passe" class="form-label">mot de passe</label>
                            <input type="password" id="message" name="password" class="form-input">
                        </div>
                        <div class="form-row">
                            <label html="Mot de passe" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" id="message" name="Cpassword" class="form-input">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-block">
                            Envoyer
                        </button>
                    </form>
                </article>
            </section>
            <!-- featured recipes -->

        </main>
        <!-- footer -->
        <?php
        require_once(__DIR__ . '/../base/footer.php');
        ?>
    </section>
</body>

</html>