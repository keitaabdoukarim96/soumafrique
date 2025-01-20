document.getElementById("menu-toggle").addEventListener("click", function () {
  const mobileMenu = document.getElementById("mobile-menu");
  mobileMenu.classList.toggle("hidden");
});

// Gestion des sous-menus mobiles
document.querySelectorAll("[data-target]").forEach(menuItem => {
  menuItem.addEventListener("click", function () {
    const target = this.getAttribute("data-target");
    const subMenu = document.getElementById(target);
    subMenu.classList.toggle("hidden");
  });
});


