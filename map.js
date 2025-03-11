document.addEventListener("DOMContentLoaded", function () {
    let mapElement = document.getElementById("map");

    if (!mapElement) {
        console.error("❌ L'élément #map n'existe pas !");
        return;
    }

    // Vérification avant d'initialiser une nouvelle carte
    if (window.myMap) {
        window.myMap.remove();
    }

    // Initialisation de la carte
    window.myMap = L.map("map").setView([48.8566, 2.3522], 12);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap contributors",
    }).addTo(window.myMap);

    // Récupérer la position de l'utilisateur
    const userLat = parseFloat(localStorage.getItem("user_lat"));
    const userLng = parseFloat(localStorage.getItem("user_lng"));

    if (!isNaN(userLat) && !isNaN(userLng)) {
        window.myMap.setView([userLat, userLng], 12);
        L.marker([userLat, userLng]).addTo(window.myMap)
            .bindPopup("<b>Votre position</b>").openPopup();
    }

    // Charger les boutiques
    fetch("maps.php")
        .then(response => response.json())
        .then(epiceries => {
            epiceries.forEach(epicerie => {
                let marker = L.marker([epicerie.latitude, epicerie.longitude]).addTo(window.myMap)
                    .bindPopup(`
                        <b>${epicerie.nom_epice}</b><br>
                        ${epicerie.adresse}<br>
                        <button class="go-to-shop" data-lat="${epicerie.latitude}" data-lng="${epicerie.longitude}">Y aller</button>
                    `);
            });

            // Attendre un court délai avant d'ajouter les événements
            setTimeout(() => {
                document.querySelectorAll(".go-to-shop").forEach(button => {
                    button.addEventListener("click", function () {
                        let shopLat = this.getAttribute("data-lat");
                        let shopLng = this.getAttribute("data-lng");

                        if (!shopLat || !shopLng) {
                            alert("❌ Coordonnées non disponibles.");
                            return;
                        }

                        window.open(`https://www.google.com/maps/dir/?api=1&destination=${shopLat},${shopLng}`, "_blank");
                    });
                });
            }, 500);
        })
        .catch(error => console.error("❌ Erreur lors du chargement des boutiques :", error));
});
