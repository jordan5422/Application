<?php
require_once(__DIR__ . '/../configuration/databaseconnect.php'); 
// Récupération des variables à l'aide du client MySQL
$usersStatement = $mysqlClient->prepare('SELECT * FROM users');
$usersStatement->execute();
$users = $usersStatement->fetchAll();

$imagesStatement = $mysqlClient->prepare("SELECT i.nom AS nom_image,i.id as id_image, r.nom AS nom_recette, i.lien AS lien_image
FROM image i
INNER JOIN recette r ON i.id_recette = r.id");
$imagesStatement->execute();
$images = $imagesStatement->fetchAll(PDO::FETCH_ASSOC);

