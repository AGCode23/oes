const headerHamburger = document.querySelector(".header__hamburger");
const headerOverlayHamburger = document.querySelector(
  ".header__overlay-hamburger"
);
const headerOverlay = document.querySelector(".header__overlay");
const headerOverlayHamburgerSvg = document.querySelector(
  ".header__overlay-hamburger svg"
);
const headerHamburgerSvg = document.querySelector(".header__hamburger svg");
const body = document.querySelector("body");

headerHamburger.addEventListener("click", handleHamburger);

headerOverlayHamburger.addEventListener("click", handleHamburger);

function handleHamburger() {
  headerOverlay.classList.toggle("active");
  headerHamburger.classList.toggle("active");
  headerOverlayHamburger.classList.toggle("active");
  headerHamburgerSvg.classList.toggle("active");
  headerOverlayHamburgerSvg.classList.toggle("active");
  body.classList.toggle("no-scroll");
}
