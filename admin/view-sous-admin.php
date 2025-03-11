<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

$success_message = "";

// Vérifier si la suppression a été effectuée avec succès
if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    $success_message = "Sous-admin supprimé avec succès.";
}

// Suppression d'un sous-admin si l'ID est passé en paramètre
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        header("Location: view-sous-admin.php?deleted=1");
        exit();
    }
    $stmt->close();
}

// Récupérer les sous-admins
$query = "SELECT id, nom, email, role, date_creation FROM admin WHERE role = 'sous-admin'";
$result = $conn->query($query);
?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6">
        <h2 class="text-lg font-bold mb-4 text-center">Liste des Sous-Admins</h2>
        <?php if (!empty($success_message)) { ?>
            <p id="success-message" class="text-green-500 text-center"><?php echo $success_message; ?></p>
        <?php } ?>
        <div class="bg-white shadow-lg rounded-lg p-6 w-full">
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Nom</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">Rôle</th>
                        <th class="border p-2">Date de Création</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td class="border p-2 text-center"><?php echo $row['id']; ?></td>
                            <td class="border p-2 text-center"><?php echo htmlspecialchars($row['nom']); ?></td>
                            <td class="border p-2 text-center"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="border p-2 text-center"><?php echo htmlspecialchars($row['role']); ?></td>
                            <td class="border p-2 text-center"><?php echo $row['date_creation']; ?></td>
                            <td class="border p-2 text-center">
                                <a href="edit-sous-admin.php?id=<?php echo $row['id']; ?>" class="inline-block text-yellow-500 hover:text-yellow-700"><i class="fa fa-edit text-xl"></i></a> |
                                <a href="view-sous-admin.php?delete_id=<?php echo $row['id']; ?>" class="inline-block text-red-500 hover:text-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sous-admin ?');"><i class="fa fa-trash text-xl"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Faire disparaître le message après 3 secondes
    setTimeout(function() {
        let messageElement = document.getElementById('success-message');
        if (messageElement) {
            messageElement.style.display = 'none';
        }
    }, 3000);
</script>

<?php include('./templates/footer.php'); ?>
