<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

// Récupérer les catégories depuis la base de données
$query = "SELECT * FROM categorie_recette ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<div class="flex min-h-screen">
<?php include('sidebar2.php'); ?>
<div class="flex-1 p-6">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full">
    <h2 class="text-lg font-bold mb-4 text-center">Catégories de Recettes Africaines</h2>
    <table class="w-full text-sm border border-gray-300">
      <thead class="bg-gray-200 text-gray-600 uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left border-b">ID</th>
          <th class="py-3 px-4 text-left border-b">Nom de la catégorie</th>
          <th class="py-3 px-4 text-left border-b">Description</th>
          <th class="py-3 px-4 text-center border-b">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4"><?php echo htmlspecialchars($row['id']); ?></td>
          <td class="py-3 px-4 font-semibold"><?php echo htmlspecialchars($row['nom']); ?></td>
          <td class="py-3 px-4"><?php echo htmlspecialchars($row['description']); ?></td>
          <td class="border py-3 px-4 text-center"> 
            <div class="flex items-center justify-center space-x-4">
                <!-- Icône Voir -->
                <a href="view-category.php?id=<?= $row['id'] ?>" 
                   class="inline-block text-blue-500 hover:text-blue-700">
                    <i class="fa fa-eye text-xl"></i>
                </a>
                <!-- Icône Modifier -->
                <a href="edit-category.php?id=<?= $row['id'] ?>" 
                   class="inline-block text-yellow-500 hover:text-yellow-700">
                    <i class="fa fa-edit text-xl"></i>
                </a>
                <!-- Icône Supprimer -->
                <a href="?delete_id=<?= $row['id'] ?>" 
                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');"
                   class="inline-block text-red-500 hover:text-red-700">
                    <i class="fa fa-trash text-xl"></i>
                </a>
            </div>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
</div>

<?php mysqli_close($conn); ?>
<?php include('./templates/footer.php'); ?>
