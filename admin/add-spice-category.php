<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

// Traitement du formulaire
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les valeurs du formulaire
    $nom_categorie = $_POST['category_name'] ?? '';
    $sous_categorie = $_POST['subcategories'] ?? '';

    // Vérification des champs
    if (!empty($nom_categorie) && !empty($sous_categorie)) {
        // Sécurisation des entrées
        $nom_categorie = mysqli_real_escape_string($conn, trim($nom_categorie));
        $sous_categorie = mysqli_real_escape_string($conn, trim($sous_categorie));

        // Requête SQL d'insertion
        $sql = "INSERT INTO categorie_epice (nom_categorie, sous_categorie) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $nom_categorie, $sous_categorie);

        if (mysqli_stmt_execute($stmt)) {
            $message = "<p class='text-green-500 text-center'>✅ Catégorie ajoutée avec succès !</p>";

            // Attendre quelques secondes avant de recharger la page
            echo "<script>
                setTimeout(() => {
                    window.location.href = window.location.href;
                }, 2000);
                </script>";
        } else {
            $message = "<p class='text-red-500 text-center'>❌ Erreur lors de l'ajout : " . mysqli_error($conn) . "</p>";
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "<p class='text-orange-500 text-center'>⚠️ Veuillez remplir tous les champs.</p>";
    }
}
?>

<div class="flex min-h-screen">
<?php include('sidebar2.php'); ?>
<div class="flex-1 p-6 flex flex-col items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-lg font-bold mb-4 text-center">Ajouter une catégorie d'épices</h2>

    <!-- Message de succès ou d'erreur -->
    <?= isset($message) ? $message : ''; ?>

    <!-- Formulaire -->
    <form id="add-category-form" method="post" class="space-y-4">
      <!-- Nom de la catégorie -->
      <div>
        <label for="category-name" class="block text-gray-700 font-medium mb-2">Nom de la catégorie :</label>
        <input type="text" id="category-name" name="category_name" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
      </div>

      <!-- Sous-catégories -->
      <div>
        <label for="subcategories" class="block text-gray-700 font-medium mb-2">Sous-catégories (séparées par une virgule) :</label>
        <textarea id="subcategories" name="subcategories" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" rows="3" placeholder="Exemple : Graines, Baies" required></textarea>
      </div>

      <!-- Bouton Soumettre -->
      <div class="flex justify-center">
        <button type="submit" class="btn-gradient text-white py-2 px-4 rounded-lg">Ajouter</button>
      </div>
    </form>
  </div>
</div>
</div>
<?php include('./templates/footer.php'); ?>
