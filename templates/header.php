<?php

$total_items = 0;
session_start();
include('admin/config/db.php');
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Récupérer uniquement les produits du panier de l'utilisateur connecté
    $stmt = $conn->prepare("SELECT SUM(quantite) AS total FROM panier WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($total_items);
    $stmt->fetch();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/soumafrique/assets/css/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="/soumafrique/assets/css/custom-styles.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <title>SoumAfrique</title>

  <style>
   #cart-count {
  min-width: 18px;
  min-height: 18px;
  font-size: 12px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
  position: absolute;
  top: 0;
  right: 0;
  transform: translate(50%, -50%);
}


.fas.fa-shopping-cart {
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
}

  </style>
</head>

<body class="font-sans bg-gray-100 flex flex-col min-h-screen">

  <header class="bg-white shadow-md fixed w-full z-50">
    <div class="container mx-auto px-4 flex items-center justify-between py-3">
      <!-- Logo -->
      <div class="flex items-center">
        <a href="./index.php">
          <img src="/soumafrique/assets/img/logo/logo.png" alt="Logo SoumAfrique" class="h-20">
        </a>
      </div>
      <nav class="hidden md:flex space-x-8 items-center h-16">
        <a href="/soumafrique/index.php" class="text-black font-bold hover:bg-red-700 hover:text-white py-2 px-4 rounded">Accueil</a>
        <a href="/soumafrique/epicerie.php" class="text-black font-bold hover:bg-red-700 hover:text-white py-2 px-4 rounded" id="menu-epicerie">Épicerie</a>
        <a href="/soumafrique/recettes.php" class="text-black font-bold hover:bg-red-700 hover:text-white py-2 px-4 rounded" id="menu-recettes">Recettes</a>
        <a href="/soumafrique/about.php" class="text-black font-bold hover:bg-red-700 hover:text-white py-2 px-4 rounded">À propos</a>
        <a href="/soumafrique/contact.php" class="text-black font-bold hover:bg-red-700 hover:text-white py-2 px-4 rounded">Contact</a>
        <?php if (!isset($_SESSION["user_id"])) : ?>
        <a href="/soumafrique/admin/inscription-proprietaire.php" class="bg-red-700 text-white font-bold py-2 px-4 rounded hover:bg-red-800">Propriétaire de Boutique, cliquez ici</a>
        <?php endif; ?>
      <!-- 🛒 Icône Panier Fixe avec compteur bien positionné -->
<!-- Icône du panier avec compteur -->
<div class="relative ml-6">
  <a href="panier.php" class="relative flex items-center text-gray-900 hover:text-gray-700 transition">
    <i class="fas fa-shopping-cart text-3xl text-yellow-500"></i>
    <span id="cart-count" class="absolute top-0 right-0 transform translate-x-2 -translate-y-2 bg-green-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-md">
      <?= $total_items ?: 0 ?>
    </span>
  </a>
</div>



      </nav>

      <!-- Icônes à droite
      <div class="flex space-x-4">
        <a href="./panier/panier.php" class="text-black hover-menu"><i class="fas fa-shopping-cart"></i></a>
        <a href="./user/profil.php" class="text-black hover-menu"><i class="fas fa-user"></i></a>
      </div> -->
      <!-- Icônes à droite -->
        <!-- Icônes à droite -->
<!-- Icônes à droite -->
<div class="flex space-x-4 relative -ml-2"> <!-- Ajustement avec -mr-4 -->
    <?php if (isset($_SESSION["user_id"])) : ?>
        <!-- Bouton "Mon compte" avec menu déroulant -->
        <div class="relative">
            <button id="accountButton" class="text-black hover-menu flex items-center text-sm">
                
            
                <span class="mr-4">Mon compte ▼</span>
            </button>
            <!-- Contenu du menu déroulant (caché par défaut) -->
            <div id="accountMenu" class="hidden absolute bg-white shadow-sm rounded-md mt-1 w-32 left-0 translate-x-[-5px] z-50">
                <a href="profile.php" class="block px-3 py-1 text-sm text-black hover:bg-gray-100 flex items-center">
                    <i class="fas fa-user text-purple-500 mr-2"></i> Profil
                </a>
                <a href="logout.php" class="block px-3 py-1 text-sm text-red-500 hover:bg-gray-100 flex items-center">
                    <i class="fas fa-sign-out-alt text-orange-500 mr-2"></i> Déconnexion
                </a>
            </div>
        </div>
    <?php else : ?>
        <!-- Lien de connexion -->
        <a href="login.php" class="text-black hover-menu text-sm">Connexion</a>
    <?php endif; ?>
</div>

      <!-- Menu mobile -->
      <button id="menu-toggle" class="md:hidden text-black">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    <!-- Menu déroulant pour mobile -->
    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-md">
      <a href="./index.php" class="block px-4 py-2 text-black hover-menu">Accueil</a>

      <!-- Menu Épicerie avec sous-menus -->
      <div class="relative">
        <a href="./epicerie.php" class="block px-4 py-2 text-black hover-menu">Épicerie</a>
        <div class="ml-4 hidden" id="sub-menu-epicerie">
          <a href="./sousmenus/epicerie/epices-entieres.php" class="block px-4 py-2 text-black hover-menu">Épices Entières</a>
          <a href="./sousmenus/epicerie/epices-moulues.php" class="block px-4 py-2 text-black hover-menu">Épices Moulues</a>
          <a href="./sousmenus/epicerie/mélanges-épices.php" class="block px-4 py-2 text-black hover-menu">Mélanges d'Épices</a>
          <a href="./sousmenus/epicerie/autres.php" class="block px-4 py-2 text-black hover-menu">Autres</a>
        </div>
      </div>

      <!-- Menu Recettes avec sous-menus -->
      <div class="relative font-bold">
        <a href="./recettes.php" class="block px-4 py-2 text-black hover-menu">Recettes</a>
        <div class="ml-4 hidden" id="sub-menu-recettes">
          <a href="./sousmenus/recettes/entrées.php" class="block px-4 py-2 text-black hover-menu">Entrées</a>
          <a href="./sousmenus/recettes/plats-principaux.php" class="block px-4 py-2 text-black hover-menu">Plats Principaux</a>
          <a href="./sousmenus/recettes/accompagnements.php" class="block px-4 py-2 text-black hover-menu">Accompagnements</a>
          <a href="./sousmenus/recettes/desserts.php" class="block px-4 py-2 text-black hover-menu">Desserts</a>
        </div>
      </div>

      <a href="./about.php" class="block font-bold px-4 py-2 text-black hover-menu">À propos</a>
      <a href="./contact.php" class="block font-bold px-4 py-2 text-black hover-menu">Contact</a>
      <?php if (!isset($_SESSION["user_id"])) : ?>
      <a href="/soumafrique/admin/proprietaire.php" class="bg-red-700 text-white font-bold py-2 px-4 rounded hover:bg-red-800">Propriétaire de Boutique, cliquez ici</a>
      <?php endif; ?>
    </div>
  </header>

  <button id="open-sidebar" class="fixed top-4 left-4 bg-green-700 text-white p-3 rounded-full shadow-lg">
    <i class="fas fa-sliders-h"></i>
  </button>

  <!-- JavaScript pour gérer l'affichage du menu au clic -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const accountButton = document.getElementById("accountButton");
    const accountMenu = document.getElementById("accountMenu");

    // Fonction pour afficher/masquer le menu au clic
    accountButton.addEventListener("click", function (event) {
        event.stopPropagation(); // Empêche la fermeture immédiate
        accountMenu.classList.toggle("hidden");
    });

    // Fermer le menu si on clique en dehors
    document.addEventListener("click", function (event) {
        if (!accountButton.contains(event.target) && !accountMenu.contains(event.target)) {
            accountMenu.classList.add("hidden");
        }
    });
});
</script>