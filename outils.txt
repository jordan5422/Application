<?php
session_start();
require_once(__DIR__ . '/../../variables/variables.php');
require_once(__DIR__ . '/../../variables/functions.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$postData = $_POST;
$isPresent = false;

// Validation du formulaire
if (isset($postData)) {
    if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire.';
    } elseif ((!isset($postData['password']) && !isset($postData['Cpassword'])) || $postData['password'] !== $postData['Cpassword']) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Erreur de mot de passe';
    } elseif (!isset($postData['nom'])) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Entrez un nom';
    } else {
        foreach ($users as $user) {
            if ($user['mail'] === $postData['email']) {
                $isPresent = true;
                break;
            }
        }
    }

    $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Utilisateur deja présent';
    if(!$isPresent){
        $insertRecipe = $mysqlClient->prepare('INSERT INTO users(mail, password, telephone, nom, role) VALUES (:mail, :password, :telephone, :nom, :role)');
        $insertRecipe->execute([
            'mail' => $postData['email'],
            'password' => $postData['password'],
            'telephone' => 0000,
            'nom' => $postData['nom'],
            'role' => 'user',
        ]);
        
    redirectToUrl('../../login/login.php');
    }
    
}
