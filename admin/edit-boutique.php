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

// Gestion de la mise à jour
$message = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_complet = trim($_POST['nom_complet']);
    $email = trim($_POST['email']);
    $nom_boutique = trim($_POST['nom_boutique']);
    $adresse_boutique = trim($_POST['adresse_boutique']);
    $ville = trim($_POST['ville']);
    $pays = trim($_POST['pays']);
    $horaires_ouverture = trim($_POST['horaires_ouverture']);
    $contact = trim($_POST['contact']);
    $status = trim($_POST['status']);
    $role = trim($_POST['role']);

    $update_sql = "UPDATE proprietaire SET 
        nom_complet = ?, email = ?, nom_boutique = ?, adresse_boutique = ?, 
        ville = ?, pays = ?, horaires_ouverture = ?, contact = ?, status = ?, role = ? 
        WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssssi', 
        $nom_complet, $email, $nom_boutique, $adresse_boutique, 
        $ville, $pays, $horaires_ouverture, $contact, $status, $role, $id
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = '<p class="text-green-500" id="success-message">Mise à jour effectuée avec succès.</p>';
        echo "<script>
                setTimeout(() => {
                    window.location.href = 'boutique-valider.php';
                }, 2000);
              </script>";
    } else {
        $message = '<p class="text-red-500">Erreur lors de la mise à jour.</p>';
    }
    mysqli_stmt_close($stmt);
}
?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6 flex flex-col items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-lg font-bold mb-4 text-center text-yellow-700">Modifier la Boutique</h2>
            
            <!-- Message de succès ou d'erreur -->
            <?= $message ?>

            <!-- Formulaire de modification -->
            <form id="edit-boutique-form" class="space-y-4" method="post">
                <div class="mb-4">
                    <label class="font-semibold text-gray-700">Nom Complet :</label>
                    <input type="text" name="nom_complet" value="<?= htmlspecialchars($boutique['nom_complet']) ?>" 
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-gray-700">Email :</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($boutique['email']) ?>" 
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-gray-700">Nom Boutique :</label>
                    <input type="text" name="nom_boutique" value="<?= htmlspecialchars($boutique['nom_boutique']) ?>" 
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-gray-700">Adresse :</label>
                    <input type="text" name="adresse_boutique" value="<?= htmlspecialchars($boutique['adresse_boutique']) ?>" 
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-gray-700">Ville :</label>
                    <input type="text" name="ville" value="<?= htmlspecialchars($boutique['ville']) ?>" 
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-gray-700">Pays :</label>
                    <input type="text" name="pays" value="<?= htmlspecialchars($boutique['pays']) ?>" 
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-gray-700">Horaires :</label>
                    <input type="text" name="horaires_ouverture" value="<?= htmlspecialchars($boutique['horaires_ouverture']) ?>" 
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-gray-700">Contact :</label>
                    <input type="text" name="contact" value="<?= htmlspecialchars($boutique['contact']) ?>" 
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-gray-700">Statut :</label>
                    <select name="status" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
                        <option value="validé" <?= ($boutique['status'] === 'validé') ? 'selected' : '' ?>>Validé</option>
                        <option value="en attente" <?= ($boutique['status'] === 'en attente') ? 'selected' : '' ?>>En attente</option>
                        <option value="rejeté" <?= ($boutique['status'] === 'rejeté') ? 'selected' : '' ?>>Rejeté</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-gray-700">Rôle :</label>
                    <select name="role" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
                        <option value="propriétaire" <?= ($boutique['role'] === 'propriétaire') ? 'selected' : '' ?>>Propriétaire</option>
                        <option value="admin" <?= ($boutique['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="btn-gradient text-white py-2 px-4 rounded-lg hover:bg-yellow-700">
                        Enregistrer
                    </button>
                </div>
            </form>

            <div class="text-center mt-6">
                <a href="boutique-valider.php" class="btn-gradient text-white py-2 px-4 rounded-lg hover:bg-gray-700">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>

<?php include('./templates/footer.php'); ?>
