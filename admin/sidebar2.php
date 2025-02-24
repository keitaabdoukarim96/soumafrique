<?php
// Démarre la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Vérifie si l'utilisateur est connecté et récupère son rôle
$role = $_SESSION['role'] ?? null; // Le rôle est récupéré de la session (défini lors de la connexion)
?>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2">

    <nav class="text-sm">
    <?php if ($role === 'admin_role'): ?>
      <!-- Dashboard -->
      <a href="admin-dashboard.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
      </a>
      <!-- Gestion des boutiques -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-store mr-3"></i> Gestion des boutiques
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="manage-shops.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" >
            <i class="fas fa-tools mr-3"></i> Gérer les boutiques
          </a>
          <a href="validate-shop.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-check-circle mr-3"></i> Valider une boutique
          </a>
          <a href="add-product.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700 " >
            <i class="fas fa-plus mr-3"></i> Ajouter un produit
          </a>
        </div>
      </div>
      <!-- Catégories d'épices -->


      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-leaf mr-3"></i> Catégories d'épices
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" >
            <i class="fas fa-list mr-3"></i> Voir les catégories
          </a>
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" >
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
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" >
            <i class="fas fa-list mr-3"></i> Voir les catégories de recettes
          </a>
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" >
            <i class="fas fa-plus mr-3"></i> Ajouter une recette
          </a>
        </div>
      </div>
      <!-- Gestion des utilisateurs -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-users mr-3"></i> Gestion des utilisateurs
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700 " >
            <i class="fas fa-user-plus mr-3"></i> Ajouter un utilisateur
          </a>
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" >
            <i class="fas fa-users-cog mr-3"></i> Voir les utilisateurs
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
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" >
            <i class="fas fa-eye mr-3"></i> Voir les rôles
          </a>
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" >
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
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" >
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
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-spinner mr-3"></i> Gérer les Livraisons
          </a>

        </div>
      </div>
      <?php else: ?>
        <!-- Autres utilisateurs : seulement "Ajouter un produit" -->
        <a href="add-product.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-plus mr-3"></i> Ajouter un produit
        </a>
      <?php endif; ?>

      <!-- Déconnexion -->
      <a href="logout.php" class="flex items-center py-2 px-4 rounded hover:bg-red-600">
        <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
      </a>
    </nav>
  </aside>


  
</div>