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
  <div class="w-3/4 p-4 ">
      <!-- Section épices -->
  <section class="">
    <h2 class="text-2xl font-bold mb-6 text-center underline">Les Épices</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
      <!-- Exemple de carte épice -->
      <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
        <img src="assets/img/product/p3.png" alt="Poudre de Kinkeliba" class="w-full h-48 object-cover">
        <div class="p-4">
          <h3 class="text-lg font-bold text-gray-800">Nom: Poudre de Kinkeliba</h3>
          <p class="text-sm text-gray-600"><strong>Boutique:</strong> Smach Épicerie</p>
          <p class="text-sm text-gray-600"><strong>Adresse:</strong> 6 rue charle lalances</p>
          <p class="text-sm text-gray-600"><strong>Horaire:</strong> 08H00 A 22H30</p>
          <div class="flex justify-between items-center mt-4">
            <button class="btn-gradient py-2 px-4 text-white rounded-lg font-bold"><a href="./details/detail-epice.php">VOIR LES DÉTAILS</a></button>
            <a href="./panier/panier.php" class="text-green-700">
              <i class="fas fa-shopping-cart text-green-700 text-xl cursor-pointer"></i>
          </a>
          </div>
        </div>
      </div>
      <!-- Répliquez pour d'autres épices -->
      <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
        <img src="assets/img/product/p3.png" alt="Poivre en Poudre" class="w-full h-48 object-cover">
        <div class="p-4">
          <h3 class="text-lg font-bold text-gray-800">Nom: Poivre en Poudre</h3>
          <p class="text-sm text-gray-600"><strong>Boutique:</strong> Smach Épicerie</p>
          <p class="text-sm text-gray-600"><strong>Adresse:</strong> 27 faubourg besançon</p>
          <p class="text-sm text-gray-600"><strong>Horaire:</strong> 08H00 A 22H30</p>
          <div class="flex justify-between items-center mt-4">
          <button class="btn-gradient py-2 px-4 text-white rounded-lg font-bold"><a href="./details/detail-epice.php">VOIR LES DÉTAILS</a></button>
          <a href="./panier/panier.php" class="text-green-700">
              <i class="fas fa-shopping-cart text-green-700 text-xl cursor-pointer"></i>
          </a>
          </div>
        </div>
      </div>

      <!-- Répliquez pour d'autres épices -->
      <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
        <img src="assets/img/product/p3.png" alt="Poivre en Poudre" class="w-full h-48 object-cover">
        <div class="p-4">
          <h3 class="text-lg font-bold text-gray-800">Nom: Poivre en Poudre</h3>
          <p class="text-sm text-gray-600"><strong>Boutique:</strong> Smach Épicerie</p>
          <p class="text-sm text-gray-600"><strong>Adresse:</strong> 27 faubourg besançon</p>
          <p class="text-sm text-gray-600"><strong>Horaire:</strong> 08H00 A 22H30</p>
          <div class="flex justify-between items-center mt-4">
            <button class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
            <a href="./panier/panier.php" class="text-green-700">
              <i class="fas fa-shopping-cart text-green-700 text-xl cursor-pointer"></i>
          </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section recettes -->
  <section class="mt-12">
    <h2 class="text-2xl font-bold mb-6 text-center underline">Les Recettes</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
      <!-- Exemple de carte recette -->
      <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="assets/img/recette-1.png" alt="Recette Yassa" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Yassa de Poulet</h3>
            <p class="text-sm text-gray-600 mt-2"><strong>Ingrédients:</strong> Poulet, oignons, citron...</p>
            <p class="text-sm text-gray-600"><strong>Durée de cuisson:</strong> 30 à 40 min</p>
            <p class="text-sm text-gray-600"><strong>Nombre de personnes:</strong> 3 à 4</p>
            <p class="text-sm text-gray-600"><strong>Mode de cuisson :</strong> Les mor..</p>
            <div class="flex justify-center items-center mt-4">
              <button class="btn-gradient py-2 px-6 text-white rounded-lg font-bold"><a href="./details/detail-recette.php">VOIR LES DÉTAILS</a></button>
            </div>
          </div>
        </div>
        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="assets/img/recette-1.png" alt="Recette Yassa" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Yassa de Poulet</h3>
            <p class="text-sm text-gray-600 mt-2"><strong>Ingrédients:</strong> Poulet, oignons, citron...</p>
            <p class="text-sm text-gray-600"><strong>Durée de cuisson:</strong> 30 à 40 min</p>
            <p class="text-sm text-gray-600"><strong>Nombre de personnes:</strong> 3 à 4</p>
            <p class="text-sm text-gray-600"><strong>Mode de cuisson :</strong> Les mor..</p>
            <div class="flex justify-center items-center mt-4">
            <button class="btn-gradient py-2 px-6 text-white rounded-lg font-bold"><a href="./details/detail-recette.php">VOIR LES DÉTAILS</a></button>
            </div>
          </div>
        </div>

        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="assets/img/recette-1.png" alt="Recette Yassa" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Yassa de Poulet</h3>
            <p class="text-sm text-gray-600 mt-2"><strong>Ingrédients:</strong> Poulet, oignons, citron...</p>
            <p class="text-sm text-gray-600"><strong>Durée de cuisson:</strong> 30 à 40 min</p>
            <p class="text-sm text-gray-600"><strong>Nombre de personnes:</strong> 3 à 4</p>
            <p class="text-sm text-gray-600"><strong>Mode de cuisson :</strong> Les mor..</p>
            <div class="flex justify-center items-center mt-4">
            <button class="btn-gradient py-2 px-6 text-white rounded-lg font-bold"><a href="./details/detail-recette.php">VOIR LES DÉTAILS</a></button>
            </div>
          </div>
        </div>
    </div>
  </section>
      
    </div>
</div>

</main>
<!-- Footer start-->
<?php include('./templates/footer.php'); ?>
<!--Footer end-->
