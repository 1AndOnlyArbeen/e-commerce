/* ══ Product Search Filter ══ */

function filterProducts() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const filtered = products.filter(p => p.name.toLowerCase().includes(search));
    renderProducts(filtered);
}
