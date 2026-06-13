document.addEventListener("DOMContentLoaded", () => {
  const colorModeBtn = document.getElementById("dark-mode");
  const moon = colorModeBtn.querySelector(".fa-moon");
  const sun = colorModeBtn.querySelector(".fa-sun");

  function setTheme(isDark) {
    document.documentElement.classList.toggle("dark", isDark);
    localStorage.theme = isDark ? "dark" : "light";
    moon.style.display = isDark ? "none" : "";
    sun.style.display = isDark ? "" : "none";
  }

  const isDark = localStorage.theme === "dark";
  setTheme(isDark);

  colorModeBtn.addEventListener("click", () => {
    const isDark = document.documentElement.classList.contains("dark");
    setTheme(!isDark);
  });
});
