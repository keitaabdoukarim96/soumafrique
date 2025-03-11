<?php

include('templates/header.php');


// Vérifier si une commande a bien été passée
if (!isset($_GET["commande_id"])) {
    header("Location: index.php");
    exit();
}

$commande_id = intval($_GET["commande_id"]);

// Récupérer les informations de la commande
$query = "SELECT commandes.total, commandes.date_commande, commandes.statut, users.nom, users.email 
          FROM commandes 
          JOIN users ON commandes.user_id = users.id 
          WHERE commandes.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $commande_id);
$stmt->execute();
$result = $stmt->get_result();
$commande = $result->fetch_assoc();
$stmt->close();

// Récupérer les détails de la commande
$query = "SELECT epicerie.nom_epice, epicerie.image_epice, details_commande.quantite, details_commande.prix 
          FROM details_commande 
          JOIN epicerie ON details_commande.produit_id = epicerie.id 
          WHERE details_commande.commande_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $commande_id);
$stmt->execute();
$result = $stmt->get_result();
$details_commande = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<main class="container mx-auto px-4 py-10 mt-20">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Confirmation de votre commande</h2>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-xl font-bold text-gray-800">Merci pour votre commande, <?= htmlspecialchars($commande['nom']); ?> !</h3>
        <p class="text-gray-600 mt-2">Votre commande a bien été enregistrée.</p>
        <p class="text-gray-600">Un email de confirmation a été envoyé à <strong><?= htmlspecialchars($commande['email']); ?></strong>.</p>
        <p class="text-gray-600">Numéro de commande : <strong>#<?= $commande_id; ?></strong></p>
        <p class="text-gray-600">Date de commande : <strong><?= date('d/m/Y H:i', strtotime($commande['date_commande'])); ?></strong></p>
        <p class="text-gray-600">Statut : <strong><?= ucfirst($commande['statut']); ?></strong></p>
    </div>

    <!-- Détails de la commande -->
    <div class="bg-white shadow-md rounded-lg p-6 mt-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Détails de votre commande</h3>
        <ul class="space-y-4">
            <?php foreach ($details_commande as $item) : ?>
                <li class="flex justify-between items-center border-b pb-2">
                    <img src="admin/uploads/<?= htmlspecialchars($item['image_epice']); ?>" class="w-16 h-16 object-cover rounded-lg">
                    <span class="text-gray-800 font-bold"> <?= htmlspecialchars($item['nom_epice']); ?> (x<?= $item['quantite']; ?>)</span>
                    <span class="text-gray-800 font-bold"><?= number_format($item['prix'] * $item['quantite'], 2, ',', ' '); ?> €</span>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="flex justify-between border-t pt-4 mt-4">
            <p class="font-bold text-gray-800">Total payé :</p>
            <p class="font-bold text-green-600"><?= number_format($commande['total'], 2, ',', ' '); ?> €</p>
        </div>
    </div>

    <!-- Bouton retour accueil -->
    <div class="mt-6 text-center">
        <a href="index.php" class="btn-gradient py-3 px-6 rounded-lg font-bold text-white">Retour à l'accueil</a>
    </div>
</main>

<?php include('templates/footer.php'); ?>
