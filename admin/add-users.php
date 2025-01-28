<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
    <h2 class="text-lg font-bold mb-4 text-center">Ajouter un utilisateur</h2>
    <form id="add-user-form">
      <!-- Nom -->
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-medium mb-2">Nom :</label>
        <input type="text" id="name" name="name" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-medium mb-2">Email :</label>
        <input type="email" id="email" name="email" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Adresse -->
      <div class="mb-4">
        <label for="address" class="block text-gray-700 font-medium mb-2">Adresse :</label>
        <input type="text" id="address" name="address" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Contact -->
      <div class="mb-4">
        <label for="contact" class="block text-gray-700 font-medium mb-2">Contact :</label>
        <input type="text" id="contact" name="contact" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Rôle -->
      <div class="mb-4">
        <label for="role" class="block text-gray-700 font-medium mb-2">Rôle :</label>
        <select id="role" name="role" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
          <option value="admin">Admin</option>
          <option value="utilisateur">Utilisateur</option>
          <option value="moderateur">Propriétaire</option>
        </select>
      </div>
      <!-- Mot de passe -->
      <div class="mb-4">
        <label for="password" class="block text-gray-700 font-medium mb-2">Mot de passe :</label>
        <input type="password" id="password" name="password" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Répéter le mot de passe -->
      <div class="mb-4">
        <label for="confirm_password" class="block text-gray-700 font-medium mb-2">Confirmer le mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Bouton Soumettre -->
      <div class="flex justify-center">
        <button type="submit" class=" text-white py-2 px-4 rounded-lg btn-gradient">Ajouter</button>
      </div>
    </form>
  </div>
</div>
