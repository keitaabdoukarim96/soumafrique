<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('admin/config/db.php');

header('Content-Type: application/json'); // ✅ S'assurer que la réponse est bien JSON

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $produit_id = $_POST["product_id"]; // Correspond à 'produit_id' dans la base
    $quantite = 1; // Ajout par défaut
    $prix = $_POST["price"];

    // Vérifier si le produit est déjà dans le panier
    $stmt = $conn->prepare("SELECT id, quantite FROM panier WHERE user_id = ? AND produit_id = ?");
    $stmt->bind_param("ii", $user_id, $produit_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($panier_id, $existing_quantite);
        $stmt->fetch();
        $new_quantite = $existing_quantite + 1;

        $update_stmt = $conn->prepare("UPDATE panier SET quantite = ? WHERE id = ?");
        $update_stmt->bind_param("ii", $new_quantite, $panier_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        $insert_stmt = $conn->prepare("INSERT INTO panier (user_id, produit_id, quantite, prix) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param("iiid", $user_id, $produit_id, $quantite, $prix);
        $insert_stmt->execute();
        $insert_stmt->close();
    }

    // Récupérer le total des articles après ajout
    $stmt = $conn->prepare("SELECT SUM(quantite) FROM panier WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($total_items);
    $stmt->fetch();
    $stmt->close();

    // ✅ Envoyer la réponse JSON correcte
    echo json_encode(["total_items" => $total_items]);
    exit();
} else {
    echo json_encode(["error" => "Requête invalide"]);
    exit();
}
?>
