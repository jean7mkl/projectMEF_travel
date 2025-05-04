function setCookie(name, value, days) {
  const expires = new Date(Date.now() + days * 864e5).toUTCString();
  document.cookie = name + "=" + encodeURIComponent(value) + "; expires=" + expires + "; path=/";
}

function getCookie(name) {
  return document.cookie.split("; ").reduce((r, v) => {
    const parts = v.split("=");
    return parts[0] === name ? decodeURIComponent(parts[1]) : r;
  }, "");
}

function applyTheme(theme) {
  const override = document.getElementById("theme-override");
  let path = "";

  switch (theme) {
    case "dark":
      path = "assets/css/dark.css";
      break;
    case "contrast":
      path = "assets/css/contrast.css";
      break;
    case "accessible":
      path = "assets/css/accessible.css";
      break;
    default:
      path = "";
  }

  override.href = path;
  setCookie("theme", theme, 30);
}

document.addEventListener("DOMContentLoaded", () => {
  const savedTheme = getCookie("theme") || "light";
  applyTheme(savedTheme);

  document.getElementById("toggle-theme")?.addEventListener("click", () => applyTheme("dark"));
  document.getElementById("toggle-contrast")?.addEventListener("click", () => applyTheme("contrast"));
  document.getElementById("toggle-accessible")?.addEventListener("click", () => applyTheme("accessible"));
});
