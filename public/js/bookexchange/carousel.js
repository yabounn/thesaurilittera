// let deg = 0;

// function rotate() {
//     let item1 = document.getElementsByClassName('item')[0];
//     let item2 = document.getElementsByClassName('item')[1];
//     let item3 = document.getElementsByClassName('item')[2];
//     let item4 = document.getElementsByClassName('item')[3];
//     let item5 = document.getElementsByClassName('item')[4];
//     let item6 = document.getElementsByClassName('item')[5];
    
//     deg += 60;

//     // item1.style.transform = "rotateY(60deg) translateZ(346.4px)";
//     item1.style.transform = "rotateY("+deg+"deg) translateZ(346.4px)";
//     // item2.style.transform = "rotateY(120deg) translateZ(346.4px)";
//     item2.style.transform = "rotateY("+(deg+60)+"deg) translateZ(346.4px)";
//     // item3.style.transform = "rotateY(180deg) translateZ(346.4px)";
//     item3.style.transform = "rotateY("+(deg+120)+"deg) translateZ(346.4px)";
//     // item4.style.transform = "rotateY(240deg) translateZ(346.4px)";
//     item4.style.transform = "rotateY("+(deg+180)+"deg) translateZ(346.4px)";
//     // item5.style.transform = "rotateY(300deg) translateZ(346.4px)";
//     item5.style.transform = "rotateY("+(deg+240)+"deg) translateZ(346.4px)";
//     // item6.style.transform = "rotateY(360deg) translateZ(346.4px)";
//     item6.style.transform = "rotateY("+(deg+300)+"deg) translateZ(346.4px)";
// }

let items, length, deg, z, move = 0;

function rotate(direction) {
   move += direction;

   for(let i = 0; i < length; i++) {
    items[i].style.transform = "rotateY("+(deg*(i+move))+"deg) translateZ("+z+"px)";
   }
}

function load() {
    items = document.getElementsByClassName('item');
    length = items.length;

    // Calcul le nombre de degrés pour faire tourner chaques éléments
    deg = 360 / length;

    // Calcul de la translation z (trigo)
    z = (items[0].offsetWidth / 2) / Math.tan((deg / 2) * (Math.PI / 180));

    // Stylisation du carousel
    for(let i = 0; i < length; i++) {
        items[i].style.transform = "rotateY("+(deg*i)+"deg) translateZ("+z+"px)";
    }
}

window.addEventListener('load', load);