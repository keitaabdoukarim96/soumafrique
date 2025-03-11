<?php
// Connexion à la base de données
include('templates/header.php');
// Récupérer la position de l'utilisateur (via JS)
echo '<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            localStorage.setItem("user_lat", position.coords.latitude);
            localStorage.setItem("user_lng", position.coords.longitude);
        });
    }
</script>';
// Nombre d'éléments par page
$limit = 6;

// Page courante pour épices
$page_epices = isset($_GET['page_epices']) && is_numeric($_GET['page_epices']) ? intval($_GET['page_epices']) : 1;
$offset_epices = ($page_epices - 1) * $limit;

// Page courante pour recettes
$page_recettes = isset($_GET['page_recettes']) && is_numeric($_GET['page_recettes']) ? intval($_GET['page_recettes']) : 1;
$offset_recettes = ($page_recettes - 1) * $limit;

// Récupérer les épices
$sql_epices = "SELECT id, nom_epice, image_epice, epicerie_nom, prix, adresse, horaires, disponibilite, latitude, longitude  
               FROM epicerie 
               LIMIT $limit OFFSET $offset_epices";
$result_epices = mysqli_query($conn, $sql_epices);
$epices = mysqli_fetch_all($result_epices, MYSQLI_ASSOC);

// Nombre total d'épices
$total_epices_result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM epicerie");
$total_epices = mysqli_fetch_assoc($total_epices_result)['count'];
$total_pages_epices = ceil($total_epices / $limit);

// Récupérer les recettes
$sql_recettes = "SELECT id, recipe_name, main_image, cooking_time, servings, cooking_method, budget 
                 FROM recette 
                 LIMIT $limit OFFSET $offset_recettes";
$result_recettes = mysqli_query($conn, $sql_recettes);
$recettes = mysqli_fetch_all($result_recettes, MYSQLI_ASSOC);

// Nombre total de recettes
$total_recettes_result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM recette");
$total_recettes = mysqli_fetch_assoc($total_recettes_result)['count'];
$total_pages_recettes = ceil($total_recettes / $limit);
?>






<main class="flex-grow mt-20 mb-20">
  <!-- Carrousel ajusté -->
  <div class="relative w-full">
    <!-- Slides -->
    <div id="carousel" class="relative overflow-hidden">
      <div class="carousel-slide">
        <img src="assets/img/1.jpg" alt="Épice 1" class="w-full h-[70vh] object-cover">
      </div>
      <div class="carousel-slide hidden">
        <img src="assets/img/2.jpg" alt="Épice 2" class="w-full h-[70vh] object-cover">
      </div>
      <div class="carousel-slide hidden">
        <img src="assets/img/3.jpg" alt="Épice 3" class="w-full h-[70vh] object-cover">
      </div>
    </div>

    <!-- Barre de recherche centrée sur le carrousel -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
      <form id="search-form" class="flex items-center bg-white rounded-full shadow-lg overflow-hidden border border-gray-300 focus-within:border-red-500 transition-all duration-300">
        <input type="text" id="search-input" placeholder="Recherchez une épice ou une recette..."
          class="flex-grow py-3 px-5 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">

        <button type="submit" id="search-button"
          class="bg-red-500 text-white px-6 py-3 rounded-full hover:bg-red-600 transition-all duration-300">
          <i class="fas fa-search"></i>
        </button>
      </form>


      <!-- Résultats de recherche en grille -->
      <div id="search-results"
        class="absolute w-full bg-white border border-gray-300 shadow-lg rounded-lg mt-1 hidden p-4 grid grid-cols-1 sm:grid-cols-4 md:grid-cols-3 gap-4 max-h-80 overflow-y-auto">
        <!-- Les résultats s'afficheront ici dynamiquement -->
      </div>


    </div>


    <!-- Cercles de navigation 
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
      <div class="circle bg-gray-300 w-3 h-3 rounded-full cursor-pointer" data-slide="0"></div>
      <div class="circle bg-gray-300 w-3 h-3 rounded-full cursor-pointer" data-slide="1"></div>
      <div class="circle bg-gray-300 w-3 h-3 rounded-full cursor-pointer" data-slide="2"></div>
    </div>-->
  </div>

  <div class="flex mt-8">
    <aside class="w-1/4 bg-gray-100 shadow-lg">
      <!-- Titre FILTRER -->
      <div class="bg-green-700 text-white p-4 flex justify-between items-center">
        <h2 class="text-lg font-bold flex items-center">
          <i class="fas fa-sliders-h mr-2"></i> FILTRER
        </h2>
        <button id="reset-filters" class="text-sm font-bold underline hover:text-gray-300">Réinitialiser</button>
      </div>

      <!-- Contenu de la sidebar -->
      <div class="space-y-6 p-4">
        <!-- Recherche -->
        <section>
          <h3 class="font-bold text-gray-700 mb-2">RECHERCHE</h3>
          <input type="text" id="search-filter" placeholder="Recherchez une épice ou une recette..."
            class="w-full py-2 px-4 border rounded bg-gray-200 focus:outline-none">
        </section>


        <!-- Filtrer par type -->
        <section>
          <h3 class="font-bold text-gray-700 mb-2">PAR TYPE</h3>
          <label class="flex items-center"><input type="checkbox" class="type-filter mr-2" value="epice"> Épices</label>
          <label class="flex items-center"><input type="checkbox" class="type-filter mr-2" value="recette"> Recettes</label>
        </section>

        <!-- Par catégorie d'épices -->
        <section>
          <h3 class="font-bold text-gray-700 mb-2">PAR CATÉGORIE D'ÉPICE</h3>
          <ul class="space-y-2">
            <li><label><input type="checkbox" class="category-filter-epices mr-2" value="Épices Entières"> Épices Entières</label></li>
            <li><label><input type="checkbox" class="category-filter-epices mr-2" value="Graines"> Graines</label></li>
            <li><label><input type="checkbox" class="category-filter-epices mr-2" value="Baies"> Baies</label></li>
            <li><label><input type="checkbox" class="category-filter-epices mr-2" value="Épices moulues ou en poudre"> Épices moulues</label></li>
            <li><label><input type="checkbox" class="category-filter-epices mr-2" value="Mélanges d'Epices"> Mélanges d'Epices</label></li>
          </ul>
        </section>

        <!-- Par catégorie de recettes -->
        <section>
          <h3 class="font-bold text-gray-700 mb-2">PAR CATÉGORIE DE RECETTE</h3>
          <ul class="space-y-2">
            <li><label><input type="checkbox" class="category-filter-recettes mr-2" value="Plats traditionnels"> Plats traditionnels</label></li>
            <li><label><input type="checkbox" class="category-filter-recettes mr-2" value="Desserts"> Desserts</label></li>
            <li><label><input type="checkbox" class="category-filter-recettes mr-2" value="Soupes"> Soupes</label></li>
          </ul>
        </section>


        <!-- Disponibilité -->
        <section>
          <h3 class="font-bold text-gray-700 mb-2">DISPONIBILITÉ</h3>
          <label class="flex items-center"><input type="checkbox" id="available-filter" class="mr-2"> En stock</label>
        </section>

        <!-- Filtrage avancé par prix -->
        <section>
          <div class="space-y-4">

            <button id="apply-filters" class="font-bold bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded w-full">
              Appliquer
            </button>
          </div>
        </section>
      </div>
    </aside>


    <!-- Contenu principal -->
    <div class="w-3/4 p-4" id="filter-results">
      <!-- Section épices -->
      <section id="epices-section">
        <h2 class="text-2xl font-bold mb-6 text-center underline">Les Épices</h2>
        <div class="products-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
          <?php foreach ($epices as $epice): ?>
            <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
              <img src="admin/uploads/<?= htmlspecialchars($epice['image_epice']); ?>" alt="<?= htmlspecialchars($epice['nom_epice']); ?>" class="w-full h-48 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($epice['nom_epice']); ?></h3>
                <p class="text-lg font-semibold text-red-600"><?= number_format($epice['prix'], 2, ',', ' ') ?> €</p> <!-- ✅ Prix affiché ici -->
                <p class="text-sm text-gray-600"><strong>Boutique:</strong> <?= htmlspecialchars($epice['epicerie_nom']); ?></p>
                <p class="text-sm text-gray-600"><strong>Adresse:</strong> <?= htmlspecialchars($epice['adresse']); ?></p>
                <p class="text-sm text-gray-600"><strong>Horaire:</strong> <?= htmlspecialchars($epice['horaires']); ?></p>
                <p class="text-sm <?= isset($epice['disponibilite']) && $epice['disponibilite'] == 'en_stock' ? 'text-green-600' : 'text-red-600'; ?>">
                  <strong>Disponibilité :</strong> <?= isset($epice['disponibilite']) && $epice['disponibilite'] == 'en_stock' ? 'En stock' : 'Rupture de stock'; ?>
                </p>
                <div class="flex justify-between items-center mt-4">
                 <!-- ✅ Bouton Géolocalisation -->
<button class="btn-gradient text-white px-4 py-2 rounded-lg font-bold flex items-center transition duration-300"
        id="go-to-map-<?= $epice['id']; ?>"
        data-lat="<?= htmlspecialchars($epice['latitude']); ?>"
        data-lng="<?= htmlspecialchars($epice['longitude']); ?>">
    <i class="fas fa-map-marker-alt mr-2"></i> 
</button>

                  <a href="detail-epice.php?id=<?= $epice['id']; ?>" class="bg-red-500 py-2 px-4 text-white rounded-lg font-bold"><i class="fa fa-eye text-xl"></i></a>
                  <!-- ✅ Bouton Ajouter au Panier -->
                  <button class="btn-gradient text-white px-4 py-2 rounded-lg font-bold flex items-center  transition duration-300 add-to-cart"
                    data-id="<?= $epice['id']; ?>"
                    data-name="<?= htmlspecialchars($epice['nom_epice']); ?>"
                    data-price="<?= $epice['prix']; ?>">
                    <i class="fas fa-shopping-cart mr-2"></i>
                  </button>
              </div>
            </div>
        </div>
      <?php endforeach; ?>
  
  </div>
    <!-- Pagination épices -->
    <div class="flex justify-center mt-8 space-x-4">
      <?php if ($page_epices > 1): ?>
        <a href="?page_epices=<?= $page_epices - 1; ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">Précédent</a>
      <?php endif; ?>
      <?php if ($page_epices < $total_pages_epices): ?>
        <a href="?page_epices=<?= $page_epices + 1; ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">Suivant</a>
      <?php endif; ?>
    </div>
    </section>

    <!-- Section recettes -->
    <section class="mt-12" id="recettes-section">
      <h2 class="text-2xl font-bold mb-6 text-center underline">Les Recettes</h2>
      <div class="products-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
        <?php foreach ($recettes as $recette): ?>
          <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
            <img src="admin/uploads/<?= htmlspecialchars($recette['main_image']); ?>" alt="<?= htmlspecialchars($recette['recipe_name']); ?>" class="w-full h-48 object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($recette['recipe_name']); ?></h3>
              <p class="text-sm text-gray-600"><strong>Durée:</strong> <?= htmlspecialchars($recette['cooking_time']); ?> min</p>
              <p class="text-sm text-gray-600"><strong>Portions:</strong> <?= htmlspecialchars($recette['servings']); ?> pers.</p>
              <p class="text-sm text-gray-600"><strong>Mode de cuisson:</strong> <?= htmlspecialchars($recette['cooking_method']); ?></p>
              <p class="text-sm text-gray-600"><strong>Budget:</strong> <?= htmlspecialchars($recette['budget']); ?> €</p>

              <div class="flex justify-center items-center mt-4">
                <a href="detail-recette.php?id=<?= $recette['id']; ?>" class="bg-red-500 py-2 px-4 text-white rounded-lg font-bold"><i class="fa fa-eye text-xl"></i></a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Pagination recettes -->
      <div class="flex justify-center mt-8 space-x-4">
        <?php if ($page_recettes > 1): ?>
          <a href="?page_recettes=<?= $page_recettes - 1; ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">Précédent</a>
        <?php endif; ?>
        <?php if ($page_recettes < $total_pages_recettes): ?>
          <a href="?page_recettes=<?= $page_recettes + 1; ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">Suivant</a>
        <?php endif; ?>
      </div>
    </section>
  </div>
  </div>

</main>
<!-- Inclure le fichier JS -->
<script src="search.js"></script>
<script src="filter.js"></script>
<script src="cart.js"></script>
<script src="geolocalisation.js"></script>
<script src="map.js"></script>

<!-- Footer start-->
<?php include('templates/footer.php'); ?>
<!--Footer end-->