  // Initialiser la carte
  var map = L.map('map').setView([47.508, 6.8028], 13); // Coordonnées pour Montbéliard, France

  // Ajouter les tuiles de la carte
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  // Ajouter des marqueurs statiques
  var boutiques = [
    { coords: [47.508, 6.8028], name: "Boutique Centre Ville" },
    { coords: [47.509, 6.808], name: "Boutique Gare" },
    { coords: [47.507, 6.798], name: "Boutique Place Ferrer" },
    { coords: [47.510, 6.812], name: "Boutique Parc" },
    { coords: [47.506, 6.790], name: "Boutique Université" },
    { coords: [47.504, 6.795], name: "Boutique Marché" },
    { coords: [47.512, 6.818], name: "Boutique Théâtre" },
    { coords: [47.507, 6.803], name: "Boutique Place Saint Martin" },
    { coords: [47.509, 6.810], name: "Boutique Port" },
    { coords: [47.503, 6.792], name: "Boutique Stade" }
  ];

  boutiques.forEach(function(boutique) {
    L.marker(boutique.coords, {
      icon: L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
      })
    }).addTo(map).bindPopup(`<b>${boutique.name}</b>`);
  });

