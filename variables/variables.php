<?php
require_once(__DIR__ . '/../configuration/databaseconnect.php'); 
// Récupération des variables à l'aide du client MySQL
$usersStatement = $mysqlClient->prepare('SELECT * FROM users');
$usersStatement->execute();
$users = $usersStatement->fetchAll();

$recipesStatement = $mysqlClient->prepare('SELECT * FROM recette');
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();