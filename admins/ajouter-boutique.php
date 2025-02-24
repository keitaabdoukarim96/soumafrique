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
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-lg font-bold mb-4 text-center">Ajouter un produit</h2>
    <form id="add-product-form">
      <!-- Nom de l'épice -->
      <div class="mb-4">
        <label for="product-name" class="block text-gray-700 font-medium mb-2">Nom de l'épice :</label>
        <input type="text" id="product-name" name="product_name" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Boutique -->
      <div class="mb-4">
        <label for="shop-name" class="block text-gray-700 font-medium mb-2">Boutique :</label>
        <input type="text" id="shop-name" name="shop_name" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Adresse -->
      <div class="mb-4">
        <label for="address" class="block text-gray-700 font-medium mb-2">Adresse :</label>
        <input type="text" id="address" name="address" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Horaires -->
      <div class="mb-4">
        <label for="schedule" class="block text-gray-700 font-medium mb-2">Horaires :</label>
        <input type="text" id="schedule" name="schedule" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Catégorie -->
      <div class="mb-4">
        <label for="category" class="block text-gray-700 font-medium mb-2">Catégorie :</label>
        <select id="category" name="category" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
          <option value="">Sélectionnez une catégorie</option>
          <option value="epices-entieres">Épices entières</option>
          <option value="epices-moulues">Épices moulues ou en poudre</option>
          <option value="herbes-aromatiques">Herbes aromatiques séchées</option>
          <option value="epices-fumees">Épices fumées ou fermentées</option>
        </select>
      </div>
      <!-- Prix -->
      <div class="mb-4">
        <label for="price" class="block text-gray-700 font-medium mb-2">Prix :</label>
        <input type="number" id="price" name="price" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <div class="mb-4">
    <label for="description" class="block text-gray-700 font-medium mb-2">Description :</label>
    <div id="editor" class="w-full border rounded-lg p-2"></div>
    <input type="hidden" id="description" name="description">
</div>
      <!-- Bouton Soumettre -->
      <div class="flex justify-center">
        <button type="submit" class="btn-gradient text-white py-2 px-4 rounded-lg ">Ajouter</button>
      </div>
    </form>
  </div>
</div>  
    </div>
  </main>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialisation de Quill
        var quill = new Quill('#editor', {
            theme: 'snow' // Thème de l'éditeur (snow ou bubble)
        });

        // Mettre à jour le champ caché lors des modifications
        quill.on('text-change', function () {
            document.querySelector("input[name='description']").value = quill.root.innerHTML;
        });

        // Vérifier si une ancienne valeur est présente (pour la modification)
        var existingDescription = document.querySelector("input[name='description']").value;
        if (existingDescription) {
            quill.root.innerHTML = existingDescription;
        }
    });
</script>

<!-- QuillJS JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script src="assets/js/app.js"></script>
</body>

</html>