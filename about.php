<?php 
include('./templates/header.php');
?>

<!-- Image avec titre centré -->
<section class="relative">
  <div class="relative w-full h-[70vh]">
    <!-- Image de fond -->
    <img src="assets/img/apropos-banner.png" alt="Bannière À propos" class="absolute inset-0 w-full h-full object-cover">
    <!-- Superposition sombre et texte centré -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4" style="padding-top: calc(80px + 1rem);">
      <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold text-center leading-tight">
        SoumAfrique : Les Saveurs de l'Afrique à Votre Porte
      </h1>
    </div>
  </div>
</section>





<!-- Corps de la page -->
<main class="flex-grow py-20 bg-gray-50">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Bienvenue -->
    <section class="mb-12">
      <h2 class="text-2xl sm:text-3xl font-bold text-green-700 mb-4 text-center">Bienvenue sur SoumAfrique</h2>
      <p class="text-gray-700 text-lg text-center leading-relaxed">
        Votre plateforme dédiée à la découverte et à l’achat des épices et produits d’épicerie africaine. 
        Nous connectons les amateurs de saveurs authentiques et les professionnels de la cuisine aux boutiques locales spécialisées, 
        tout en facilitant la recherche, la commande, et la livraison.
      </p>
    </section>

    <!-- Notre Mission -->
    <section class="bg-white shadow-md rounded-lg p-6 mb-12">
      <h3 class="text-xl font-bold text-red-700 mb-4">Notre Mission</h3>
      <p class="text-gray-700 leading-relaxed">
        Chez SoumAfrique, notre mission est de promouvoir la richesse culinaire africaine en rendant accessibles des produits authentiques, 
        de qualité et adaptés aux besoins de chaque utilisateur. Nous valorisons le savoir-faire des producteurs locaux et offrons une expérience 
        fluide et conviviale pour nos clients, qu’ils soient passionnés de cuisine ou restaurateurs.
      </p>
    </section>

    <!-- Notre Vision -->
    <section class="bg-green-100 shadow-md rounded-lg p-6 mb-12">
      <h3 class="text-xl font-bold text-green-700 mb-4">Notre Vision</h3>
      <p class="text-gray-700 leading-relaxed">
        Nous aspirons à devenir la référence incontournable pour les épices africaines, en offrant une plateforme qui allie tradition et modernité. 
        Notre objectif est de rapprocher les cultures culinaires tout en soutenant l’économie locale des boutiques et producteurs.
      </p>
    </section>

    <!-- Pourquoi SoumAfrique -->
    <section class="bg-white shadow-md rounded-lg p-6">
      <h3 class="text-xl font-bold text-red-700 mb-4">Pourquoi SoumAfrique ?</h3>
      <p class="text-gray-700 leading-relaxed">
        En choisissant SoumAfrique, vous rejoignez une communauté qui célèbre les saveurs, les traditions, et la créativité culinaire. 
        Que vous soyez curieux de nouvelles recettes ou à la recherche de produits spécifiques, nous sommes là pour répondre à vos besoins avec 
        excellence et convivialité.
      </p>
    </section>
  </div>
</main>

<?php include('./templates/footer.php'); ?>
