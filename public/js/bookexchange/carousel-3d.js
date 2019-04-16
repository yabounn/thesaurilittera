let items, length, deg, z, move = 0;

function rotate(direction) {
   move += direction;

   for(let i = 0; i < length; i++) {
    items[i].style.transform = "rotateY("+(deg*(i+move))+"deg) translateZ("+z+"px)";
   }
}

function load() {
    items = document.getElementsByClassName('item-3d');
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