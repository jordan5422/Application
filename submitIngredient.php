<?php
//require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '../configuration/mysql.php');
require_once(__DIR__ . '../configuration/databaseconnect.php');
require_once(__DIR__ . '/variables/functions.php');


if(!empty($_POST)) {


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
        if($check !== false) {
            echo "Le fichier est une image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }
    //}
  
    $id=1;
    //ajout dans BD
      if ($uploadOk == 1) {
        $sql = "INSERT INTO recette (nom, type, nombre_plats, temps_preparation, temps_Cuisson, photo, description, instruction_cuisson,id_users) VALUES (?, ?,?, ?, ?, ?, ?, ?,?)";
        $stmt = $mysqlClient->prepare($sql);
  
        try {
          $stmt->execute([$name, $nbr,$type, $temps_prep, $temps_cuis, $target_file, $description, $instruction, $id]);
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
        echo "Le fichier ". htmlspecialchars( basename( $_FILES["photo"]["name"])). " a été téléchargé.";
  
        // Utilisation de lastInsertId pour obtenir l'ID de la dernière insertion
        $recipeId = $mysqlClient->lastInsertId();
  
        // Redirection vers l'autre page en incluant l'ID dans l'URL
       // header('Location: ../AjoutIngredient.php?id=' . $recipeId);
        exit();
       } else {
         echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
       }
  
       
  
    }
    
  
  
