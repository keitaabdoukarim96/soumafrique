<?php
include('../admin/config/db.php');

$searchTerm = $_GET['query'] ?? '';

$sql = "SELECT id, recipe_name, main_image, cooking_time, servings, cooking_method, budget, category_id, description 
        FROM recette 
        WHERE recipe_name LIKE ? 
        OR cooking_method LIKE ? 
        OR category_id LIKE ? 
        OR description LIKE ?
        ORDER BY id DESC LIMIT 10";

$stmt = mysqli_prepare($conn, $sql);
$likeTerm = "%$searchTerm%";
mysqli_stmt_bind_param($stmt, 'ssss', $likeTerm, $likeTerm, $likeTerm, $likeTerm);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td class="border p-2 text-center"><?= $row['id'] ?></td>
        <td class="border p-2"><?= htmlspecialchars($row['recipe_name']) ?></td>
        <td class="border p-2 text-center">
            <?php if (!empty($row['main_image'])): ?>
                <img src="<?= str_replace('./uploads/', 'uploads/', htmlspecialchars($row['main_image'])) ?>"
                     class="w-16 h-16 object-cover rounded">
            <?php endif; ?>
        </td>
        <td class="border p-2 text-center"><?= htmlspecialchars($row['cooking_time']) ?> min</td>
        <td class="border p-2 text-center"><?= htmlspecialchars($row['servings']) ?></td>
        <td class="border p-2"><?= htmlspecialchars($row['cooking_method']) ?></td>
        <td class="border p-2 text-center"><?= htmlspecialchars($row['budget']) ?> €</td>
        <td class="border p-2"><?= htmlspecialchars($row['category_id']) ?></td>
        <td class="border p-2">
            <?php
            $desc = explode(' ', strip_tags($row['description']));
            $excerpt = implode(' ', array_slice($desc, 0, 10));
            echo htmlspecialchars($excerpt) . (count($desc) > 10 ? '...' : '');
            ?>
        </td>
        <td class="border p-2 text-center">
            <div class="flex space-x-2">
                <!-- Bouton Voir -->
                <a href="view-recette.php?id=<?= $row['id'] ?>"
                   class="inline-block text-blue-500 hover:text-blue-700">
                    <i class="fa fa-eye text-xl"></i>
                </a>
                <!-- Bouton Modifier -->
                <a href="edit-recette.php?id=<?= $row['id'] ?>"
                   class="inline-block text-yellow-500 hover:text-yellow-700">
                    <i class="fa fa-edit text-xl"></i>
                </a>
                <!-- Bouton Supprimer -->
                <a href="?delete_id=<?= $row['id'] ?>"
                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');"
                   class="inline-block text-red-500 hover:text-red-700">
                    <i class="fa fa-trash text-xl"></i>
                </a>
            </div>
        </td>
    </tr>
<?php endwhile; ?>
