<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

// Vérifier si un ID de recette est passé dans l'URL
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

// Récupérer les ingrédients associés à la recette
$sql_ingredients = "SELECT ingredient_name, ingredient_image FROM recette_ingredients WHERE recette_id = ?";
$stmt_ing = mysqli_prepare($conn, $sql_ingredients);
mysqli_stmt_bind_param($stmt_ing, 'i', $id);
mysqli_stmt_execute($stmt_ing);
$ingredients_result = mysqli_stmt_get_result($stmt_ing);

$ingredients = [];
while ($row = mysqli_fetch_assoc($ingredients_result)) {
    $ingredients[] = $row;
}

?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6 flex flex-col items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-lg font-bold mb-4 text-center">Détails de la Recette</h2>

            <!-- Nom de la recette -->
            <p class="text-gray-700"><strong>Nom :</strong> <?= htmlspecialchars($recette['recipe_name']); ?></p>

            <!-- Image principale -->
            <div class="mt-4">
                <img src="../admin/<?= htmlspecialchars($recette['main_image']); ?>" alt="<?= htmlspecialchars($recette['recipe_name']); ?>" class="w-full max-h-64 object-cover rounded-lg shadow-md">
            </div>

            <!-- Autres informations -->
            <p class="text-gray-700 mt-4"><strong>Catégorie :</strong> <?= htmlspecialchars($recette['categorie_nom']); ?></p>
            <p class="text-gray-700"><strong>Durée de cuisson :</strong> <?= htmlspecialchars($recette['cooking_time']); ?> min</p>
            <p class="text-gray-700"><strong>Portions :</strong> <?= htmlspecialchars($recette['servings']); ?> personnes</p>
            <p class="text-gray-700"><strong>Mode de cuisson :</strong> <?= htmlspecialchars($recette['cooking_method']); ?></p>
            <p class="text-gray-700"><strong>Budget :</strong> <?= htmlspecialchars($recette['budget']); ?> €</p>

            <!-- Ingrédients -->
            <div class="mt-6">
                <h3 class="text-lg font-bold">Ingrédients :</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-2">
                    <?php if (!empty($ingredients)) : ?>
                        <?php foreach ($ingredients as $ingredient) : ?>
                            <div class="text-center">
                                <img src="../admin/<?= htmlspecialchars($ingredient['ingredient_image']); ?>" alt="<?= htmlspecialchars($ingredient['ingredient_name']); ?>" class="w-24 h-24 object-cover rounded-lg shadow-md">
                                <p class="mt-2 text-gray-700"><?= htmlspecialchars($ingredient['ingredient_name']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-gray-500">Aucun ingrédient ajouté.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <h3 class="text-lg font-bold">Description :</h3>
                <p class="text-gray-700"><?= nl2br(htmlspecialchars_decode($recette['description'])); ?></p>
            </div>

            <!-- Bouton Retour -->
            <div class="flex justify-center mt-6">
                <a href="vew-liste-recette.php" class="btn-gradient text-white py-2 px-4 rounded-lg hover:bg-green-700 transition">
                    ⬅ Retour à la liste des recettes
                </a>
            </div>
        </div>
    </div>
</div>

<?php include('./templates/footer.php'); ?>
