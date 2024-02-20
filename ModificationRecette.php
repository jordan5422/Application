

<?php

//require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '../configuration/mysql.php');
require_once(__DIR__ . '../configuration/databaseconnect.php');

$donnee=[];
$donnee['id']= 11;
$donnee['nom']= "giuy";
$donnee['origine']= "hbjghfg";
$donnee['quantite']= 56;
$donnee['photo']= "uploads/favorie.jpg";
$donnee['description']= "khjgf";
$donnee['id_recette']=5;

$uploadOk = 1;

if (!empty($_POST)) {
    //recupere données du formulaire
    //echo "je recupere mes donnees";
    $name = $_POST['name'];
    $nbr = $_POST['nbr'];
    $type = $_POST['type'];
    $temps_prep = $_POST['temps_preparation'];
    $temps_cuis = $_POST['temps_cuisson'];
    $description = $_POST['description'];
    $instruction = $_POST['instruction_cuisson'];

    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "uploads/"; // Assurez-vous que ce dossier existe et est accessible en écriture
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);

        // Vérifiez si le fichier est une image réelle
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            echo "Le fichier est une image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

    } else{
        $target_file = $donnee['photo'];
        $uploadOk = 1;
    }

    
        if ($uploadOk == 1) {
            $sql = "UPDATE ingredients SET nom = ?, type = ?, nombre_plats = ?, photo = ?,temps_preparation=?,temps_Cuisson=?,instruction_cuisson=?, description = ? WHERE id = ?";
            $stmt = $mysqlClient->prepare($sql);
    
            try {
                $stmt->execute([$name, $nbr, $type ,$temps_prep,$temps_cuis, $target_file, $instruction ,$description, $donnee['id']]);
                echo "Ingrédient modifié avec succès dans la bd";
            } catch (PDOException $e) {
                echo "Erreur lors de la modification  des données: " . $e->getMessage();
            }

            // Déplacez le fichier téléchargé vers le nouveau chemin
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                echo "Le fichier " . htmlspecialchars(basename($_FILES["photo"]["name"])) . " a été téléchargé.";
            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            }

        } else {
            echo "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
            $uploadOk = 0; // Marquer le téléchargement comme échoué
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
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
    />
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
            <form class="form contact-form" action="AjoutIngredient.php" method="post" enctype="multipart/form-data">
              <div class="form-row">
                <label for="name" class="form-label">Nom Recette</label>
                <input type="text" name="name" id="name" class="form-input" value="<?php echo $donnee['nom'] ?>" required />
              </div>
              <div class="form-row">
                <label for="name" class="form-label">Nombre de personne</label>
                <input type="text" name="nbr" id="name" class="form-input" value="<?php echo $donnee['Nombre_plats'] ?>" required/>
              </div>
              <div class="form-row">
                <label for="name" class="form-label">type</label>
                <input type="text" name="type" id="name" class="form-input" value="<?php echo $donnee['type'] ?>" required/>
              </div>
              <div class="form-row">
                <label for="name" class="form-label">Temps de préparation</label>
                <input type="text" name="temps_prep" id="name" class="form-input" value="<?php echo $donnee['temps_preparation'] ?>" required/>
              </div>
              <div class="form-row">
                <label for="name" class="form-label">Temps de cuisson</label>
                <input type="text" name="temps_cuis" id="name" class="form-input" value="<?php echo $donnee['temps_cuisson'] ?>" required/>
              </div>
                <div class="form-row">
                    <label for="photo" for="photo" class="form-label">inserer une photo du plat :</label>
                    <input type="file" name="photo" id="photo" class="form-input " accept ="image/*"/>
                    <p><?php echo $donnee['photo'] ?></p>
                    <div>
                        <img src="./<?php echo $donnee['photo'] ?>" alt=""  height="200px" width="200px">
                </div>
                <article>
                    <div class="form-row">
                        <label for="message" class="form-label">Description de la Recette</label>
                        <textarea name="description" id="message" class="form-textarea"value="<?php echo $donnee['description'] ?>" required></textarea>
                    </div>
                    <div class="form-row">
                        <label for="message" class="form-label">Instructions</label>
                        <textarea name="instruction" id="message" class="form-textarea"value="<?php echo $donnee['instruction_cuisson'] ?>" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-block">
                        submit
                    </button>
                </article>
          </article>
        </section>
     <!-- featured recipes -->
       <section class="featured-recipes">
        <h5 class="featured-title">Regardez-moi ça !</h5>
        <div class="recipes-list">
          <!-- single recipe -->
          <a href="single-recipe.html" class="recipe">
            <img
              src="../assets/recipes/recipe-1.jpeg"
              class="img recipe-img"
              alt=""
            />
            <h5>Carne Asada</h5>
            <p>Prep : 15min | Cook : 5min</p>
          </a>
          <!-- end of single recipe -->
          <!-- single recipe -->
          <a href="single-recipe.html" class="recipe">
            <img
              src="../assets/recipes/recipe-2.jpeg"
              class="img recipe-img"
              alt=""
            />
            <h5>Greek Ribs</h5>
            <p>Prep : 15min | Cook : 5min</p>
          </a>
          <!-- end of single recipe -->
          <!-- single recipe -->
          <a href="single-recipe.html" class="recipe">
            <img
              src="../assets/recipes/recipe-3.jpeg"
              class="img recipe-img"
              alt=""
            />
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


  

  
