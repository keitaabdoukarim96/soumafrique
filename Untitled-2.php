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
      <a href="admin-dashboard.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700" data-link="admin-dashboard.php">
        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
      </a>

      <!-- Gestion des boutiques -->
      <div class="menu-group" data-group="boutiques">
        <a href="#" class="menu-item parent flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-store mr-3"></i> Gestion des boutiques
          <i class="fas fa-chevron-down ml-auto"></i>
        </a>
        <div class="submenu hidden pl-8 space-y-2">
          <a href="boutique-valider.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700" data-link="boutique-valider.php">
            <i class="fas fa-tools mr-3"></i> Boutique validée
          </a>
          <a href="validate-shop.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700" data-link="validate-shop.php">
            <i class="fas fa-check-circle mr-3"></i> Valider une boutique
          </a>
        </div>
      </div>

      <!-- Catégories d'épices -->
      <div class="menu-group" data-group="epices">
        <a href="#" class="menu-item parent flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-leaf mr-3"></i> Catégories d'épices
          <i class="fas fa-chevron-down ml-auto"></i>
        </a>
        <div class="submenu hidden pl-8 space-y-2">
          <a href="view-spice-categories.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700" data-link="view-spice-categories.php">
            <i class="fas fa-list mr-3"></i> Voir les catégories
          </a>
          <a href="add-spice-category.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700" data-link="add-spice-category.php">
            <i class="fas fa-plus mr-3"></i> Ajouter une catégorie
          </a>
          <a href="add-product.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700" data-link="add-product.php">
            <i class="fas fa-plus mr-3"></i> Ajouter une Épice
          </a>
          <a href="vew-liste-product.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700" data-link="vew-liste-product.php">
            <i class="fas fa-eye mr-3"></i> Voir les Épices
          </a>
        </div>
      </div>

      <!-- Les recettes -->
      <div class="menu-group" data-group="recettes">
        <a href="#" class="menu-item parent flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-utensils mr-3"></i> Les recettes
          <i class="fas fa-chevron-down ml-auto"></i>
        </a>
        <div class="submenu hidden pl-8 space-y-2">
          <a href="vew-liste-recette.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700" data-link="vew-liste-recette.php">
            <i class="fas fa-eye mr-3"></i> Voir les recettes
          </a>
          <a href="view-recipe-categories.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700" data-link="view-recipe-categories.php">
            <i class="fas fa-list mr-3"></i> Voir les catégories de recettes
          </a>
          <a href="add-recette.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700" data-link="add-recette.php">
            <i class="fas fa-plus mr-3"></i> Ajouter une recette
          </a>
        </div>
      </div>

      <!-- Commandes -->
      <div class="menu-group" data-group="commandes">
        <a href="#" class="menu-item parent flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-box mr-3"></i> Commandes
          <i class="fas fa-chevron-down ml-auto"></i>
        </a>
        <div class="submenu hidden pl-8 space-y-2">
          <a href="#" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-tasks mr-3"></i> Gérer les commandes
          </a>
        </div>
      </div>

      <!-- Livraison -->
      <div class="menu-group" data-group="livraison">
        <a href="#" class="menu-item parent flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-truck mr-3"></i> Livraison
          <i class="fas fa-chevron-down ml-auto"></i>
        </a>
        <div class="submenu hidden pl-8 space-y-2">
          <a href="#" class="menu-item flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-spinner mr-3"></i> Gérer les Livraisons
          </a>
        </div>
      </div>

    <?php endif; ?>

    <!-- Déconnexion -->
    <a href="logout.php" class="menu-item flex items-center py-2 px-4 rounded hover:bg-red-600">
      <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
    </a>
  </nav>
</aside>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const currentPage = window.location.pathname.split("/").pop();
    const menuItems = document.querySelectorAll(".menu-item");
    const menuGroups = document.querySelectorAll(".menu-group");

    menuItems.forEach(item => {
        if (item.getAttribute("data-link") === currentPage) {
            item.classList.add("bg-red-500");
            let parentGroup = item.closest(".menu-group");
            if (parentGroup) {
                parentGroup.classList.add("open");
                parentGroup.querySelector(".submenu").style.display = "block";
            }
        }
    });
});
</script>
