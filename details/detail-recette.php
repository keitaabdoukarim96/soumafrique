<?php
// Connexion à la base de données
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

// Vérification que l'ID est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Recette non spécifiée.");
}

$id = intval($_GET['id']);

// Récupérer les détails de la recette
$sql = "SELECT r.*, c.nom AS categorie_nom
        FROM recette r 
        LEFT JOIN categorie_recette c ON r.category_id = c.id
        WHERE r.id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Recette non trouvée.");
}

$recette = mysqli_fetch_assoc($result);
$category_id = $recette['category_id'];

// Récupérer les ingrédients associés
$sql_ingredients = "SELECT ingredient_name, ingredient_image 
                    FROM recette_ingredients 
                    WHERE recette_id = ?";
$stmt = mysqli_prepare($conn, $sql_ingredients);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$ingredients_result = mysqli_stmt_get_result($stmt);

$ingredients = [];
while ($row = mysqli_fetch_assoc($ingredients_result)) {
    $ingredients[] = $row;
}

// Récupérer des recettes similaires (max 3)
$sql_similaires = "SELECT id, recipe_name, main_image, cooking_time, servings, cooking_method, budget 
                   FROM recette 
                   WHERE category_id = ? AND id != ? 
                   ORDER BY RAND() LIMIT 3";
$stmt = mysqli_prepare($conn, $sql_similaires);
mysqli_stmt_bind_param($stmt, 'ii', $category_id, $id);
mysqli_stmt_execute($stmt);
$similaires_result = mysqli_stmt_get_result($stmt);

$recettes_similaires = [];
while ($row = mysqli_fetch_assoc($similaires_result)) {
    $recettes_similaires[] = $row;
}

mysqli_stmt_close($stmt);
?>

<!--Header start-->
<?php include('../templates/header.php'); ?>
<!--Header end-->

<main class="flex-grow mt-20 mb-20">
  <div class="container mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-6 mt-20">
      <a href="/soumafrique/index.php" class="text-green-700 font-bold">Accueil</a> >
      <a href="/soumafrique/recettes.php" class="text-green-700 font-bold">Recettes</a> >
      <span class="text-red-600 font-bold"><?= htmlspecialchars($recette['recipe_name']); ?></span>
    </nav>

    <!-- Titre et image principale -->
    <h1 class="text-center text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-8">
      <?= htmlspecialchars($recette['recipe_name']); ?>
    </h1>
    <div class="flex justify-center mb-8 mt-10">
      <img src="../admin/<?= htmlspecialchars($recette['main_image']); ?>" alt="<?= htmlspecialchars($recette['recipe_name']); ?>" class="w-full max-w-md rounded-lg shadow-md">
    </div>

    <!-- Infos sur la recette -->
    <div class="flex justify-center space-x-8 text-gray-700 text-sm mb-8 mt-10">
      <div class="flex flex-col items-center">
        <i class="far fa-clock text-2xl mb-2"></i>
        <span><?= htmlspecialchars($recette['cooking_time']); ?> min</span>
      </div>
      <div class="flex flex-col items-center">
        <i class="fas fa-users text-2xl mb-2"></i>
        <span><?= htmlspecialchars($recette['servings']); ?> pers.</span>
      </div>
      <div class="flex flex-col items-center">
        <i class="fas fa-fire text-2xl mb-2"></i>
        <span><?= htmlspecialchars($recette['cooking_method']); ?></span>
      </div>
      <div class="flex flex-col items-center">
        <i class="fas fa-tags text-2xl mb-2"></i>
        <span><?= htmlspecialchars($recette['budget']); ?> €</span>
      </div>
    </div>

    <!-- Ingrédients -->
    <section class="mb-12">
      <h2 class="text-xl font-bold mb-4"><i class="fas fa-leaf mr-2"></i> Ingrédients</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($ingredients as $ingredient): ?>
          <div class="text-center">
            <img src="../admin/<?= htmlspecialchars($ingredient['ingredient_image']); ?>" alt="<?= htmlspecialchars($ingredient['ingredient_name']); ?>" class="w-20 h-20 mx-auto">
            <p class="mt-2"><?= htmlspecialchars($ingredient['ingredient_name']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Préparation -->
    <section>
      <h2 class="text-xl font-bold mb-4"><i class="fas fa-concierge-bell mr-2"></i> Préparation</h2>
      <div class="text-gray-700">
        <?= nl2br(htmlspecialchars_decode($recette['description'])); ?>
      </div>
    </section>

    <!-- Recettes Similaires -->
    <?php if (!empty($recettes_similaires)): ?>
      <section class="mt-12">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Recettes Similaires</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($recettes_similaires as $recette_similaire): ?>
            <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
              <img src="../admin/<?= htmlspecialchars($recette_similaire['main_image']); ?>" alt="<?= htmlspecialchars($recette_similaire['recipe_name']); ?>" class="w-full h-48 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($recette_similaire['recipe_name']); ?></h3>
                
                <p class="text-sm text-gray-600 mt-2">
                  <strong>Durée:</strong> <?= htmlspecialchars($recette_similaire['cooking_time']); ?> min
                </p>
                <p class="text-sm text-gray-600">
                  <strong>Portions:</strong> <?= htmlspecialchars($recette_similaire['servings']); ?> pers.
                </p>
                <p class="text-sm text-gray-600">
                  <strong>Mode de cuisson:</strong> <?= htmlspecialchars($recette_similaire['cooking_method']); ?>
                </p>
                <p class="text-sm text-gray-600">
                  <strong>Budget:</strong> <?= htmlspecialchars($recette_similaire['budget']); ?> €
                </p>

                <div class="flex justify-center items-center mt-4">
                  <a href="detail-recette.php?id=<?= $recette_similaire['id'] ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">
                    VOIR LA RECETTE
                  </a>
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
<?php include('../templates/footer.php'); ?>
<!--Footer end-->
