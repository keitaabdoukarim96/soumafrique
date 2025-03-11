<?php 
include('./templates/header.php');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

// Récupérer les boutiques validées en forçant l'encodage
$sql = "SELECT id, nom_complet, email, nom_boutique, adresse_boutique, horaires_ouverture, contact 
        FROM proprietaire 
        WHERE BINARY status = 'validé'";


// Vérifier si un ID de suppression est passé dans l'URL
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
  $delete_id = intval($_GET['delete_id']);

  // Supprimer la boutique en vérifiant que l'ID existe
  $delete_sql = "DELETE FROM proprietaire WHERE id = ?";
  $stmt = mysqli_prepare($conn, $delete_sql);
  mysqli_stmt_bind_param($stmt, 'i', $delete_id);

  if (mysqli_stmt_execute($stmt)) {
      echo "<script>
              alert('Boutique supprimée avec succès.');
              window.location.href = 'boutique-valider.php';
            </script>";
  } else {
      echo "<p class='text-red-500 text-center'>Erreur lors de la suppression de la boutique.</p>";
  }

  mysqli_stmt_close($stmt);
}


$result = mysqli_query($conn, $sql);
?>

<div class="flex min-h-screen">
<?php include('sidebar2.php'); ?>
<div class="flex flex-col items-center bg-gray-100 w-full py-8">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-6xl">
    <h2 class="text-2xl font-bold mb-6 text-center text-green-700">Liste des Boutiques Validées</h2>
    
    <table class="min-w-full text-sm border border-gray-300">
      <thead class="bg-gray-500 text-white uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left border-b">Nom et Prénom</th>
          <th class="py-3 px-4 text-left border-b">Email</th>
          <th class="py-3 px-4 text-left border-b">Nom de la Boutique</th>
          <th class="py-3 px-4 text-left border-b">Adresse</th>
          <th class="py-3 px-4 text-left border-b">Horaires</th>
          <th class="py-3 px-4 text-left border-b">Contact</th>
          <th class="py-3 px-4 text-center border-b">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr class="border-b hover:bg-gray-100 text-center">
              <td class="py-3 px-4 text-left"><?= htmlspecialchars($row['nom_complet']) ?></td>
              <td class="py-3 px-4 text-left"><?= htmlspecialchars($row['email']) ?></td>
              <td class="py-3 px-4 text-left"><?= htmlspecialchars($row['nom_boutique']) ?></td>
              <td class="py-3 px-4 text-left"><?= htmlspecialchars($row['adresse_boutique']) ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($row['horaires_ouverture']) ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($row['contact']) ?></td>
              <td class="py-3 px-4 flex justify-center space-x-2">
              <a href="view-boutique.php?id=<?= $row['id'] ?>" 
              class="inline-block text-blue-500 hover:text-blue-700">
              <i class="fa fa-eye text-xl"></i>
                </a>

                <a href="edit-boutique.php?id=<?= $row['id'] ?>" 
                class="inline-block text-yellow-500 hover:text-yellow-700">
                <i class="fa fa-edit text-xl"></i>
                </a>

                <a href="?delete_id=<?= $row['id'] ?>" 
                  onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette boutique ?');"
                  class="inline-block text-red-500 hover:text-red-700">
                    <i class="fa fa-trash text-xl"></i>
                </a>

              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="py-4 text-center text-gray-500">Aucune boutique validée pour le moment.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Pagination 
    <div class="flex justify-end mt-6 space-x-2">
      <button class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400">Précédent</button>
      <button class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-700">1</button>
      <button class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400">2</button>
      <button class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400">Suivant</button>
    </div>
    -->
  </div>
</div>
</div>

<?php include('./templates/footer.php'); ?>
