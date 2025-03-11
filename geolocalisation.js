document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[id^='go-to-map-']").forEach(button => {
        button.addEventListener("click", function () {
            const shopLat = this.getAttribute("data-lat");
            const shopLng = this.getAttribute("data-lng");

            if (!shopLat || !shopLng) {
                alert("❌ Coordonnées de la boutique non disponibles.");
                return;
            }

            // Vérifier si la position de l'utilisateur est stockée
            const userLat = localStorage.getItem("user_lat");
            const userLng = localStorage.getItem("user_lng");

            if (!userLat || !userLng) {
                alert("❌ Activez votre localisation pour voir l'itinéraire.");
                return;
            }

            // URL pour ouvrir OpenStreetMap avec l'itinéraire
            //const osmUrl = `https://www.openstreetmap.org/directions?engine=graphhopper_foot&route=${userLat},${userLng};${shopLat},${shopLng}`;
            const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${shopLat},${shopLng}&travelmode=walking`;
            window.open(googleMapsUrl, "_blank");

            // Ouvrir la carte dans un nouvel onglet
            //window.open(osmUrl, "_blank");
        });
    });
});
