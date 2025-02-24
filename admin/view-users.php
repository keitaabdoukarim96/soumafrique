<?php
include('./config/db.php');

// Récupérer les paramètres de recherche (si soumis)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Préparer la requête SQL
$query = "SELECT id, nom, email, created_at FROM users";
if ($search !== '') {
    $query .= " WHERE nom LIKE '%$search%' OR email LIKE '%$search%'";
}

$result = mysqli_query($conn, $query); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des utilisateurs</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center min-h-screen bg-gray-100">

  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-4xl">
    <!-- Titre et champ de filtre -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-bold">Liste des utilisateurs</h2>

      <!-- Formulaire de filtre -->
      <form action="view-users.php" method="GET" class="flex space-x-2">
        <input
          type="text"
          name="search"
          value="<?= htmlspecialchars($search); ?>"
          placeholder="Rechercher..."
          class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-48"
        >
        <!--<button
          type="submit"
          class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600"
        >
          Filtrer
        </button>-->
      </form>
    </div>

    <!-- Tableau des utilisateurs -->
    <table class="min-w-full text-sm border border-gray-300">
      <thead class="bg-gray-200 text-gray-600 uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left border-b">ID</th>
          <th class="py-3 px-4 text-left border-b">Nom</th>
          <th class="py-3 px-4 text-left border-b">Email</th>
          <th class="py-3 px-4 text-left border-b">Date d'ajout</th>
          <th class="py-3 px-4 text-center border-b">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php if (mysqli_num_rows($result) > 0) : ?>
          <?php while ($user = mysqli_fetch_assoc($result)) : ?>
            <tr class="border-b hover:bg-gray-100">
              <td class="py-3 px-4"><?= htmlspecialchars($user['id']); ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($user['nom']); ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($user['email']); ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($user['created_at']); ?></td>
              <td class="py-3 px-4 text-center">
                <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs">Voir</button>
                <button class="bg-yellow-500 text-white py-1 px-2 rounded text-xs">Modifier</button>
                <button class="bg-red-500 text-white py-1 px-2 rounded text-xs">Supprimer</button>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else : ?>
          <tr>
            <td colspan="5" class="py-3 px-4 text-center text-gray-500">Aucun utilisateur trouvé.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Pagination statique -->
    <div class="flex justify-end mt-4">
      <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-l">Précédent</button>
      <button class="bg-blue-500 text-white py-1 px-3">1</button>
      <button class="bg-gray-300 text-gray-700 py-1 px-3">2</button>
      <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-r">Suivant</button>
    </div>
  </div>

</body>
</html>
