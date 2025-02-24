

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
