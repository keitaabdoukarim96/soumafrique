document.addEventListener("DOMContentLoaded", function () {
    let filters = {}; // Variable globale pour stocker les filtres

    const applyFiltersBtn = document.getElementById("apply-filters");
    const resetFiltersBtn = document.getElementById("reset-filters");

    if (!applyFiltersBtn || !resetFiltersBtn) {
        console.error("Les boutons 'Appliquer' ou 'Réinitialiser' sont introuvables !");
        return;
    }

    applyFiltersBtn.addEventListener("click", function () {
        applyFilters();
    });

    resetFiltersBtn.addEventListener("click", function () {
        resetFilters();
    });

    function applyFilters() {
        filters = {
            search: document.getElementById("search-filter")?.value.trim() || "",
            sort: document.getElementById("sort-filter")?.value || "default",
            available: document.getElementById("available-filter")?.checked ? 1 : 0,
            min_price: document.getElementById("min-price")?.value || 0,
            max_price: document.getElementById("max-price")?.value || 100,
            categoriesEpices: Array.from(document.querySelectorAll(".category-filter-epices:checked")).map(cb => cb.value),
            categoriesRecettes: Array.from(document.querySelectorAll(".category-filter-recettes:checked")).map(cb => cb.value),
            types: Array.from(document.querySelectorAll(".type-filter:checked")).map(cb => cb.value)
        };

        console.log("Filtres envoyés :", filters);

        fetch("filter.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(filters)
        })
        .then(response => response.json())
        .then(data => {
            console.log("Réponse du serveur :", data);
            if (data.error) {
                console.error("Erreur serveur :", data.error);
            } else {
                updateProductsList(data);
            }
        })
        .catch(error => console.error("Erreur lors du filtrage :", error));
    }

    function resetFilters() {
        document.getElementById("search-filter").value = "";
        document.getElementById("sort-filter").value = "default";
        document.getElementById("available-filter").checked = false;
        document.getElementById("min-price").value = "";
        document.getElementById("max-price").value = "";

        document.querySelectorAll(".category-filter-epices").forEach(checkbox => checkbox.checked = false);
        document.querySelectorAll(".category-filter-recettes").forEach(checkbox => checkbox.checked = false);
        document.querySelectorAll(".type-filter").forEach(checkbox => checkbox.checked = false);

        applyFilters(); // Recharge la liste sans filtres
    }

    function updateProductsList(products) {
        // Détecter la page actuelle et sélectionner le bon conteneur
        const epicesContainer = document.querySelector("#epices-section .products-grid");
        const recettesContainer = document.querySelector("#recettes-section .products-grid");

        // Vérifier quel type de produit doit être mis à jour
        const hasEpices = products.some(p => p.type === "epice");
        const hasRecettes = products.some(p => p.type === "recette");

        // Nettoyer les conteneurs
        if (epicesContainer) epicesContainer.innerHTML = "";
        if (recettesContainer) recettesContainer.innerHTML = "";

        if (!Array.isArray(products) || products.length === 0) {
            if (epicesContainer) epicesContainer.innerHTML = "<p class='text-center text-gray-600 col-span-full'>Aucune épice trouvée.</p>";
            if (recettesContainer) recettesContainer.innerHTML = "<p class='text-center text-gray-600 col-span-full'>Aucune recette trouvée.</p>";
            return;
        }

        products.forEach(product => {
            let productHTML = `
                <div class="border border-green-500 rounded-lg overflow-hidden shadow-lg">
                    <img src="${product.image}" alt="${product.name}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800">${product.name}</h3>
                        ${product.type === 'epice' ? `
                        <p class="text-sm text-gray-600"><strong>Boutique:</strong> ${product.boutique || "N/A"}</p>
                        <p class="text-sm text-gray-600"><strong>Adresse:</strong> ${product.adresse || "N/A"}</p>
                        <p class="text-sm text-gray-600"><strong>Horaire:</strong> ${product.horaires || "N/A"}</p>
                        <p class="text-sm ${product.disponibilite === 'en_stock' ? 'text-green-600' : 'text-red-600'}">
                           <strong>Disponibilité :</strong> ${product.disponibilite === 'en_stock' ? 'En stock' : 'Rupture de stock'}
                        </p>
                        ` : `
                        <p class="text-sm text-gray-600"><strong>Durée:</strong> ${product.duree || "N/A"} min</p>
                        <p class="text-sm text-gray-600"><strong>Portions:</strong> ${product.portions || "N/A"} pers.</p>
                        <p class="text-sm text-gray-600"><strong>Mode de cuisson:</strong> ${product.cuisson || "N/A"}</p>
                        <p class="text-sm text-gray-600"><strong>Budget:</strong> ${product.budget || "N/A"} €</p>
                        `}
                        <div class="flex justify-center items-center mt-4">
                            <a href="${product.type === 'epice' ? 'details/detail-epice.php?id=' + product.id : 'details/detail-recette.php?id=' + product.id}" 
                               class="btn-gradient py-2 px-4 text-white rounded-lg font-bold">
                               VOIR LES DÉTAILS
                            </a>
                        </div>
                    </div>
                </div>
            `;

            if (product.type === "epice" && epicesContainer) {
                epicesContainer.innerHTML += productHTML;
            } else if (product.type === "recette" && recettesContainer) {
                recettesContainer.innerHTML += productHTML;
            }
        });
    }
});
