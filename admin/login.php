<?php
include('./templates/header.php');
?>

<main class="flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Connexion</h2>
    <form>
      <!-- Email -->
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Adresse Email</label>
        <input type="email" placeholder="Entrez votre email" class="w-full py-2 px-4 border rounded-lg">
      </div>
      <!-- Mot de passe -->
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Mot de passe</label>
        <input type="password" placeholder="Entrez votre mot de passe" class="w-full py-2 px-4 border rounded-lg">
      </div>
      <!-- Bouton -->
      <button type="submit" class="btn-gradient w-full py-2 px-4 rounded-lg font-bold text-white">Se connecter</button>
    </form>
  </div>
</main>

<?php
include('./templates/footer.php');
?>
