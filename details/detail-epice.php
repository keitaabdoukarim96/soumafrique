<!--Header start-->
<?php include('../templates/header.php'); ?>
<!--Header end-->

<main class="flex-grow mt-20 mb-20 px-4">
  <div class="container mx-auto">
        <!-- Chemin de navigation (Breadcrumb) -->
    <nav class="text-sm mb-4 mt-20" style="background-color: #f9f9f9; padding: 10px;">
        <a href="/soumafrique/index.php" class="text-green-700 font-bold">Accueil</a> >
        <a href="/soumafrique/epicerie.php" class="text-green-700 font-bold">Épicerie</a> >
        <span class="text-gray-800 font-bold">Poivre en poudre</span>
    </nav>

    <!-- Section principale -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Image de l'épice -->
      <div>
        <img src="../assets/img/product/p3.png" alt="Poivre moulu" class="w-full h-auto border border-green-500 rounded-lg">
      </div>

      <!-- Détails de l'épice -->
      <div class="border border-green-500 rounded-lg p-4 bg-white">
        <!-- Prix statique -->
        <p class="text-lg font-bold text-green-700 mb-2">6 € / 100g</p>
        <h1 class="text-2xl font-bold text-green-700 mb-4">Poivre moulu de Guinée</h1>
        <p class="text-sm text-gray-700 mb-2"><strong>Épicerie :</strong> Smach Épicerie</p>
        <p class="text-sm text-gray-700 mb-2"><strong>Horaires :</strong> 08h - 22h30</p>
        <p class="text-sm text-gray-700 mb-2"><strong>Adresse :</strong> 27 faubourg de Besançon</p>
        <p class="text-sm text-gray-700 mb-2"><strong>Contact :</strong> 0782273438</p>
        <p class="text-sm text-gray-700 mb-4"><strong>Disponibilité :</strong> <span class="text-green-600 font-bold">En stock</span></p>

        <!-- Comparateur de prix -->
        <div class="mb-4">
          <h3 class="font-bold text-gray-700 mb-2">Comparateur de prix entre boutiques</h3>
          <div class="space-y-2">
            <label><input type="radio" name="price" class="mr-2"> Boutique A : 8 €/100g</label><br>
            <label><input type="radio" name="price" class="mr-2"> Boutique B : 7,5 €/100g</label><br>
            <label><input type="radio" name="price" class="mr-2"> Boutique C : 9 €/100g</label>
          </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex space-x-4 mb-4">
          <button class="btn-gradient px-4 py-2 text-white font-bold rounded">Ajouter au panier</button>
          <button class="btn-gradient px-4 py-2 text-white font-bold rounded">Acheter cet article</button>
        </div>

        <!-- Tags -->
        <div class="flex flex-wrap space-x-2">
          <span class="bg-gray-200 px-2 py-1 rounded-full text-sm">POIVRE</span>
          <span class="bg-gray-200 px-2 py-1 rounded-full text-sm">GINGEMBRE</span>
          <span class="bg-gray-200 px-2 py-1 rounded-full text-sm">SAVEUR</span>
          <span class="bg-gray-200 px-2 py-1 rounded-full text-sm">PIQUANT</span>
        </div>
      </div>
    </section>

    <!-- Détails supplémentaires -->
    <section class="mt-12">
      <h2 class="text-xl font-bold text-gray-800 mb-4">Détails de l'épice</h2>
      <p class="text-gray-700 mb-4">
        La maniguette, également appelée poivre de Guinée ou grains de paradis, est une épice emblématique d’Afrique de l’Ouest. 
        Son goût subtil et unique en fait un substitut raffiné au poivre classique.
      </p>
      
      <!-- Informations complémentaires -->
      <h3 class="font-bold text-gray-800 mb-2">Provenance</h3>
      <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>Guinée</li>
        <li>Côte d’Ivoire</li>
        <li>Ghana</li>
      </ul>

      <h3 class="font-bold text-gray-800 mb-2">Utilisation culinaire</h3>
      <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>Tradition africaine : utilisée dans les plats épicés, les ragoûts, et les viandes grillées.</li>
        <li>Boissons : ajoutée aux infusions ou utilisée comme épice dans le gin.</li>
      </ul>

      <h3 class="font-bold text-gray-800 mb-2">Bienfaits</h3>
      <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>Aide digestive</li>
        <li>Anti-inflammatoire</li>
        <li>Riche en antioxydants</li>
      </ul>
    </section>

    <!-- Recettes associées -->
    <section class="mt-12">
      <h2 class="text-xl font-bold text-gray-800 mb-4">Recettes de cuisine associées</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
      <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="../assets/img/recette-1.png" alt="Recette Yassa" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Yassa de Poulet</h3>
            <p class="text-sm text-gray-600 mt-2"><strong>Ingrédients:</strong> Poulet, oignons, citron...</p>
            <p class="text-sm text-gray-600"><strong>Durée de cuisson:</strong> 30 à 40 min</p>
            <p class="text-sm text-gray-600"><strong>Nombre de personnes:</strong> 3 à 4</p>
            <p class="text-sm text-gray-600"><strong>Mode de cuisson :</strong> Les mor..</p>
            <div class="flex justify-center items-center mt-4">
              <button class="btn-gradient py-2 px-6 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
            </div>
          </div>
        </div>

        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="../assets/img/recette-1.png" alt="Recette Yassa" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Yassa de Poulet</h3>
            <p class="text-sm text-gray-600 mt-2"><strong>Ingrédients:</strong> Poulet, oignons, citron...</p>
            <p class="text-sm text-gray-600"><strong>Durée de cuisson:</strong> 30 à 40 min</p>
            <p class="text-sm text-gray-600"><strong>Nombre de personnes:</strong> 3 à 4</p>
            <p class="text-sm text-gray-600"><strong>Mode de cuisson :</strong> Les mor..</p>
            <div class="flex justify-center items-center mt-4">
              <button class="btn-gradient py-2 px-6 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
            </div>
          </div>
        </div>

        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="../assets/img/recette-1.png" alt="Recette Yassa" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800">Nom: Yassa de Poulet</h3>
            <p class="text-sm text-gray-600 mt-2"><strong>Ingrédients:</strong> Poulet, oignons, citron...</p>
            <p class="text-sm text-gray-600"><strong>Durée de cuisson:</strong> 30 à 40 min</p>
            <p class="text-sm text-gray-600"><strong>Nombre de personnes:</strong> 3 à 4</p>
            <p class="text-sm text-gray-600"><strong>Mode de cuisson :</strong> Les mor..</p>
            <div class="flex justify-center items-center mt-4">
              <button class="btn-gradient py-2 px-6 text-white rounded-lg font-bold">VOIR LES DÉTAILS</button>
            </div>
          </div>
        </div>
      </div>
    </section>

     <!-- Recettes associées -->
     <section class="mt-12">
      <h2 class="text-xl font-bold text-gray-800 mb-4">Épices associées</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
      <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="../assets/img/product/p3.png" alt="Poudre de Kinkeliba" class="w-full h-48 object-cover">
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

        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="../assets/img/product/p3.png" alt="Poudre de Kinkeliba" class="w-full h-48 object-cover">
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

        <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
          <img src="../assets/img/product/p3.png" alt="Poudre de Kinkeliba" class="w-full h-48 object-cover">
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
      </div>
    </section>
  </div>
</main>

<!-- Footer start-->
<?php include('../templates/footer.php'); ?>
<!--Footer end-->
