const burger = document.querySelector(".hamburger");
const nav = document.querySelector("nav ul");
const body = document.querySelector("body");

burger.addEventListener("click", function () {
  burger.classList.toggle("transform");
  nav.classList.toggle("slide");
  body.classList.toggle("black");
});
