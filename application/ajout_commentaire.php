<?php
session_start();
require_once(__DIR__ . '/../configuration/databaseconnect.php');

// Vérifier si l'utilisateur est connecté
//if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    //header("Location: login.php");
   // exit();
//}
//var_dump($_SESSION['LOGGED_USER']);
//var_dump($_POST);

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si le champ de commentaire est vide
    if (empty(trim($_POST["comment"]))) {
        $comment_err = "Veuillez saisir votre commentaire.";
    } else {
        // Préparer la déclaration d'insertion
        $sql = "INSERT INTO commentaires (commentaire, heure, date, id_users, id_recette) VALUES (:comment, :heure, :date, :user_id, :recipe_id)";
        
        if ($stmt = $mysqlClient->prepare($sql)) {
            // Liaison des paramètres
            $stmt->bindParam(":comment", $param_comment, PDO::PARAM_STR);
            $stmt->bindParam(":heure", $param_heure, PDO::PARAM_STR);
            $stmt->bindParam(":date", $param_date, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $param_user_id, PDO::PARAM_INT);
            $stmt->bindParam(":recipe_id", $param_recipe_id, PDO::PARAM_INT);
            
            // Définir les valeurs des paramètres
            $param_comment = trim($_POST["comment"]);
            $param_heure = date("H:i:s"); // Heure actuelle
            $param_date = date("Y-m-d"); // Date actuelle
            $param_user_id = $_SESSION['LOGGED_USER']['user_id'];
            $param_recipe_id = intval($_POST['id_recette']); // Récupérer l'ID de la recette à partir de la session

            // Exécuter la déclaration préparée
            if ($stmt->execute()) {
                // Rediriger l'utilisateur vers la page de la recette après l'ajout du commentaire
                header("Location: content_unique.php?id=" . intval($_POST['id_recette']));
                //header("refresh:1");
                exit();
            } else {
                echo "Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
            }
        }
        
        // Fermer la déclaration
        unset($stmt);
    }
    
    // Fermer la connexion
    unset($mysqlClient);
}
?>
