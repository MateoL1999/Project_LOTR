const nav = document.querySelector("nav");
const menu = document.querySelector('.menu');
const burger = document.querySelector('.burger');
const titre = document.querySelector('.Card--Image');
const detail = document.querySelector('.Detail--card');


let lastScroll = 0;

burger.addEventListener("click", () => {
    menu.classList.toggle("display");
});


//////////////////////////Slider//////////////////////////

let imgSlider = document.getElementsByClassName("img--slider")
let etape = 0;
let nbrImage = imgSlider.length;
let precedent = document.querySelector('.precedent');
let suivant = document.querySelector('.suivant');

function enleverActiveImages() {
    for (i = 0; i < nbrImage; i++) {
        imgSlider[i].classList.remove('active');
    }

}

if(suivant) {
    suivant.addEventListener('click', function () {
        etape++;
        if (etape >= nbrImage) {
            etape = 0;
        }
        enleverActiveImages();
        imgSlider[etape].classList.add('active');
    })
}

if(precedent) {
    precedent.addEventListener('click', function () {
        etape--;
        if (etape < 0) {
            etape = nbrImage - 1;
        }
        enleverActiveImages();
        imgSlider[etape].classList.add('active');
    })
}

if(precedent) {
    setInterval(function () {
        etape++;
        if (etape >= nbrImage) {
            etape = 0;
        }
        enleverActiveImages();
        imgSlider[etape].classList.add('active');
    }, 3000)
}


titre.addEventListener("mouseover", () => {
    console.log('oui');
    detail.classList.toggle("display--card");
});
// window.addEventListener("scroll", () => {
//     if (window.scrollY < lastScroll) {
//         nav.style.top = 0;
//     } else {
//         nav.style.top = "-60px";
//     }
//     lastScroll = window.scrollY;
// });