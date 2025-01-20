<?php
include('../templates/header.php');
?>

<!-- Image avec titre centré -->
<section class="relative">
  <div class="relative w-full h-[70vh]">
    <!-- Image de fond -->
    <img src="../assets/img/profil-banner.png" alt="Bannière Profil" class="absolute inset-0 w-full h-full object-cover">
    <!-- Superposition sombre et texte centré -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4" style="padding-top: calc(80px + 1rem);">
      <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold text-center leading-tight">
        Mon Profil
      </h1>
    </div>
  </div>
</section>

<!-- Section Profil -->
<main class="container mx-auto px-4 py-10 space-y-10">
  <!-- Informations personnelles -->
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Informations personnelles</h2>
    <div class="space-y-4">
      <!-- Nom -->
      <div class="flex items-center justify-between">
        <p class="text-gray-700 font-medium">Nom :</p>
        <p class="text-gray-900 font-bold">John Doe</p>
      </div>
      <!-- Email -->
      <div class="flex items-center justify-between">
        <p class="text-gray-700 font-medium">Email :</p>
        <p class="text-gray-900 font-bold">johndoe@example.com</p>
      </div>
      <!-- Téléphone -->
      <div class="flex items-center justify-between">
        <p class="text-gray-700 font-medium">Téléphone :</p>
        <p class="text-gray-900 font-bold">+33 6 12 34 56 78</p>
      </div>
      <!-- Adresse -->
      <div class="flex items-center justify-between">
        <p class="text-gray-700 font-medium">Adresse :</p>
        <p class="text-gray-900 font-bold">123 Rue de Paris, 75001 Paris</p>
      </div>
    </div>

    <!-- Bouton Modifier -->
    <div class="mt-6 text-center">
      <button class="btn-gradient py-2 px-6 rounded-lg font-bold text-white hover:shadow-lg">
        Modifier mes informations
      </button>
    </div>
  </div>

  <!-- Commandes récentes -->
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Commandes récentes</h2>
    <ul class="space-y-4">
      <li class="border-b pb-4">
        <p class="text-gray-800 font-bold">Commande #12345</p>
        <p class="text-gray-600">Date : 10 janvier 2025</p>
        <p class="text-gray-600">Statut : Livrée</p>
      </li>
      <li class="border-b pb-4">
        <p class="text-gray-800 font-bold">Commande #12344</p>
        <p class="text-gray-600">Date : 5 janvier 2025</p>
        <p class="text-gray-600">Statut : En cours</p>
      </li>
    </ul>
    <div class="mt-4 text-center">
      <button class="btn-gradient py-2 px-6 rounded-lg font-bold text-white hover:shadow-lg">
        Voir toutes mes commandes
      </button>
    </div>
  </div>

  <!-- Articles favoris -->
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Mes favoris</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <!-- Exemple d'article -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md">
        <img src="assets/img/favori1.jpg" alt="Article favori 1" class="w-full h-32 object-cover rounded-lg">
        <p class="text-gray-800 font-bold mt-2">Épice spéciale</p>
        <button class="btn-gradient py-1 px-4 rounded-lg font-bold text-white mt-2 hover:shadow-lg">
          Voir l'article
        </button>
      </div>
      <div class="bg-gray-100 p-4 rounded-lg shadow-md">
        <img src="assets/img/favori2.jpg" alt="Article favori 2" class="w-full h-32 object-cover rounded-lg">
        <p class="text-gray-800 font-bold mt-2">Mélange d'épices</p>
        <button class="btn-gradient py-1 px-4 rounded-lg font-bold text-white mt-2 hover:shadow-lg">
          Voir l'article
        </button>
      </div>
    </div>
  </div>

  <!-- Articles sauvegardés -->
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Mes articles sauvegardés</h2>
    <ul class="space-y-4">
      <li>
        <p class="text-gray-800 font-bold">Article : Sauce épicée au piment</p>
        <button class="btn-gradient py-1 px-4 rounded-lg font-bold text-white mt-2 hover:shadow-lg">
          Voir l'article
        </button>
      </li>
      <li>
        <p class="text-gray-800 font-bold">Article : Mélange spécial pour barbecue</p>
        <button class="btn-gradient py-1 px-4 rounded-lg font-bold text-white mt-2 hover:shadow-lg">
          Voir l'article
        </button>
      </li>
    </ul>
  </div>
</main>


<?php
include('../templates/footer.php');
?>
