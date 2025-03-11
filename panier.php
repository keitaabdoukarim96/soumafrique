<?php 

include('templates/header.php');


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Récupérer les articles du panier
$query = "SELECT panier.id, panier.produit_id, panier.quantite, panier.prix, epicerie.nom_epice, epicerie.image_epice FROM panier 
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
?>

<!-- Image avec titre centré -->
<section class="relative">
  <div class="relative w-full h-[70vh]">
    <img src="assets/img/panier-banner.png" alt="Bannière Panier" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4">
      <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold text-center">Votre Panier</h1>
    </div>
  </div>
</section>

<!-- Section Panier -->
<main class="container mx-auto px-4 py-10">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Articles du panier -->
    <div class="lg:col-span-2 bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Articles dans votre panier</h2>
      <div class="space-y-6">
        <?php foreach ($panier_items as $item) : ?>
          <div class="flex items-center space-x-4">
            <img src="admin/uploads/<?= htmlspecialchars($item['image_epice']); ?>" class="w-24 h-24 object-cover rounded-lg">
            <div class="flex-1">
              <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($item['nom_epice']); ?></h3>
              <p class="text-gray-600">Prix unitaire: <?= number_format($item['prix'], 2, ',', ' '); ?> €</p>
              <button class="text-red-600 hover:underline text-sm mt-2" onclick="supprimerProduit(<?= $item['id']; ?>)">Supprimer</button>
            </div>
            <div class="flex items-center space-x-2">
              <button class="border px-2 py-1 rounded-lg" onclick="modifierQuantite(<?= $item['id']; ?>, -1)">-</button>
              <span class="font-bold"><?= $item['quantite']; ?></span>
              <button class="border px-2 py-1 rounded-lg" onclick="modifierQuantite(<?= $item['id']; ?>, 1)">+</button>
            </div>
            <p class="text-lg font-bold text-gray-800"><?= number_format($item['prix'] * $item['quantite'], 2, ',', ' '); ?> €</p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Résumé du panier -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Résumé</h2>
      <div class="space-y-4">
        <div class="flex justify-between">
          <p class="text-gray-600">Sous-total</p>
          <p class="font-bold text-gray-800"><?= number_format($total, 2, ',', ' '); ?> €</p>
        </div>
        <div class="flex justify-between">
          <p class="text-gray-600">Frais de livraison</p>
          <p class="font-bold text-gray-800"><?= number_format($livraison, 2, ',', ' '); ?> €</p>
        </div>
        <div class="flex justify-between border-t pt-4">
          <p class="font-bold text-gray-800">Total</p>
          <p class="font-bold text-green-600"><?= number_format($total_general, 2, ',', ' '); ?> €</p>
        </div>
      </div>
      <!-- Bouton passer commande -->
<div class="mt-6">
    <a href="checkout.php" class="btn-gradient py-3 px-6 w-full rounded-lg font-bold text-white text-center block">Passer à la commande</a>
</div>

    </div>
  </div>
</main>

<script>
function modifierQuantite(id, change) {
    fetch('modifier_quantite.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&change=${change}`
    }).then(() => location.reload());
}

function supprimerProduit(id) {
    if (confirm("Voulez-vous supprimer cet article du panier ?")) {
        fetch('supprimer_panier.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}`
        }).then(() => location.reload());
    }
}
</script>

<?php include('templates/footer.php'); ?>
