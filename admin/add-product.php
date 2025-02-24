<?php include('./templates/header.php');?>

<div class="flex min-h-screen">
<?php include('sidebar2.php'); ?>
<div class="flex-1 p-6 flex flex-col items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-lg font-bold mb-4 text-center">Ajouter un produit</h2>
    <form id="add-product-form">
      <!-- Nom de l'épice -->
      <div class="mb-4">
        <label for="product-name" class="block text-gray-700 font-medium mb-2">Nom de l'épice :</label>
        <input type="text" id="product-name" name="product_name" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Boutique -->
      <div class="mb-4">
        <label for="shop-name" class="block text-gray-700 font-medium mb-2">Boutique :</label>
        <input type="text" id="shop-name" name="shop_name" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Adresse -->
      <div class="mb-4">
        <label for="address" class="block text-gray-700 font-medium mb-2">Adresse :</label>
        <input type="text" id="address" name="address" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Horaires -->
      <div class="mb-4">
        <label for="schedule" class="block text-gray-700 font-medium mb-2">Horaires :</label>
        <input type="text" id="schedule" name="schedule" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Catégorie -->
      <div class="mb-4">
        <label for="category" class="block text-gray-700 font-medium mb-2">Catégorie :</label>
        <select id="category" name="category" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
          <option value="">Sélectionnez une catégorie</option>
          <option value="epices-entieres">Épices entières</option>
          <option value="epices-moulues">Épices moulues ou en poudre</option>
          <option value="herbes-aromatiques">Herbes aromatiques séchées</option>
          <option value="epices-fumees">Épices fumées ou fermentées</option>
        </select>
      </div>
      <!-- Prix -->
      <div class="mb-4">
        <label for="price" class="block text-gray-700 font-medium mb-2">Prix :</label>
        <input type="number" id="price" name="price" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500">
      </div>
      <!-- Description -->
      <div class="mb-4">
        <label for="description" class="block text-gray-700 font-medium mb-2">Description :</label>
        <div id="description" name="description" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-500"></div>
      </div>
      <!-- Bouton Soumettre -->
      <div class="flex justify-center">
        <button type="submit" class="btn-gradient text-white py-2 px-4 rounded-lg ">Ajouter</button>
      </div>
    </form>
  </div>
</div>  
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const quillDescription = new Quill("#description", {
      theme: "snow",
      modules: {
        toolbar: [["bold", "italic", "underline"], [{ list: "ordered" }, { list: "bullet" }], ["link", "image"]],
      },
    });
  });
</script>
<?php include('./templates/footer.php');?>