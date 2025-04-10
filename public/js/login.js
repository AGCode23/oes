const loginFormContainer = document.getElementById("login__form-container");
const loginImageContainer = document.getElementById("login__image-container");
const loginLoginForm = document.getElementById("login__login-form");
const loginRegisterForm = document.getElementById("login__register-form");

function toggleForm() {
  loginFormContainer.classList.toggle("shift-right");
  loginImageContainer.classList.toggle("shift-left");

  if (loginLoginForm.style.display === "none") {
    loginLoginForm.style.display = "flex";
    loginFormContainer.style.flex = 1.5;
    loginRegisterForm.style.display = "none";
    loginImageContainer.style.flex = 2;
  } else {
    loginLoginForm.style.display = "none";
    loginFormContainer.style.flex = 2;
    loginRegisterForm.style.display = "flex";
  }
}
