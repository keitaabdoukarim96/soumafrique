function updateStatus(id, action) {
    fetch('validate-shop.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&action=${action}&ajax=true`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const statusCell = document.getElementById(`status-${id}`);
            if (action === 'valider') {
                statusCell.innerHTML = "<span class='bg-green-500 text-white px-2 py-1 rounded'>Validé</span>";
            } else {
                statusCell.innerHTML = "<span class='bg-red-500 text-white px-2 py-1 rounded'>Rejeté</span>";
            }

            const successMessage = document.getElementById('successMessage');
            successMessage.textContent = data.message;
            successMessage.classList.remove('hidden');

            setTimeout(() => {
                successMessage.classList.add('hidden');
            }, 4000);
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Erreur :', error));
}
