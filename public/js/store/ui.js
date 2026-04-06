/* ══ UI: Account Dropdown & Escape Key ══ */

function toggleAccountMenu() {
    document.getElementById('accountMenu').classList.toggle('hidden');
}

document.addEventListener('click', function (e) {
    const wrapper = document.getElementById('accountWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        const menu = document.getElementById('accountMenu');
        if (menu) menu.classList.add('hidden');
    }
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeProductModal();
        closeCheckout();
        closeOrdersModal();
    }
});
