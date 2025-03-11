<?php
include('./admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

// Vérification du paramètre
if (!isset($_GET['query']) || empty($_GET['query'])) {
    echo json_encode(["error" => "Aucun terme de recherche fourni"]);
    exit;
}

$searchTerm = "%" . $_GET['query'] . "%";

// Debugging : Vérifier si la connexion est établie
if (!$conn) {
    echo json_encode(["error" => "Erreur de connexion à la base de données"]);
    exit;
}

// Requête SQL sans COLLATE
$sql = "
    (SELECT id, nom_epice AS name, image_epice AS image, 'epice' AS type 
     FROM epicerie WHERE nom_epice LIKE ? OR details LIKE ? LIMIT 5)
    UNION
    (SELECT id, recipe_name AS name, main_image AS image, 'recette' AS type 
     FROM recette WHERE recipe_name LIKE ? OR description LIKE ? LIMIT 5)
    UNION
    (SELECT id, nom_boutique AS name, '' AS image, 'boutique' AS type 
     FROM proprietaire WHERE nom_boutique LIKE ? OR adresse_boutique LIKE ? LIMIT 5)
";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    echo json_encode(["error" => "Erreur dans la préparation de la requête SQL"]);
    exit;
}

mysqli_stmt_bind_param($stmt, 'ssssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$results = [];
while ($row = mysqli_fetch_assoc($result)) {
   
    $results[] = $row;
}
foreach ($results as &$row) {
    if (!empty($row['image'])) {
        // Supprimer "./uploads/" pour les recettes
        if ($row['type'] === 'recette' && strpos($row['image'], './uploads/') !== false) {
            $row['image'] = str_replace("./uploads/", "admin/uploads/", $row['image']);
        } else {
            // Ajouter proprement "admin/uploads/" pour les épices et boutiques
            $row['image'] = "admin/uploads/" . ltrim($row['image'], "/");
        }
    } else {
        // Image par défaut si aucune image n'est disponible
        $row['image'] = "assets/img/no-image.png"; 
    }
}






// Vérifier si le résultat est vide
if (empty($results)) {
    echo json_encode(["message" => "Aucun résultat trouvé"]);
    exit;
}

echo json_encode($results);
?>
