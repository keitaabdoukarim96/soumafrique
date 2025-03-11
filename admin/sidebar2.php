<?php
// Démarre la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? null;
?>

<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2" id="sidebar">

    <nav class="text-sm">
      <?php if ($role === 'admin_role'): ?>
        <a href="admin-dashboard.php" class="menu-item" data-group="dashboard">
          <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
        </a>

        <!-- Gestion des boutiques -->
        <div class="menu-group" data-group="boutiques">
          <a href="#" class="menu-item parent">
            <i class="fas fa-store mr-3"></i> Gestion des boutiques
            <i class="fas fa-chevron-down ml-auto"></i>
          </a>
          <div class="submenu">
            <a href="boutique-valider.php" class="menu-item">
                <i class="fas fa-check-circle mr-3"></i> Boutique validée
            </a>
            <a href="validate-shop.php" class="menu-item">
                <i class="fas fa-user-check mr-3"></i> Valider une boutique
            </a>
        </div>

        </div>

        <!-- Catégories d'épices -->
        <div class="menu-group" data-group="epices">
          <a href="#" class="menu-item parent">
            <i class="fas fa-leaf mr-3"></i> Catégories d'épices
            <i class="fas fa-chevron-down ml-auto"></i>
          </a>
          <div class="submenu">
              <a href="view-spice-categories.php" class="menu-item">
                  <i class="fas fa-list mr-3"></i> Voir les catégories
              </a>
              <a href="add-spice-category.php" class="menu-item">
                  <i class="fas fa-plus-circle mr-3"></i> Ajouter une catégorie
              </a>
              <a href="add-product.php" class="menu-item">
                  <i class="fas fa-pepper-hot mr-3"></i> Ajouter une Épice
              </a>
              <a href="vew-liste-product.php" class="menu-item">
                  <i class="fas fa-eye mr-3"></i> Voir les Épices
              </a>
          </div>

        </div>

        <!-- Les recettes -->
        <div class="menu-group" data-group="epices">
          <a href="#" class="menu-item parent">
            <i class="fas fa-utensils mr-3"></i> Les recettes
            <i class="fas fa-chevron-down ml-auto"></i>
          </a>
          <div class="submenu">
            <a href="vew-liste-recette.php" class="menu-item"><i class="fas fa-list mr-3"></i>Voir les recettes</a>
            <a href="view-recipe-categories.php" class="menu-item"><i class="fas fa-list mr-3"></i>catégories de recettes</a>
            <a href="add-recette.php" class="menu-item"><i class="fas fa-plus mr-3"></i>Ajouter une recette</a>
          </div>
        </div>

        <!-- Gestion des utilisateurs -->
        <div class="menu-group" data-group="users">
          <a href="#" class="menu-item parent">
            <i class="fas fa-users mr-3"></i> Gestion des Sous Admins
            <i class="fas fa-chevron-down ml-auto"></i>
          </a>
          <div class="submenu">
            <a href="add-sous-admin.php" class="menu-item"><i class="fas fa-plus mr-3"></i>Ajouter un Sous Admin</a>
            <a href="view-sous-admin.php" class="menu-item"><i class="fas fa-list mr-3"></i>Voir les Sous Admins</a>
          </div>
        </div>

        <!-- Commandes -->
        <div class="menu-group" data-group="orders">
            <a href="#" class="menu-item parent">
                <i class="fas fa-box mr-3"></i> Commandes
                <i class="fas fa-chevron-down ml-auto"></i>
            </a>
            <div class="submenu">
                <a href="all-orders.php" class="menu-item">
                    <i class="fas fa-list mr-3"></i> Toutes les commandes
                </a>
                <a href="pending-orders.php" class="menu-item">
                    <i class="fas fa-clock mr-3"></i> Commandes en attente
                </a>
                <a href="in-progress-orders.php" class="menu-item">
                    <i class="fas fa-truck-loading mr-3"></i> Commandes en cours
                </a>
                <a href="completed-orders.php" class="menu-item">
                    <i class="fas fa-check-circle mr-3"></i> Commandes terminées
                </a>
                <a href="cancelled-orders.php" class="menu-item">
                    <i class="fas fa-times-circle mr-3"></i> Commandes annulées
                </a>
                <a href="orders-statistics.php" class="menu-item">
                    <i class="fas fa-chart-line mr-3"></i> Statistiques des commandes
                </a>
            </div>
        </div>

       <!-- Livraison -->
        <div class="menu-group" data-group="delivery">
            <a href="#" class="menu-item parent">
                <i class="fas fa-truck mr-3"></i> Livraison
                <i class="fas fa-chevron-down ml-auto"></i>
            </a>
            <div class="submenu">
                <a href="all-deliveries.php" class="menu-item">
                    <i class="fas fa-list mr-3"></i> Toutes les livraisons
                </a>
                <a href="pending-deliveries.php" class="menu-item">
                    <i class="fas fa-clock mr-3"></i> Livraisons en attente
                </a>
                <a href="in-progress-deliveries.php" class="menu-item">
                    <i class="fas fa-shipping-fast mr-3"></i> Livraisons en cours
                </a>
                <a href="completed-deliveries.php" class="menu-item">
                    <i class="fas fa-check-circle mr-3"></i> Livraisons terminées
                </a>
                <a href="cancelled-deliveries.php" class="menu-item">
                    <i class="fas fa-times-circle mr-3"></i> Livraisons annulées
                </a>
                <a href="assign-delivery.php" class="menu-item">
                    <i class="fas fa-user-tag mr-3"></i> Assigner une livraison
                </a>
                <a href="delivery-partners.php" class="menu-item">
                    <i class="fas fa-motorcycle mr-3"></i> Partenaires de livraison
                </a>
                <a href="delivery-statistics.php" class="menu-item">
                    <i class="fas fa-chart-line mr-3"></i> Statistiques des livraisons
                </a>
            </div>
        </div>

      <?php else: ?>
        <a href="add-product.php" class="menu-item"><i class="fas fa-plus mr-3"></i>Ajouter un produit</a>
        <a href="liste-product-proprietaire.php" class="menu-item"><i class="fas fa-list mr-3"></i>Voir la liste des épices</a>
      <?php endif; ?>

      <!-- Contact -->
<div class="group">
    <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
        <i class="fas fa-envelope mr-3"></i> Contact
        <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
    </a>
    <div class="hidden pl-8 space-y-2 group-hover:block">
        <a href="admin_messages.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-inbox mr-3"></i> Gérer les Messages
        </a>
    </div>
</div>


      <a href="logout.php" class="menu-item logout">
        <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
      </a>
    </nav>
  </aside>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.pathname.split("/").pop(); // Récupère le fichier actuel
    const menuItems = document.querySelectorAll(".menu-item");
    const menuGroups = document.querySelectorAll(".menu-group");

    menuItems.forEach(item => {
        if (item.getAttribute("href") === currentUrl) {
            item.classList.add("active");

            // Vérifier si l'élément appartient à un sous-menu
            let parentGroup = item.closest(".menu-group");
            if (parentGroup) {
                parentGroup.classList.add("open");
                parentGroup.querySelector(".submenu").style.display = "block";
            }
        }
    });

    // Gérer le clic sur un parent pour afficher son sous-menu
    menuGroups.forEach(group => {
        const parentLink = group.querySelector(".parent");
        const submenu = group.querySelector(".submenu");

        parentLink.addEventListener("click", function (e) {
            e.preventDefault();
            const isOpen = group.classList.contains("open");

            // Fermer tous les autres groupes
            menuGroups.forEach(g => {
                g.classList.remove("open");
                g.querySelector(".submenu").style.display = "none";
            });

            // Ouvrir ou fermer le groupe actuel
            if (!isOpen) {
                group.classList.add("open");
                submenu.style.display = "block";
            }
        });
    });
});
</script>

<style>
/* Style pour les onglets actifs */
.menu-item {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background 0.3s;
}
.menu-item:hover {
    background: #374151;
}
.menu-item.active {
    background: #1f2937;
}

/* Gestion des sous-menus */
.menu-group .submenu {
    display: none;
    padding-left: 15px;
}
.menu-group.open .submenu {
    display: block;
}
.menu-group .parent {
    display: flex;
    align-items: center;
    cursor: pointer;
}
.menu-group .parent i {
    transition: transform 0.3s;
}
.menu-group.open .parent i {
    transform: rotate(180deg);
}
</style>
