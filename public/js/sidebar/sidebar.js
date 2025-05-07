document.addEventListener("DOMContentLoaded", () => {
  const currentPath = window.location.pathname;
  const subLinks = document.querySelectorAll(".header__nav-sublink");
  const headerNavContainer = document.querySelector(".header__nav");
  let isExpanded = false;
  let initialScrollHeight = 0;
  let initialClientHeight = 0;

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
      if (!isExpanded) {
        submenu.classList.add("show");
        isExpanded = true;

        initialScrollHeight = headerNavContainer.scrollHeight;
        initialClientHeight = headerNavContainer.clientHeight;
      } else {
        submenu.classList.remove("show");
        isExpanded = false;
      }
      checkScrollBarVisibility(headerNavContainer);
    });
  });
});

function checkScrollBarVisibility(container) {
  if (container.scrollHeight > container.clientHeight) {
    container.style.width = "260px";
  } else {
    container.style.width = "250px";
  }
}
