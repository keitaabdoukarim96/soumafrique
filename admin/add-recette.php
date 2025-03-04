<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

// Récupérer les catégories depuis la base de données
$query = "SELECT * FROM categorie_recette ORDER BY nom ASC";
$result = mysqli_query($conn, $query);

$message = "";

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipe_name = mysqli_real_escape_string($conn, $_POST['recipe_name']);
    $cooking_time = (int) $_POST['cooking_time'];
    $servings = (int) $_POST['servings'];
    $cooking_method = mysqli_real_escape_string($conn, $_POST['cooking_method']);
    $budget = (float) $_POST['budget'];
    $category_id = (int) $_POST['category'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Gérer l'upload de l'image principale avec un nom unique
    $main_image_name = uniqid() . '_' . basename($_FILES['main_image']['name']);
    $main_image = "./uploads/" . $main_image_name;
    move_uploaded_file($_FILES['main_image']['tmp_name'], $main_image);
    
    // Insérer la recette dans la base de données
    $sql = "INSERT INTO recette (recipe_name, main_image, cooking_time, servings, cooking_method, budget, category_id, description) 
            VALUES ('$recipe_name', '$main_image', $cooking_time, $servings, '$cooking_method', $budget, $category_id, '$description')";
    
    if (mysqli_query($conn, $sql)) {
        $recette_id = mysqli_insert_id($conn);
        
        // Gérer les ingrédients avec un nom unique pour chaque image
        if (!empty($_FILES['ingredient_images']['name'][0])) {
            foreach ($_FILES['ingredient_images']['name'] as $index => $name) {
                $ingredient_name = mysqli_real_escape_string($conn, $_POST['ingredient_titles'][$index]);
                $ingredient_image_name = uniqid() . '_' . basename($_FILES['ingredient_images']['name'][$index]);
                $ingredient_image = "./uploads/" . $ingredient_image_name;
                move_uploaded_file($_FILES['ingredient_images']['tmp_name'][$index], $ingredient_image);
                
                $sql_ingredient = "INSERT INTO recette_ingredients (recette_id, ingredient_name, ingredient_image) 
                                  VALUES ($recette_id, '$ingredient_name', '$ingredient_image')";
                mysqli_query($conn, $sql_ingredient);
            }
        }
        
        $message = "<div id='message' class='p-3 mb-4 text-green-700 bg-green-200 border border-green-400 rounded'>Recette ajoutée avec succès !</div>";
        echo "<script>setTimeout(() => { window.location.href='add-recette.php'; }, 3000);</script>";
    } else {
        $message = "<div id='message' class='p-3 mb-4 text-red-700 bg-red-200 border border-red-400 rounded'>Erreur lors de l'ajout de la recette.</div>";
    }
}
?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6 flex flex-col items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-lg font-bold mb-4 text-center">Ajouter une Recette</h2>
            <?php echo $message; ?>
            <form id="add-recipe-form" method="POST" enctype="multipart/form-data" class="space-y-4">
                <!-- Nom de la recette -->
                <div>
                    <label for="recipe-name" class="block text-gray-700 font-medium mb-2">Nom de la recette :</label>
                    <input type="text" id="recipe-name" name="recipe_name" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
                </div>
                
                <!-- Image principale -->
                <div>
                    <label for="main-image" class="block text-gray-700 font-medium mb-2">Image principale :</label>
                    <input type="file" id="main-image" name="main_image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
                    <img id="main-image-preview" class="mt-2 hidden w-full max-h-48 object-cover rounded-lg">
                </div>

                <!-- Ingrédients (Images) avec Titres -->
                <div>
                    <label for="ingredient-images" class="block text-gray-700 font-medium mb-2">Images des Ingrédients :</label>
                    <div id="ingredient-container">
                        <div class="ingredient-item flex space-x-2 mb-2">
                            <input type="file" name="ingredient_images[]" accept="image/*" class="border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
                            <input type="text" name="ingredient_titles[]" placeholder="Nom de l'ingrédient" class="border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
                        </div>
                    </div>
                    <button type="button" id="add-ingredient" class="mt-2 text-blue-500">+ Ajouter un ingrédient</button>
                </div>

                <!-- Durée de cuisson -->
                <div>
                    <label for="cooking-time" class="block text-gray-700 font-medium mb-2">Durée de cuisson (min) :</label>
                    <input type="number" id="cooking-time" name="cooking_time" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
                </div>

                <!-- Nombre de personnes -->
                <div>
                    <label for="servings" class="block text-gray-700 font-medium mb-2">Nombre de personnes :</label>
                    <input type="number" id="servings" name="servings" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
                </div>

                <!-- Mode de cuisson -->
                <div>
                    <label for="cooking-method" class="block text-gray-700 font-medium mb-2">Mode de cuisson :</label>
                    <input type="text" id="cooking-method" name="cooking_method" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
                </div>
                
                <!-- Budget -->
                <div>
                    <label for="budget" class="block text-gray-700 font-medium mb-2">Budget (€) :</label>
                    <input type="number" id="budget" name="budget" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
                </div>
                
                <!-- Catégorie -->
                <div>
                    <label for="category" class="block text-gray-700 font-medium mb-2">Catégorie :</label>
                    <select id="category" name="category" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                <?php echo htmlspecialchars($row['nom']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                
                <!-- Description avec Quill -->
                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description :</label>
                    <div id="description-editor" class="w-full border border-gray-300 rounded-lg p-2"></div>
                    <textarea name="description" id="description-hidden" style="display: none;"></textarea>
                </div>

                <!-- Bouton Soumettre -->
                <div class="flex justify-center">
                    <button type="submit" class="text-white py-2 px-4 rounded-lg btn-gradient">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById("main-image").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("main-image-preview").src = e.target.result;
            document.getElementById("main-image-preview").classList.remove("hidden");
        };
        reader.readAsDataURL(file);
    }
});
// Gérer l'ajout dynamique des ingrédients et leur prévisualisation
document.getElementById("add-ingredient").addEventListener("click", function() {
    const container = document.getElementById("ingredient-container");
    const newIngredient = document.createElement("div");
    newIngredient.classList.add("ingredient-item", "flex", "space-x-2", "mb-2");

    newIngredient.innerHTML = `
        <input type="file" name="ingredient_images[]" accept="image/*" class="border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500 ingredient-input" required>
        <input type="text" name="ingredient_titles[]" placeholder="Nom de l'ingrédient" class="border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
        <img class="hidden ingredient-preview w-16 h-16 object-cover rounded-lg">
    `;

    container.appendChild(newIngredient);

    // Ajouter l'événement de prévisualisation pour le nouvel ingrédient
    newIngredient.querySelector(".ingredient-input").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = newIngredient.querySelector(".ingredient-preview");
                previewImage.src = e.target.result;
                previewImage.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        }
    });
});
  setTimeout(() => { 
    const message = document.getElementById('message');
    if (message) message.style.display = 'none';
  }, 3000);

  document.addEventListener("DOMContentLoaded", function() {
    const quill = new Quill("#description-editor", {
      theme: "snow",
      modules: {
        toolbar: [["bold", "italic", "underline"], [{ header: 1 }, { header: 2 }, { header: 3 }], [{ list: "ordered" }, { list: "bullet" }], ["link", "image"], [{ size: [] }]]
      }
    });

    const form = document.getElementById("add-recipe-form");
    const hiddenField = document.getElementById("description-hidden");
    form.addEventListener("submit", function() {
      hiddenField.value = quill.root.innerHTML;
    });
  });


  
</script>

<?php mysqli_close($conn); ?>
<?php include('./templates/footer.php'); ?>

