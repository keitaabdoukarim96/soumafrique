<!--Header start-->
<?php include('../templates/header.php'); ?>
<!--Header end-->

<main class="flex-grow mt-20 mb-20">
  <div class="container mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-6 mt-20">
      <a href="/soumafrique/index.php" class="text-green-700 font-bold">Accueil</a> >
      <a href="/soumafrique/recettes.php" class="text-green-700 font-bold">Recettes</a> >
      <a href="#" class="text-green-700 font-bold">Plat principal</a> >
      <a href="#" class="text-green-700 font-bold">Viande en sauce</a> >
      <span class="text-red-600 font-bold">Cuisses de poulet à la sauce d'arachide</span>
    </nav>

    <!-- Titre et image principale -->
    <h1 class="text-center text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-8">
      Cuisses de poulet à la sauce d'arachide
    </h1>
    <div class="flex justify-center mb-8 mt-10">
      <img src="../assets/img/recette-poulet-arachide.jpg" alt="Cuisses de poulet à la sauce d'arachide" class="w-full max-w-md rounded-lg shadow-md">
    </div>

    <!-- Infos sur la recette -->
    <div class="flex justify-center space-x-8 text-gray-700 text-sm mb-8 mt-10">
      <div class="flex flex-col items-center">
        <i class="far fa-clock text-2xl mb-2"></i>
        <span>1h</span>
      </div>
      <div class="flex flex-col items-center">
        <i class="fas fa-utensils text-2xl mb-2"></i>
        <span>facile</span>
      </div>
      <div class="flex flex-col items-center">
        <i class="fas fa-tags text-2xl mb-2"></i>
        <span>bon marché</span>
      </div>
    </div>

    <!-- Ingrédients -->
    <section class="mb-12">
      <h2 class="text-xl font-bold mb-4"><i class="fas fa-leaf mr-2"></i> Ingrédients</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Liste des ingrédients avec icônes -->
        <div class="text-center">
          <img src="../assets/img/persil.jpg" alt="Persil" class="w-20 h-20 mx-auto">
          <p class="mt-2">10 brins de persil</p>
        </div>
        <div class="text-center">
          <img src="../assets/img/curry.png" alt="Curry" class="w-20 h-20 mx-auto">
          <p class="mt-2">1 pincée curry</p>
        </div>
        <div class="text-center">
          <img src="../assets/img/gingembre.png" alt="Gingembre" class="w-20 h-20 mx-auto">
          <p class="mt-2">1 cuillère à café de gingembre moulu</p>
        </div>
        <div class="text-center">
          <img src="../assets/img/product/p3.png" alt="Poivre blanc" class="w-20 h-20 mx-auto">
          <p class="mt-2">poivre blanc</p>
        </div>
        <div class="text-center">
          <img src="../assets/img/poulet.jpg" alt="Poulet" class="w-20 h-20 mx-auto">
          <p class="mt-2">1 Poulet</p>
        </div>
        <div class="text-center">
          <img src="../assets/img/tomate.jpg" alt="Tomates" class="w-20 h-20 mx-auto">
          <p class="mt-2">3 tomates</p>
        </div>
        <div class="text-center">
          <img src="../assets/img/oignons.jpg" alt="Oignons" class="w-20 h-20 mx-auto">
          <p class="mt-2">2 oignons</p>
        </div>
      </div>
    </section>

    <!-- Préparation -->
    <section>
      <h2 class="text-xl font-bold mb-4"><i class="fas fa-concierge-bell mr-2"></i> Préparation</h2>
      <ul class="list-decimal list-inside space-y-4 text-gray-700">
        <li>Faire revenir les cuisses de poulet dans une cocotte ou un faitout avec le beurre.</li>
        <li>Mixer la tomate avec les oignons, l’ail et le persil.</li>
        <li>Délayer 3 cuillères à soupe de pâte d’arachide dans de l’eau afin d’obtenir un mélange homogène.</li>
        <li>Lorsque les cuisses de poulet sont bien dorées, les retirer de la cocotte, et verser à leur place les tomates mixées et la sauce d’arachide.</li>
        <li>Mélanger au fouet puis émietter les cubes de bouillon, saupoudrer de poivre, de curry et de gingembre.</li>
        <li>Laisser mijoter à feu doux pendant quelques minutes, remettre les cuisses de poulet dans la sauce et cuire pendant 30 minutes à feu doux.</li>
      </ul>
    </section>
  </div>
</main>

<!-- Footer start-->
<?php include('../templates/footer.php'); ?>
<!--Footer end-->
