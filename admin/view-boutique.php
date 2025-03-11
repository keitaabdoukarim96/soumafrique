<?php
include('./templates/header.php');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

// Vérifier si un ID est passé en paramètre
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p class='text-red-500 text-center'>Boutique non trouvée.</p>";
    exit();
}

$id = intval($_GET['id']);

// Récupérer les informations de la boutique
$sql = "SELECT id, nom_complet, email, nom_boutique, adresse_boutique, ville, pays, 
               horaires_ouverture, contact, status, password_temporaire, role
        FROM proprietaire 
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$boutique = mysqli_fetch_assoc($result);

if (!$boutique) {
    echo "<p class='text-red-500 text-center'>Aucune boutique trouvée.</p>";
    exit();
}
?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6 flex flex-col items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-lg font-bold mb-4 text-center text-green-700">Détails de la Boutique</h2>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">ID:</label>
                <p class="text-gray-900"><?= $boutique['id'] ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Nom Complet:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['nom_complet']) ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Email:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['email']) ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Nom Boutique:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['nom_boutique']) ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Adresse:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['adresse_boutique']) ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Ville:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['ville']) ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Pays:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['pays']) ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Horaires:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['horaires_ouverture']) ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Contact:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['contact']) ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Statut:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['status']) ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Mot de passe temporaire:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['password_temporaire']) ?></p>
            </div>

            <div class="mb-4">
                <label class="font-semibold text-gray-700">Rôle:</label>
                <p class="text-gray-900"><?= htmlspecialchars($boutique['role']) ?></p>
            </div>

            <div class="text-center mt-6">
                <a href="boutique-valider.php" class="btn-gradient text-white py-2 px-4 rounded-lg hover:bg-gray-700">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>

<?php include('./templates/footer.php'); ?>
