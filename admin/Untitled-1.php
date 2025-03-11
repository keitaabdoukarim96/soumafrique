<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

// Vérifier si un ID de recette est passé
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    die("Recette non spécifiée.");
}

// Récupérer les informations de la recette
$sql = "SELECT * FROM recette WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Recette non trouvée.");
}

$recette = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Récupérer les catégories existantes
$query = "SELECT id, nom FROM categorie_recette ORDER BY nom ASC";
$result = mysqli_query($conn, $query);
$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Récupérer les ingrédients associés
$sql_ingredients = "SELECT id, ingredient_name, ingredient_image FROM recette_ingredients WHERE recette_id = ?";
$stmt_ing = mysqli_prepare($conn, $sql_ingredients);
mysqli_stmt_bind_param($stmt_ing, 'i', $id);
mysqli_stmt_execute($stmt_ing);
$ingredients_result = mysqli_stmt_get_result($stmt_ing);

$ingredients = [];
while ($row = mysqli_fetch_assoc($ingredients_result)) {
    $ingredients[] = $row;
}

// Gérer la mise à jour
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_name = $_POST['recipe_name'];
    $cooking_time = (int)$_POST['cooking_time'];
    $servings = (int)$_POST['servings'];
    $cooking_method = $_POST['cooking_method'];
    $budget = (float)$_POST['budget'];
    $category_id = (int)$_POST['category'];
    $description = $_POST['description'];

    // Gestion de l'image principale
    if (!empty($_FILES['main_image']['name'])) {
        $main_image_name = uniqid() . '_' . basename($_FILES['main_image']['name']);
        $main_image = "./uploads/" . $main_image_name;
        move_uploaded_file($_FILES['main_image']['tmp_name'], $main_image);
    } else {
        $main_image = $recette['main_image'];
    }

    // Mise à jour de la recette
    $sql_update = "UPDATE recette 
                   SET recipe_name = ?, main_image = ?, cooking_time = ?, servings = ?, 
                       cooking_method = ?, budget = ?, category_id = ?, description = ? 
                   WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, 'ssiiisisi', 
        $recipe_name, $main_image, $cooking_time, $servings, 
        $cooking_method, $budget, $category_id, $description, $id);
    $update_success = mysqli_stmt_execute($stmt_update);

    // Mise à jour des ingrédients
    if (!empty($_POST['ingredient_ids'])) {
        foreach ($_POST['ingredient_ids'] as $index => $ingredient_id) {
            $ingredient_name = $_POST['ingredient_titles'][$index];

            if (!empty($_FILES['ingredient_images']['name'][$index])) {
                $ingredient_image_name = uniqid() . '_' . basename($_FILES['ingredient_images']['name'][$index]);
                $ingredient_image = "./uploads/" . $ingredient_image_name;
                move_uploaded_file($_FILES['ingredient_images']['tmp_name'][$index], $ingredient_image);
            } else {
                $ingredient_image = $_POST['ingredient_old_images'][$index];
            }

            $sql_update_ing = "UPDATE recette_ingredients 
                               SET ingredient_name = ?, ingredient_image = ? 
                               WHERE id = ?";
            $stmt_update_ing = mysqli_prepare($conn, $sql_update_ing);
            mysqli_stmt_bind_param($stmt_update_ing, 'ssi', 
                $ingredient_name, $ingredient_image, $ingredient_id);
            mysqli_stmt_execute($stmt_update_ing);
        }
    }

    if ($update_success) {
        $message = '<p class="text-green-500" id="success-message">Mise à jour effectuée avec succès.</p>';
        echo "<script>
                setTimeout(() => {
                    window.location.href = 'view-liste-recette.php';
                }, 3000);
              </script>";
    } else {
        $message = '<p class="text-red-500">Erreur lors de la mise à jour.</p>';
    }
}
?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6 flex flex-col items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-lg font-bold mb-4 text-center">Modifier la Recette</h2>
            
            <?= $message ?>

            <form id="edit-recipe-form" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nom :</label>
                    <input type="text" name="recipe_name" value="<?= htmlspecialchars($recette['recipe_name']) ?>" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Catégorie :</label>
                    <select name="category" class="w-full border rounded-lg p-2">
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category['id'] ?>" <?= ($category['id'] == $recette['category_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Image principale :</label>
                    <img src="../admin/<?= htmlspecialchars($recette['main_image']) ?>" class="w-full max-h-48 object-cover rounded-lg mb-2">
                    <input type="file" name="main_image" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Mode de cuisson :</label>
                    <input type="text" name="cooking_method" value="<?= htmlspecialchars($recette['cooking_method']) ?>" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Budget (€) :</label>
                    <input type="number" name="budget" value="<?= $recette['budget'] ?>" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Description :</label>
                    <div id="description-editor"><?= htmlspecialchars_decode($recette['description']) ?></div>
                    <textarea name="description" id="description-hidden" style="display: none;"></textarea>
                </div>

                <button type="submit" class="btn-gradient text-white py-2 px-4 rounded-lg">Mettre à jour</button>
            </form>

            <div class="text-center mt-4">
                <a href="view-liste-recette.php" class="btn-gradient text-white py-2 px-4 rounded-lg">Retour</a>
            </div>
        </div>
    </div>
</div>

<?php include('./templates/footer.php'); ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const quill = new Quill("#description-editor", {
        theme: "snow",
        modules: {
            toolbar: [["bold", "italic", "underline"], [{ header: 1 }, { header: 2 }], [{ list: "ordered" }, { list: "bullet" }], ["link", "image"], [{ size: [] }]]
        }
    });

    const hiddenField = document.getElementById("description-hidden");
    quill.root.innerHTML = hiddenField.value;

    document.getElementById("edit-recipe-form").addEventListener("submit", function() {
        hiddenField.value = quill.root.innerHTML;
    });
});
</script>
