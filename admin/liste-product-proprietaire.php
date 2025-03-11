<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
session_start();
include('./templates/header.php');

// Vérifier si la session contient un utilisateur connecté
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}

// Récupérer l'ID du propriétaire connecté
$user_id = $_SESSION["id"];

// Gérer la suppression d'une épice
$message = '';
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    // Vérifier que l'épice appartient bien au propriétaire connecté avant suppression
    $delete_sql = "DELETE FROM epicerie WHERE id = ? AND proprietaire_id = ?";
    $stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($stmt, 'ii', $delete_id, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $message = '<p class="text-green-500 text-center" id="success-message">Épice supprimée avec succès.</p>';
        echo "<script>
                setTimeout(() => {
                    window.location.href = '".$_SERVER['PHP_SELF']."';
                }, 3000);
              </script>";
    } else {
        $message = '<p class="text-red-500 text-center">Erreur lors de la suppression de l\'épice.</p>';
    }
    mysqli_stmt_close($stmt);
}

// Nombre d'éléments par page
$limit = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Récupérer uniquement les épices ajoutées par le propriétaire connecté
$sql = "
    SELECT 
        epicerie.id,
        epicerie.nom_epice,
        epicerie.image_epice,
        epicerie.disponibilite,
        categorie_epice.nom_categorie AS categorie,
        epicerie.details
    FROM 
        epicerie
    LEFT JOIN 
        categorie_epice 
    ON 
        epicerie.categorie_id = categorie_epice.id
    WHERE 
        epicerie.proprietaire_id = ?
    LIMIT ? OFFSET ?
";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'iii', $user_id, $limit, $offset);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Compter le nombre total d'enregistrements pour le propriétaire connecté
$count_sql = "SELECT COUNT(*) AS total FROM epicerie WHERE proprietaire_id = ?";
$count_stmt = mysqli_prepare($conn, $count_sql);
mysqli_stmt_bind_param($count_stmt, 'i', $user_id);
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);
?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">MES ÉPICES</h1>

        <!-- Affichage des messages -->
        <?= $message ?>

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-300 w-full">
                <thead class="bg-gray-200 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="border py-3 px-4 text-left">Nom Epice</th>
                        <th class="border py-3 px-4 text-center">Image</th>
                        <th class="border py-3 px-4 text-center">Disponible</th>
                        <th class="border py-3 px-4 text-center">Catégorie</th>
                        <th class="border py-3 px-4 text-left">Détail</th>
                        <th class="border py-3 px-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border py-3 px-4"><?= htmlspecialchars($row['nom_epice']) ?></td>
                            <td class="border py-3 px-4 text-center">
                                <?php if (!empty($row['image_epice'])): ?>
                                    <img src="./uploads/<?= htmlspecialchars($row['image_epice']) ?>" alt="<?= htmlspecialchars($row['nom_epice']) ?>" class="w-16 h-16 object-cover rounded">
                                <?php endif; ?>
                            </td>
                            <td class="border py-3 px-4 text-center">
                                <?= strpos($row['disponibilite'], 'en_stock') !== false ? 'En stock' : 'En rupture' ?>
                            </td>
                            <td class="border py-3 px-4 text-center"><?= htmlspecialchars($row['categorie']) ?></td>
                            <td class="border py-3 px-4">
                                <?php
                                $words = explode(' ', strip_tags($row['details']));
                                $excerpt = implode(' ', array_slice($words, 0, 5));
                                echo htmlspecialchars($excerpt) . (count($words) > 5 ? '...' : '');
                                ?>
                            </td>
                            <td class="border py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-4">
                                    <a href="view-epice.php?id=<?= $row['id'] ?>" class="inline-block text-blue-500 hover:text-blue-700">
                                        <i class="fa fa-eye text-xl"></i>
                                    </a>
                                    <a href="edit-product-proprietaire.php?id=<?= $row['id'] ?>" class="inline-block text-yellow-500 hover:text-yellow-700">
                                        <i class="fa fa-edit text-xl"></i>
                                    </a>
                                    <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette épice ?');" class="inline-block text-red-500 hover:text-red-700">
                                        <i class="fa fa-trash text-xl"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-end mt-4 space-x-2">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">Retour</a>
            <?php endif; ?>
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">Suivant</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('./templates/footer.php'); ?>
