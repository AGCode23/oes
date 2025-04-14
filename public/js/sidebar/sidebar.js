document.addEventListener("DOMContentLoaded", () => {
  const currentPath = window.location.pathname;
  const subLinks = document.querySelectorAll(".header__nav-sublink");

  subLinks.forEach((link) => {
    if (link.getAttribute("href") === currentPath) {
      link.classList.add("active");
      const submenu = link.closest(".header__submenu");
      if (submenu) submenu.classList.add("show");
    }
  });

  const mainLinks = document.querySelectorAll(
    ".header__nav-links:not(.header__nav-toggle)"
  );

  mainLinks.forEach((link) => {
    if (link.getAttribute("href") === currentPath) {
      link.classList.add("active");
    }
  });

  const toggles = document.querySelectorAll(".header__nav-toggle");

  toggles.forEach((button) => {
    const targetId = button.getAttribute("data-target");
    const submenu = document.getElementById(targetId);

    button.addEventListener("click", () => {
      submenu.classList.toggle("show");
    });
  });
});
