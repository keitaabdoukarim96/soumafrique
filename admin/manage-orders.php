<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-4xl">
    <h2 class="text-lg font-bold mb-4 text-center">Liste des commandes</h2>
    <table class="min-w-full text-sm border border-gray-300">
      <thead class="bg-gray-200 text-gray-600 uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left border-b">ID</th>
          <th class="py-3 px-4 text-left border-b">Statut</th>
          <th class="py-3 px-4 text-center border-b">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <!-- Données statiques pour le tableau -->
        <?php for ($i = 1; $i <= 5; $i++) : ?>
          <tr class="border-b hover:bg-gray-100">
            <td class="py-3 px-4">Commande <?= $i ?></td>
            <td class="py-3 px-4">En cours</td>
            <td class="py-3 px-4 text-center">
              <button class="bg-green-500 text-white py-1 px-2 rounded text-xs">Passer</button>
              <button class="bg-red-500 text-white py-1 px-2 rounded text-xs">Annuler</button>
            </td>
          </tr>
        <?php endfor; ?>
      </tbody>
    </table>

    <!-- Pagination statique -->
    <div class="flex justify-end mt-4">
      <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-l">Précédent</button>
      <button class="bg-blue-500 text-white py-1 px-3">1</button>
      <button class="bg-gray-300 text-gray-700 py-1 px-3">2</button>
      <button class="bg-gray-300 text-gray-700 py-1 px-3 rounded-r">Suivant</button>
    </div>
  </div>
</div>
