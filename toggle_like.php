<?php
require_once(__DIR__ . '/configuration/mysql.php');
require_once(__DIR__ . '/configuration/databaseconnect.php');
require_once(__DIR__ . '/variables/variables.php');
require_once(__DIR__ . '/variables/functions.php');

$idRecette = $_POST['id_recette'];
$idUser = $_POST['id_user']; // L'ID de l'utilisateur est passé par AJAX

// Vérifier si le "like" existe déjà
$likeCheckStmt = $mysqlClient->prepare("SELECT id FROM likes WHERE id_users = ? AND id_recette = ?");
$likeCheckStmt->execute([$idUser, $idRecette]);
$like = $likeCheckStmt->fetch();

if ($like) {
    // Supprimer le "like" existant
    $deleteStmt = $mysqlClient->prepare("DELETE FROM likes WHERE id = ?");
    $deleteStmt->execute([$like['id']]);
} else {
    // Ajouter un nouveau "like"
    $insertStmt = $mysqlClient->prepare("INSERT INTO likes (id_users, id_recette, date, heure) VALUES (?, ?, CURDATE(), CURTIME())");
    $insertStmt->execute([$idUser, $idRecette]);
}

// Récupérer et renvoyer le nouveau nombre de "likes"
$newLikeCountStmt = $mysqlClient->prepare("SELECT COUNT(*) FROM likes WHERE id_recette = ?");
$newLikeCountStmt->execute([$idRecette]);
$newLikeCount = $newLikeCountStmt->fetchColumn();

echo json_encode(['newLikeCount' => $newLikeCount]);
