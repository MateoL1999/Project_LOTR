
const menu = document.querySelector('.menu');
const burger = document.querySelector('.burger');
const box = document.querySelectorAll('.container--title');
const boxV2 = document.querySelectorAll('.conteneur--details');


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


box.forEach(boxElement => {
    boxElement.addEventListener("mouseenter", () => {
       boxElement.childNodes.forEach(elementChild =>{     // Pour chaque enfant de la boite
           if(elementChild.tagName === 'DIV') {                      // Vérifier que c'est une div
               elementChild.classList.toggle("display--card");  // si oui, toggle la classe
           }
       })
    });
    boxElement.addEventListener("mouseleave", () => {
        boxElement.childNodes.forEach(elementChild =>{
            if(elementChild.tagName === 'DIV') {
                elementChild.classList.toggle("display--card");
            }
        })
    });


})

boxV2.forEach(boxElementV2 => {
    boxElementV2.addEventListener("mouseenter", () => {
        boxElementV2.childNodes.forEach(elementChild =>{     // Pour chaque enfant de la boite
            if(elementChild.tagName === 'DIV') {                      // Vérifier que c'est une div
                elementChild.classList.toggle("display--card");  // si oui, toggle la classe
            }
        })
    });
    boxElementV2.addEventListener("mouseleave", () => {
        boxElementV2.childNodes.forEach(elementChild =>{
            if(elementChild.tagName === 'DIV') {
                elementChild.classList.toggle("display--card");
            }
        })
    });

})
