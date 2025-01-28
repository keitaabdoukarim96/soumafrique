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
    <div class="w-3/4 p-4">
      <h2 class="text-2xl font-bold mb-6 text-center underline">Les Recettes</h2>
      <!-- Grille des recettes -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Exemple de carte recette -->
        
        <!-- Répliquez ce bloc pour d'autres recettes -->
        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="assets/img/recette-1.png" alt="Recette Sauce Arachide" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Sauce Arachide</h3>
            <p class="text-sm text-gray-600 mt-2"><strong>Ingrédients:</strong> Arachide, viande...</p>
            <p class="text-sm text-gray-600"><strong>Durée de cuisson:</strong> 45 min</p>
            <p class="text-sm text-gray-600"><strong>Nombre de personnes:</strong> 5 à 6</p>
            <p class="text-sm text-gray-600"><strong>Mode de cuisson :</strong> Les mor..</p>
            <div class="flex justify-center items-center mt-4">
              <button class="btn-gradient py-2 px-6 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
            </div>
          </div>
        </div>

        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="assets/img/recette-1.png" alt="Recette Sauce Arachide" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Sauce Arachide</h3>
            <p class="text-sm text-gray-600 mt-2"><strong>Ingrédients:</strong> Arachide, viande...</p>
            <p class="text-sm text-gray-600"><strong>Durée de cuisson:</strong> 45 min</p>
            <p class="text-sm text-gray-600"><strong>Nombre de personnes:</strong> 5 à 6</p>
            <p class="text-sm text-gray-600"><strong>Mode de cuisson :</strong> Les mor..</p>
            <div class="flex justify-center items-center mt-4">
              <button class="btn-gradient py-2 px-6 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
            </div>
          </div>
        </div>
        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="assets/img/recette-1.png" alt="Recette Sauce Arachide" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Sauce Arachide</h3>
            <p class="text-sm text-gray-600 mt-2"><strong>Ingrédients:</strong> Arachide, viande...</p>
            <p class="text-sm text-gray-600"><strong>Durée de cuisson:</strong> 45 min</p>
            <p class="text-sm text-gray-600"><strong>Nombre de personnes:</strong> 5 à 6</p>
            <p class="text-sm text-gray-600"><strong>Mode de cuisson :</strong> Les mor..</p>
            <div class="flex justify-center items-center mt-4">
              <button class="btn-gradient py-2 px-6 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Footer start-->
<?php include('./templates/footer.php'); ?>
<!--Footer end-->
