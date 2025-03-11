<?php
include('./templates/header.php');
include('../admin/config/db.php'); // Connexion à la base de données
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}

// Récupérer les statistiques
$query_users = "SELECT COUNT(*) AS total_users FROM users";
$query_boutiques = "SELECT COUNT(*) AS total_boutiques FROM proprietaire";
$query_epices = "SELECT COUNT(*) AS total_epices FROM epicerie";
$query_recettes = "SELECT COUNT(*) AS total_recettes FROM recette";

$result_users = mysqli_query($conn, $query_users);
$result_boutiques = mysqli_query($conn, $query_boutiques);
$result_epices = mysqli_query($conn, $query_epices);
$result_recettes = mysqli_query($conn, $query_recettes);

$total_users = mysqli_fetch_assoc($result_users)['total_users'];
$total_boutiques = mysqli_fetch_assoc($result_boutiques)['total_boutiques'];
$total_epices = mysqli_fetch_assoc($result_epices)['total_epices'];
$total_recettes = mysqli_fetch_assoc($result_recettes)['total_recettes'];

// Récupérer les dernières entrées avec images et détails
$query_latest_epices = "SELECT id, nom_epice, image_epice, poids_net, prix, epicerie_nom, horaires, adresse, contact_epicerie, disponibilite, details FROM epicerie ORDER BY id DESC LIMIT 5";
$query_latest_boutiques = "SELECT id, nom_complet, email, nom_boutique, adresse_boutique, ville, horaires_ouverture, contact, role FROM proprietaire ORDER BY id DESC LIMIT 5";

$query_latest_recettes = " SELECT id, recipe_name, main_image, cooking_time, servings, cooking_method, budget, category_id, description FROM recette ORDER BY id DESC LIMIT 5";

$latest_epices = mysqli_query($conn, $query_latest_epices);
$latest_boutiques = mysqli_query($conn, $query_latest_boutiques);
$latest_recettes = mysqli_query($conn, $query_latest_recettes);

?>


<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6">

        <!-- Cartes statistiques -->
        <!-- Cartes statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <h5 class="text-lg font-semibold">Utilisateurs</h5>
                    <h2 class="text-3xl font-bold" id="totalUsers"><?= $total_users ?></h2>
                </div>
                <i class="fas fa-users fa-3x opacity-75"></i>
            </div>

            <div class="bg-green-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <h5 class="text-lg font-semibold">Boutiques</h5>
                    <h2 class="text-3xl font-bold" id="totalBoutiques"><?= $total_boutiques ?></h2>
                </div>
                <i class="fas fa-store fa-3x opacity-75"></i>
            </div>

            <div class="bg-yellow-500 text-gray-900 p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <h5 class="text-lg font-semibold">Épices</h5>
                    <h2 class="text-3xl font-bold" id="totalEpices"><?= $total_epices ?></h2>
                </div>
                <i class="fas fa-pepper-hot fa-3x opacity-75"></i>
            </div>

            <div class="bg-red-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <h5 class="text-lg font-semibold">Recettes</h5>
                    <h2 class="text-3xl font-bold" id="totalRecettes"><?= $total_recettes ?></h2>
                </div>
                <i class="fas fa-utensils fa-3x opacity-75"></i>
            </div>
        </div>



        <!-- Tableaux récapitulatifs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Dernières épices -->
            <div class="bg-white shadow-lg rounded-lg p-4">
                <h2 class="text-lg font-bold mb-2">Dernières Épices</h2>
                <!-- Formulaire de recherche -->
                    <div class="flex justify-end mb-4">
                        <input type="text" id="searchEpices" placeholder="Rechercher une épice..."
                            class="border rounded-lg p-2 w-64 focus:ring focus:ring-blue-500">
                    </div>
                    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">ID</th>
                <th class="border p-2">Nom</th>
                <th class="border p-2">Image</th>
                <th class="border p-2">Épicerie</th>
                <th class="border p-2">Horaires</th>
                <th class="border p-2">Adresse</th>
                <th class="border p-2">Contact</th>
                <th class="border p-2">Disponibilité</th>
                <th class="border p-2">Détails</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody id="epicesTable">
            <?php while ($row = mysqli_fetch_assoc($latest_epices)): ?>
                <tr>
                    <td class="border p-2 text-center"><?= $row['id'] ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['nom_epice']) ?></td>
                    <td class="border p-2 text-center">
                        <?php if (!empty($row['image_epice'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['image_epice']) ?>"
                                class="w-16 h-16 object-cover rounded">
                        <?php else: ?>
                            <p class="text-red-500">Aucune image</p>
                        <?php endif; ?>
                    </td>
                    <td class="border p-2"><?= htmlspecialchars($row['epicerie_nom']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['horaires']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['adresse']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['contact_epicerie']) ?></td>
                    <td class="border p-2 text-center">
                        <?= strpos($row['disponibilite'], 'en_stock') !== false ? 'En stock' : 'En rupture' ?>
                    </td>
                    <td class="border p-2">
                        <?php
                        $desc = explode(' ', strip_tags($row['details']));
                        $excerpt = implode(' ', array_slice($desc, 0, 10));
                        echo htmlspecialchars($excerpt) . (count($desc) > 10 ? '...' : '');
                        ?>
                    </td>
                    <td class="border p-2 text-center">
                        <div class="flex space-x-2">
                            <a href="view-epice.php?id=<?= $row['id'] ?>"
                                class="inline-block text-blue-500 hover:text-blue-700">
                                <i class="fa fa-eye text-xl"></i>
                            </a>
                            <a href="edit-epice.php?id=<?= $row['id'] ?>"
                                class="inline-block text-yellow-500 hover:text-yellow-700">
                                <i class="fa fa-edit text-xl"></i>
                            </a>
                            <a href="?delete_id=<?= $row['id'] ?>"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette épice ?');"
                                class="inline-block text-red-500 hover:text-red-700">
                                <i class="fa fa-trash text-xl"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
            </div>

<!-- Dernières Boutiques -->
<div class="bg-white shadow-lg rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">Dernières Boutiques</h2>
        <input type="text" id="search-boutiques" placeholder="Rechercher..." class="border px-3 py-2 rounded-lg">
    </div>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">ID</th>
                <th class="border p-2">Nom Complet</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Nom Boutique</th>
                <th class="border p-2">Adresse</th>
                <th class="border p-2">Horaires</th>
                <th class="border p-2">Contact</th>
                <th class="border p-2">Rôle</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody id="table-boutiques">
            <?php while ($row = mysqli_fetch_assoc($latest_boutiques)): ?>
                <tr>
                    <td class="border p-2 text-center"><?= $row['id'] ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['nom_complet']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['email']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['nom_boutique']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['adresse_boutique']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['horaires_ouverture']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['contact']) ?></td>
                    <td class="border p-2 text-center"><?= htmlspecialchars($row['role']) ?></td>
                    <td class="border p-2 text-center">
                        <div class="flex space-x-2">
                            <a href="view-boutique.php?id=<?= $row['id'] ?>" class="inline-block text-blue-500 hover:text-blue-700">
                                <i class="fa fa-eye text-xl"></i>
                            </a>
                            <a href="edit-boutique.php?id=<?= $row['id'] ?>" class="inline-block text-yellow-500 hover:text-yellow-700">
                                <i class="fa fa-edit text-xl"></i>
                            </a>
                            <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette boutique ?');" class="inline-block text-red-500 hover:text-red-700">
                                <i class="fa fa-trash text-xl"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Script AJAX pour la recherche dynamique -->
<script>
document.getElementById("search-boutiques").addEventListener("keyup", function() {
    let searchValue = this.value.trim();

    fetch("search-boutiques.php?query=" + searchValue)
        .then(response => response.text())
        .then(data => {
            document.getElementById("table-boutiques").innerHTML = data;
        });
});
</script>


<!-- Dernières Recettes avec Recherche Dynamique -->
<div class="bg-white shadow-lg rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">Dernières Recettes</h2>
        <!-- Champ de recherche aligné à droite -->
        <input type="text" id="search-recettes" 
               class="border p-2 rounded w-1/3 focus:ring  " 
               placeholder=" Rechercher une recette...">
    </div>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">ID</th>
                <th class="border p-2">Nom</th>
                <th class="border p-2">Image</th>
                <th class="border p-2">Temps de cuisson</th>
                <th class="border p-2">Portions</th>
                <th class="border p-2">Méthode</th>
                <th class="border p-2">Budget</th>
                <th class="border p-2">Catégorie</th>
                <th class="border p-2">Description</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody id="recette-table-body">
            <?php while ($row = mysqli_fetch_assoc($latest_recettes)): ?>
                <tr>
                    <td class="border p-2 text-center"><?= $row['id'] ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['recipe_name']) ?></td>
                    <td class="border p-2 text-center">
                        <?php if (!empty($row['main_image'])): ?>
                            <img src="uploads/<?= htmlspecialchars(basename($row['main_image'])) ?>"
                                 class="w-16 h-16 object-cover rounded">
                        <?php endif; ?>
                    </td>
                    <td class="border p-2 text-center"><?= htmlspecialchars($row['cooking_time']) ?> min</td>
                    <td class="border p-2 text-center"><?= htmlspecialchars($row['servings']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['cooking_method']) ?></td>
                    <td class="border p-2 text-center"><?= htmlspecialchars($row['budget']) ?> €</td>
                    <td class="border p-2"><?= htmlspecialchars($row['category_id']) ?></td>
                    <td class="border p-2">
                        <?php
                        $desc = explode(' ', strip_tags($row['description']));
                        $excerpt = implode(' ', array_slice($desc, 0, 10));
                        echo htmlspecialchars($excerpt) . (count($desc) > 10 ? '...' : '');
                        ?>
                    </td>
                    <td class="border p-2 text-center">
                        <div class="flex space-x-2">
                            <!-- Bouton Voir -->
                            <a href="view-recette.php?id=<?= $row['id'] ?>"
                               class="inline-block text-blue-500 hover:text-blue-700">
                                <i class="fa fa-eye text-xl"></i>
                            </a>
                            <!-- Bouton Modifier -->
                            <a href="edit-recette.php?id=<?= $row['id'] ?>"
                               class="inline-block text-yellow-500 hover:text-yellow-700">
                                <i class="fa fa-edit text-xl"></i>
                            </a>
                            <!-- Bouton Supprimer -->
                            <a href="?delete_id=<?= $row['id'] ?>"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');"
                               class="inline-block text-red-500 hover:text-red-700">
                                <i class="fa fa-trash text-xl"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Script AJAX pour la Recherche Dynamique -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-recettes");
    const tableBody = document.getElementById("recette-table-body");

    searchInput.addEventListener("input", function() {
        const searchTerm = this.value.toLowerCase();

        fetch("search-recettes.php?query=" + searchTerm)
            .then(response => response.text())
            .then(data => {
                tableBody.innerHTML = data;
            });
    });
});
</script>


        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 w-full">
            <h2 class="text-lg font-bold mb-4 text-center">Évolution des Données</h2>
            <div class="w-full" style="height: 400px;">
                <canvas id="statsChart"></canvas>
            </div>
        </div>


    </div>
</div>

<?php include('./templates/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("statsChart").getContext("2d");
        var statsChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Utilisateurs", "Boutiques", "Épices", "Recettes"],
                datasets: [{
                    label: "Nombre total",
                    data: [<?= $total_users ?>, <?= $total_boutiques ?>, <?= $total_epices ?>, <?= $total_recettes ?>],
                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true, // Rend la courbe responsive
                maintainAspectRatio: false, // Permet d'occuper toute la largeur
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Affiche uniquement des nombres entiers
                        }
                    },
                    x: {
                        grid: {
                            display: false // Supprime les lignes inutiles sur l'axe X
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Cache la légende si elle n'est pas nécessaire
                    }
                }
            }
        });
    });
</script>

<!--Ajoutons ce script pour mettre à jour le tableau en temps réel.-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateDashboard() {
            fetch("fetch-dashboard-data.php")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("totalUsers").textContent = data.total_users;
                    document.getElementById("totalBoutiques").textContent = data.total_boutiques;
                    document.getElementById("totalEpices").textContent = data.total_epices;
                    document.getElementById("totalRecettes").textContent = data.total_recettes;

                    // Mettre à jour la courbe des statistiques
                    statsChart.data.datasets[0].data = [
                        data.total_users,
                        data.total_boutiques,
                        data.total_epices,
                        data.total_recettes
                    ];
                    statsChart.update();
                })
                .catch(error => console.error("Erreur lors de la récupération des données:", error));
        }

        // Actualiser toutes les 5 secondes
        setInterval(updateDashboard, 5000);
    });
</script>

<script>
document.getElementById('searchEpices').addEventListener('keyup', function() {
    let query = this.value;

    fetch('search-epices.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'query=' + encodeURIComponent(query)
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('epicesTable').innerHTML = data;
    });
});
</script>


<!-- Script AJAX pour la recherche dynamique -->
<script>
document.getElementById("search-boutiques").addEventListener("keyup", function() {
    let searchValue = this.value.trim();

    fetch("search-boutiques.php?query=" + searchValue)
        .then(response => response.text())
        .then(data => {
            document.getElementById("table-boutiques").innerHTML = data;
        });
});
</script>


<!-- Script AJAX pour la Recherche Dynamique -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-recettes");
    const tableBody = document.getElementById("recette-table-body");

    searchInput.addEventListener("input", function() {
        const searchTerm = this.value.toLowerCase();

        fetch("search-recettes.php?query=" + searchTerm)
            .then(response => response.text())
            .then(data => {
                tableBody.innerHTML = data;
            });
    });
});
</script>