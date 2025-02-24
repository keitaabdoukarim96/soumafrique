document.addEventListener("DOMContentLoaded", () => {
    const dynamicSection = document.getElementById("dynamic-section");
    const dynamicTitle = document.getElementById("dynamic-title");
    const dynamicContent = document.getElementById("dynamic-content");
  
    // Ajouter un utilisateur
    document.getElementById("add-user-btn").addEventListener("click", () => {
      dynamicSection.classList.remove("hidden");
      dynamicTitle.textContent = "Ajouter un utilisateur";
      dynamicContent.innerHTML = `
        <form id="add-user-form">
          <label class="block mb-2 font-semibold">Nom :</label>
          <input type="text" placeholder="Nom" class="border border-gray-300 rounded w-full px-3 py-2 mb-4" />
          <label class="block mb-2 font-semibold">Email :</label>
          <input type="email" placeholder="Email" class="border border-gray-300 rounded w-full px-3 py-2 mb-4" />
          <label class="block mb-2 font-semibold">Rôle :</label>
          <select class="border border-gray-300 rounded w-full px-3 py-2 mb-4">
            <option value="Admin">Admin</option>
            <option value="Propriétaire">Propriétaire</option>
            <option value="Service de Livraison">Service de Livraison</option>
          </select>
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ajouter</button>
        </form>
      `;
    });
  
    // Voir un utilisateur
    document.querySelectorAll(".view-user-btn").forEach(button => {
      button.addEventListener("click", () => {
        const userId = button.dataset.id;
        dynamicSection.classList.remove("hidden");
        dynamicTitle.textContent = "Détails de l'utilisateur";
        dynamicContent.innerHTML = `
          <p><strong>ID :</strong> ${userId}</p>
          <p><strong>Nom :</strong> John Doe</p>
          <p><strong>Email :</strong> john@example.com</p>
          <p><strong>Rôle :</strong> Admin</p>
        `;
      });
    });
  
    // Modifier un utilisateur
    document.querySelectorAll(".edit-user-btn").forEach(button => {
      button.addEventListener("click", () => {
        const userId = button.dataset.id;
        dynamicSection.classList.remove("hidden");
        dynamicTitle.textContent = "Modifier l'utilisateur";
        dynamicContent.innerHTML = `
          <form id="edit-user-form">
            <label class="block mb-2 font-semibold">Nom :</label>
            <input type="text" value="John Doe" class="border border-gray-300 rounded w-full px-3 py-2 mb-4" />
            <label class="block mb-2 font-semibold">Email :</label>
            <input type="email" value="john@example.com" class="border border-gray-300 rounded w-full px-3 py-2 mb-4" />
            <label class="block mb-2 font-semibold">Rôle :</label>
            <select class="border border-gray-300 rounded w-full px-3 py-2 mb-4">
              <option value="Admin" selected>Admin</option>
              <option value="Propriétaire">Propriétaire</option>
              <option value="Service de Livraison">Service de Livraison</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
          </form>
        `;
      });
    });
  
    // Supprimer un utilisateur
    document.querySelectorAll(".delete-user-btn").forEach(button => {
      button.addEventListener("click", () => {
        const userId = button.dataset.id;
        dynamicSection.classList.remove("hidden");
        dynamicTitle.textContent = "Supprimer l'utilisateur";
        dynamicContent.innerHTML = `
          <p>Êtes-vous sûr de vouloir supprimer cet utilisateur (ID : ${userId}) ?</p>
          <button id="confirm-delete" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Confirmer</button>
          <button id="cancel-delete" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Annuler</button>
        `;
  
        // Gérer la confirmation ou l'annulation
        document.getElementById("confirm-delete").addEventListener("click", () => {
          alert(`Utilisateur ID: ${userId} supprimé (simulation)`);
          dynamicSection.classList.add("hidden");
        });
  
        document.getElementById("cancel-delete").addEventListener("click", () => {
          dynamicSection.classList.add("hidden");
        });
      });
    });
  });
  
//GESTION USER

  document.addEventListener("DOMContentLoaded", () => {
    // Cibler le lien pour ajouter un utilisateur
    const addUserLink = document.getElementById("add-user-link");
    const contentContainer = document.getElementById("dynamic-content");

    // Écouter le clic sur le lien
    addUserLink.addEventListener("click", (e) => {
      e.preventDefault(); // Empêcher le rechargement de la page

      // Requête AJAX pour charger le formulaire
      fetch("add-users.php")
        .then((response) => {
          if (!response.ok) throw new Error("Erreur lors du chargement !");
          return response.text();
        })
        .then((html) => {
          contentContainer.innerHTML = html; // Injecter le contenu
        })
        .catch((error) => {
          console.error("Erreur :", error);
          contentContainer.innerHTML = "<p class='text-red-500'>Impossible de charger le contenu.</p>";
        });
    });
  });

//VIEWS USERS

  document.addEventListener("DOMContentLoaded", () => {
    // Cibler le lien pour voir les utilisateurs
    const viewUsersLink = document.getElementById("view-users-link");
    const contentContainer = document.getElementById("dynamic-content");

    // Écouter le clic sur le lien
    viewUsersLink.addEventListener("click", (e) => {
      e.preventDefault(); // Empêcher le rechargement de la page

      // Requête AJAX pour charger le tableau des utilisateurs
      fetch("view-users.php")
        .then((response) => {
          if (!response.ok) throw new Error("Erreur lors du chargement !");
          return response.text();
        })
        .then((html) => {
          contentContainer.innerHTML = html; // Injecter le contenu
        })
        .catch((error) => {
          console.error("Erreur :", error);
          contentContainer.innerHTML = "<p class='text-red-500'>Impossible de charger le contenu.</p>";
        });
    });
  });

//manage-shop

  document.addEventListener("DOMContentLoaded", () => {
    // Cibler le lien pour gérer les boutiques
    const manageShopsLink = document.getElementById("manage-shops-link");
    const contentContainer = document.getElementById("dynamic-content");

    // Écouter le clic sur le lien
    manageShopsLink.addEventListener("click", (e) => {
      e.preventDefault(); // Empêcher le rechargement de la page

      // Requête AJAX pour charger le tableau des boutiques
      fetch("manage-shops.php")
        .then((response) => {
          if (!response.ok) throw new Error("Erreur lors du chargement !");
          return response.text();
        })
        .then((html) => {
          contentContainer.innerHTML = html; // Injecter le contenu
        })
        .catch((error) => {
          console.error("Erreur :", error);
          contentContainer.innerHTML = "<p class='text-red-500'>Impossible de charger le contenu.</p>";
        });
    });
  });

// validate-shop

  document.addEventListener("DOMContentLoaded", () => {
    // Cibler le lien pour valider une boutique
    const validateShopLink = document.getElementById("validate-shop-link");
    const contentContainer = document.getElementById("dynamic-content");

    // Écouter le clic sur le lien
    validateShopLink.addEventListener("click", (e) => {
      e.preventDefault(); // Empêcher le rechargement de la page

      // Requête AJAX pour charger la liste des boutiques à valider
      fetch("validate-shop.php")
        .then((response) => {
          if (!response.ok) throw new Error("Erreur lors du chargement !");
          return response.text();
        })
        .then((html) => {
          contentContainer.innerHTML = html; // Injecter le contenu
        })
        .catch((error) => {
          console.error("Erreur :", error);
          contentContainer.innerHTML = "<p class='text-red-500'>Impossible de charger le contenu.</p>";
        });
    });
  });

//add product
  document.addEventListener("DOMContentLoaded", () => {
    const addProductLink = document.getElementById("add-product-link");
    const contentContainer = document.getElementById("dynamic-content");
  
    addProductLink.addEventListener("click", (e) => {
      e.preventDefault();
  
      // Charger le contenu via AJAX
      fetch("add-product.php")
        .then((response) => {
          if (!response.ok) throw new Error("Erreur lors du chargement !");
          return response.text();
        })
        .then((html) => {
          contentContainer.innerHTML = html;
  
          // Initialiser Quill.js après l'injection du contenu
          const quill = new Quill("#description", {
            theme: "snow",
            modules: {
              toolbar: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["link", "image"],
              ],
            },
          });
        })
        .catch((error) => {
          console.error("Erreur :", error);
          contentContainer.innerHTML =
            "<p class='text-red-500'>Impossible de charger le contenu.</p>";
        });
    });
  });

//manage-orders
 
  document.addEventListener("DOMContentLoaded", () => {
    const manageOrdersLink = document.getElementById("manage-orders-link");
    const contentContainer = document.getElementById("dynamic-content");

    manageOrdersLink.addEventListener("click", (e) => {
      e.preventDefault();

      // Charger le contenu via AJAX
      fetch("manage-orders.php")
        .then((response) => {
          if (!response.ok) throw new Error("Erreur lors du chargement !");
          return response.text();
        })
        .then((html) => {
          contentContainer.innerHTML = html;
        })
        .catch((error) => {
          console.error("Erreur :", error);
          contentContainer.innerHTML =
            "<p class='text-red-500'>Impossible de charger le contenu.</p>";
        });
    });
  });

// mange deliveries
document.addEventListener("DOMContentLoaded", () => {
  const manageDeliveriesLink = document.getElementById("manage-deliveries-link");
  const contentContainer = document.getElementById("dynamic-content");

  manageDeliveriesLink.addEventListener("click", (e) => {
    e.preventDefault();

    // Charger le contenu via AJAX
    fetch("manage-deliveries.php")
      .then((response) => {
        if (!response.ok) throw new Error("Erreur lors du chargement !");
        return response.text();
      })
      .then((html) => {
        contentContainer.innerHTML = html;
      })
      .catch((error) => {
        console.error("Erreur :", error);
        contentContainer.innerHTML =
          "<p class='text-red-500'>Impossible de charger le contenu.</p>";
      });
  });
});
///view-spice-categories
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

//add-spice-category
document.addEventListener("DOMContentLoaded", () => {
  const addSpiceCategoryLink = document.getElementById("add-spice-category-link");
  const contentContainer = document.getElementById("dynamic-content");

  addSpiceCategoryLink.addEventListener("click", (e) => {
    e.preventDefault();

    // Charger le contenu via AJAX
    fetch("add-spice-category.php")
      .then((response) => {
        if (!response.ok) throw new Error("Erreur lors du chargement du formulaire !");
        return response.text();
      })
      .then((html) => {
        contentContainer.innerHTML = html;
      })
      .catch((error) => {
        console.error("Erreur :", error);
        contentContainer.innerHTML = "<p class='text-red-500'>Impossible de charger le formulaire.</p>";
      });
  });
});

//view-roles
  document.addEventListener("DOMContentLoaded", () => {
    const viewRolesLink = document.getElementById("view-roles-link");
    const contentContainer = document.getElementById("dynamic-content");

    viewRolesLink.addEventListener("click", (e) => {
      e.preventDefault();

      // Charger le contenu via AJAX
      fetch("view-roles.php")
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
  
  //add-role.php
  document.addEventListener("DOMContentLoaded", () => {
    const addRoleLink = document.getElementById("add-role-link");
    const contentContainer = document.getElementById("dynamic-content");

    addRoleLink.addEventListener("click", (e) => {
      e.preventDefault();

      // Charger le contenu via AJAX
      fetch("add-role.php")
        .then((response) => {
          if (!response.ok) throw new Error("Erreur lors du chargement du formulaire !");
          return response.text();
        })
        .then((html) => {
          contentContainer.innerHTML = html;
        })
        .catch((error) => {
          console.error("Erreur :", error);
          contentContainer.innerHTML = "<p class='text-red-500'>Impossible de charger le formulaire.</p>";
        });
    });
  });

 //Script AJAX pour charger la liste des catégories de recettes 
 document.addEventListener("DOMContentLoaded", () => {
  const viewRecipeCategoriesLink = document.getElementById("view-recipe-categories-link");
  const contentContainer = document.getElementById("dynamic-content");

  viewRecipeCategoriesLink.addEventListener("click", (e) => {
    e.preventDefault();

    // Charger le contenu via AJAX
    fetch("view-recipe-categories.php")
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

//Script AJAX pour afficher le formulaire d'ajout de recette
document.addEventListener("DOMContentLoaded", () => {
  const addRecipeLink = document.getElementById("add-recipe-link");
  const contentContainer = document.getElementById("dynamic-content");

  addRecipeLink.addEventListener("click", (e) => {
    e.preventDefault();

    // Charger le contenu via AJAX
    fetch("add-recipe.php")
      .then((response) => {
        if (!response.ok) throw new Error("Erreur lors du chargement du formulaire !");
        return response.text();
      })
      .then((html) => {
        contentContainer.innerHTML = html;

        // Initialiser Quill.js après l'injection du contenu
        const quillIngredients = new Quill("#ingredients", {
          theme: "snow",
          modules: {
            toolbar: [["bold", "italic", "underline"], [{ list: "ordered" }, { list: "bullet" }], ["link", "image"]],
          },
        });
        
        const quillDescription = new Quill("#description", {
          theme: "snow",
          modules: {
            toolbar: [["bold", "italic", "underline"], [{ list: "ordered" }, { list: "bullet" }], ["link", "image"]],
          },
        });
      })
      .catch((error) => {
        console.error("Erreur :", error);
        contentContainer.innerHTML = "<p class='text-red-500'>Impossible de charger le formulaire.</p>";
      });
  });
});
