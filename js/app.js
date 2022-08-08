const burger = document.querySelector(".burger");
const navMenu = document.querySelector(".nav-menu");
const brand = document.querySelector(".brand");

burger.addEventListener("click", () => {
    burger.classList.toggle("active");
    navMenu.classList.toggle("active");
});

brand.addEventListener("click", () => {
    burger.classList.remove("active");
    navMenu.classList.remove("active");
});

document.querySelectorAll(".nav-link").forEach(n =>
    n.addEventListener("click", () => {
        burger.classList.remove("active");
        navMenu.classList.remove("active");
    })
);
