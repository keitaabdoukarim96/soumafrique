  <?php

  session_start(); // Démarrer la session pour récupérer les données
  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: admin-login.php");
    exit;
  }
  ?>


  <?php include('header.php'); ?>
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2">

      <nav class="text-sm">
        <!-- Dashboard -->
        <a href="admin-dashboard.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
          <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
        </a>

        <!-- Gestion des utilisateurs -->
        <div class="group">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-users mr-3"></i> Gestion des utilisateurs
            <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
          </a>
          <div class="hidden pl-8 space-y-2 group-hover:block">
            <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700 " id="add-user-link">
              <i class="fas fa-user-plus mr-3"></i> Ajouter un utilisateur
            </a>
            <a href="liste-clients.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
              <i class="fas fa-users-cog mr-3"></i> Voir les utilisateurs
            </a>
          </div>
        </div>
        <!-- Catégories d'épices -->

        <!-- Gestion des boutiques -->
        <div class="group">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-store mr-3"></i> Gestion des boutiques
            <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
          </a>
          <div class="hidden pl-8 space-y-2 group-hover:block">
            <a href="liste-boutique.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="manage-shops-link">
              <i class="fas fa-tools mr-3"></i> Gérer les boutiques
            </a>
            <a href="valider-boutique.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="validate-shop-link">
              <i class="fas fa-check-circle mr-3"></i> Valider une boutique
            </a>
            <a href="ajouter-boutique.php" class="flex items-center py-2 px-4 rounded hover:bg-gray-700 " id="add-product-link">
              <i class="fas fa-plus mr-3"></i> Ajouter un produit
            </a>
          </div>
        </div>
        <div class="group">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-leaf mr-3"></i> Catégories d'épices
            <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
          </a>
          <div class="hidden pl-8 space-y-2 group-hover:block">
            <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="view-spice-categories-link">
              <i class="fas fa-list mr-3"></i> Voir les catégories
            </a>
            <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="add-spice-category-link">
              <i class="fas fa-plus mr-3"></i> Ajouter une catégorie
            </a>
          </div>
        </div>
        <!-- Les recettes -->
        <div class="group">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-utensils mr-3"></i> Les recettes
            <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
          </a>
          <div class="hidden pl-8 space-y-2 group-hover:block">
            <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="view-recipe-categories-link">
              <i class="fas fa-list mr-3"></i> Voir les catégories de recettes
            </a>
            <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="add-recipe-link">
              <i class="fas fa-plus mr-3"></i> Ajouter une recette
            </a>
          </div>
        </div>
        <!-- Les rôles -->
        <div class="group">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-user-tag mr-3"></i> Les rôles
            <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
          </a>
          <div class="hidden pl-8 space-y-2 group-hover:block">
            <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="view-roles-link">
              <i class="fas fa-eye mr-3"></i> Voir les rôles
            </a>
            <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="add-role-link">
              <i class="fas fa-user-shield mr-3"></i> Ajouter un rôle
            </a>
          </div>
        </div>

        <!-- Commandes -->
        <div class="group">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-box mr-3"></i> Commandes
            <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
          </a>
          <div class="hidden pl-8 space-y-2 group-hover:block">
            <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="manage-orders-link">
              <i class="fas fa-tasks mr-3"></i> Gérer les commandes
            </a>

          </div>
        </div>

        <!-- Livraison -->
        <div class="group">
          <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-truck mr-3"></i> Livraison
            <i class="fas fa-chevron-down ml-auto transform group-hover:rotate-180"></i>
          </a>
          <div class="hidden pl-8 space-y-2 group-hover:block">
            <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700" id="manage-deliveries-link">
              <i class="fas fa-spinner mr-3"></i> Gérer les Livraisons
            </a>

          </div>
        </div>

        <!-- Déconnexion -->
        <a href="logout.php" class="flex items-center py-2 px-4 rounded hover:bg-red-600">
          <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
        </a>
      </nav>
    </aside>
    <!-- Contenu principal -->
    <main class="flex-1 bg-gray-100 p-6">
      <div id="dynamic-content">
        <h1 class="text-2xl font-bold mb-6">Bienvenue sur le Dashboard, <span class="text-red-600"><?php echo htmlspecialchars($_SESSION["nom"]); ?></span></h1>

        <!-- Cartes Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <!-- Carte Utilisateurs -->
          <div class="bg-white shadow-lg rounded-lg p-4 flex items-center">
            <i class="fas fa-users text-green-500 text-3xl mr-4"></i>
            <div>
              <h2 class="text-lg font-bold text-gray-700">Utilisateurs</h2>
              <p class="text-3xl font-bold text-gray-800">120</p>
              <p class="text-gray-600">Total des utilisateurs inscrits</p>
            </div>
          </div>
          <!-- Carte Boutiques -->
          <div class="bg-white shadow-lg rounded-lg p-4 flex items-center">
            <i class="fas fa-store text-yellow-500 text-3xl mr-4"></i>
            <div>
              <h2 class="text-lg font-bold text-gray-700">Boutiques</h2>
              <p class="text-3xl font-bold text-gray-800">15</p>
              <p class="text-gray-600">Boutiques partenaires</p>
            </div>
          </div>
          <!-- Carte Commandes -->
          <div class="bg-white shadow-lg rounded-lg p-4 flex items-center">
            <i class="fas fa-box text-blue-500 text-3xl mr-4"></i>
            <div>
              <h2 class="text-lg font-bold text-gray-700">Commandes</h2>
              <p class="text-3xl font-bold text-gray-800">230</p>
              <p class="text-gray-600">Commandes en cours</p>
            </div>
          </div>
          <!-- Carte Promotions -->
          <div class="bg-white shadow-lg rounded-lg p-4 flex items-center">
            <i class="fas fa-tags text-red-500 text-3xl mr-4"></i>
            <div>
              <h2 class="text-lg font-bold text-gray-700">Promotions</h2>
              <p class="text-3xl font-bold text-gray-800">5</p>
              <p class="text-gray-600">Promotions actives</p>
            </div>
          </div>
        </div>

        <!-- Tableaux pour les sections -->
        <!-- Gestion des utilisateurs -->
        <section class="mt-8">
          <h2 class="text-lg font-bold mb-4">Gestion des utilisateurs</h2>
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
              <thead class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                <tr>
                  <th class="py-3 px-6 text-left">Nom</th>
                  <th class="py-3 px-6 text-left">Email</th>
                  <th class="py-3 px-6 text-left">Rôle</th>
                  <th class="py-3 px-6 text-center">Actions</th>
                </tr>
              </thead>
              <tbody class="text-gray-700">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                  <tr class="border-b">
                    <td class="py-3 px-6">Utilisateur <?= $i ?></td>
                    <td class="py-3 px-6">user<?= $i ?>@example.com</td>
                    <td class="py-3 px-6">Admin</td>
                    <td class="py-3 px-6 text-center">
                      <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs">Voir</button>
                      <button class="bg-yellow-500 text-white py-1 px-2 rounded text-xs">Modifier</button>
                      <button class="bg-red-500 text-white py-1 px-2 rounded text-xs">Supprimer</button>
                    </td>
                  </tr>
                <?php endfor; ?>
              </tbody>
            </table>
            <div class="flex justify-end bg-gray-100 py-2 px-4">
              <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-l">Précédent</button>
              <button class="bg-blue-500 text-white py-1 px-3">1</button>
              <button class="bg-gray-300 text-gray-700 py-1 px-3">2</button>
              <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-r">Suivant</button>
            </div>
          </div>
        </section>
        <!-- Gestion des boutiques -->
        <section class="mt-8">
          <h2 class="text-lg font-bold mb-4">Gestion des boutiques</h2>
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
              <thead class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                <tr>
                  <th class="py-3 px-6 text-left">Nom de la boutique</th>
                  <th class="py-3 px-6 text-left">Propriétaire</th>
                  <th class="py-3 px-6 text-left">Adresse</th>
                  <th class="py-3 px-6 text-left">Horaires</th>
                  <th class="py-3 px-6 text-center">Actions</th>
                </tr>
              </thead>
              <tbody class="text-gray-700">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                  <tr class="border-b">
                    <td class="py-3 px-6">Boutique <?= $i ?></td>
                    <td class="py-3 px-6">Propriétaire <?= $i ?></td>
                    <td class="py-3 px-6">Adresse <?= $i ?></td>
                    <td class="py-3 px-6">08h-18h</td>
                    <td class="py-3 px-6 text-center">
                      <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs">Voir</button>
                      <button class="bg-yellow-500 text-white py-1 px-2 rounded text-xs">Modifier</button>
                      <button class="bg-red-500 text-white py-1 px-2 rounded text-xs">Supprimer</button>
                    </td>
                  </tr>
                <?php endfor; ?>
              </tbody>
            </table>
            <div class="flex justify-end bg-gray-100 py-2 px-4">
              <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-l">Précédent</button>
              <button class="bg-blue-500 text-white py-1 px-3">1</button>
              <button class="bg-gray-300 text-gray-700 py-1 px-3">2</button>
              <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-r">Suivant</button>
            </div>
          </div>
        </section>

        <!-- Gestion des promotions -->
        <section class="mt-8">
          <h2 class="text-lg font-bold mb-4">Gestion des promotions</h2>
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
              <thead class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                <tr>
                  <th class="py-3 px-6 text-left">Nom Épice</th>
                  <th class="py-3 px-6 text-left">Boutique</th>
                  <th class="py-3 px-6 text-left">Adresse</th>
                  <th class="py-3 px-6 text-left">Horaires</th>
                  <th class="py-3 px-6 text-left">Prix</th>
                  <th class="py-3 px-6 text-left">Date Début</th>
                  <th class="py-3 px-6 text-left">Date Fin</th>
                  <th class="py-3 px-6 text-center">Actions</th>
                </tr>
              </thead>
              <tbody class="text-gray-700">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                  <tr class="border-b">
                    <td class="py-3 px-6">Épice <?= $i ?></td>
                    <td class="py-3 px-6">Boutique <?= $i ?></td>
                    <td class="py-3 px-6">Adresse <?= $i ?></td>
                    <td class="py-3 px-6">08h-18h</td>
                    <td class="py-3 px-6">10€</td>
                    <td class="py-3 px-6">01/01/2023</td>
                    <td class="py-3 px-6">01/02/2023</td>
                    <td class="py-3 px-6 text-center">
                      <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs">Voir</button>
                      <button class="bg-yellow-500 text-white py-1 px-2 rounded text-xs">Modifier</button>
                      <button class="bg-red-500 text-white py-1 px-2 rounded text-xs">Supprimer</button>
                    </td>
                  </tr>
                <?php endfor; ?>
              </tbody>
            </table>
            <div class="flex justify-end bg-gray-100 py-2 px-4">
              <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-l">Précédent</button>
              <button class="bg-blue-500 text-white py-1 px-3">1</button>
              <button class="bg-gray-300 text-gray-700 py-1 px-3">2</button>
              <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-r">Suivant</button>
            </div>
          </div>
        </section>

        <!-- Livraison -->
        <section class="mt-8">
          <h2 class="text-lg font-bold mb-4">Gestion des livraisons</h2>
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
              <thead class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                <tr>
                  <th class="py-3 px-6 text-left">Commande</th>
                  <th class="py-3 px-6 text-left">Destinataire</th>
                  <th class="py-3 px-6 text-left">Adresse</th>
                  <th class="py-3 px-6 text-left">Statut</th>
                  <th class="py-3 px-6 text-left">Date Livraison</th>
                  <th class="py-3 px-6 text-center">Actions</th>
                </tr>
              </thead>
              <tbody class="text-gray-700">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                  <tr class="border-b">
                    <td class="py-3 px-6">Commande <?= $i ?></td>
                    <td class="py-3 px-6">Client <?= $i ?></td>
                    <td class="py-3 px-6">Adresse <?= $i ?></td>
                    <td class="py-3 px-6">En cours</td>
                    <td class="py-3 px-6">01/01/2023</td>
                    <td class="py-3 px-6 text-center">
                      <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs">Voir</button>
                      <button class="bg-yellow-500 text-white py-1 px-2 rounded text-xs">Modifier</button>
                      <button class="bg-red-500 text-white py-1 px-2 rounded text-xs">Supprimer</button>
                    </td>
                  </tr>
                <?php endfor; ?>
              </tbody>
            </table>
            <div class="flex justify-end bg-gray-100 py-2 px-4">
              <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-l">Précédent</button>
              <button class="bg-blue-500 text-white py-1 px-3">1</button>
              <button class="bg-gray-300 text-gray-700 py-1 px-3">2</button>
              <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-r">Suivant</button>
            </div>
          </div>
        </section>
      </div>
    </main>
  </div>
  </body>

  </html>