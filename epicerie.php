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
      <!-- Grille des épices -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Exemple de carte épice -->
        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="assets/img/product/p3.png" alt="Poudre de Kinkeliba" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Poudre de Kinkeliba</h3>
            <p class="text-sm text-gray-600"><strong>Boutique:</strong> Smach Épicerie</p>
            <p class="text-sm text-gray-600"><strong>Adresse:</strong> 6 rue charle lalances</p>
            <p class="text-sm text-gray-600"><strong>Horaire:</strong> 08H00 A 22H30</p>
            <div class="flex justify-between items-center mt-4">
              <button class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
              <i class="fas fa-shopping-cart text-green-700 text-xl cursor-pointer"></i>
            </div>
          </div>
        </div>

        <!-- Exemple de carte épice -->
        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="assets/img/product/p3.png" alt="Poudre de Kinkeliba" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Poudre de Kinkeliba</h3>
            <p class="text-sm text-gray-600"><strong>Boutique:</strong> Smach Épicerie</p>
            <p class="text-sm text-gray-600"><strong>Adresse:</strong> 6 rue charle lalances</p>
            <p class="text-sm text-gray-600"><strong>Horaire:</strong> 08H00 A 22H30</p>
            <div class="flex justify-between items-center mt-4">
              <button class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
              <i class="fas fa-shopping-cart text-green-700 text-xl cursor-pointer"></i>
            </div>
          </div>
        </div>

        <!-- Exemple de carte épice -->
        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="assets/img/product/p3.png" alt="Poudre de Kinkeliba" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Poudre de Kinkeliba</h3>
            <p class="text-sm text-gray-600"><strong>Boutique:</strong> Smach Épicerie</p>
            <p class="text-sm text-gray-600"><strong>Adresse:</strong> 6 rue charle lalances</p>
            <p class="text-sm text-gray-600"><strong>Horaire:</strong> 08H00 A 22H30</p>
            <div class="flex justify-between items-center mt-4">
              <button class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
              <i class="fas fa-shopping-cart text-green-700 text-xl cursor-pointer"></i>
            </div>
          </div>
        </div>

        <!-- Exemple de carte épice -->
        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="assets/img/product/p3.png" alt="Poudre de Kinkeliba" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Poudre de Kinkeliba</h3>
            <p class="text-sm text-gray-600"><strong>Boutique:</strong> Smach Épicerie</p>
            <p class="text-sm text-gray-600"><strong>Adresse:</strong> 6 rue charle lalances</p>
            <p class="text-sm text-gray-600"><strong>Horaire:</strong> 08H00 A 22H30</p>
            <div class="flex justify-between items-center mt-4">
              <button class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
              <i class="fas fa-shopping-cart text-green-700 text-xl cursor-pointer"></i>
            </div>
          </div>
        </div>
        <!-- Répliquez ce bloc pour d'autres épices -->
      </div>
      <!-- Pagination -->
      <div class="flex justify-center mt-8 space-x-4">
        <button class="bg-green-700 text-white px-4 py-2 rounded-lg">
          <i class="fas fa-arrow-left"></i>
        </button>
        <button class="bg-green-700 text-white px-4 py-2 rounded-lg">
          <i class="fas fa-arrow-right"></i>
        </button>
      </div>
    </div>
  </div>
</main>


<!-- Footer start-->
<?php include('./templates/footer.php'); ?>
<!--Footer end-->
