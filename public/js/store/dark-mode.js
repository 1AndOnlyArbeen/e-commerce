/* ══ Dark Mode ══ */

function toggleDarkMode() {
    const html = document.documentElement;
    const isDark = html.getAttribute('data-theme') === 'dark';
    html.setAttribute('data-theme', isDark ? 'light' : 'dark');
    localStorage.setItem('theme', isDark ? 'light' : 'dark');
    document.querySelectorAll('#dmBtn').forEach(b => {
        b.textContent = isDark ? '🌙 Dark' : '☀️ Light';
    });
}

/* Apply saved theme on load */
(function () {
    const saved = localStorage.getItem('theme');
    if (saved) {
        document.documentElement.setAttribute('data-theme', saved);
        document.querySelectorAll('#dmBtn').forEach(b => {
            b.textContent = saved === 'dark' ? '☀️ Light' : '🌙 Dark';
        });
    }
})();
