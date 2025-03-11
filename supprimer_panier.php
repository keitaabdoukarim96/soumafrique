<?php
session_start();
include('admin/config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $panier_id = intval($_POST["id"]);

    $stmt = $conn->prepare("DELETE FROM panier WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $panier_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Redirection vers le panier
header("Location: panier.php");
exit();
?>
