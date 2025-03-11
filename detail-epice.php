<?php
// Connexion à la base de données
include('./templates/header.php');


// Vérification que l'ID est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Épice non spécifiée.");
}

$id = intval($_GET['id']);

// Requête pour récupérer les détails de l'épice
$sql = "SELECT * FROM epicerie WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Épice non trouvée.");
}

$epice = mysqli_fetch_assoc($result);
$category_id = $epice['categorie_id'] ?? null; // Récupérer la catégorie si elle existe

// Requête pour récupérer d'autres épices de la même catégorie (max 3)
if ($category_id) {
    $sql_similaires = "SELECT id, nom_epice, image_epice, prix, epicerie_nom, horaires, adresse, disponibilite 
                       FROM epicerie 
                       WHERE categorie_id = ? AND id != ? 
                       ORDER BY RAND() LIMIT 3";
    $stmt = mysqli_prepare($conn, $sql_similaires);
    mysqli_stmt_bind_param($stmt, 'ii', $category_id, $id);
} else {
    // Si pas de catégorie, afficher des épices aléatoires
    $sql_similaires = "SELECT id, nom_epice, image_epice, prix, epicerie_nom, horaires, adresse, disponibilite 
                       FROM epicerie 
                       WHERE id != ? 
                       ORDER BY RAND() LIMIT 3";
    $stmt = mysqli_prepare($conn, $sql_similaires);
    mysqli_stmt_bind_param($stmt, 'i', $id);
}

mysqli_stmt_execute($stmt);
$similaires_result = mysqli_stmt_get_result($stmt);
$epices_similaires = [];
while ($row = mysqli_fetch_assoc($similaires_result)) {
    $epices_similaires[] = $row;
}

mysqli_stmt_close($stmt);

// Fonction pour transformer le HTML en texte formaté
function htmlToText($html) {
    $html = preg_replace('/<h2[^>]*>(.*?)<\/h2>/i', "\n\n$1\n" . str_repeat('-', 40) . "\n", $html);
    $html = preg_replace('/<br[^>]*>/', "\n", $html);
    return strip_tags($html);
}
?>

<!--Header start-->

<!--Header end-->

<main class="flex-grow mt-20 mb-20 px-4">
  <div class="container mx-auto">
    <!-- Chemin de navigation (Breadcrumb) -->
    <nav class="text-sm mb-4 mt-20" style="background-color: #f9f9f9; padding: 10px;">
        <a href="/soumafrique/index.php" class="text-green-700 font-bold">Accueil</a> >
        <a href="/soumafrique/epicerie.php" class="text-green-700 font-bold">Épicerie</a> >
        <span class="text-gray-800 font-bold"><?= htmlspecialchars($epice['nom_epice']); ?></span>
    </nav>

    <!-- Section principale -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Image de l'épice -->
      <div>
        <img src="admin/uploads/<?= htmlspecialchars($epice['image_epice']); ?>" alt="<?= htmlspecialchars($epice['nom_epice']); ?>" class="w-full h-auto border border-green-500 rounded-lg">
      </div>

      <!-- Détails de l'épice -->
      <div class="border border-green-500 rounded-lg p-4 bg-white">
        <p class="text-lg font-bold text-green-700 mb-2"><?= htmlspecialchars($epice['prix']); ?> €</p>
        <h1 class="text-2xl font-bold text-green-700 mb-4"><?= htmlspecialchars($epice['nom_epice']); ?></h1>
        <p class="text-sm text-gray-700 mb-2"><strong>Épicerie :</strong> <?= htmlspecialchars($epice['epicerie_nom']); ?></p>
        <p class="text-sm text-gray-700 mb-2"><strong>Horaires :</strong> <?= htmlspecialchars($epice['horaires']); ?></p>
        <p class="text-sm text-gray-700 mb-2"><strong>Adresse :</strong> <?= htmlspecialchars($epice['adresse']); ?></p>
        <p class="text-sm text-gray-700 mb-2"><strong>Contact :</strong> <?= htmlspecialchars($epice['contact_epicerie']); ?></p>
        <p class="text-sm text-gray-700 mb-4"><strong>Disponibilité :</strong> 
          <span class="<?= $epice['disponibilite'] == 'en_stock' ? 'text-green-600 font-bold' : 'text-red-600 font-bold'; ?>">
            <?= $epice['disponibilite'] == 'en_stock' ? 'En stock' : 'Rupture de stock'; ?>
          </span>
        </p>

        <div class="flex items-center mt-4 space-x-4">
                  <!-- ✅ Bouton Géolocalisation -->
                  <button class="btn-gradient text-white px-4 py-2 rounded-lg font-bold flex items-center transition duration-300"
        id="go-to-map-<?= $epice['id']; ?>"
        data-lat="<?= htmlspecialchars($epice['latitude']); ?>"
        data-lng="<?= htmlspecialchars($epice['longitude']); ?>">
    <i class="fas fa-map-marker-alt mr-2"></i>  Aller à la boutique
    </button>
                 
      <button class="btn-gradient text-white  px-4 py-2 rounded-lg font-bold flex items-center  transition duration-300 add-to-cart" 
              data-id="<?= $epice['id']; ?>" 
              data-name="<?= htmlspecialchars($epice['nom_epice']); ?>" 
              data-price="<?= $epice['prix']; ?>">
        <i class="fas fa-shopping-cart mr-2"></i>  Panier
      </button>
                </div>
      </div>
    </section>

    <!-- Détails supplémentaires -->
    <section class="mt-12">
      <h2 class="text-lg font-bold mb-4">Description</h2>
      <p class="text-gray-700 mb-4">
        <?= nl2br(htmlToText($epice['details'])); ?>
      </p>
    </section>

    <!-- Autres Épices Similaires -->
    <?php if (!empty($epices_similaires)): ?>
      <section class="mt-12">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Autres Épices</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($epices_similaires as $epice_similaire): ?>
            <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
              <img src="admin/uploads/<?= htmlspecialchars($epice_similaire['image_epice']); ?>" alt="<?= htmlspecialchars($epice_similaire['nom_epice']); ?>" class="w-full h-48 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($epice_similaire['nom_epice']); ?></h3>
                <p class="text-sm text-gray-600"><strong>Prix :</strong> <?= htmlspecialchars($epice_similaire['prix']); ?> €</p>
                <p class="text-sm text-gray-600"><strong>Boutique :</strong> <?= htmlspecialchars($epice_similaire['epicerie_nom']); ?></p>
                <p class="text-sm text-gray-600"><strong>Adresse :</strong> <?= htmlspecialchars($epice_similaire['adresse']); ?></p>
                <p class="text-sm text-gray-600"><strong>Horaire :</strong> <?= htmlspecialchars($epice_similaire['horaires']); ?></p>
                <p class="text-sm <?= $epice_similaire['disponibilite'] == 'en_stock' ? 'text-green-600' : 'text-red-600'; ?>">
                  <strong>Disponibilité :</strong> <?= $epice_similaire['disponibilite'] == 'en_stock' ? 'En stock' : 'Rupture de stock'; ?>
                </p>
                <div class="flex justify-between items-center mt-4">
                  <!-- ✅ Bouton Géolocalisation -->
                  <button class="btn-gradient text-white px-4 py-2 rounded-lg font-bold flex items-center transition duration-300"
        id="go-to-map-<?= $epice['id']; ?>"
        data-lat="<?= htmlspecialchars($epice['latitude']); ?>"
        data-lng="<?= htmlspecialchars($epice['longitude']); ?>">
    <i class="fas fa-map-marker-alt mr-2"></i> 
</button>
                  <a href="detail-epice.php?id=<?= $epice['id']; ?>" class="bg-red-500 py-2 px-4 text-white rounded-lg font-bold"><i class="fa fa-eye text-xl"></i></a>
                   <!-- ✅ Bouton Ajouter au Panier -->
      <button class="btn-gradient text-white px-4 py-2 rounded-lg font-bold flex items-center  transition duration-300 add-to-cart" 
              data-id="<?= $epice['id']; ?>" 
              data-name="<?= htmlspecialchars($epice['nom_epice']); ?>" 
              data-price="<?= $epice['prix']; ?>">
        <i class="fas fa-shopping-cart mr-2"></i> 
      </button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>
  </div>
</main>

<!-- Footer start-->
<script src="js/geolocalisation.js"></script>
<script src="js/map.js"></script>
<script src="cart.js"></script>
<?php include('templates/footer.php'); ?>
<!--Footer end-->
