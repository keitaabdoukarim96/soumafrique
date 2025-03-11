document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-input");
    const searchResults = document.getElementById("search-results");
    const searchForm = document.getElementById("search-form");
    const searchButton = document.getElementById("search-button");

    if (!searchInput || !searchResults || !searchButton || !searchForm) {
        console.error("Les éléments de recherche n'existent pas dans le DOM.");
        return;
    }
// 🔍 Recherche dynamique (au clavier)
    searchInput.addEventListener("keyup", function() {
        let query = searchInput.value.trim();

        if (query.length > 1) {
            fetch(`search.php?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = "";
                    searchResults.classList.remove("hidden");

                    if (data.length === 0) {
                        searchResults.innerHTML = "<p class='p-2 text-gray-600'>Aucun résultat trouvé.</p>";
                        return;
                    }

                   
                    let resultsHTML = `<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-2">`;

                    data.forEach(item => {
                        resultsHTML += `
                             <a href="${item.type === 'epice' ? 'detail-epice.php?id=' + item.id :
                                      item.type === 'recette' ? 'detail-recette.php?id=' + item.id :
                                      'view-boutique.php?id=' + item.id}"
                               class="flex flex-col items-center bg-white shadow-md rounded-lg p-3 hover:bg-gray-200 transition">
                               
                                ${item.image ? `<img src="${item.image}" class=""w-20 h-20 object-cover rounded-lg mb-2">` : ''}

                                <div class="text-center">
                                    <p class="font-semibold text-sm truncate w-24">${item.name}</p>
                                    <span class="text-xs text-gray-500">${item.type.toUpperCase()}</span>
                                </div>
                            </a>
                        `;
                    });

                    resultsHTML += `</div>`;
                    searchResults.innerHTML = resultsHTML;
                }).catch(error => {
                    console.error("Erreur lors de la récupération des résultats :", error);
                });
        } else {
            searchResults.classList.add("hidden");
        }
    });

    // 🎯 Validation avec le bouton de recherche
    searchButton.addEventListener("click", function (event) {
        event.preventDefault();
        let query = searchInput.value.trim();

        if (query.length > 1) {
            window.location.href = `search-results.php?query=${query}`;
        }
    });

    // 🖱️ Cacher les résultats si on clique en dehors
    document.addEventListener("click", function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add("hidden");
        }
    });
});
