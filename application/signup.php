<?php
session_start();
require_once(__DIR__ . '/../base/link.php');
require_once(__DIR__ . '/../variables/variables.php');
require_once(__DIR__ . '/../variables/functions.php');
$errors = [];

if (!empty($_POST)) {
    $isPresent = false;
    $errors = validerInscription($_POST);
    if ((int)$_POST['captcha'] === $_SESSION['captcha']) {
        if (empty($errors)) {
            foreach ($users as $user) {
                if ($user['mail'] === $_POST['email']) {
                    $isPresent = true;
                    break;
                }
            }
            if (!$isPresent) {
                addUser($_POST);
                redirectToUrl('../../login/login.php');
            } else {
                redirectToUrl('../signup.php');
            }
        }
    }
}

$num1 = rand(1, 10);
$num2 = rand(1, 10);
$_SESSION['captcha'] = $num1 + $num2;

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
        <main class="page ">
            <section class="">
                <article class="inscription">
                    <form class="form contact-form" method="post" action="">
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
                        <div class="form-row justify-content-center">
                            <?php
                            echo "Combien font $num1 + $num2 ? <br>";
                            echo '<input type="text" id="message" name="captcha" class="form-input">';
                            if (!empty($errors)) {
                                foreach ($errors as $error) {
                                    echo '<span style="color: red;">' . htmlspecialchars($error) . '</span><br>';
                                }
                            }
                            ?>
                        </div>
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