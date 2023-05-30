const menuHamburger = document.querySelector(".menu-hamburger");
const navLinks = document.querySelector(".nav-links");

menuHamburger.addEventListener('click', () => {
    navLinks.classList.toggle('mobile-menu');
    document.body.classList.toggle('no-scroll');
    window.scrollTo(0, 0);
});