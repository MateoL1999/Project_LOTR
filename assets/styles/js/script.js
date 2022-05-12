const nav = document.querySelector("nav");
const menu = document.querySelector('.menu');
const burger = document.querySelector('.burger');
console.log('kuruma')

let lastScroll = 0;

burger.addEventListener("click", () => {
    menu.classList.toggle("display");
});





// window.addEventListener("scroll", () => {
//     if (window.scrollY < lastScroll) {
//         nav.style.top = 0;
//     } else {
//         nav.style.top = "-60px";
//     }
//     lastScroll = window.scrollY;
// });
