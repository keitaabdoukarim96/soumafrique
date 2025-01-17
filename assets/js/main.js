document.getElementById("menu-toggle").addEventListener("click", function () {
  const mobileMenu = document.getElementById("mobile-menu");
  mobileMenu.classList.toggle("hidden");
});

const epicerieLink = document.querySelector("#mobile-menu a[href='./epicerie.html']");
const recettesLink = document.querySelector("#mobile-menu a[href='./recettes.html']");

epicerieLink.addEventListener("click", function (e) {
  e.preventDefault();
  document.getElementById("sub-menu-epicerie").classList.toggle("hidden");
});

recettesLink.addEventListener("click", function (e) {
  e.preventDefault();
  document.getElementById("sub-menu-recettes").classList.toggle("hidden");
});


document.addEventListener("DOMContentLoaded", function() {
  const menuItems = document.querySelectorAll("nav a"); // Sélectionne tous les liens du menu

  menuItems.forEach(item => {
    item.addEventListener("click", () => {
      // Supprime la classe active de tous les menus
      menuItems.forEach(i => i.classList.remove("active"));
      // Ajoute la classe active au menu cliqué
      item.classList.add("active");
    });
  });

  // Gérer les sous-menus
  const subMenuItems = document.querySelectorAll(".relative .absolute a");
  subMenuItems.forEach(subItem => {
    subItem.addEventListener("click", (e) => {
      // Empêche l'activation par défaut du lien parent
      e.stopPropagation();
      // Supprime les classes actives des sous-menus
      subMenuItems.forEach(i => i.classList.remove("active"));
      subItem.classList.add("active");
    });
  });
});


