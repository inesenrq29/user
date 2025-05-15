function openProductModal(element) {
    const modal = document.getElementById('productModal');
    const title = element.getAttribute('data-title');
    const description = element.getAttribute('data-description');
    const price = element.getAttribute('data-price');

    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = description;
    document.getElementById('modalPrice').textContent = price;

    modal.style.display = 'block';
}

// Fonction pour fermer la modale
function closeProductModal() {
    document.getElementById('productModal').style.display = 'none';
}

// Fermer la modale si on clique en dehors
window.onclick = function(event) {
    const modal = document.getElementById('productModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}