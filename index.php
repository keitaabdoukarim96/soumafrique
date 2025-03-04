<?php
// Connexion à la base de données
header('Content-Type: text/html; charset=utf-8');
include('./admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");

// Nombre d'éléments par page
$limit = 6;

// Page courante pour épices
$page_epices = isset($_GET['page_epices']) && is_numeric($_GET['page_epices']) ? intval($_GET['page_epices']) : 1;
$offset_epices = ($page_epices - 1) * $limit;

// Page courante pour recettes
$page_recettes = isset($_GET['page_recettes']) && is_numeric($_GET['page_recettes']) ? intval($_GET['page_recettes']) : 1;
$offset_recettes = ($page_recettes - 1) * $limit;

// Récupérer les épices
$sql_epices = "SELECT id, nom_epice, image_epice, epicerie_nom, adresse, horaires, disponibilite 
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


<!--Header start-->
<?php include('./templates/header.php'); ?>
<!--Header end-->



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

    <!-- Barre de recherche centrée -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white bg-opacity-70 rounded-lg p-4 shadow-lg max-w-md w-full">
      <form class="flex items-center">
        <input type="text" placeholder="Recherchez une épice ou une recette" class="flex-grow py-2 px-4 rounded-l-lg focus:outline-none">
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-r-lg">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>

    <!-- Cercles de navigation -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
      <div class="circle bg-gray-300 w-3 h-3 rounded-full cursor-pointer" data-slide="0"></div>
      <div class="circle bg-gray-300 w-3 h-3 rounded-full cursor-pointer" data-slide="1"></div>
      <div class="circle bg-gray-300 w-3 h-3 rounded-full cursor-pointer" data-slide="2"></div>
    </div>
  </div>
  
  <div class="flex mt-8">
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
        <input type="text" placeholder="Taper 'Soum...'" class="w-full py-2 px-4 border rounded bg-gray-200 focus:outline-none">
      </section>

      <!-- Trier par lettre -->
      <section>
        <h3 class="font-bold text-gray-700 mb-2">TRIER PAR LETTRE</h3>
        <label class="flex items-center">
          <input type="checkbox" class="mr-2"> A-Z, Z-A
        </label>
      </section>

      <!-- Par catégorie d'épices -->
      <section>
        <h3 class="font-bold text-gray-700 mb-2">PAR CATÉGORIE D'ÉPICE</h3>
        <ul class="space-y-2">
          <li><label><input type="checkbox" class="mr-2"> Épices Entières</label></li>
          <ul class="ml-4 space-y-1">
            <li><label><input type="checkbox" class="mr-2"> Graines</label></li>
            <li><label><input type="checkbox" class="mr-2"> Baies</label></li>
          </ul>
          <li><label><input type="checkbox" class="mr-2"> Épices Moulues ou en Poudre</label></li>
          <ul class="ml-4 space-y-1">
            <li><label><input type="checkbox" class="mr-2"> Poudre de Kinkeliba</label></li>
            <li><label><input type="checkbox" class="mr-2"> Poudre de Baobab</label></li>
            <li><label><input type="checkbox" class="mr-2"> Gousses de Néré</label></li>
          </ul>
        </ul>
      </section>

      <!-- Comparateur de prix entre boutiques -->
      <section>
        <h3 class="font-bold text-gray-700 mb-2">COMPARATEUR DE PRIX ENTRE BOUTIQUES</h3>
        <ul class="space-y-2">
          <li><label><input type="radio" name="price-compare" class="mr-2"> Boutique A : 8 €/100g</label></li>
          <li><label><input type="radio" name="price-compare" class="mr-2"> Boutique B : 7,5 €/100g</label></li>
          <li><label><input type="radio" name="price-compare" class="mr-2"> Boutique C : 9 €/100g</label></li>
        </ul>
      </section>

      <!-- Filtrage avancé par prix -->
      <section>
        <h3 class="font-bold text-gray-700 mb-2">FILTRAGE AVANCÉ PAR PRIX</h3>
        <div class="space-y-4">
          <!-- Curseur de prix -->
          <div>
            <label for="price-range" class="block text-sm font-medium text-gray-700">Prix</label>
            <input type="range" id="price-range" min="1" max="100" step="1" class="w-full">
            <div class="flex justify-between text-sm text-gray-500 mt-1">
              <span>1 €</span>
              <span>100 €</span>
            </div>
          </div>

          <!-- Entrées manuelles -->
          <div class="flex space-x-2">
            <input type="number" placeholder="Min" class="w-1/2 py-2 px-3 border rounded bg-gray-200 focus:outline-none">
            <input type="number" placeholder="Max" class="w-1/2 py-2 px-3 border rounded bg-gray-200 focus:outline-none">
          </div>

          <!-- Bouton de validation -->
          <button class="font-bold btn-gradient hover:shadow-lg text-white px-4 py-2 rounded w-full">
            Appliquer
          </button>
        </div>
      </section>
    </div>
  </aside>

  <!-- Contenu principal -->
  <div class="w-3/4 p-4">
      <!-- Section épices -->
      <section>
        <h2 class="text-2xl font-bold mb-6 text-center underline">Les Épices</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
          <?php foreach ($epices as $epice): ?>
            <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
              <img src="./admin/uploads/<?= htmlspecialchars($epice['image_epice']); ?>" alt="<?= htmlspecialchars($epice['nom_epice']); ?>" class="w-full h-48 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($epice['nom_epice']); ?></h3>
                <p class="text-sm text-gray-600"><strong>Boutique:</strong> <?= htmlspecialchars($epice['epicerie_nom']); ?></p>
                <p class="text-sm text-gray-600"><strong>Adresse:</strong> <?= htmlspecialchars($epice['adresse']); ?></p>
                <p class="text-sm text-gray-600"><strong>Horaire:</strong> <?= htmlspecialchars($epice['horaires']); ?></p>
                <p class="text-sm <?= isset($epice['disponibilite']) && $epice['disponibilite'] == 'en_stock' ? 'text-green-600' : 'text-red-600'; ?>">
                   <strong>Disponibilité :</strong> <?= isset($epice['disponibilite']) && $epice['disponibilite'] == 'en_stock' ? 'En stock' : 'Rupture de stock'; ?>
                </p>
                <div class="flex justify-between items-center mt-4">
                  <a href="./details/detail-epice.php?id=<?= $epice['id']; ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">VOIR LES DÉTAILS</a>
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
      <section class="mt-12">
        <h2 class="text-2xl font-bold mb-6 text-center underline">Les Recettes</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
          <?php foreach ($recettes as $recette): ?>
            <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
              <img src="./admin/<?= htmlspecialchars($recette['main_image']); ?>" alt="<?= htmlspecialchars($recette['recipe_name']); ?>" class="w-full h-48 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($recette['recipe_name']); ?></h3>
                <p class="text-sm text-gray-600"><strong>Durée:</strong> <?= htmlspecialchars($recette['cooking_time']); ?> min</p>
                <p class="text-sm text-gray-600"><strong>Portions:</strong> <?= htmlspecialchars($recette['servings']); ?> pers.</p>
                <p class="text-sm text-gray-600"><strong>Mode de cuisson:</strong> <?= htmlspecialchars($recette['cooking_method']); ?></p>
                <p class="text-sm text-gray-600"><strong>Budget:</strong> <?= htmlspecialchars($recette['budget']); ?> €</p>
                
                <div class="flex justify-center items-center mt-4">
                  <a href="./details/detail-recette.php?id=<?= $recette['id']; ?>" class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">VOIR LES DÉTAILS</a>
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
<!-- Footer start-->
<?php include('./templates/footer.php'); ?>
<!--Footer end-->
