<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

// Récupérer l'ID de la catégorie à modifier
$id = $_GET['id'] ?? null;
$category_name = '';
$subcategories = '';
$message = '';

if ($id) {
    // Récupérer les données de la catégorie depuis la base de données
    $query = "SELECT nom_categorie, sous_categorie FROM categorie_epice WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $category_name, $subcategories);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_category_name = trim($_POST['category_name']);
    $new_subcategories = trim($_POST['subcategories']);

    if (!empty($new_category_name) && !empty($new_subcategories)) {
        // Mettre à jour la catégorie dans la base de données
        $update_query = "UPDATE categorie_epice SET nom_categorie = ?, sous_categorie = ? WHERE id = ?";
        if ($update_stmt = mysqli_prepare($conn, $update_query)) {
            mysqli_stmt_bind_param($update_stmt, 'ssi', $new_category_name, $new_subcategories, $id);
            if (mysqli_stmt_execute($update_stmt)) {
                $message = '<p class="text-green-500">Mise à jour effectuée avec succès !</p>';
                // Mettre à jour les variables pour refléter les nouvelles données
                $category_name = $new_category_name;
                $subcategories = $new_subcategories;
                echo "<script>
                      setTimeout(() => {
                          window.location.href = window.location.href;
                      }, 2000);
                      </script>";
            } else {
                $message = '<p class="text-red-500">Erreur lors de la mise à jour. Veuillez réessayer.</p>';
            }
            mysqli_stmt_close($update_stmt);
        }
    } else {
        $message = '<p class="text-red-500">Veuillez remplir tous les champs.</p>';
    }
}
?>

<div class="flex min-h-screen">
<?php include('sidebar2.php'); ?>
<div class="flex-1 p-6 flex flex-col items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-lg font-bold mb-4 text-center">Formulaire de modification</h2>

    <!-- Message de succès ou d'erreur -->
    <div id="message-container">
        <?= $message ?>
    </div>

    <!-- Formulaire -->
    <form id="add-category-form" method="post" class="space-y-4">
      <!-- Nom de la catégorie -->
      <div>
        <label for="category-name" class="block text-gray-700 font-medium mb-2">Nom de la catégorie :</label>
        <input type="text" id="category-name" name="category_name" value="<?= htmlspecialchars($category_name) ?>" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
      </div>

      <!-- Sous-catégories -->
      <div>
        <label for="subcategories" class="block text-gray-700 font-medium mb-2">Sous-catégories (séparées par une virgule) :</label>
        <textarea id="subcategories" name="subcategories" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" rows="3" required><?= htmlspecialchars($subcategories) ?></textarea>
      </div>

      <!-- Bouton Soumettre -->
      <div class="flex justify-center">
        <button type="submit" id="update-button" class="btn-gradient text-white py-2 px-4 rounded-lg" disabled>Mise à jour</button>
      </div>
      <!-- Nouveau bouton -->
<div class="flex justify-center mt-2">
  <button type="button" class="btn-gradient text-white py-2 px-4 rounded-lg" onclick="window.location.href='view-spice-categories.php'">Liste des catégories</button>
</div>
    </form>
  </div>
</div>
</div>
<?php include('./templates/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Faire disparaître le message après 2 secondes
  const messageContainer = document.getElementById('message-container');
  if (messageContainer) {
    setTimeout(() => {
      messageContainer.style.display = 'none';
    }, 2000);
  }

  // Activer/désactiver le bouton en fonction des modifications
  const categoryNameInput = document.getElementById('category-name');
  const subcategoriesInput = document.getElementById('subcategories');
  const updateButton = document.getElementById('update-button');

  const originalCategoryName = categoryNameInput.value;
  const originalSubcategories = subcategoriesInput.value;

  function checkForChanges() {
    if (
      categoryNameInput.value.trim() !== originalCategoryName ||
      subcategoriesInput.value.trim() !== originalSubcategories
    ) {
      updateButton.disabled = false;
    } else {
      updateButton.disabled = true;
    }
  }

  categoryNameInput.addEventListener('input', checkForChanges);
  subcategoriesInput.addEventListener('input', checkForChanges);
});
</script>
