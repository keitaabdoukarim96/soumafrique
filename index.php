<!--Header start-->
<?php include('./templates/header.php'); ?>
<!--Header end-->

<main class="flex-grow mt-20 mb-10">
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
</main>





<!-- Footer start-->
<?php include('./templates/footer.php'); ?>
<!--Footer end-->