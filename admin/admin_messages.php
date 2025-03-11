<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

// Nombre d'éléments par page
$limit = 5;
$offset = isset($_GET['page']) ? ($_GET['page'] - 1) * $limit : 0;

$message = ''; // Initialisation du message

// Suppression si un `delete_id` est passé dans l'URL
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM messages WHERE id = ?";
    if ($delete_stmt = mysqli_prepare($conn, $delete_query)) {
        mysqli_stmt_bind_param($delete_stmt, 'i', $delete_id);
        if (mysqli_stmt_execute($delete_stmt)) {
            $message = '<p class="text-green-500 text-center" id="delete-message">Le message a été supprimé avec succès.</p>';
        } else {
            $message = '<p class="text-red-500 text-center" id="delete-message">Erreur lors de la suppression du message.</p>';
        }
        mysqli_stmt_close($delete_stmt);
    }
}

// Récupérer les messages avec une limite et un offset
$query = "SELECT id, name, email, subject, message, created_at FROM messages ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Compter le nombre total de messages
$total_query = "SELECT COUNT(*) as count FROM messages";
$total_result = mysqli_query($conn, $total_query);
$total_count = mysqli_fetch_assoc($total_result)['count'];
$total_pages = ceil($total_count / $limit);
?>

<div class="flex min-h-screen">
<?php include('sidebar2.php'); ?>
<div class="flex-1 p-6">
  <div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-lg font-bold mb-4 text-center">📩 Messages Reçus</h2>

    <!-- Message de suppression -->
    <?php if ($message): ?>
      <?= $message ?>
    <?php endif; ?>

    <table class="table-auto w-full border-collapse border border-gray-300">
      <thead class="bg-gray-200 text-gray-600 uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left border">Nom</th>
          <th class="py-3 px-4 text-left border">Email</th>
          <th class="py-3 px-4 text-left border">Sujet</th>
          <th class="py-3 px-4 text-left border">Message</th>
          <th class="py-3 px-4 text-left border">Date</th>
          <th class="py-3 px-4 text-center border">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php
        // Parcourir les résultats et afficher chaque ligne
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr class="border-b hover:bg-gray-100">';
            echo '<td class="py-3 px-4 font-semibold border">' . htmlspecialchars($row['name']) . '</td>';
            echo '<td class="py-3 px-4 font-semibold border">' . htmlspecialchars($row['email']) . '</td>';
            echo '<td class="py-3 px-4 border">' . htmlspecialchars($row['subject']) . '</td>';
            echo '<td class="py-3 px-4 border">' . nl2br(htmlspecialchars($row['message'])) . '</td>';
            echo '<td class="py-3 px-4 border">' . htmlspecialchars($row['created_at']) . '</td>';
            echo '<td class="py-3 px-4 text-center border">';
            echo '<a href="reply_message.php?id=' . $row['id'] . '" class="inline-block text-blue-500 hover:text-blue-700 mr-2"><i class="fa fa-reply text-xl"></i></a>';
           
            echo '<button class="inline-block text-red-500 hover:text-red-700" onclick="return confirmDeletion(' . $row['id'] . ')"><i class="fa fa-trash text-xl"></i></button>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
      </tbody>
    </table>

    <!-- Boutons de pagination -->
    <div class="flex justify-end mt-4 space-x-2">
      <?php if ($offset > 0): ?>
          <a href="?page=<?php echo $offset / $limit; ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">Retour</a>
      <?php endif; ?>
      <?php if ($offset + $limit < $total_count): ?>
          <a href="?page=<?php echo ($offset / $limit) + 2; ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">Suivant</a>
      <?php endif; ?>
    </div>
  </div>
</div>
</div>

<script>
  function confirmDeletion(id) {
    if (confirm("Voulez-vous vraiment supprimer ce message ?")) {
      window.location.href = '?delete_id=' + id;
      return true;
    }
    return false;
  }

  // Faire disparaître le message après 2 secondes
  const deleteMessage = document.getElementById('delete-message');
  if (deleteMessage) {
    setTimeout(() => {
      deleteMessage.style.display = 'none';
    }, 3000);
  }
</script>

<?php include('./templates/footer.php'); ?>
