<!-- Contenu du fichier view-recipe-categories.php -->
<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-4xl">
    <h2 class="text-lg font-bold mb-4 text-center">Catégories de Recettes Africaines</h2>
    <table class="min-w-full text-sm border border-gray-300">
      <thead class="bg-gray-200 text-gray-600 uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left border-b">ID</th>
          <th class="py-3 px-4 text-left border-b">Nom de la catégorie</th>
          <th class="py-3 px-4 text-left border-b">Description</th>
          <th class="py-3 px-4 text-center border-b">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <!-- Liste des catégories africaines -->
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4">1</td>
          <td class="py-3 px-4 font-semibold">Plats Traditionnels</td>
          <td class="py-3 px-4">Recettes emblématiques des différentes régions d'Afrique</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
          </td>
        </tr>
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4">2</td>
          <td class="py-3 px-4 font-semibold">Soupes & Ragoûts</td>
          <td class="py-3 px-4">Les soupes et plats mijotés typiques d'Afrique</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
          </td>
        </tr>
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4">3</td>
          <td class="py-3 px-4 font-semibold">Grillades & Barbecues</td>
          <td class="py-3 px-4">Les viandes et poissons grillés, spécialités africaines</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
          </td>
        </tr>
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4">4</td>
          <td class="py-3 px-4 font-semibold">Boissons & Jus Naturels</td>
          <td class="py-3 px-4">Les boissons africaines à base de fruits et d’épices</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>