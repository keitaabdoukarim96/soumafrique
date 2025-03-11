<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

include('./admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

// Vérifier si les données JSON sont reçues
$data = file_get_contents("php://input");
if (!$data) {
    echo json_encode(["error" => "Aucune donnée reçue"]);
    exit;
}

$decodedData = json_decode($data, true);
if (!$decodedData) {
    echo json_encode(["error" => "Données JSON invalides", "rawData" => $data]);
    exit;
}

// Extraction des filtres
$searchQuery = "%" . ($decodedData['search'] ?? '') . "%";
$sortValue = $decodedData['sort'] ?? 'default';
$availableOnly = $decodedData['available'] ?? 0;
$minPrice = $decodedData['min_price'] ?? 0;
$maxPrice = $decodedData['max_price'] ?? 100;
$selectedCategoriesEpice = $decodedData['categoriesEpices'] ?? [];
$selectedCategoriesRecette = $decodedData['categoriesRecettes'] ?? [];
$selectedTypes = $decodedData['types'] ?? [];

// **1️⃣ Préparer la requête pour les épices avec toutes les informations nécessaires**
$sql_epices = "SELECT e.id, e.nom_epice AS name, e.image_epice AS image, 'epice' AS type, 
                      e.epicerie_nom, e.adresse, e.horaires, e.disponibilite, 
                      c.nom_categorie AS categorie
               FROM epicerie e
               LEFT JOIN categorie_epice c ON e.id = c.id
               WHERE e.nom_epice LIKE ?";

$params = [$searchQuery];

// Filtrer par disponibilité
if ($availableOnly) {
    $sql_epices .= " AND e.disponibilite = 'en_stock'";
}

// Filtrer par catégories si sélectionnées
if (!empty($selectedCategoriesEpice)) {
    $placeholders = implode(',', array_fill(0, count($selectedCategoriesEpice), '?'));
    $sql_epices .= " AND c.nom_categorie IN ($placeholders)";
    $params = array_merge($params, $selectedCategoriesEpice);
}

// **2️⃣ Préparer la requête pour les recettes avec toutes les informations nécessaires**
$sql_recettes = "SELECT r.id, r.recipe_name AS name, r.main_image AS image, 'recette' AS type,
                        r.cooking_time, r.servings, r.cooking_method, r.budget,
                        cr.nom AS categorie
                 FROM recette r
                 LEFT JOIN categorie_recette cr ON r.id = cr.id
                 WHERE r.recipe_name LIKE ?";

$params_recettes = [$searchQuery];

// Filtrer par catégories si sélectionnées
if (!empty($selectedCategoriesRecette)) {
    $placeholders = implode(',', array_fill(0, count($selectedCategoriesRecette), '?'));
    $sql_recettes .= " AND cr.nom IN ($placeholders)";
    $params_recettes = array_merge($params_recettes, $selectedCategoriesRecette);
}

// **3️⃣ Fusionner les résultats**
$results = [];

// Exécuter la requête pour les épices
$stmt = mysqli_prepare($conn, $sql_epices);
mysqli_stmt_bind_param($stmt, str_repeat("s", count($params)), ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $row['image'] = !empty($row['image']) ? "admin/uploads/" . ltrim($row['image'], "./uploads/") : "assets/img/no-image.png";
    
    // Ajouter les détails formatés
    $row['detail'] = "Boutique: " . htmlspecialchars($row['epicerie_nom']) . "<br>"
                   . "Adresse: " . htmlspecialchars($row['adresse']) . "<br>"
                   . "Horaire: " . htmlspecialchars($row['horaires']) . "<br>"
                   . "Disponibilité: " . ($row['disponibilite'] == 'en_stock' ? 'En stock' : 'Rupture de stock');
    
    $results[] = $row;
}

// Exécuter la requête pour les recettes
$stmt = mysqli_prepare($conn, $sql_recettes);
mysqli_stmt_bind_param($stmt, str_repeat("s", count($params_recettes)), ...$params_recettes);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $row['image'] = !empty($row['image']) ? "admin/uploads/" . ltrim($row['image'], "./uploads/") : "assets/img/no-image.png";

    // Ajouter les détails formatés
    $row['detail'] = "Durée: " . htmlspecialchars($row['cooking_time']) . " min<br>"
                   . "Portions: " . htmlspecialchars($row['servings']) . " pers.<br>"
                   . "Mode de cuisson: " . htmlspecialchars($row['cooking_method']) . "<br>"
                   . "Budget: " . htmlspecialchars($row['budget']) . " €";
    
    $results[] = $row;
}

// **4️⃣ Envoyer la réponse JSON**
echo json_encode($results);
exit;
