document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        let produitId = encodeURIComponent(this.dataset.id);
        let prix = encodeURIComponent(this.dataset.price);

        fetch('ajout_panier.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product_id=${produitId}&price=${prix}` // ⚠️ On envoie product_id mais il sera utilisé en produit_id dans PHP
        })
        .then(response => response.json()) // ✅ Vérifier que la réponse est bien JSON
        .then(data => {
            if (data.error) {
                console.error("Erreur:", data.error);
            } else if (data.total_items !== undefined) {
                document.getElementById('cart-count').textContent = data.total_items;
            }
        })
        .catch(error => console.error('Erreur JSON:', error)); // ✅ Afficher les erreurs JSON
    });
});
