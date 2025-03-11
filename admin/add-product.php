<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

// Vérifier si la session contient un utilisateur connecté
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}

// Récupérer l'ID de l'utilisateur connecté
$user_id = $_SESSION["id"];
$user_role = "";

// Vérifier le rôle de l'utilisateur dans la table proprietaire
$query_proprietaire = "SELECT role FROM proprietaire WHERE id = ?";
$stmt_proprietaire = $conn->prepare($query_proprietaire);
$stmt_proprietaire->bind_param("i", $user_id);
$stmt_proprietaire->execute();
$result_proprietaire = $stmt_proprietaire->get_result();

if ($row_proprietaire = $result_proprietaire->fetch_assoc()) {
    $user_role = $row_proprietaire['role'];
}
$stmt_proprietaire->close();

// Vérifier si l'utilisateur a accès au formulaire (admin ou propriétaire)
if ($user_role !== 'propriétaire' && $user_role !== 'admin_role') {
    echo "<p class='text-red-500 text-center'>Accès refusé. Vous n'avez pas les autorisations nécessaires.</p>";
    exit();
}

// Récupérer les catégories existantes depuis la table categorie_epice
$query = "SELECT id, nom_categorie FROM categorie_epice";
$result = mysqli_query($conn, $query);
$categories = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

$message = "";
// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des champs obligatoires
    $required_fields = ['nom_epice', 'poids_net', 'prix', 'epicerie_nom', 'horaires', 'adresse', 'contact_epicerie', 'categorie_id'];
    $error = false;
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $error = true;
            break;
        }
    }
    
    if ($error) {
        $message = '<p class="text-red-500">Tous les champs obligatoires doivent être remplis.</p>';
    } else {
        $nom_epice = $_POST['nom_epice'];
        $poids_net = $_POST['poids_net'];
        $prix = $_POST['prix'];
        $epicerie_nom = $_POST['epicerie_nom'];
        $horaires = $_POST['horaires'];
        $adresse = $_POST['adresse'];
        $contact_epicerie = $_POST['contact_epicerie'];
        $disponibilite = isset($_POST['disponibilite']) ? implode(',', $_POST['disponibilite']) : '';
        $mots_cles = isset($_POST['mots_cles']) ? implode(',', $_POST['mots_cles']) : '';
        $details = $_POST['details'] ?? '';
        $categorie_id = $_POST['categorie_id'];

        // Traiter l'image
        $image_epice = null;
        if (isset($_FILES['image_epice']) && $_FILES['image_epice']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = './uploads/';
            $file_name = uniqid() . '_' . basename($_FILES['image_epice']['name']);
            $upload_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['image_epice']['tmp_name'], $upload_file)) {
                $image_epice = $file_name;
            }
        }


        // Récupérer l'ID du propriétaire à partir de la table "proprietaire"
        $proprietaire_id = null;
        $query = "SELECT id FROM proprietaire WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $proprietaire_id = $row['id'];
        } else {
            die("Erreur : Impossible de récupérer l'ID du propriétaire.");
        }

        mysqli_stmt_close($stmt);
        // Insertion dans la base de données
        $sql = "INSERT INTO epicerie (
          nom_epice, 
          image_epice, 
          poids_net, 
          prix, 
          epicerie_nom, 
          horaires, 
          adresse, 
          contact_epicerie, 
          disponibilite, 
          mots_cles, 
          details, 
          categorie_id, 
          proprietaire_id
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param(
              $stmt,
              'sssdsssssssii',  // Types : string, string, double, string, string, string, string, string, string, string, int, int
              $nom_epice,
              $image_epice,
              $poids_net,
              $prix,
              $epicerie_nom,
              $horaires,
              $adresse,
              $contact_epicerie,
              $disponibilite,
              $mots_cles,
              $details,
              $categorie_id,
              $proprietaire_id
            );

            if (mysqli_stmt_execute($stmt)) {
                $message = '<p class="text-green-500">Épice ajoutée avec succès !</p>';
                echo "<script>
                          setTimeout(() => {
                              window.location.href = window.location.href;
                          }, 3000);
                      </script>";
            } else {
                $message = '<p class="text-red-500">Erreur lors de l’ajout de l’épice.</p>';
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = '<p class="text-red-500">Impossible de préparer la requête.</p>';
        }
    }
}
include('./templates/header.php');
?>


<div class="flex min-h-screen">
<?php include('sidebar2.php'); ?>
<div class="flex-1 p-6 flex flex-col items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-lg font-bold mb-4 text-center">Ajouter une Épice</h2>

    <!-- Affichage des messages -->
    <?php if (!empty($message)) echo $message; ?>

    <form id="add-product-form" class="space-y-4" method="post" enctype="multipart/form-data">
      <!-- Nom de l'épice -->
      <div class="flex items-center mb-4">
        <label for="nom_epice" class="block text-gray-700 font-medium mr-2">Nom de l'épice :</label>
        <input type="text" id="nom_epice" name="nom_epice" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <!-- Image de l'épice -->
      <div class="flex flex-col mb-4">
        <label for="image_epice" class="block text-gray-700 font-medium mb-2">Image de l'épice :</label>
        <input type="file" id="image_epice" name="image_epice" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
        <img id="image-preview" class="mt-4 w-32 h-32 object-cover rounded-lg shadow-md" style="display: none;" />
      </div>

      <!-- Poids net -->
      <div class="flex items-center mb-4">
        <label for="poids_net" class="block text-gray-700 font-medium mr-2">Poids net :</label>
        <input type="number" id="poids_net" name="poids_net" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <!-- Prix -->
      <div class="flex items-center mb-4">
        <label for="prix" class="block text-gray-700 font-medium mr-2">Prix :</label>
        <input type="number" id="prix" name="prix" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <!-- Catégorie -->
      <div class="flex items-center mb-4">
        <label for="categorie_id" class="block text-gray-700 font-medium mr-2">Catégorie :</label>
        <select id="categorie_id" name="categorie_id" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
          <option value="">Sélectionnez une catégorie</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['nom_categorie']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Épicerie -->
      <div class="flex items-center mb-4">
        <label for="epicerie_nom" class="block text-gray-700 font-medium mr-2">Épicerie :</label>
        <input type="text" id="epicerie_nom" name="epicerie_nom" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <!-- Horaires -->
      <div class="flex items-center mb-4">
        <label for="horaires" class="block text-gray-700 font-medium mr-2">Horaires :</label>
        <input type="text" id="horaires" name="horaires" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <!-- Adresse -->
      <div class="flex items-center mb-4">
        <label for="adresse" class="block text-gray-700 font-medium mr-2">Adresse :</label>
        <input type="text" id="adresse" name="adresse" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <!-- Contact épicerie -->
      <div class="flex items-center mb-4">
        <label for="contact_epicerie" class="block text-gray-700 font-medium mr-2">Contact épicerie :</label>
        <input type="text" id="contact_epicerie" name="contact_epicerie" class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>

      <!-- Disponibilité -->
      <div class="flex items-center mb-4">
        <span class="block text-gray-700 font-medium mr-2">Disponibilité :</span>
        <div class="flex space-x-4">
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="disponibilite[]" value="en_stock" class="form-checkbox">
            <span>En stock</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="disponibilite[]" value="en_rupture" class="form-checkbox">
            <span>En rupture de stock</span>
          </label>
        </div>
      </div>

      <!-- Hashtags -->
      <div class="flex items-center mb-4">
        <span class="block text-gray-700 font-medium mr-2">Mots-clés :</span>
        <div class="flex space-x-4">
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="mots_cles[]" value="poivre" class="form-checkbox">
            <span>Poivre</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="mots_cles[]" value="gingembre" class="form-checkbox">
            <span>Gingembre</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="mots_cles[]" value="saveur" class="form-checkbox">
            <span>Saveur</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="mots_cles[]" value="piquant" class="form-checkbox">
            <span>Piquant</span>
          </label>
        </div>
      </div>

      <!-- Détails de l'épice -->
      <div class="mb-4">
        <label for="details" class="block text-gray-700 font-medium mb-2">Détails de l'épice :</label>
        <div id="details" name="details" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500"></div>
        <!-- Champ caché pour envoyer le contenu de Quill -->
        <textarea name="details" id="details-hidden" style="display: none;"></textarea>
      </div>

      <!-- Bouton Soumettre -->
      <div class="flex justify-center">
        <button type="submit" class="btn-gradient text-white py-2 px-4 rounded-lg">Ajouter</button>
      </div>
    </form>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const quillDescription = new Quill("#details", {
      theme: "snow",
      modules: {
        toolbar: [
          ["bold", "italic", "underline"], 
          [{ header: 1 }, { header: 2 }, { header: 3 }], 
          [{ list: "ordered" }, { list: "bullet" }], 
          ["link", "image"],
          [{ size: [] }]
        ]
      }
    });

    const addProductForm = document.getElementById('add-product-form');
    const hiddenDetailsField = document.getElementById('details-hidden');

    addProductForm.addEventListener('submit', function() {
      hiddenDetailsField.value = quillDescription.root.innerHTML;
    });

    // Preview de l'image
    const imageInput = document.getElementById('image_epice');
    const imagePreview = document.getElementById('image-preview');
    imageInput.addEventListener('change', function() {
      const file = imageInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          imagePreview.src = e.target.result;
          imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
      } else {
        imagePreview.style.display = 'none';
      }
    });
  });
</script>
<?php include('./templates/footer.php'); ?>
