<!-- Contenu du fichier add-role.php -->
<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-lg font-bold mb-4 text-center">Ajouter un rôle</h2>
    <form id="add-role-form" class="space-y-4">
      <!-- Nom du rôle -->
      <div>
        <label for="role-name" class="block text-gray-700 font-medium mb-2">Nom du rôle :</label>
        <input type="text" id="role-name" name="role_name" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" required>
      </div>

      <!-- Description du rôle -->
      <div>
        <label for="role-description" class="block text-gray-700 font-medium mb-2">Description :</label>
        <textarea id="role-description" name="role_description" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-500" rows="3" placeholder="Description du rôle" required></textarea>
      </div>

      <!-- Bouton Soumettre -->
      <div class="flex justify-center">
        <button type="submit" class="btn-gradient text-white py-2 px-4 rounded-lg hover:bg-blue-600">Ajouter</button>
      </div>
    </form>
  </div>
</div>