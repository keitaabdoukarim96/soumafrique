<?php
include('./templates/header.php');
include('../admin/config/db.php');

// Initialisation des messages
$error_message = '';
$success_message = '';

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupération des champs du formulaire
  $nom_complet = $_POST['full_name'];
  $email = $_POST['email'];
  $nom_boutique = $_POST['shop_name'];
  $adresse_boutique = $_POST['shop_address'];
  $ville = $_POST['city'];
  $pays = "France"; // Par défaut, puisque le champ est en lecture seule
  $horaires_ouverture = $_POST['opening_hours'];
  $contact = $_POST['contact'];

  // Vérification si l'email existe déjà
  $query_check = "SELECT email FROM proprietaire WHERE email = ?";
  $stmt_check = $conn->prepare($query_check);
  $stmt_check->bind_param("s", $email);
  $stmt_check->execute();
  $stmt_check->store_result();

  if ($stmt_check->num_rows > 0) {
    // Si l'email existe déjà
    $error_message = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
  } else {
    // Insérer l'enregistrement si l'email n'existe pas
    $query = "INSERT INTO proprietaire (nom_complet, email, nom_boutique, adresse_boutique, ville, pays, horaires_ouverture, contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $nom_complet, $email, $nom_boutique, $adresse_boutique, $ville, $pays, $horaires_ouverture, $contact);

    if ($stmt->execute()) {
      // Succès
      $success_message = "Inscription réussie. Vous recevrez un email avec vos identifiants.";
    } else {
      // Erreur d'insertion
      $error_message = "Une erreur est survenue. Veuillez réessayer.";
    }
    $stmt->close();
  }

  $stmt_check->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>


<main class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <!-- Titre principal amélioré -->
    <h2 class="text-3xl font-extrabold text-red-700 mb-4 text-center">
      Devenir Vendeur sur <span class="text-black">SoumAfrique</span>
    </h2>

    <!-- Message d'information mis en valeur -->
    <p class="text-gray-700 text-md text-center mb-6 bg-yellow-100 p-3 rounded-lg shadow-md">
      <span class="font-semibold text-red-700">Après avoir renseigné ces champs,</span>
      vous recevrez un email contenant vos accès pour pouvoir ajouter vos produits.
      <br><span class="font-semibold">Merci de bien vouloir remplir ce formulaire.</span>
    </p>

    <?php if ($error_message): ?>
      <p class="text-red-500 text-center"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <?php if ($success_message): ?>
      <p class="text-green-500 text-center"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <form id="owner-registration-form" action="" method="POST">
      <!-- Nom et Prénom -->
      <div class="mb-4">
        <label for="full-name" class="block text-gray-700 font-bold mb-2">Nom et Prénom</label>
        <input type="text" id="full-name" name="full_name" class="w-full py-2 px-4 border rounded-lg focus:ring focus:ring-red-500" required>
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-bold  mb-2">Email :</label>
        <input type="email" id="email" name="email" class="w-full border rounded-lg p-2 focus:ring focus:ring-red-500" required>
      </div>

      <!-- Nom de la Boutique -->
      <div class="mb-4">
        <label for="shop-name" class="block text-gray-700 font-bold mb-2">Nom de la Boutique</label>
        <input type="text" id="shop-name" name="shop_name" class="w-full py-2 px-4 border rounded-lg focus:ring focus:ring-red-500" required>
      </div>

      <!-- Adresse de la Boutique -->
      <div class="mb-4">
        <label for="shop-address" class="block text-gray-700 font-bold mb-2">Adresse de la Boutique</label>
        <input type="text" id="shop-address" name="shop_address" class="w-full py-2 px-4 border rounded-lg focus:ring focus:ring-red-500" required>
      </div>

      <!-- Ville -->
      <div class="mb-4">
        <label for="city" class="block text-gray-700 font-bold mb-2">Ville</label>
        <input type="text" id="city" name="city" class="w-full py-2 px-4 border rounded-lg focus:ring focus:ring-red-500" required>
      </div>

      <!-- Pays (lecture seule) -->
      <div class="mb-4">
        <label for="country" class="block text-gray-700 font-bold mb-2">Pays</label>
        <input type="text" id="country" name="country" value="France" readonly class="w-full py-2 px-4 border rounded-lg bg-gray-200 cursor-not-allowed">
      </div>

      <!-- Horaires d'Ouverture -->
      <div class="mb-4">
        <label for="opening-hours" class="block text-gray-700 font-bold mb-2">Horaires d'Ouverture</label>
        <input type="text" id="opening-hours" name="opening_hours" placeholder="Ex: 9h00 - 18h00" class="w-full py-2 px-4 border rounded-lg focus:ring focus:ring-red-500" required>
      </div>

      <!-- Contact -->
      <div class="mb-4">
        <label for="contact" class="block text-gray-700 font-bold mb-2">Contact</label>
        <input type="text" id="contact" name="contact" class="w-full py-2 px-4 border rounded-lg focus:ring focus:ring-red-500" required>
      </div>

      <!-- Bouton d'Inscription -->
      <button type="submit" class="btn-gradient text-white w-full py-2 px-4 rounded-lg font-bold  transition duration-300">
        S'inscrire
      </button>
    </form>
  </div>
</main>


<?php
include('./templates/footer.php');
?>