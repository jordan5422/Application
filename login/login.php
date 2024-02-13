<?php
session_start();
require_once(__DIR__ . '/../configuration/databaseconnect.php');
require_once(__DIR__ . '/../variables/variables.php');
require_once(__DIR__ . '/../variables/functions.php');
?>
<!--
   Si utilisateur/trice est non identifié(e), on affiche le formulaire
-->

<!-- inclusion des variables et fonctions -->


<!DOCTYPE html>
<html>
<?php
require_once(__DIR__ . '/../base/link.php');
?>

<body>
    <section class="container ">

        <?php
        require_once(__DIR__ . '/../base/header.php');
        ?>
        <main class="page">
            <div class="main">
                <br>
                <br>
                <br>
                <div class="content row">
                    <div class="col-8">
                        <h1>Les meilleurs recettes <br><span>chez nous !</span></h1>
                        <p class="par">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt neque
                            expedita atque eveniet <br> quis nesciunt. Quos nulla vero consequuntur, fugit nemo ad delectus
                            <br> a quae totam ipsa illum minus laudantium?
                        </p>
                    </div>

                    <div class="col form-4">
                        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
                            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                                <div class="card-body">
                                    <form action="submit_login.php" method="post">
                                        <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $_SESSION['LOGIN_ERROR_MESSAGE'];
                                                unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?>
                                            </div>
                                        <?php endif; ?>
                                        <h2>Login Here</h2>
                                        <br>
                                        <input type="email" class="form-control" name="email" placeholder="Enter Email Here">
                                        <p></p>
                                        <input type="password" name="password" class="form-control" placeholder="Enter Password Here">
                                        <button type="submit" class="btnn">Login</button>

                                        <p class="link">Don't have an account<br>
                                            <a href="../application/signup.php">Sign up </a> here</a>
                                        </p>
                                        <p class="liw">Log in with</p>

                                        <div class="icons">
                                            <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                                            <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                                            <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                                            <a href="#"><ion-icon name="logo-google"></ion-icon></a>
                                            <a href="#"><ion-icon name="logo-skype"></ion-icon></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="alert alert-success" role="alert">
                                Bonjour <?php echo $_SESSION['LOGGED_USER']['email']; ?> et bienvenue sur le site !
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </section>
    <?php
    require_once(__DIR__ . '/../base/footer.php');
    ?>
</body>

</html>