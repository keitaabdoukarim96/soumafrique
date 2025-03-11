<?php
include('../admin/config/db.php');

$query = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT id, nom_complet, email, nom_boutique, adresse_boutique, horaires_ouverture, contact, role 
        FROM proprietaire 
        WHERE nom_complet LIKE ? 
        OR nom_boutique LIKE ? 
        OR email LIKE ? 
        OR adresse_boutique LIKE ? 
        OR horaires_ouverture LIKE ? 
        OR contact LIKE ? 
        OR role LIKE ? 
        ORDER BY id DESC LIMIT 10";

$stmt = mysqli_prepare($conn, $sql);
$searchTerm = "%" . $query . "%";
mysqli_stmt_bind_param($stmt, "sssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td class='border p-2 text-center'>{$row['id']}</td>
            <td class='border p-2'>".htmlspecialchars($row['nom_complet'])."</td>
            <td class='border p-2'>".htmlspecialchars($row['email'])."</td>
            <td class='border p-2'>".htmlspecialchars($row['nom_boutique'])."</td>
            <td class='border p-2'>".htmlspecialchars($row['adresse_boutique'])."</td>
            <td class='border p-2'>".htmlspecialchars($row['horaires_ouverture'])."</td>
            <td class='border p-2'>".htmlspecialchars($row['contact'])."</td>
            <td class='border p-2 text-center'>".htmlspecialchars($row['role'])."</td>
            <td class='border p-2 text-center'>
                <div class='flex space-x-2'>
                    <a href='view-boutique.php?id={$row['id']}' class='inline-block text-blue-500 hover:text-blue-700'>
                        <i class='fa fa-eye text-xl'></i>
                    </a>
                    <a href='edit-boutique.php?id={$row['id']}' class='inline-block text-yellow-500 hover:text-yellow-700'>
                        <i class='fa fa-edit text-xl'></i>
                    </a>
                    <a href='?delete_id={$row['id']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette boutique ?\");' class='inline-block text-red-500 hover:text-red-700'>
                        <i class='fa fa-trash text-xl'></i>
                    </a>
                </div>
            </td>
          </tr>";
}
?>
