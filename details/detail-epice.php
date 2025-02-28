<?php
// Connexion à la base de données
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

// Vérification que l'ID est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Épice non spécifiée.");
}

$id = intval($_GET['id']);

// Requête pour récupérer les détails de l'épice
$sql = "SELECT * FROM epicerie WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Épice non trouvée.");
}

$epice = mysqli_fetch_assoc($result);

// Fonction pour transformer le HTML en texte formaté
function htmlToText($html) {
    // Remplace les balises <h2> et <h3> par des titres en majuscules avec des lignes en dessous
    $html = preg_replace('/<h2[^>]*>(.*?)<\/h2>/i', "\n\n$1\n" . str_repeat('-', 40) . "\n", $html);


    // Remplace les balises <br> par des retours à la ligne
    $html = preg_replace('/<br[^>]*>/', "\n", $html);

    // Supprime toutes les autres balises HTML
    $html = strip_tags($html);

    return trim($html);
}
?>
<!--Header start-->
<?php include('../templates/header.php'); ?>
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
        <img src="../admin/uploads/<?= htmlspecialchars($epice['image_epice']); ?>" alt="<?= htmlspecialchars($epice['nom_epice']); ?>" class="w-full h-auto border border-green-500 rounded-lg">
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

        <!-- Boutons d'action -->
        <div class="flex space-x-4 mb-4">
          <button class="btn-gradient px-4 py-2 text-white font-bold rounded">Ajouter au panier</button>
          <button class="btn-gradient px-4 py-2 text-white font-bold rounded">Acheter cet article</button>
        </div>
      </div>
    </section>
    <!-- Détails supplémentaires -->
    <section class="mt-12">
      <p class="text-gray-700 mb-4">
        <?= nl2br(htmlToText($epice['details'])); ?>
      </p>
    </section>
  </div>
</main>

<!-- Footer start-->
<?php include('../templates/footer.php'); ?>
<!--Footer end-->
