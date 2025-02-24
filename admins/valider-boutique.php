<?php

include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
session_start(); // Démarrer la session pour récupérer les données
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}

// Traitement de la validation/rejet (sans AJAX)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['action'])) {
  $id = intval($_POST['id']);
  $action = $_POST['action'];

  if ($action == "valider") {
      $status = "validé";
      $_SESSION['message'] = "✅ Boutique validée avec succès !";
  } elseif ($action == "rejeter") {
      $status = "rejeté";
      $_SESSION['message'] = "❌ Boutique rejetée avec succès !";
  } else {
      $_SESSION['message'] = "⚠️ Erreur : Action non reconnue.";
  }

  // Mise à jour de la base de données
  $query = "UPDATE proprietaire SET status = ? WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "si", $status, $id);
  
  if (mysqli_stmt_execute($stmt)) {
      $_SESSION['status-update'] = true; // Pour forcer l'affichage du message
  } else {
      $_SESSION['message'] = "⚠️ Erreur lors de la mise à jour.";
  }

  mysqli_stmt_close($stmt);

  // Rafraîchir la page après mise à jour
  header("Location: valider-boutique.php");
  exit();
}

// Récupérer les boutiques
$query = "SELECT * FROM proprietaire";
$result = mysqli_query($conn, $query);
?>
<?php include('header.php'); ?>
<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2">

    <nav class="text-sm">
      <!-- Dashboard -->
      <a href="admin-dashboard.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
      </a>

      <!-- Gestion des utilisateurs -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-users mr-3"></i> Gestion des clients
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700 " id="add-user-link">
            <i class="fas fa-user-plus mr-3"></i> Ajouter un utilisateur
          </a>
          <a href="liste-clients.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-users-cog mr-3"></i> Voir les utilisateurs
          </a>
        </div>
      </div>
      <!-- Catégories d'épices -->

      <!-- Gestion des boutiques -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-store mr-3"></i> Gestion des boutiques
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="liste-boutique.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="manage-shops-link">
            <i class="fas fa-tools mr-3"></i> Gérer les boutiques
          </a>
          <a href="valider-boutique.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="validate-shop-link">
            <i class="fas fa-check-circle mr-3"></i> Valider une boutique
          </a>
          <a href="ajouter-boutique.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700 " id="add-product-link">
            <i class="fas fa-plus mr-3"></i> Ajouter un produit
          </a>
        </div>
      </div>
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-leaf mr-3"></i> Catégories d'épices
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="view-spice-categories-link">
            <i class="fas fa-list mr-3"></i> Voir les catégories
          </a>
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="add-spice-category-link">
            <i class="fas fa-plus mr-3"></i> Ajouter une catégorie
          </a>
        </div>
      </div>
      <!-- Les recettes -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-utensils mr-3"></i> Les recettes
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="view-recipe-categories-link">
            <i class="fas fa-list mr-3"></i> Voir les catégories de recettes
          </a>
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="add-recipe-link">
            <i class="fas fa-plus mr-3"></i> Ajouter une recette
          </a>
        </div>
      </div>
      <!-- Les rôles -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-user-tag mr-3"></i> Les rôles
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="view-roles-link">
            <i class="fas fa-eye mr-3"></i> Voir les rôles
          </a>
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="add-role-link">
            <i class="fas fa-user-shield mr-3"></i> Ajouter un rôle
          </a>
        </div>
      </div>

      <!-- Commandes -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-box mr-3"></i> Commandes
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="manage-orders-link">
            <i class="fas fa-tasks mr-3"></i> Gérer les commandes
          </a>

        </div>
      </div>

      <!-- Livraison -->
      <div class="group">
        <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-truck mr-3"></i> Livraison
          <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
        </a>
        <div class="hidden pl-8 space-y-2 group-hover:block">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="manage-deliveries-link">
            <i class="fas fa-spinner mr-3"></i> Gérer les Livraisons
          </a>

        </div>
      </div>

      <!-- Déconnexion -->
      <a href="logout.php" class="flex items-center py-2 px-4 rounded hover:bg-red-600">
        <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
      </a>
    </nav>
  </aside>
  <!-- Contenu principal -->
  <main class="flex-1 bg-gray-100 p-6">
    <div id="dynamic-content">
      <h1 class="text-2xl font-bold mb-6">Bienvenue sur le Dashboard, <span class="text-red-600"><?php echo htmlspecialchars($_SESSION["nom"]); ?></span></h1>
      <!-- Tableau -->
      <div class="bg-white shadow-md rounded-lg overflow-hidden w-full max-w-5xl mx-auto">
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
                                <form method="POST" action="valider-boutique.php">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="valider">
                                    <button type="submit" class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600">✔</button>
                                </form>
                                <form method="POST" action="valider-boutique.php">
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
    </div>
  </main>
</div>
</body>
</html>