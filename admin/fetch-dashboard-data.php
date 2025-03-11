<?php
include('../admin/config/db.php'); 
session_start();

// Récupérer les statistiques
$query_users = "SELECT COUNT(*) AS total_users FROM users";
$query_boutiques = "SELECT COUNT(*) AS total_boutiques FROM proprietaire";
$query_epices = "SELECT COUNT(*) AS total_epices FROM epicerie";
$query_recettes = "SELECT COUNT(*) AS total_recettes FROM recette";

$result_users = mysqli_query($conn, $query_users);
$result_boutiques = mysqli_query($conn, $query_boutiques);
$result_epices = mysqli_query($conn, $query_epices);
$result_recettes = mysqli_query($conn, $query_recettes);

$total_users = mysqli_fetch_assoc($result_users)['total_users'];
$total_boutiques = mysqli_fetch_assoc($result_boutiques)['total_boutiques'];
$total_epices = mysqli_fetch_assoc($result_epices)['total_epices'];
$total_recettes = mysqli_fetch_assoc($result_recettes)['total_recettes'];

// Retourner les données en JSON
echo json_encode([
    'total_users' => $total_users,
    'total_boutiques' => $total_boutiques,
    'total_epices' => $total_epices,
    'total_recettes' => $total_recettes
]);

exit();
?>