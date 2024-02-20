<?php
session_start();
require_once(__DIR__ . '/../variables/variables.php');
require_once(__DIR__ . '/../variables/functions.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$postData = $_POST;

// Validation du formulaire
if (isset($postData['email']) &&  isset($postData['password'])) {
if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
     $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire.';
} else {
     foreach ($users as $user) {
         if (
             $user['mail'] === $postData['email'] &&
             $user['password'] === $postData['password']
         ) {
             $_SESSION['LOGGED_USER'] = [
                 'email' => $user['mail'],
                 'id' => $user['id'],
                 'nom' => $user['nom'],
                 'telephone' => $user['telephone'],
                 'role' => $user['role'],
                 'photo' => $user['photo'],
                 'password' => $user['password'],

             ];
         }
     }

     if (!isset($_SESSION['LOGGED_USER'])) {
         $_SESSION['LOGIN_ERROR_MESSAGE'] = sprintf(
             'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
             $postData['email'],
             strip_tags($postData['password'])
         );
     }else{
        redirectToUrl('../home.php');
     }
}
redirectToUrl('login.php');
}