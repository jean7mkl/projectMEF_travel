<footer>
        <p>&copy; 2025 Agence de Voyage de Leo Bouabdallah, Thomas Ribeiro, Jean Moukarzel.<br> Tous droits réservés.</p>
    </footer>
    <script>
function setCookie(name, value, days) {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/';
}

function getCookie(name) {
    return document.cookie.split('; ').reduce((r, v) => {
        const parts = v.split('=');
        return parts[0] === name ? decodeURIComponent(parts[1]) : r;
    }, '');
}

function applyTheme(theme) {
    const override = document.getElementById('theme-override');
    if (!override) return;

    let href = "";
    switch (theme) {
        case "dark":
            href = "assets/css/dark.css";
            break;
        case "contrast":
            href = "assets/css/contrast.css";
            break;
        case "accessible":
            href = "assets/css/accessible.css";
            break;
        case "light":
        default:
            href = "";
            break;
    }

    override.href = href;
    setCookie('theme', theme, 30);
}

document.addEventListener("DOMContentLoaded", () => {
    let savedTheme = getCookie("theme") || "light";
    applyTheme(savedTheme);

    document.getElementById("toggle-theme")?.addEventListener("click", () => {
        const current = getCookie("theme") || "light";
        const next = current === "dark" ? "light" : "dark";
        applyTheme(next);
    });

    document.getElementById("toggle-contrast")?.addEventListener("click", () => applyTheme("contrast"));
    document.getElementById("toggle-accessible")?.addEventListener("click", () => applyTheme("accessible"));
});
</script>

</body>
</html>
