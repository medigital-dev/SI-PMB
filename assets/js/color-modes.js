/*!
 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
 * Copyright 2011-2023 The Bootstrap Authors
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 */

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
    let activeTheme;
    if (theme === "auto") {
      const currentTheme = window.matchMedia("(prefers-color-scheme: dark)")
        .matches
        ? "dark"
        : "light";
      document.documentElement.setAttribute("data-bs-theme", currentTheme);
      activeTheme = currentTheme;
    } else {
      document.documentElement.setAttribute("data-bs-theme", theme);
      activeTheme = theme;
    }
    setLogo(activeTheme);
  };

  const setLogo = (theme) => {
    fetch("/api/logo.php")
      .then((response) => response.json())
      .then((data) => {
        const logos = data;
        const logoSrc = logos.find((logo) => logo.type === theme)?.src;
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

  const showActiveTheme = (theme, focus = false) => {
    const themeSwitcher = document.querySelector("#bd-theme");
    if (!themeSwitcher) return;

    const themeSwitcherText = document.querySelector("#bd-theme-text");
    const activeThemeIcon = document.querySelector(".theme-icon-active use");
    const btnToActive = document.querySelector(
      `[data-bs-theme-value="${theme}"]`
    );
    const svgOfActiveBtn = btnToActive
      .querySelector("svg use")
      .getAttribute("href");

    // Hapus class "active" dari semua tombol tema
    document.querySelectorAll("[data-bs-theme-value]").forEach((element) => {
      element.classList.remove("active");
      element.setAttribute("aria-pressed", "false");
    });

    // Tambahkan class "active" ke tombol tema yang dipilih
    btnToActive.classList.add("active");
    btnToActive.setAttribute("aria-pressed", "true");

    // Ubah ikon tema utama di tombol dropdown
    activeThemeIcon.setAttribute("href", svgOfActiveBtn);

    // Perbarui label toggle
    const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`;
    themeSwitcher.setAttribute("aria-label", themeSwitcherLabel);

    // Menampilkan checkmark di tema aktif
    document.querySelectorAll(".dropdown-item svg.ms-auto").forEach((icon) => {
      icon.classList.add("d-none");
    });
    btnToActive.querySelector("svg.ms-auto").classList.remove("d-none");

    if (focus) themeSwitcher.focus();
  };

  window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", () => {
      const storedTheme = getStoredTheme();
      if (storedTheme !== "light" && storedTheme !== "dark") {
        setTheme(getPreferredTheme());
      }
    });

  window.addEventListener("DOMContentLoaded", () => {
    showActiveTheme(getPreferredTheme());

    document.querySelectorAll("[data-bs-theme-value]").forEach((toggle) => {
      toggle.addEventListener("click", () => {
        const theme = toggle.getAttribute("data-bs-theme-value");
        setStoredTheme(theme);
        setTheme(theme);
        showActiveTheme(theme, true);
      });
    });
  });
})();
