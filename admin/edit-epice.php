<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

// Récupérer l'ID de l'épice à modifier
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

// Récupérer les catégories existantes
$query = "SELECT id, nom_categorie FROM categorie_epice";
$result = mysqli_query($conn, $query);
$categories = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

// Gérer la mise à jour
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom_epice = $_POST['nom_epice'];
    $poids_net = $_POST['poids_net'];
    $prix = $_POST['prix'];
    $categorie_id = $_POST['categorie_id'];
    $epicerie_nom = $_POST['epicerie_nom'];
    $horaires = $_POST['horaires'];
    $adresse = $_POST['adresse'];
    $contact_epicerie = $_POST['contact_epicerie'];

    // Vérifier la disponibilité (ajouter une valeur par défaut)
    $disponibilite = isset($_POST['disponibilite']) ? implode(',', $_POST['disponibilite']) : 'en_rupture';

    // Vérifier que la valeur est valide
    if (!in_array($disponibilite, ['en_stock', 'en_rupture'])) {
        $disponibilite = 'en_rupture';
    }

    // Gestion des mots-clés
    $mots_cles = isset($_POST['mots_cles']) ? implode(',', $_POST['mots_cles']) : '';

    // Récupérer les détails de l'épice
    $details = $_POST['details'];

    // Gestion de l'image
    if (isset($_FILES['image_epice']) && $_FILES['image_epice']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = './uploads/';
        $file_name = uniqid() . '_' . basename($_FILES['image_epice']['name']);
        $upload_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['image_epice']['tmp_name'], $upload_file)) {
            $image_epice = $file_name;
        } else {
            $image_epice = $epice['image_epice'];
        }
    } else {
        $image_epice = $epice['image_epice'];
    }

    // Préparer la requête de mise à jour
    $update_sql = "UPDATE epicerie 
                   SET nom_epice = ?, poids_net = ?, prix = ?, categorie_id = ?, 
                       epicerie_nom = ?, horaires = ?, adresse = ?, contact_epicerie = ?, 
                       disponibilite = ?, mots_cles = ?, details = ?, image_epice = ?
                   WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, 'sdsissssssssi', 
        $nom_epice, $poids_net, $prix, $categorie_id, 
        $epicerie_nom, $horaires, $adresse, $contact_epicerie, 
        $disponibilite, $mots_cles, $details, $image_epice, $id);

    // Exécuter la mise à jour
    if (mysqli_stmt_execute($stmt)) {
        $message = '<p class="text-green-500" id="success-message">Mise à jour effectuée avec succès.</p>';
        echo "<script>
                setTimeout(() => {
                    window.location.href = window.location.href;
                }, 3000);
              </script>";
    } else {
        $message = '<p class="text-red-500">Erreur lors de la mise à jour.</p>';
    }
    mysqli_stmt_close($stmt);
}
?>


<div class="flex min-h-screen">
<?php include('sidebar2.php'); ?>
<div class="flex-1 p-6 flex flex-col items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-lg font-bold mb-4 text-center">Modifier une Épice</h2>
    
    <!-- Message de succès ou d'erreur -->
    <?= $message ?>

    <!-- Formulaire de mise à jour -->
    <form id="edit-product-form" class="space-y-4" method="post">
      <div class="flex items-center mb-4">
        <label for="nom_epice" class="block text-gray-700 font-medium mr-2">Nom de l'épice :</label>
        <input type="text" id="nom_epice" name="nom_epice" value="<?= htmlspecialchars($epice['nom_epice']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <div class="flex flex-col mb-4">
        <label for="image_epice" class="block text-gray-700 font-medium mb-2">Image de l'épice :</label>
        <img src="./uploads/<?= htmlspecialchars($epice['image_epice']) ?>" alt="Image de l'épice" class="w-32 h-32 object-cover rounded-lg shadow-md">
        <input type="file" id="image_epice" name="image_epice" class="mt-2">
      </div>

      <div class="flex items-center mb-4">
        <label for="poids_net" class="block text-gray-700 font-medium mr-2">Poids net :</label>
        <input type="number" id="poids_net" name="poids_net" value="<?= htmlspecialchars($epice['poids_net']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <div class="flex items-center mb-4">
        <label for="prix" class="block text-gray-700 font-medium mr-2">Prix :</label>
        <input type="number" id="prix" name="prix" value="<?= htmlspecialchars($epice['prix']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <div class="flex items-center mb-4">
        <label for="categorie_id" class="block text-gray-700 font-medium mr-2">Catégorie :</label>
        <select id="categorie_id" name="categorie_id" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
          <option value="">Sélectionnez une catégorie</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category['id']) ?>" <?= $category['id'] == $epice['categorie_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($category['nom_categorie']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="flex items-center mb-4">
        <label for="epicerie_nom" class="block text-gray-700 font-medium mr-2">Épicerie :</label>
        <input type="text" id="epicerie_nom" name="epicerie_nom" value="<?= htmlspecialchars($epice['epicerie_nom']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <div class="flex items-center mb-4">
        <label for="horaires" class="block text-gray-700 font-medium mr-2">Horaires :</label>
        <input type="text" id="horaires" name="horaires" value="<?= htmlspecialchars($epice['horaires']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <div class="flex items-center mb-4">
        <label for="adresse" class="block text-gray-700 font-medium mr-2">Adresse :</label>
        <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($epice['adresse']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <div class="flex items-center mb-4">
        <label for="contact_epicerie" class="block text-gray-700 font-medium mr-2">Contact épicerie :</label>
        <input type="text" id="contact_epicerie" name="contact_epicerie" value="<?= htmlspecialchars($epice['contact_epicerie']) ?>" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <div class="flex items-center mb-4">
        <label class="block text-gray-700 font-medium mr-2">Disponibilité :</label>
        <div class="flex space-x-4">
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="disponibilite[]" value="en_stock" <?= strpos($epice['disponibilite'], 'en_stock') !== false ? 'checked' : '' ?>>
            <span>En stock</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="disponibilite[]" value="en_rupture" <?= strpos($epice['disponibilite'], 'en_rupture') !== false ? 'checked' : '' ?>>
            <span>En rupture de stock</span>
          </label>
        </div>
      </div>

      <div class="flex items-center mb-4">
        <span class="block text-gray-700 font-medium mr-2">Mots-clés :</span>
        <div class="flex space-x-4">
          <?php foreach (explode(',', $epice['mots_cles']) as $mot_cle): ?>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="mots_cles[]" value="<?= htmlspecialchars(trim($mot_cle)) ?>" checked>
              <span><?= htmlspecialchars(trim($mot_cle)) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="mb-4">
        <label for="details" class="block text-gray-700 font-medium mb-2">Détails de l'épice :</label>
        <div id="details"><?= htmlspecialchars_decode($epice['details']) ?></div>
        <!-- Champ caché pour envoyer les données -->
        <textarea name="details" id="details-hidden" style="display: none;"><?= htmlspecialchars($epice['details']) ?></textarea>
      </div>

      <div class="flex justify-center">
        <button type="submit" class="btn-gradient text-white py-2 px-4 rounded-lg">Enregistrer</button>
      </div>
    </form>
    <div class="mb-4 mt-4 text-center">
  <a href="vew-liste-product.php" class="btn-gradient text-white py-2 px-4 rounded-lg">Retour à la liste</a>
</div>
  </div>
</div>
<?php include('./templates/footer.php'); ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const quillDescription = new Quill("#details", {
        theme: "snow",
        modules: {
            toolbar: [["bold", "italic", "underline"], [{ header: 1 }, { header: 2 }], [{ list: "ordered" }, { list: "bullet" }], ["link", "image"], [{ size: [] }]]
        }
    });

    const editProductForm = document.getElementById("edit-product-form");
    const hiddenDetailsField = document.getElementById("details-hidden");

    editProductForm.addEventListener("submit", function() {
        hiddenDetailsField.value = quillDescription.root.innerHTML;
    });
});
</script>