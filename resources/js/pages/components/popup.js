// Importálás
import { ref } from 'vue'

// Definiálás
let popup = ref({
    show: false,
    image: null
});

let popup_images = [];

let popup_index = 0;

// Felugró ablak megnyitása
const openPopup = (images, index) => {
    
    // Átvenni a megadott értékeket
    popup_index = index;
    popup_images = images;

    // Kép megjelenítése
    showImage();
};

// Felugró ablak bezárása
const closePopup = () => {
    popup.value = {};
};

// Előző kép
const prevImage = () => {

    // Lekérdezni az aktuális hosszat
    let length = popup_images.length-1;

    // A következő képhez tartozó indexet csökkenteni
    popup_index--;

    // Ha kisebb, mint 0, akkor a hossz legyen az index
    if (popup_index<0) {
        popup_index = length;
    }

    // Kép megjelenítése
    showImage();
}

// Következő kép
const nextImage = () => {

    // Lekérdezni az aktuális hosszat
    let length = popup_images.length-1;

    // A következő képhez tartozó index növelése
    popup_index++;

    // Ha nagyobb, mint a hossz, akkor a 0-s index legyen használva
    if (popup_index>length) {
        popup_index = 0;
    }

    // Kép megjelenítése
    showImage();
}

// Kép megjelenítése
const showImage = () => {

    // Lekérdezni az aktuális képek közül az aktuális indexűt
    let src = popup_images[popup_index].image;

    // Ezen kép és a popup ablak megjelenítése
    popup.value = { show: true, image: src };
}

// Exportálás
export {
    popup,
    openPopup,
    closePopup,
    prevImage,
    nextImage
}