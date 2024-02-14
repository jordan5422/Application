<?php
session_start();
require_once(__DIR__ . '/../../variables/variables.php');
require_once(__DIR__ . '/../../variables/functions.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assignation et nettoyage des données soumises
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['Cpassword'];

    // Initialisation d'un tableau pour stocker les messages d'erreur
    $errors = [];

    // Validation du nom
    if (empty($nom)) {
        $errors[] = "Le nom est requis.";
    }

    // Validation de l'email
    if (empty($email)) {
        $errors[] = "L'e-mail est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse e-mail n'est pas valide.";
    }

    // Validation du mot de passe
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    // Vérification de la correspondance des mots de passe
    if ($password !== $confirmPassword) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Afficher les erreurs s'il y en a, sinon traiter le formulaire
    if (!empty($errors)) {
        echo "<h3>Erreur(s) lors de la soumission du formulaire :</h3><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
    } else {
        // Ici, vous pouvez procéder à l'enregistrement des données dans une base de données par exemple
        echo "Merci " . htmlspecialchars($nom) . ", votre inscription a bien été prise en compte.";
        // N'oubliez pas de sécuriser la gestion des mots de passe (hashage) avant stockage !
    }
} else {
    // Rediriger l'utilisateur vers la page du formulaire si la méthode n'est pas POST
    header("Location: index.php");
    exit;
}

?>
