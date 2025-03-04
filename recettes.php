<?php
// Connexion à la base de données
header('Content-Type: text/html; charset=utf-8');
include('./admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

// Nombre de recettes par page
$limit = 6;

if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Récupérer les recettes
    $sql = "SELECT id, recipe_name, main_image, cooking_time, servings, cooking_method, budget, description 
            FROM recette 
            LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $sql);

    // Compter le nombre total de pages
    $count_result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM recette");
    $total_count = mysqli_fetch_assoc($count_result)['count'];
    $total_pages = ceil($total_count / $limit);

    // Préparer les données JSON
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => intval($row['id']),
            'recipe_name' => htmlspecialchars($row['recipe_name']),
            'main_image' => htmlspecialchars($row['main_image']),
            'cooking_time' => htmlspecialchars($row['cooking_time']),
            'servings' => htmlspecialchars($row['servings']),
            'cooking_method' => htmlspecialchars($row['cooking_method']),
            'budget' => htmlspecialchars($row['budget']),
            'description' => htmlspecialchars($row['description']),
        ];
    }

    echo json_encode(['data' => $data, 'total_pages' => $total_pages]);
    exit();
}

// Calcul du total des pages pour la pagination (non utilisé dans AJAX)
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM recette");
$total_count = mysqli_fetch_assoc($total_result)['count'];
$total_pages = ceil($total_count / $limit);
?>


<!--Header start-->
<?php include('./templates/header.php'); ?>
<!--Header end-->

<section class="relative">
  <div class="relative w-full h-[70vh]">
    <!-- Image de fond -->
    <img src="assets/img/contact-banner.png" alt="Bannière Contact" class="absolute inset-0 w-full h-full object-cover">
    <!-- Superposition sombre et formulaire de recherche centré -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4" style="padding-top: calc(80px + 1rem);">
      <!-- Barre de recherche centrée -->
      <div class="bg-white bg-opacity-70 rounded-lg p-4 shadow-lg max-w-md w-full">
        <form class="flex items-center">
          <input
            type="text"
            placeholder="Recherchez une épice ou une recette"
            class="flex-grow py-2 px-4 rounded-l-lg focus:outline-none"
          />
          <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-r-lg">
            <i class="fas fa-search"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<main class="flex-grow mt-10 mb-10">
  <div class="flex">
    <!-- Sidebar -->
    <aside class="w-1/4 bg-gray-100 shadow-lg">
      <!-- Titre FILTRER -->
      <div class="bg-green-700 text-white p-4">
        <h2 class="text-lg font-bold flex items-center">
          <i class="fas fa-sliders-h mr-2"></i> FILTRER
        </h2>
      </div>
      <!-- Contenu de la sidebar -->
      <div class="space-y-6 p-4">
        <!-- Recherche -->
        <section>
          <h3 class="font-bold text-gray-700 mb-2">RECHERCHE</h3>
          <input type="text" placeholder="Taper 'Recette...'" class="w-full py-2 px-4 border rounded bg-gray-200 focus:outline-none">
        </section>
        <!-- Filtrage par catégorie -->
        <section>
          <h3 class="font-bold text-gray-700 mb-2">PAR CATÉGORIE DE RECETTES</h3>
          <ul class="space-y-2 ml-4">
            <li><label><input type="checkbox" class="mr-2"> Entrées</label></li>
            <li><label><input type="checkbox" class="mr-2"> Plats principaux</label></li>
            <li><label><input type="checkbox" class="mr-2"> Desserts</label></li>
          </ul>
          <h3 class="font-bold text-gray-700 mb-2">FILTRAGE PAR BUDGET</h3>
          <div class="space-y-4 ml-4">
            <!-- Curseur de budget -->
            <div>
              <label for="budget-range" class="block text-sm font-medium text-gray-700">Budget (€)</label>
              <input type="range" id="budget-range" min="5" max="100" step="1" class="w-full">
              <div class="flex justify-between text-sm text-gray-500 mt-1">
                <span>5 €</span>
                <span>100 €</span>
              </div>
            </div>
            <!-- Entrées manuelles -->
            <div class="flex space-x-2">
              <input type="number" placeholder="Min (€)" class="w-1/2 py-2 px-3 border rounded bg-gray-200 focus:outline-none">
              <input type="number" placeholder="Max (€)" class="w-1/2 py-2 px-3 border rounded bg-gray-200 focus:outline-none">
            </div>
          </div>
          <h3 class="font-bold text-gray-700 mb-2 mt-4">FILTRAGE PAR INGRÉDIENTS</h3>
          <input type="text" placeholder="Ex: Poulet, Riz..." class="w-full py-2 px-3 border rounded bg-gray-200 focus:outline-none">
          <h3 class="font-bold text-gray-700 mt-2 uppercase">Recettes avec Épices entières</h3>
          <ul class="space-y-2 ml-4">
            <li><label><input type="checkbox" class="mr-2"> Marinades pour viandes </label></li>
            <li><label><input type="checkbox" class="mr-2"> Ragoût de poisson épicé</label></li>
            <li><label><input type="checkbox" class="mr-2"> Riz parfumé</label></li>
          </ul>
        </section>
        
        <!-- Bouton de validation -->
        <button class="font-bold btn-gradient hover:shadow-lg text-white px-4 py-2 rounded w-full mt-6">
          Appliquer
        </button>
      </div>
    </aside>

    <!-- Contenu principal -->
    <div class="w-full lg:w-3/4 p-4">
      <h2 class="text-2xl font-bold mb-6 text-center underline">Les Recettes</h2>
      <div id="recettes-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Les recettes seront chargées ici par AJAX -->
      </div>
      <div class="flex justify-center mt-8 space-x-4">
        <button id="prev-btn" class="bg-green-700 text-white px-4 py-2 rounded-lg" data-page="1">
          <i class="fas fa-arrow-left"></i>
        </button>
        <button id="next-btn" class="bg-green-700 text-white px-4 py-2 rounded-lg" data-page="2">
          <i class="fas fa-arrow-right"></i>
        </button>
      </div>
    </div>
  </div>
</main>

<!-- Footer start-->
<?php include('./templates/footer.php'); ?>
<!--Footer end-->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const recettesContainer = document.getElementById('recettes-container');
  const prevBtn = document.getElementById('prev-btn');
  const nextBtn = document.getElementById('next-btn');
  let currentPage = 1;

  function loadRecettes(page) {
    fetch(`recettes.php?ajax=1&page=${page}`)
      .then(response => response.json())
      .then(data => {
        recettesContainer.innerHTML = data.data.map(recette => `
          <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
            <img src="${recette.main_image.replace('./uploads/', './admin/uploads/')}" alt="${recette.recipe_name}" class="w-full h-48 object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold text-gray-800">${recette.recipe_name}</h3>
              <p class="text-sm text-gray-600"><strong>Durée:</strong> ${recette.cooking_time} min</p>
              <p class="text-sm text-gray-600"><strong>Portions:</strong> ${recette.servings} personnes</p>
              <p class="text-sm text-gray-600"><strong>Mode de cuisson:</strong> ${recette.cooking_method}</p>
              <p class="text-sm text-gray-600"><strong>Budget:</strong> ${recette.budget}€</p>
              <div class="flex justify-center items-center mt-4">
                <a href="details/detail-recette.php?id=${recette.id}" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">VOIR LES DÉTAILS</a>
              </div>
            </div>
          </div>
        `).join('');

        prevBtn.style.display = page === 1 ? 'none' : 'block';
        nextBtn.style.display = page >= data.total_pages ? 'none' : 'block';
      })
      .catch(error => console.error('Erreur lors du chargement des recettes:', error));
  }

  prevBtn.addEventListener('click', () => {
    if (currentPage > 1) {
      currentPage -= 1;
      loadRecettes(currentPage);
    }
  });

  nextBtn.addEventListener('click', () => {
    currentPage += 1;
    loadRecettes(currentPage);
  });

  loadRecettes(currentPage);
});
</script>