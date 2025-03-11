<?php
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

$search = isset($_POST['query']) ? $_POST['query'] : '';

$sql = "SELECT id, nom_epice, image_epice, epicerie_nom, horaires, adresse, contact_epicerie, disponibilite, details 
        FROM epicerie 
        WHERE nom_epice LIKE ? OR epicerie_nom LIKE ? OR adresse LIKE ? 
        ORDER BY id DESC LIMIT 5";

$stmt = mysqli_prepare($conn, $sql);
$searchParam = "%$search%";
mysqli_stmt_bind_param($stmt, 'sss', $searchParam, $searchParam, $searchParam);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$output = '';
while ($row = mysqli_fetch_assoc($result)) {
    $output .= '
        <tr>
            <td class="border p-2 text-center">' . $row['id'] . '</td>
            <td class="border p-2">' . htmlspecialchars($row['nom_epice']) . '</td>
            <td class="border p-2 text-center">';
    if (!empty($row['image_epice'])) {
        $output .= '<img src="./uploads/' . htmlspecialchars($row['image_epice']) . '" class="w-16 h-16 object-cover rounded">';
    } else {
        $output .= '<p class="text-red-500">Aucune image</p>';
    }
    $output .= '</td>
            <td class="border p-2">' . htmlspecialchars($row['epicerie_nom']) . '</td>
            <td class="border p-2">' . htmlspecialchars($row['horaires']) . '</td>
            <td class="border p-2">' . htmlspecialchars($row['adresse']) . '</td>
            <td class="border p-2">' . htmlspecialchars($row['contact_epicerie']) . '</td>
            <td class="border p-2 text-center">' . (strpos($row['disponibilite'], 'en_stock') !== false ? 'En stock' : 'En rupture') . '</td>
            <td class="border p-2">' . htmlspecialchars(substr(strip_tags($row['details']), 0, 50)) . '...</td>
            <td class="border p-2 text-center">
                <div class="flex space-x-2">
                    <a href="view-epice.php?id=' . $row['id'] . '" class="inline-block text-blue-500 hover:text-blue-700"><i class="fa fa-eye text-xl"></i></a>
                    <a href="edit-epice.php?id=' . $row['id'] . '" class="inline-block text-yellow-500 hover:text-yellow-700"><i class="fa fa-edit text-xl"></i></a>
                    <a href="?delete_id=' . $row['id'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette épice ?\');" class="inline-block text-red-500 hover:text-red-700"><i class="fa fa-trash text-xl"></i></a>
                </div>
            </td>
        </tr>';
}
echo $output;
?>
