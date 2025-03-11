<?php
// Connexion à la base de données
include('./templates/header.php');
// Récupérer la position de l'utilisateur (via JS)

// Vérification du paramètre
if (!isset($_GET['query']) || empty($_GET['query'])) {
    echo "<p class='text-center text-gray-600'>Aucun terme de recherche fourni.</p>";
    exit;
}

$searchTerm = "%" . $_GET['query'] . "%";

$sql = "
    (SELECT id, nom_epice AS name, image_epice AS image, 'epice' AS type 
     FROM epicerie WHERE nom_epice LIKE ? OR details LIKE ?)
    UNION
    (SELECT id, recipe_name AS name, main_image AS image, 'recette' AS type 
     FROM recette WHERE recipe_name LIKE ? OR description LIKE ?)
    UNION
    (SELECT id, nom_boutique AS name, '' AS image, 'boutique' AS type 
     FROM proprietaire WHERE nom_boutique LIKE ? OR adresse_boutique LIKE ?)
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ssssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$results = [];
while ($row = mysqli_fetch_assoc($result)) {
    if (!empty($row['image'])) {
        $row['image'] = "admin/uploads/" . $row['image'];
    }
    $results[] = $row;
}
?>






<main class="flex-grow mt-20 mb-20 px-4">
  <div class="container mx-auto">
            <h1 class="text-2xl font-bold text-center mb-6 mt-10">Résultats pour : "<?= htmlspecialchars($_GET['query']) ?>"</h1>

<!-- Grille d'affichage -->
<!-- Grille d'affichage -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php if (!empty($results)): ?>
        <?php foreach ($results as $row): ?>
            <a href="<?= $row['type'] === 'epice' ? 'detail-epice.php?id=' . $row['id'] :
                        ($row['type'] === 'recette' ? 'detail-recette.php?id=' . $row['id'] :
                        'view-boutique.php?id=' . $row['id']) ?>"
               class="block bg-white shadow-md rounded-lg overflow-hidden transition transform hover:scale-105 hover:shadow-xl">
                
                <!-- Vérification et affichage de l'image -->
                <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                    <?php if (!empty($row['image'])): ?>
                        <img src="<?= htmlspecialchars($row['image']) ?>" class="w-full h-full object-cover">
                    <?php elseif ($row['type'] === 'recette' && !empty($row['main_image'])): ?>
                        <img src="./admin/uploads/<?= htmlspecialchars($row['main_image']); ?>" 
                             alt="<?= htmlspecialchars($row['recipe_name']); ?>" 
                             class="w-full h-48 object-cover">
                    <?php else: ?>
                        <img src="assets/img/no-image.png" class="w-24 h-24 object-cover opacity-50">
                    <?php endif; ?>
                </div>

                <!-- Informations sur l'élément -->
                <div class="p-4 text-center">
                    <p class="font-semibold text-lg"><?= htmlspecialchars($row['name']) ?></p>
                    <span class="text-sm text-gray-500"><?= strtoupper($row['type']) ?></span>
                   
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center text-gray-600 col-span-full">Aucun résultat trouvé.</p>
    <?php endif; ?>
</div>



        </div>
     
        </main>


<!-- Footer -->
<?php include('./templates/footer.php'); ?>
