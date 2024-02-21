<?php
session_start();
require_once(__DIR__ . '/../configuration/databaseconnect.php');
require_once(__DIR__ . '/../variables/functions.php');
require_once(__DIR__ . '/../variables/variables.php');


$errors = [];
$photo = [];

if (!empty($_POST)) {
  $errors = validerDonnee($_POST);
  $photo = verifPhoto($_FILES);
  if (empty($errors) && empty($photoErrors['errors'])) {
    $info = addIngredient($_POST, $mysqlClient, $photo["filePath"], $_GET['id']);

  }
}


sessionMAJ(getAllUsers($mysqlClient));
$userCourant = $_SESSION['LOGGED_USER'];

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
        <article>
          <form class="form contact-form" action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
              <label for="name" class="form-label">Nom de l'Ingrediant</label>
              <input type="text" name="name" id="name" class="form-input" required />
            </div>
            <div class="form-row">
              <label for="name" class="form-label">Origine</label>
              <input type="text" name="origine" id="origine" class="form-input" required />
            </div>
            <div class="form-row">
              <label for="name" class="form-label">Quantité</label>
              <input type="text" name="quantite" id="quantite" class="form-input" required />
            </div>
            <div class="form-row">
              <label for="screenshot" class="btn btn-outline-primary">
                Nouvelle photo
                <input type="file" name="screenshot" id="screenshot" class="account-settings-fileinput form-control">
              </label> &nbsp;
            </div>
            <div class="form-row">
              <label for="message" class="form-label">Description de l'Ingredient</label>
              <textarea name="message" id="message" class="form-textarea" required></textarea>
            </div>
            <button type="submit" class="btn btn-block btn-success">Submit</button>
          </form>
        </article>
    </main>
    <!-- footer -->
    <?php
    require_once(__DIR__ . '/../base/footer.php');
    ?>
  </section>
</body>

</html>