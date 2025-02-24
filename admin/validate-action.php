<?php
// Inclure la connexion à la base de données
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4"); // Correction de l'encodage

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}

// Traitement des actions (validation ou rejet)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['action'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    // Définir le statut en fonction de l'action
    if ($action == "valider") {
        $status = "validé";
        $_SESSION['message'] = "✅ Boutique validée avec succès !";
    } elseif ($action == "rejeter") {
        $status = "rejeté";
        $_SESSION['message'] = "❌ Boutique rejetée avec succès !";
    } else {
        $_SESSION['message'] = "⚠️ Action non reconnue.";
    }

    // Mise à jour de la base de données
    $query = "UPDATE proprietaire SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $status, $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = $action === "valider"
            ? "✅ Boutique validée avec succès !"
            : "❌ Boutique rejetée avec succès !";
    } else {
        $_SESSION['message'] = "⚠️ Erreur lors de la mise à jour.";
    }

    mysqli_stmt_close($stmt);
}

// Récupérer les boutiques à afficher
$query = "SELECT * FROM proprietaire";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoumAfrique - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-100 flex">
    <!-- Sidebar -->
     <!-- Sidebar -->



    <!-- Contenu principal -->
    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-6">Validation des Propriétaires</h1>

        <!-- Message de succès -->
        <?php if (isset($_SESSION['message'])) : ?>
            <div id="successMessage" class="bg-green-500 text-white text-center py-2 rounded mb-3">
                <?php echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <script>
                setTimeout(() => {
                    document.getElementById('successMessage').style.display = 'none';
                }, 4000);
            </script>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <!-- Tableau -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full bg-white border border-gray-300">
                <thead class="bg-black text-white text-sm">
                    <tr>
                        <th class="py-2 px-2">Nom Complet</th>
                        <th class="py-2 px-2">Email</th>
                        <th class="py-2 px-2">Nom Boutique</th>
                        <th class="py-2 px-2">Adresse</th>
                        <th class="py-2 px-2">Horaires</th>
                        <th class="py-2 px-2">Contact</th>
                        <th class="py-2 px-2">Statut</th>
                        <th class="py-2 px-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="border-b">
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['nom_complet'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['nom_boutique'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['adresse_boutique'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['horaires_ouverture'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['contact'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2">
                                <?php 
                                    if ($row['status'] == "en_attente") {
                                        echo "<span class='bg-yellow-500 text-white px-2 py-1 rounded'>Attente</span>";
                                    } elseif ($row['status'] == "validé") {
                                        echo "<span class='bg-green-500 text-white px-2 py-1 rounded'>Validé</span>";
                                    } else {
                                        echo "<span class='bg-red-500 text-white px-2 py-1 rounded'>Rejeté</span>";
                                    }
                                ?>
                            </td>
                            <td class="py-2 px-2 flex justify-center gap-1">
                                <form method="POST" class="inline" action="validate-action.php">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="valider">
                                    <button type="submit" class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600">✔</button>
                                </form>
                                <form method="POST" class="inline" action="validate-action.php">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="rejeter">
                                    <button type="submit" class="bg-red-500 text-white text-xs px-2 py-1 rounded hover:bg-red-600">✖</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
<?php
// Fermer la connexion
mysqli_close($conn);
?>
