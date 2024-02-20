<?php
session_start();
require_once(__DIR__ . '/../configuration/databaseconnect.php');
require_once(__DIR__ . '/../variables/variables.php');
require_once(__DIR__ . '/../variables/functions.php');

// deleteUser($userCourant, $mysqlClient);

// detruit toutes les données de session
session_unset();
// detruit la session elle mme 
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil
redirectToUrl('login.php');