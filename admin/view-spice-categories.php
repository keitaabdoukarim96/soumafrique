<!-- Script AJAX pour charger les catégories d'épices -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const viewSpiceCategoriesLink = document.getElementById("view-spice-categories-link");
    const contentContainer = document.getElementById("dynamic-content");

    viewSpiceCategoriesLink.addEventListener("click", (e) => {
      e.preventDefault();

      // Charger le contenu via AJAX
      fetch("view-spice-categories.php")
        .then((response) => {
          if (!response.ok) throw new Error("Erreur lors du chargement !");
          return response.text();
        })
        .then((html) => {
          contentContainer.innerHTML = html;
        })
        .catch((error) => {
          console.error("Erreur :", error);
          contentContainer.innerHTML = "<p class='text-red-500'>Impossible de charger le contenu.</p>";
        });
    });
  });
</script>

<!-- Contenu du fichier view-spice-categories.php -->
<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-4xl">
    <h2 class="text-lg font-bold mb-4 text-center">Catégories d'épices</h2>
    <table class="min-w-full text-sm border border-gray-300">
      <thead class="bg-gray-200 text-gray-600 uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left border-b">Catégorie</th>
          <th class="py-3 px-4 text-left border-b">Sous-catégories</th>
          <th class="py-3 px-4 text-center border-b">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <!-- Épices entières -->
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4 font-semibold">Épices entières</td>
          <td class="py-3 px-4">Graines, Baies</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
            <button class="bg-green-500 text-white py-1 px-2 rounded text-xs hover:bg-green-600">Voir détails</button>
          </td>
        </tr>
        <!-- Épices moulues ou en poudre -->
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4 font-semibold">Épices moulues ou en poudre</td>
          <td class="py-3 px-4">Poudre, Gousses, Racine</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
            <button class="bg-green-500 text-white py-1 px-2 rounded text-xs hover:bg-green-600">Voir détails</button>
          </td>
        </tr>
        <!-- Herbes aromatiques séchées -->
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4 font-semibold">Herbes aromatiques séchées</td>
          <td class="py-3 px-4">Feuilles</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
            <button class="bg-green-500 text-white py-1 px-2 rounded text-xs hover:bg-green-600">Voir détails</button>
          </td>
        </tr>
        <!-- Épices fumées ou fermentées -->
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4 font-semibold">Épices fumées ou fermentées</td>
          <td class="py-3 px-4">Poudre, Gousses, Piments séchés</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
            <button class="bg-green-500 text-white py-1 px-2 rounded text-xs hover:bg-green-600">Voir détails</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>