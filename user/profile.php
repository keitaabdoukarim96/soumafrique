<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Récupérer le nom de l'utilisateur
$user_nom = $_SESSION["user_nom"];
?>

<?php include('../templates/header.php'); ?>
<!-- Image avec titre centré -->
<section class="relative">
  <div class="relative w-full h-[70vh]">
    <!-- Image de fond -->
    <img src="../assets/img/profil-banner.png" alt="Bannière Profil" class="absolute inset-0 w-full h-full object-cover">
    <!-- Superposition sombre et texte centré -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4" style="padding-top: calc(80px + 1rem);">
      <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold text-center leading-tight">
      Bienvenue sur votre Profil
      </h1>
    </div>
  </div>
</section>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Utilisateur</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">


  <!-- Contenu principal -->
  <main class="container mx-auto px-6 py-12 space-y-12">
    
    <!-- Informations personnelles -->
    <div class="bg-white shadow-lg rounded-lg p-8">
      <h2 class="text-2xl font-bold mb-6 border-b pb-4">Informations personnelles</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
          <p class="text-gray-700 font-medium">Nom :</p>
          <p class="text-gray-900 font-bold">John Doe</p>
        </div>
        <div>
          <p class="text-gray-700 font-medium">Email :</p>
          <p class="text-gray-900 font-bold">johndoe@example.com</p>
        </div>
        <div>
          <p class="text-gray-700 font-medium">Téléphone :</p>
          <p class="text-gray-900 font-bold">+33 6 12 34 56 78</p>
        </div>
        <div>
          <p class="text-gray-700 font-medium">Adresse :</p>
          <p class="text-gray-900 font-bold">123 Rue de Paris, 75001 Paris</p>
        </div>
      </div>
      <div class="mt-6 flex justify-between">
        <!--<a href="./logout.php" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600">Se déconnecter</a>-->
        <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Modifier mes informations</button>
      </div>
    </div>

    <!-- Commandes récentes -->
    <div class="bg-white shadow-lg rounded-lg p-8">
      <h2 class="text-2xl font-bold mb-6 border-b pb-4">Commandes récentes</h2>
      <ul class="divide-y divide-gray-200">
        <li class="py-4">
          <div class="flex justify-between">
            <p class="text-gray-900 font-bold">Commande #12345</p>
            <p class="text-green-500">Livrée</p>
          </div>
          <p class="text-gray-600 text-sm">Date : 10 janvier 2025</p>
        </li>
        <li class="py-4">
          <div class="flex justify-between">
            <p class="text-gray-900 font-bold">Commande #12344</p>
            <p class="text-yellow-500">En cours</p>
          </div>
          <p class="text-gray-600 text-sm">Date : 5 janvier 2025</p>
        </li>
      </ul>
      <div class="mt-6 text-center">
        <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Voir toutes mes commandes</button>
      </div>
    </div>

    <!-- Articles favoris -->
    <div class="bg-white shadow-lg rounded-lg p-8">
      <h2 class="text-2xl font-bold mb-6 border-b pb-4">Mes favoris</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-gray-100 rounded-lg shadow-md p-4">
          <img src="../assets/img/favori1.jpg" alt="Favori 1" class="rounded-md w-full h-40 object-cover">
          <p class="text-gray-900 font-bold mt-4">Épice spéciale</p>
          <button class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-2 hover:bg-blue-600">Voir l'article</button>
        </div>
        <div class="bg-gray-100 rounded-lg shadow-md p-4">
          <img src="../assets/img/favori2.jpg" alt="Favori 2" class="rounded-md w-full h-40 object-cover">
          <p class="text-gray-900 font-bold mt-4">Mélange d'épices</p>
          <button class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-2 hover:bg-blue-600">Voir l'article</button>
        </div>
      </div>
    </div>

    <!-- Articles sauvegardés -->
    <div class="bg-white shadow-lg rounded-lg p-8">
      <h2 class="text-2xl font-bold mb-6 border-b pb-4">Mes articles sauvegardés</h2>
      <ul class="divide-y divide-gray-200">
        <li class="py-4 flex justify-between items-center">
          <p class="text-gray-900 font-bold">Sauce épicée au piment</p>
          <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Voir l'article</button>
        </li>
        <li class="py-4 flex justify-between items-center">
          <p class="text-gray-900 font-bold">Mélange spécial pour barbecue</p>
          <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Voir l'article</button>
        </li>
      </ul>
    </div>
  </main>

</body>
</html>


<?php
include('../templates/footer.php');
?>
