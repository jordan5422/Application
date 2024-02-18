<?php
require_once(__DIR__ . '/../configuration/databaseconnect.php');

$idRecette = $_POST['id_recette'];

// Vérifier si la recette a déjà été "likée"
$likeCheckStmt = $mysqlClient->prepare("SELECT id FROM likes WHERE id_recette = ?");
$likeCheckStmt->execute([$idRecette]);
$likeExists = $likeCheckStmt->fetch();

if ($likeExists) {
    // Supprimer le "like"
    $deleteStmt = $mysqlClient->prepare("DELETE FROM likes WHERE id = ?");
    $deleteStmt->execute([$likeExists['id']]);
} else {
    // Ajouter un "like"
    $insertStmt = $mysqlClient->prepare("INSERT INTO likes (id_recette, date, heure) VALUES (?, CURDATE(), CURTIME())");
    $insertStmt->execute([$idRecette]);
}

// Récupérer le nouveau nombre de "likes"
$newLikeCountStmt = $mysqlClient->prepare("SELECT COUNT(*) FROM likes WHERE id_recette = ?");
$newLikeCountStmt->execute([$idRecette]);
$newLikeCount = $newLikeCountStmt->fetchColumn();

echo json_encode(['newLikeCount' => $newLikeCount]);
?>
