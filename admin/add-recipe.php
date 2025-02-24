<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-lg font-bold mb-4 text-center">Ajouter une Recette</h2>
    <form id="add-recipe-form" class="space-y-4">
      <!-- Nom de la recette -->
      <div>
        <label for="recipe-name" class="block text-gray-700 font-medium mb-2">Nom de la recette :</label>
        <input type="text" id="recipe-name" name="recipe_name" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
      </div>

      <!-- Ingrédients -->
      <div>
        <label for="ingredients" class="block text-gray-700 font-medium mb-2">Ingrédients :</label>
        <div id="ingredients" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500"></div>
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
        <label for="budget" class="block text-gray-700 font-medium mb-2">Budget :</label>
        <input type="number" id="budget" name="budget" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
        </div>

      <!-- Description -->
      <div>
        <label for="description" class="block text-gray-700 font-medium mb-2">Description :</label>
        <div id="description" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500"></div>
      </div>

      <!-- Bouton Soumettre -->
      <div class="flex justify-center">
        <button type="submit" class=" text-white py-2 px-4 rounded-lg btn-gradient">Ajouter</button>
      </div>
    </form>
  </div>
</div>