<div class="flex">
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
    <h1 class="text-2xl font-bold mb-4">Bienvenue sur SoumAfrique</h1>
    <p>Insérez votre contenu principal ici.</p>
  </div>
</div>
