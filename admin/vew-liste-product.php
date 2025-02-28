<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

// Nombre d'éléments par page
$limit = 5;

// Récupérer la page courante à partir de l'URL, ou 1 si non défini
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

// Calculer l'offset
$offset = ($page - 1) * $limit;

// Récupérer les données des épices avec une limite et un offset
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
    LIMIT $limit OFFSET $offset
";
$result = mysqli_query($conn, $sql);

// Compter le nombre total d'enregistrements
$count_sql = "SELECT COUNT(*) AS total FROM epicerie";
$count_result = mysqli_query($conn, $count_sql);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);
?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">LISTE DES EPICES</h1>

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
    <!-- Conteneur pour disposer les icônes horizontalement avec espace -->
    <div class="flex items-center justify-center space-x-4">
        <!-- Icône Voir -->
        <a href="view-epice.php?id=<?= $row['id'] ?>" 
           class="inline-block text-blue-500 hover:text-blue-700">
            <i class="fa fa-eye text-xl"></i>
        </a>
        <!-- Icône Modifier -->
        <a href="edit-epice.php?id=<?= $row['id'] ?>" 
           class="inline-block text-yellow-500 hover:text-yellow-700">
            <i class="fa fa-edit text-xl"></i>
        </a>
        <!-- Icône Supprimer -->
        <a href="delete-epice.php?id=<?= $row['id'] ?>" 
           class="inline-block text-red-500 hover:text-red-700">
            <i class="fa fa-trash text-xl"></i>
        </a>
    </div>
</td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Boutons de pagination -->
        <div class="flex justify-end mt-4 space-x-2">
            <!-- Bouton Retour -->
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">Retour</a>
            <?php endif; ?>

            <!-- Bouton Suivant -->
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">Suivant</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('./templates/footer.php'); ?>