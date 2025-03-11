<?php

include('templates/header.php');

// Vérifier si l'utilisateur est connecté

$user_id = $_SESSION["user_id"];

// Vérifier si le panier contient des articles
$query = "SELECT panier.produit_id, panier.quantite, panier.prix, epicerie.nom_epice 
          FROM panier 
          JOIN epicerie ON panier.produit_id = epicerie.id 
          WHERE panier.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$panier_items = $result->fetch_all(MYSQLI_ASSOC);

// Calcul du total
$total = 0;
foreach ($panier_items as $item) {
    $total += $item['prix'] * $item['quantite'];
}
$livraison = 4.99;
$total_general = $total + $livraison;

// Si le panier est vide, retour au panier
if (empty($panier_items)) {
    header("Location: panier.php");
    exit();
}
?>

<main class="container mx-auto px-4 py-10 mt-20">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Informations de livraison</h2>
    <form action="valider_commande.php" method="POST" class="bg-white shadow-md rounded-lg p-6">
        <input type="hidden" name="total" value="<?= $total_general ?>">

        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Adresse de livraison</label>
            <input type="text" name="adresse" class="w-full p-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Numéro de téléphone</label>
            <input type="tel" name="telephone" class="w-full p-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Disponibilité</label>
            <input type="text" name="disponibilite" class="w-full p-2 border rounded-lg" placeholder="Ex: Tous les jours après 18h">
        </div>

        <button type="submit" class="btn-gradient py-3 px-6 w-full rounded-lg font-bold text-white">Valider la commande</button>
    </form>
</main>

<?php include('templates/footer.php'); ?>
