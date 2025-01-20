<?php 
include('./templates/header.php');
?>

<section class="relative">
  <div class="relative w-full h-[70vh]">
    <!-- Image de fond -->
    <img src="assets/img/contact-banner.png" alt="Bannière Contact" class="absolute inset-0 w-full h-full object-cover">
    <!-- Superposition sombre et texte centré -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4" style="padding-top: calc(80px + 1rem);">
      <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold text-center leading-tight">
        Contactez-nous
      </h1>
    </div>
  </div>
</section>

<!-- Corps de la page -->
<main class="py-16 px-4 bg-gray-100">
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">
    
    <!-- Formulaire de contact -->
    <div class="bg-white shadow-lg rounded-lg p-8">
  <h2 class="text-2xl font-bold mb-6 text-red-700">Envoyez-nous un message</h2>
  <form action="#" method="POST" class="space-y-6">
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">Votre Nom</label>
      <input type="text" id="name" name="name" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100 py-2 px-4 focus:ring-green-600 focus:border-green-600 focus:bg-white">
    </div>
    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">Votre Email</label>
      <input type="email" id="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100 py-2 px-4 focus:ring-green-600 focus:border-green-600 focus:bg-white">
    </div>
    <div>
      <label for="message" class="block text-sm font-medium text-gray-700">Votre Message</label>
      <textarea id="message" name="message" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100 py-2 px-4 focus:ring-green-600 focus:border-green-600 focus:bg-white"></textarea>
    </div>
    <button type="submit" class="btn-gradient text-white px-6 py-3 rounded-lg font-bold w-full">Envoyer le message</button>
  </form>
</div>


    <!-- Informations de contact -->
    <div class="space-y-8">
      <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-green-700">Nos Coordonnées</h2>
        <ul class="space-y-4 text-gray-700">
          <li class="flex items-center">
            <i class="fas fa-map-marker-alt text-red-500 mr-4"></i>
            <span>27 faubourg de besançon</span>
          </li>
          <li class="flex items-center">
            <i class="fas fa-phone text-red-500 mr-4"></i>
            <span>(+33) 07 822 734 38</span>
          </li>
          <li class="flex items-center">
            <i class="fas fa-envelope text-red-500 mr-4"></i>
            <span>contact@soumAfrique.com</span>
          </li>
        </ul>
      </div>

    
    </div>
  </div>
</main>





<!-- Corps de la page -->

<?php include('./templates/footer.php'); ?>
