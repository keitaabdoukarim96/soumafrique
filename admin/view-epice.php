<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

// Récupérer l'ID de l'épice à afficher
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    die("Épice non trouvée.");
}

// Récupérer les informations de l'épice
$sql = "SELECT * FROM epicerie WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    die("Épice non trouvée.");
}

$epice = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Récupérer les catégories existantes depuis la table categorie_epice
$query = "SELECT id, nom_categorie FROM categorie_epice";
$result = mysqli_query($conn, $query);
$categories = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}
?>

<div class="flex min-h-screen">
<?php include('sidebar2.php'); ?>
<div class="flex-1 p-6 flex flex-col items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-lg font-bold mb-4 text-center">Voir une Épice</h2>

    <!-- Formulaire en mode lecture -->
    <form id="view-product-form" class="space-y-4">
      <!-- Nom de l'épice -->
      <div class="flex items-center mb-4">
        <label for="nom_epice" class="block text-gray-700 font-medium mr-2">Nom de l'épice :</label>
        <input type="text" id="nom_epice" name="nom_epice" value="<?= htmlspecialchars($epice['nom_epice']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500" readonly>
      </div>

      <!-- Image de l'épice -->
      <div class="flex flex-col mb-4">
        <label for="image_epice" class="block text-gray-700 font-medium mb-2">Image de l'épice :</label>
        <img src="./uploads/<?= htmlspecialchars($epice['image_epice']) ?>" alt="Image de l'épice" class="w-32 h-32 object-cover rounded-lg shadow-md">
      </div>

      <!-- Poids net -->
      <div class="flex items-center mb-4">
        <label for="poids_net" class="block text-gray-700 font-medium mr-2">Poids net :</label>
        <input type="number" id="poids_net" name="poids_net" value="<?= htmlspecialchars($epice['poids_net']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500" readonly>
      </div>

      <!-- Prix -->
      <div class="flex items-center mb-4">
        <label for="prix" class="block text-gray-700 font-medium mr-2">Prix :</label>
        <input type="number" id="prix" name="prix" value="<?= htmlspecialchars($epice['prix']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500" readonly>
      </div>

      <!-- Catégorie -->
      <div class="flex items-center mb-4">
        <label for="categorie_id" class="block text-gray-700 font-medium mr-2">Catégorie :</label>
        <select id="categorie_id" name="categorie_id" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500" disabled>
          <option value="">Sélectionnez une catégorie</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category['id']) ?>" <?= $category['id'] == $epice['categorie_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($category['nom_categorie']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Épicerie -->
      <div class="flex items-center mb-4">
        <label for="epicerie_nom" class="block text-gray-700 font-medium mr-2">Épicerie :</label>
        <input type="text" id="epicerie_nom" name="epicerie_nom" value="<?= htmlspecialchars($epice['epicerie_nom']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500" readonly>
      </div>

      <!-- Horaires -->
      <div class="flex items-center mb-4">
        <label for="horaires" class="block text-gray-700 font-medium mr-2">Horaires :</label>
        <input type="text" id="horaires" name="horaires" value="<?= htmlspecialchars($epice['horaires']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500" readonly>
      </div>

      <!-- Adresse -->
      <div class="flex items-center mb-4">
        <label for="adresse" class="block text-gray-700 font-medium mr-2">Adresse :</label>
        <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($epice['adresse']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500" readonly>
      </div>

      <!-- Contact épicerie -->
      <div class="flex items-center mb-4">
        <label for="contact_epicerie" class="block text-gray-700 font-medium mr-2">Contact épicerie :</label>
        <input type="text" id="contact_epicerie" name="contact_epicerie" value="<?= htmlspecialchars($epice['contact_epicerie']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500" readonly>
      </div>

      <!-- Disponibilité -->
      <div class="flex items-center mb-4">
        <span class="block text-gray-700 font-medium mr-2">Disponibilité :</span>
        <div class="flex space-x-4">
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="disponibilite[]" value="en_stock" <?= strpos($epice['disponibilite'], 'en_stock') !== false ? 'checked' : '' ?> disabled>
            <span>En stock</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="disponibilite[]" value="en_rupture" <?= strpos($epice['disponibilite'], 'en_rupture') !== false ? 'checked' : '' ?> disabled>
            <span>En rupture de stock</span>
          </label>
        </div>
      </div>

      <!-- Hashtags -->
      <div class="flex items-center mb-4">
        <span class="block text-gray-700 font-medium mr-2">Mots-clés :</span>
        <div class="flex space-x-4">
          <?php foreach (explode(',', $epice['mots_cles']) as $mot_cle): ?>
            <span class="bg-gray-200 px-2 py-1 rounded-lg"><?= htmlspecialchars($mot_cle) ?></span>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Détails de l'épice -->
      <div class="mb-4">
        <label for="details" class="block text-gray-700 font-medium mb-2">Détails de l'épice :</label>
        <div class="w-full border rounded-lg p-2">
        <?= htmlspecialchars_decode($epice['details']) ?>
        </div>
      </div>
    </form>
    <div class="mb-4 mt-4 text-center">
  <a href="vew-liste-product.php" class="btn-gradient text-white py-2 px-4 rounded-lg">Retour à la liste</a>
</div>
  </div>
</div>
<?php include('./templates/footer.php'); ?>
