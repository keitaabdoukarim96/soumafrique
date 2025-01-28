<!-- Contenu du fichier view-roles.php -->
<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-4xl">
    <h2 class="text-lg font-bold mb-4 text-center">Liste des rôles</h2>
    <table class="min-w-full text-sm border border-gray-300">
      <thead class="bg-gray-200 text-gray-600 uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left border-b">ID</th>
          <th class="py-3 px-4 text-left border-b">Nom du rôle</th>
          <th class="py-3 px-4 text-left border-b">Description</th>
          <th class="py-3 px-4 text-center border-b">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <!-- Données statiques pour les rôles -->
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4">1</td>
          <td class="py-3 px-4 font-semibold">Administrateur</td>
          <td class="py-3 px-4">Gestion complète du système</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
          </td>
        </tr>
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4">2</td>
          <td class="py-3 px-4 font-semibold">Propriétaire de boutique</td>
          <td class="py-3 px-4">Gestion des produits et commandes</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
          </td>
        </tr>
        <tr class="border-b hover:bg-gray-100">
          <td class="py-3 px-4">3</td>
          <td class="py-3 px-4 font-semibold">Service de livraison</td>
          <td class="py-3 px-4">Gestion des livraisons et statuts</td>
          <td class="py-3 px-4 text-center">
            <button class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600">Modifier</button>
            <button class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
