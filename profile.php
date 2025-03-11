<?php

include('templates/header.php'); 


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Récupérer les informations de l'utilisateur
$stmt = $conn->prepare("SELECT nom, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nom, $email);
$stmt->fetch();
$stmt->close();

// Récupérer les commandes récentes
$commandes = $conn->query("SELECT id, total, statut, date_commande FROM commandes WHERE user_id = $user_id ORDER BY date_commande DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);
?>

<!-- Image avec titre centré -->
<section class="relative">
  <div class="relative w-full h-[70vh]">
    <img src="assets/img/profil-banner.png" alt="Bannière Profil" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4" style="padding-top: calc(80px + 1rem);">
      <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold text-center leading-tight">
      Bienvenue, <?= htmlspecialchars($nom); ?>
      </h1>
    </div>
  </div>
</section>

<main class="container mx-auto px-6 py-12 space-y-12">
  <!-- Informations personnelles -->
  <div class="bg-white shadow-lg rounded-lg p-8">
    <h2 class="text-2xl font-bold mb-6 border-b pb-4">Informations personnelles</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <div>
        <p class="text-gray-700 font-medium">Nom :</p>
        <p class="text-gray-900 font-bold"><?= htmlspecialchars($nom); ?></p>
      </div>
      <div>
        <p class="text-gray-700 font-medium">Email :</p>
        <p class="text-gray-900 font-bold"><?= htmlspecialchars($email); ?></p>
      </div>
    </div>
    <div class="mt-6 flex justify-between">
      <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Modifier mes informations</button>
    </div>
  </div>

  <!-- Commandes récentes -->
  <div class="bg-white shadow-lg rounded-lg p-8">
    <h2 class="text-2xl font-bold mb-6 border-b pb-4">Commandes récentes</h2>
    <ul class="divide-y divide-gray-200">
      <?php foreach ($commandes as $commande): ?>
        <li class="py-4">
          <div class="flex justify-between">
            <p class="text-gray-900 font-bold">Commande #<?= $commande['id']; ?></p>
            <p class="text-yellow-500 font-bold">Statut: <?= ucfirst($commande['statut']); ?></p>
          </div>
          <p class="text-gray-600 text-sm">Date : <?= date('d/m/Y H:i', strtotime($commande['date_commande'])); ?></p>
          <p class="text-gray-900 font-bold">Total : <?= number_format($commande['total'], 2, ',', ' '); ?> €</p>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="mt-6 text-center">
      <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Voir toutes mes commandes</button>
    </div>
  </div>
</main>

<?php include('templates/footer.php'); ?>
