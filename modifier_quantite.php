<?php
session_start();
include('admin/config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $panier_id = intval($_POST["id"]);
    $change = intval($_POST["change"]);

    // Vérifier si le produit existe dans le panier
    $stmt = $conn->prepare("SELECT quantite FROM panier WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $panier_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($quantite);
    $stmt->fetch();
    $stmt->close();

    if ($quantite !== null) {
        $nouvelle_quantite = max(1, $quantite + $change); // La quantité minimale est 1

        $stmt = $conn->prepare("UPDATE panier SET quantite = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("iii", $nouvelle_quantite, $panier_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirection vers le panier
header("Location: panier.php");
exit();
?>
