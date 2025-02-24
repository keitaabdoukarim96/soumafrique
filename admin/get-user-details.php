<?php
require_once './config/db.php';

if (isset($_POST['id'])) {
    $userId = intval($_POST['id']);
    $query = "SELECT id, nom, email, 
                     '123 Rue de Paris, 75001 Paris' AS adresse, 
                     'Commande #12345 - Livrée' AS commandes, 
                     'Épice spéciale, Mélange d\'épices' AS favoris, 
                     'Sauce épicée, Barbecue mix' AS sauvegardes 
              FROM users WHERE id = $userId";

    $result = mysqli_query($conn, $query);
    if ($user = mysqli_fetch_assoc($result)) {
        echo json_encode($user);
    } else {
        echo json_encode(["error" => "Utilisateur non trouvé"]);
    }
}
?>
