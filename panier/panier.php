<?php 
include('../templates/header.php');
?>

<!-- Image avec titre centré -->
<section class="relative">
  <div class="relative w-full h-[70vh]">
    <!-- Image de fond -->
    <img src="./assets/img/panier-banner.png" alt="Bannière Panier" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4" style="padding-top: calc(80px + 1rem);">
      <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold text-center leading-tight">
        Votre Panier
      </h1>
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
        <!-- Article 1 -->
        <div class="flex items-center space-x-4">
          <img src="assets/img/article1.jpg" alt="Article 1" class="w-24 h-24 object-cover rounded-lg">
          <div class="flex-1">
            <h3 class="text-lg font-bold text-gray-800">Épice spéciale</h3>
            <p class="text-gray-600">100g - 5,99 €</p>
            <button class="text-red-600 hover:underline text-sm mt-2">Supprimer</button>
          </div>
          <div class="flex items-center space-x-2">
            <button class="text-gray-600 border border-gray-300 px-2 py-1 rounded-lg">-</button>
            <span class="font-bold">1</span>
            <button class="text-gray-600 border border-gray-300 px-2 py-1 rounded-lg">+</button>
          </div>
          <p class="text-lg font-bold text-gray-800">5,99 €</p>
        </div>
        <!-- Article 2 -->
        <div class="flex items-center space-x-4">
          <img src="assets/img/article2.jpg" alt="Article 2" class="w-24 h-24 object-cover rounded-lg">
          <div class="flex-1">
            <h3 class="text-lg font-bold text-gray-800">Mélange barbecue</h3>
            <p class="text-gray-600">200g - 12,49 €</p>
            <button class="text-red-600 hover:underline text-sm mt-2">Supprimer</button>
          </div>
          <div class="flex items-center space-x-2">
            <button class="text-gray-600 border border-gray-300 px-2 py-1 rounded-lg">-</button>
            <span class="font-bold">2</span>
            <button class="text-gray-600 border border-gray-300 px-2 py-1 rounded-lg">+</button>
          </div>
          <p class="text-lg font-bold text-gray-800">24,98 €</p>
        </div>
      </div>
    </div>

    <!-- Résumé du panier -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Résumé</h2>
      <div class="space-y-4">
        <div class="flex justify-between">
          <p class="text-gray-600">Sous-total</p>
          <p class="font-bold text-gray-800">30,97 €</p>
        </div>
        <div class="flex justify-between">
          <p class="text-gray-600">Frais de livraison</p>
          <p class="font-bold text-gray-800">4,99 €</p>
        </div>
        <div class="flex justify-between border-t pt-4">
          <p class="font-bold text-gray-800">Total</p>
          <p class="font-bold text-green-600">35,96 €</p>
        </div>
      </div>
      <!-- Code promo -->
      <div class="mt-6">
        <form class="flex items-center space-x-2">
          <input type="text" placeholder="Code promo" class="flex-grow py-2 px-4 border border-gray-300 rounded-lg focus:outline-none">
          <button type="submit" class="btn-gradient py-2 px-6 rounded-lg font-bold text-white hover:shadow-lg">
            Appliquer
          </button>
        </form>
      </div>
      <!-- Bouton passer commande -->
      <div class="mt-6">
        <button class="btn-gradient py-3 px-6 w-full rounded-lg font-bold text-white hover:shadow-lg">
          Passer à la commande
        </button>
      </div>
    </div>
  </div>
</main>


<!-- Section Épices associées -->
<section class="container mx-auto px-4 py-10">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Épices associées</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Produit 1 -->
    <div class="bg-white shadow-md rounded-lg p-4 border-2" style="border-image: linear-gradient(to right, #ebb62c, #2d7000) 1;">
      <img src="assets/img/epice1.jpg" alt="Épice 1" class="w-full h-40 object-cover rounded-lg mb-4">
      <h3 class="text-lg font-bold text-gray-800 mb-2">Poudre de Kinkeliba</h3>
      <p class="text-gray-600 mb-1"><strong>Boutique :</strong> African Market</p>
      <p class="text-gray-600 mb-1"><strong>Adresse :</strong> 45 rue du Marché</p>
      <p class="text-gray-600 mb-1"><strong>Horaire :</strong> 09H00 à 20H00</p>
      <div class="flex items-center space-x-2 mt-4">
        <button class="btn-gradient py-2 px-4 w-full rounded-lg font-bold text-white hover:shadow-lg">
          VOIR LES DÉTAILS
        </button>
        <a href="#" class="text-green-600 text-xl">
          <i class="fas fa-shopping-cart"></i>
        </a>
      </div>
    </div>
    <!-- Ajoutez d'autres produits ici en suivant ce modèle -->
  </div>
</section>

<?php include('../templates/footer.php'); ?>
