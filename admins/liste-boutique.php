<?php

session_start(); // Démarrer la session pour récupérer les données
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: admin-login.php");
  exit;
}
?>


<?php include('header.php'); ?>
<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2">

    <nav class="text-sm">
      <!-- Dashboard -->
      <a href="admin-dashboard.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
      </a>

      <!-- Gestion des utilisateurs -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-users mr-3"></i> Gestion des utilisateurs
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700 " id="add-user-link">
            <i class="fas fa-user-plus mr-3"></i> Ajouter un utilisateur
          </a>
          <a href="liste-clients.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-users-cog mr-3"></i> Voir les utilisateurs
          </a>
        </div>
      </div>
      <!-- Catégories d'épices -->

      <!-- Gestion des boutiques -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-store mr-3"></i> Gestion des boutiques
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="liste-boutique.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="manage-shops-link">
            <i class="fas fa-tools mr-3"></i> Gérer les boutiques
          </a>
          <a href="valider-boutique.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="validate-shop-link">
            <i class="fas fa-check-circle mr-3"></i> Valider une boutique
          </a>
          <a href="ajouter-boutique.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700 " id="add-product-link">
            <i class="fas fa-plus mr-3"></i> Ajouter un produit
          </a>
        </div>
      </div>
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-leaf mr-3"></i> Catégories d'épices
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="view-spice-categories-link">
            <i class="fas fa-list mr-3"></i> Voir les catégories
          </a>
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="add-spice-category-link">
            <i class="fas fa-plus mr-3"></i> Ajouter une catégorie
          </a>
        </div>
      </div>
      <!-- Les recettes -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-utensils mr-3"></i> Les recettes
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="view-recipe-categories-link">
            <i class="fas fa-list mr-3"></i> Voir les catégories de recettes
          </a>
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="add-recipe-link">
            <i class="fas fa-plus mr-3"></i> Ajouter une recette
          </a>
        </div>
      </div>
      <!-- Les rôles -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-user-tag mr-3"></i> Les rôles
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="view-roles-link">
            <i class="fas fa-eye mr-3"></i> Voir les rôles
          </a>
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="add-role-link">
            <i class="fas fa-user-shield mr-3"></i> Ajouter un rôle
          </a>
        </div>
      </div>

      <!-- Commandes -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-box mr-3"></i> Commandes
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="manage-orders-link">
            <i class="fas fa-tasks mr-3"></i> Gérer les commandes
          </a>

        </div>
      </div>

      <!-- Livraison -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-truck mr-3"></i> Livraison
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="manage-deliveries-link">
            <i class="fas fa-spinner mr-3"></i> Gérer les Livraisons
          </a>

        </div>
      </div>

      <!-- Déconnexion -->
      <a href="logout.php" class="flex items-center py-2 px-4 rounded hover:bg-red-600">
        <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
      </a>
    </nav>
  </aside>
  <!-- Contenu principal -->
  <main class="flex-1 bg-gray-100 p-6">
    <div id="dynamic-content">
      <h1 class="text-2xl font-bold mb-6">Bienvenue sur le Dashboard, <span class="text-red-600"><?php echo htmlspecialchars($_SESSION["nom"]); ?></span></h1>

      <div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-4xl">
    <h2 class="text-lg font-bold mb-4 text-center">Liste des boutiques</h2>
    <table class="min-w-full text-sm border border-gray-300">
      <thead class="bg-gray-200 text-gray-600 uppercase text-xs">
      <th class="py-3 px-4 text-left border-b">Nom et Prénom</th>
            <th class="py-3 px-4 text-left border-b">Email</th>
            <th class="py-3 px-4 text-left border-b">Nom de la Boutique</th>
            <th class="py-3 px-4 text-left border-b">Adresse de la Boutique</th>
            <th class="py-3 px-4 text-left border-b">Horaires d'Ouverture</th>
            <th class="py-3 px-4 text-left border-b">Contact</th>
            <th class="py-3 px-4 text-center border-b">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <!-- Données statiques pour le tableau -->
        <?php for ($i = 1; $i <= 5; $i++) : ?>
          <tr class="border-b hover:bg-gray-100">
            <td class="py-3 px-4">Nom et Prénom <?= $i ?></td>
            <td class="py-3 px-4">Email<?= $i ?></td>
            <td class="py-3 px-4">Nom de la Boutique<?= $i ?></td>
            <td class="py-3 px-4">Adresse de la Boutique<?= $i ?></td>
            <td class="py-3 px-4">08h-18h</td>
            <td class="py-3 px-4">+33 6 12 34 56 78 <?= $i ?></td>
            <td class="py-3 px-4 text-center">
              <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs">Voir</button>
              <button class="bg-yellow-500 text-white py-1 px-2 rounded text-xs">Modifier</button>
              <button class="bg-red-500 text-white py-1 px-2 rounded text-xs">Supprimer</button>
            </td>
          </tr>
        <?php endfor; ?>
      </tbody>
    </table>

    <!-- Pagination statique -->
    <div class="flex justify-end mt-4">
      <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-l">Précédent</button>
      <button class="bg-blue-500 text-white py-1 px-3">1</button>
      <button class="bg-gray-300 text-gray-700 py-1 px-3">2</button>
      <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-r">Suivant</button>
    </div>
  </div>
</div>

      
    </div>
  </main>
</div>
</body>

</html>