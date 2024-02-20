<?php

//require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/configuration/mysql.php');
require_once(__DIR__ . '/configuration/databaseconnect.php');
//require_once(__DIR__ .'/submitIngredient.php');


//require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/configuration/mysql.php');
require_once(__DIR__ . '/configuration/databaseconnect.php');
require_once(__DIR__ . '/variables/functions.php');


if (!empty($_POST)) {


  //recupere données du formulaire

  $name = $_POST['name'];
  $nbr = $_POST['nbr'];
  $type = $_POST['type'];
  $temps_prep = $_POST['temps_preparation'];
  $temps_cuis = $_POST['temps_cuisson'];
  $description = $_POST['description'];
  $instruction = $_POST['instruction_cuisson'];

  // Traitement de l'image
  $target_dir = "uploads/"; // Assurez-vous que ce dossier existe et est accessible en écriture
  $target_file = $target_dir . basename($_FILES["photo"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Vérifiez si le fichier est une image réelle
  //if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["photo"]["tmp_name"]);
  if ($check !== false) {
    echo "Le fichier est une image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "Le fichier n'est pas une image.";
    $uploadOk = 0;
  }
  //}

  $id = 1;
  //ajout dans BD
  if ($uploadOk == 1) {
    $sql = "INSERT INTO recette (nom, type, nombre_plats, temps_preparation, temps_Cuisson, photo, description, instruction_cuisson,id_users) VALUES (?, ?,?, ?, ?, ?, ?, ?,?)";
    $stmt = $mysqlClient->prepare($sql);

    try {
      $stmt->execute([$name, $nbr, $type, $temps_prep, $temps_cuis, $target_file, $description, $instruction, $id]);
      echo "Recette ajoutée avec succès.";
    } catch (PDOException $e) {
      echo "Erreur lors de l'insertion des données: " . $e->getMessage();
    }
  } else {
    echo "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
    $uploadOk = 0; // Marquer le téléchargement comme échoué
  }


  echo "Ingrédient ajouté avec succès dans la bd";

  // Déplacez le fichier téléchargé vers le nouveau chemin
  if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    echo "Le fichier " . htmlspecialchars(basename($_FILES["photo"]["name"])) . " a été téléchargé.";

    // Utilisation de lastInsertId pour obtenir l'ID de la dernière insertion
    $recipeId = $mysqlClient->lastInsertId();

    // Redirection vers l'autre page en incluant l'ID dans l'URL
    // header('Location: ../AjoutIngredient.php?id=' . $recipeId);
    exit();
  } else {
    echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
  }
}




?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact || Final</title>
  <!-- favicon -->
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon" />
  <!-- normalize -->
  <link rel="stylesheet" href="../css/normalize.css" />
  <!-- font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
  <!-- main css -->
  <link rel="stylesheet" href="../css/main.css" />
</head>

<body>
  <!-- nav  -->
  <nav class="navbar">
    <div class="nav-center">
      <div class="nav-header">
        <a href="index.html" class="nav-logo">
          <img src="../assets/logo.svg" alt="simply recipes" />
        </a>
        <button class="nav-btn btn">
          <i class="fas fa-align-justify"></i>
        </button>
      </div>
      <div class="nav-links">
        <a href="index.html" class="nav-link"> home </a>
        <a href="about.html" class="nav-link"> about </a>
        <a href="tags.html" class="nav-link"> tags </a>
        <a href="recipes.html" class="nav-link"> recipes </a>

        <div class="nav-link contact-link">
          <a href="contact.html" class="btn"> contact </a>
        </div>
      </div>
    </div>
  </nav>
  <!-- end of nav -->
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
      <a href="http://localhost/ProjetWeb/AjoutIngredient.php ?id=<?php $recipeId ?>" class="btn">Ajout Ingredient</a>
    </section>
    <!-- featured recipes -->
    <section class="featured-recipes">
      <h5 class="featured-title">Look At This Awesomesouce!</h5>
      <div class="recipes-list">
        <!-- single recipe -->
        <a href="single-recipe.html" class="recipe">
          <img src="../assets/recipes/recipe-1.jpeg" class="img recipe-img" alt="" />
          <h5>Carne Asada</h5>
          <p>Prep : 15min | Cook : 5min</p>
        </a>
        <!-- end of single recipe -->
        <!-- single recipe -->
        <a href="single-recipe.html" class="recipe">
          <img src="../assets/recipes/recipe-2.jpeg" class="img recipe-img" alt="" />
          <h5>Greek Ribs</h5>
          <p>Prep : 15min | Cook : 5min</p>
        </a>
        <!-- end of single recipe -->
        <!-- single recipe -->
        <a href="single-recipe.html" class="recipe">
          <img src="../assets/recipes/recipe-3.jpeg" class="img recipe-img" alt="" />
          <h5>Vegetable Soup</h5>
          <p>Prep : 15min | Cook : 5min</p>
        </a>
        <!-- end of single recipe -->
      </div>
    </section>
  </main>
  <!-- footer -->
  <footer class="page-footer">
    <p>
      &copy; <span id="date"></span>
      <span class="footer-logo">SimplyRecipes</span> Built by
      <a href="https://www.johnsmilga.com/">Coding Addict</a>
    </p>
  </footer>
  <script src="../js/app.js"></script>
</body>

</html>