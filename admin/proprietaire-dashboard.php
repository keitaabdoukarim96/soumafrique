<?php
include('./templates/header.php');
session_start(); // Démarrer la session pour récupérer les données
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}


?>

<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2">

    <nav class="text-sm">
      <!-- Dashboard -->
      <a href="admin-dashboard.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
      </a>
      <!-- Gestion des boutiques -->
      <div class="group">
          <a href="add-product.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700 " >
            <i class="fas fa-plus mr-3"></i> Ajouter un produit
          </a>
        </div>
      </div>
      <!-- Catégories d'épices -->


     
      <!-- Déconnexion -->
      <a href="logout.php" class="flex items-center py-2 px-4 rounded hover:bg-red-600">
        <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
      </a>
    </nav>
  </aside>


  
</div>

<?php
include('./templates/footer.php');
?>