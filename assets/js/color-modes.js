(() => {
  "use strict";

  const getStoredTheme = () => localStorage.getItem("theme");
  const setStoredTheme = (theme) => localStorage.setItem("theme", theme);

  const getPreferredTheme = () => {
    const storedTheme = getStoredTheme();
    if (storedTheme) {
      return storedTheme;
    }
    return window.matchMedia("(prefers-color-scheme: dark)").matches
      ? "dark"
      : "light";
  };

  const setTheme = (theme) => {
    if (
      theme === "auto" &&
      window.matchMedia("(prefers-color-scheme: dark)").matches
    ) {
      document.documentElement.setAttribute("data-bs-theme", "dark");
      setLogo("dark");
    } else {
      document.documentElement.setAttribute("data-bs-theme", theme);
      setLogo(theme);
    }
  };

  const setLogo = (theme) => {
    fetch("/api/logo.php")
      .then((response) => response.json())
      .then((data) => {
        const logos = data;
        const logoSrc = logos.find((logo) => logo.tema === theme)?.src;
        const logoElement = document.getElementById("logo");
        if (logoSrc) {
          logoElement.src = logoSrc;
          logoElement.style.display = "block";
        } else {
          logoElement.style.display = "none";
        }
      });
  };

  setTheme(getPreferredTheme());

  window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", () => {
      const storedTheme = getStoredTheme();
      if (storedTheme !== "light" && storedTheme !== "dark") {
        setTheme(getPreferredTheme());
      }
    });

  window.addEventListener("DOMContentLoaded", () => {
    setLogo(getPreferredTheme());
    document.querySelectorAll("[data-bs-theme-value]").forEach((toggle) => {
      toggle.addEventListener("click", () => {
        const theme = toggle.getAttribute("data-bs-theme-value");
        setStoredTheme(theme);
        setTheme(theme);
      });
    });
  });
})();
