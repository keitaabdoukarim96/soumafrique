<?php
require_once './config/db.php'; // Connexion à la base

// Vérifier si une recherche est envoyée
$search = isset($_POST['search']) ? trim($_POST['search']) : '';

// Construire la requête SQL avec filtrage
$query = "SELECT id, nom, email, created_at FROM users";
if ($search !== '') {
    $query .= " WHERE nom LIKE '%$search%' OR email LIKE '%$search%'";
}

$result = mysqli_query($conn, $query);

// Afficher les résultats sous forme de tableau
if (mysqli_num_rows($result) > 0) {
    while ($user = mysqli_fetch_assoc($result)) {
        echo '<tr class="border-b hover:bg-gray-100">';
        echo '<td class="py-3 px-4">' . htmlspecialchars($user['id']) . '</td>';
        echo '<td class="py-3 px-4">' . htmlspecialchars($user['nom']) . '</td>';
        echo '<td class="py-3 px-4">' . htmlspecialchars($user['email']) . '</td>';
        echo '<td class="py-3 px-4">' . htmlspecialchars($user['created_at']) . '</td>';
        echo '<td class="py-3 px-4 text-center">';
        echo '<button class="bg-blue-500 text-white py-1 px-2 rounded text-xs">Voir</button> ';
        echo '<button class="bg-yellow-500 text-white py-1 px-2 rounded text-xs">Modifier</button> ';
        echo '<button class="bg-red-500 text-white py-1 px-2 rounded text-xs">Supprimer</button>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5" class="py-3 px-4 text-center text-gray-500">Aucun utilisateur trouvé.</td></tr>';
}
?>
