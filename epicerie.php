<?php
// Connexion à la base de données
header('Content-Type: text/html; charset=utf-8');
include('./admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

// Nombre d'éléments par page
$limit = 6;

if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Inclure l'id et epicerie_nom dans la requête SQL
    $sql = "SELECT id, nom_epice, image_epice, adresse, horaires, disponibilite, epicerie_nom FROM epicerie LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $sql);

    // Compter le nombre total de pages
    $count_result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM epicerie");
    $total_count = mysqli_fetch_assoc($count_result)['count'];
    $total_pages = ceil($total_count / $limit);

    // Préparer les données JSON
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => intval($row['id']),
            'nom_epice' => htmlspecialchars($row['nom_epice']),
            'image_epice' => htmlspecialchars($row['image_epice']),
            'adresse' => htmlspecialchars($row['adresse']),
            'horaires' => htmlspecialchars($row['horaires']),
            'disponibilite' => htmlspecialchars($row['disponibilite']),
            'boutique' => htmlspecialchars($row['epicerie_nom']),
        ];
    }

    // Ajouter le nombre total de pages
    echo json_encode(['data' => $data, 'total_pages' => $total_pages]);
    exit();
}

// Calcul du total pour les boutons de pagination (non utilisé dans l’AJAX)
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM epicerie");
$total_count = mysqli_fetch_assoc($total_result)['count'];
$total_pages = ceil($total_count / $limit);
?>
<!--Header start-->
<?php include('./templates/header.php'); ?>
<!--Header end-->

<section class="relative">
  <div class="relative w-full h-[70vh]">
    <!-- Image de fond -->
    <img src="assets/img/contact-banner.png" alt="Bannière Épicerie" class="absolute inset-0 w-full h-full object-cover">
    <!-- Superposition sombre et formulaire de recherche centré -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4" style="padding-top: calc(80px + 1rem);">
      <!-- Barre de recherche centrée -->
      <div class="bg-white bg-opacity-70 rounded-lg p-4 shadow-lg max-w-md w-full">
        <form class="flex items-center">
          <input
            type="text"
            placeholder="Recherchez une épice"
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
  <div class="flex flex-col lg:flex-row">
    <!-- Sidebar -->
    <aside class="w-full lg:w-1/4 bg-gray-100 shadow-lg">
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
          <input type="text" placeholder="Taper 'Soum...'" class="w-full py-2 px-4 border rounded bg-gray-200 focus:outline-none">
        </section>

        <!-- Trier par catégorie -->
        <section>
          <h3 class="font-bold text-gray-700 mb-2 uppercase">Trier par lettre</h3>
          <ul class="space-y-2">
            <li><label><input type="checkbox" class="mr-2"> A-Z, Z-A</label></li>
          </ul>
        </section>

        <section>
          <h3 class="font-bold text-gray-700 mb-2">PAR CATÉGORIE D'ÉPICE</h3>
          <ul class="space-y-2">
            <label class="mr-2">Épices Entières</label>
            <ul class="ml-4 space-y-1">
              <li><label><input type="checkbox" class="mr-2"> Graines</label></li>
              <li><label><input type="checkbox" class="mr-2"> Baies</label></li>
            </ul>
            <li><label><input type="checkbox" class="mr-2"> Épices Moulues ou en Poudre</label></li>
            <ul class="ml-4 space-y-1">
              <li><label><input type="checkbox" class="mr-2"> Poudre de Kinkeliba</label></li>
              <li><label><input type="checkbox" class="mr-2"> Poudre de Baobab</label></li>
            </ul>
          </ul>
        </section>

        <section>
          <h3 class="font-bold text-gray-700 mb-2 uppercase">Par Prix</h3>
          <ul class="space-y-2">
            <ul class="ml-4 space-y-1">
              <li><label><input type="radio" class="mr-2"> Moins de 5 €.</label></li>
              <li><label><input type="radio" class="mr-2"> 5 € - 10 €</label></li>
              <li><label><input type="radio" class="mr-2"> Plus de 10 €</label></li>
            </ul>
          </ul>
        </section>

        <!-- Comparateur de prix -->
        <section>
          <h3 class="font-bold text-gray-700 mb-2">COMPARATEUR DE PRIX ENTRE BOUTIQUES</h3>
          <ul class="space-y-2">
            <li><label><input type="radio" name="price-compare" class="mr-2"> Boutique A : 8 €/100g</label></li>
            <li><label><input type="radio" name="price-compare" class="mr-2"> Boutique B : 7,5 €/100g</label></li>
            <li><label><input type="radio" name="price-compare" class="mr-2"> Boutique C : 9 €/100g</label></li>
          </ul>
        </section>

        <!-- Bouton Appliquer -->
        <button class="font-bold btn-gradient hover:shadow-lg text-white px-4 py-2 rounded w-full mt-4">
          Appliquer
        </button>
      </div>
    </aside>

    <!-- Contenu principal -->
    <div class="w-full lg:w-3/4 p-4">
      <h2 class="text-2xl font-bold mb-6 text-center underline">Les Épices</h2>
      <div id="epices-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Les épices seront chargées ici par AJAX -->
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
  const epicesContainer = document.getElementById('epices-container');
  const prevBtn = document.getElementById('prev-btn');
  const nextBtn = document.getElementById('next-btn');
  let currentPage = 1;

  // Fonction pour charger les données via AJAX
  function loadEpices(page) {
    fetch(`epicerie.php?ajax=1&page=${page}`)
      .then(response => response.json())
      .then(data => {
        // Mettre à jour le contenu des épices
        epicesContainer.innerHTML = data.data.map(epice => {
          const disponibiliteText = epice.disponibilite === "en_stock" ? "En stock" : "Rupture de stock";
          const disponibiliteClass = epice.disponibilite === "en_stock" ? "text-green-500" : "text-red-500";

          return `
            <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
              <img src="./admin/uploads/${epice.image_epice}" alt="${epice.nom_epice}" class="w-full h-48 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800">${epice.nom_epice}</h3>
                <p class="text-sm text-gray-600"><strong>Boutique:</strong> ${epice.boutique}</p>
                <p class="text-sm text-gray-600"><strong>Adresse:</strong> ${epice.adresse}</p>
                <p class="text-sm text-gray-600"><strong>Horaire:</strong> ${epice.horaires}</p>
                <p class="text-sm ${disponibiliteClass}"><strong>Disponibilité:</strong> ${disponibiliteText}</p>
                <div class="flex justify-center items-center mt-4">
                  <a href="details/detail-epice.php?id=${epice.id}" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">VOIR LES DÉTAILS</a>
                </div>
              </div>
            </div>
          `;
        }).join('');

        // Vérifier si on est à la première page
        if (page === 1) {
          prevBtn.style.display = 'none';
        } else {
          prevBtn.style.display = 'block';
        }

        // Vérifier si on est à la dernière page
        if (page >= data.total_pages) {
          nextBtn.style.display = 'none';
        } else {
          nextBtn.style.display = 'block';
        }
      })
      .catch(error => console.error('Erreur lors du chargement des épices:', error));
  }

  // Gestion des boutons de pagination
  prevBtn.addEventListener('click', () => {
    if (currentPage > 1) {
      currentPage -= 1;
      loadEpices(currentPage);
    }
  });

  nextBtn.addEventListener('click', () => {
    currentPage += 1;
    loadEpices(currentPage);
  });

  // Chargement initial
  loadEpices(currentPage);
});
</script>
