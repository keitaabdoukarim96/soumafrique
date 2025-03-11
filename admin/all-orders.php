<?php
session_start();
include('../admin/config/db.php');
include('templates/header.php');
?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Gestion des Commandes</h2>
        <div class="bg-white shadow-lg rounded-lg p-6">
            <!-- Récupérer les commandes -->
            <?php
            $query = "SELECT commandes.id, commandes.total, commandes.date_commande, commandes.statut, users.nom
                      FROM commandes
                      LEFT JOIN users ON commandes.user_id = users.id
                      ORDER BY commandes.date_commande DESC";
            $result = $conn->query($query);
            ?>

            <!-- Table des commandes -->
            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Client</th>
                        <th class="border px-4 py-2">Total (€)</th>
                        <th class="border px-4 py-2">Statut</th>
                        <th class="border px-4 py-2">Date</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="border-b">
                            <td class="border px-4 py-2 text-center">#<?= $row['id']; ?></td>
                            <td class="border px-4 py-2 text-center"><?= htmlspecialchars($row['nom'] ?? 'Client invité'); ?></td>
                            <td class="border px-4 py-2 text-center font-bold text-green-600">
                                <?= number_format($row['total'], 2, ',', ' '); ?> €
                            </td>
                            <td class="border px-4 py-2 text-center <?= getStatusClass($row['statut']); ?>">
                                <?= ucfirst($row['statut']); ?>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <?= date('d/m/Y H:i', strtotime($row['date_commande'])); ?>
                            </td>
                            <td class="border px-4 py-2 text-center">
    <select class="status-select border px-2 py-1" data-order-id="<?= $row['id']; ?>">
        <option value="en_attente" <?= $row['statut'] == 'en_attente' ? 'selected' : ''; ?>>En attente</option>
        <option value="confirmé" <?= $row['statut'] == 'confirmé' ? 'selected' : ''; ?>>Confirmé</option>
        <option value="expédié" <?= $row['statut'] == 'expédié' ? 'selected' : ''; ?>>Expédié</option>
        <option value="livré" <?= $row['statut'] == 'livré' ? 'selected' : ''; ?>>Livré</option>
        <option value="annulé" <?= $row['statut'] == 'annulé' ? 'selected' : ''; ?>>Annulé</option>
    </select>
</td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".status-select").forEach(select => {
        select.addEventListener("change", function () {
            let orderId = this.dataset.orderId;
            let newStatus = this.value;

            fetch("update-order-status.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `commande_id=${orderId}&statut=${newStatus}`
            })
            .then(response => response.json())
            .then(data => {
                console.log("Réponse JSON :", data); // ✅ Debug dans la console

                if (data.success) {
                    alert("Commande mise à jour avec succès !");
                } else {
                    alert("Erreur : " + data.error);
                }
            })
            .catch(error => console.error("Erreur Fetch:", error)); // ✅ Debug en cas d'erreur AJAX
        });
    });
});
</script>


<?php include('templates/footer.php'); ?>

<?php
// Fonction pour styliser le statut
function getStatusClass($status) {
    switch ($status) {
        case 'en_attente': return 'text-yellow-500 font-bold';
        case 'confirmé': return 'text-blue-500 font-bold';
        case 'expédié': return 'text-purple-500 font-bold';
        case 'livré': return 'text-green-500 font-bold';
        case 'annulé': return 'text-red-500 font-bold';
        default: return '';
    }
}
?>
