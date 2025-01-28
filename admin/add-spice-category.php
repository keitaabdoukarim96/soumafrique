<!-- Contenu du fichier add-spice-category.php -->
<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-lg font-bold mb-4 text-center">Ajouter une catégorie d'épices</h2>
    <form id="add-category-form" class="space-y-4">
      <!-- Nom de la catégorie -->
      <div>
        <label for="category-name" class="block text-gray-700 font-medium mb-2">Nom de la catégorie :</label>
        <input type="text" id="category-name" name="category_name" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
      </div>

      <!-- Sous-catégories -->
      <div>
        <label for="subcategories" class="block text-gray-700 font-medium mb-2">Sous-catégories (séparées par une virgule) :</label>
        <textarea id="subcategories" name="subcategories" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" rows="3" placeholder="Exemple : Graines, Baies" required></textarea>
      </div>

      <!-- Bouton Soumettre -->
      <div class="flex justify-center">
        <button type="submit" class="btn-gradient text-white py-2 px-4 rounded-lg">Ajouter</button>
      </div>
    </form>
  </div>
</div>
