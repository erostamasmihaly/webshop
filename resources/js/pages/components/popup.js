// Importálás
import { ref } from 'vue'

// Definiálás
let popup = ref({
    show: false,
    image: null
});

// Felugró ablak megnyitása
const openPopup = async (images, index) => {
    let src = images[index].image;
    popup.value = { show: true, image: src };
};

// Felugró ablak bezárása
const closePopup = async () => {
    popup.value = {};
};

// Exportálás
export {
    popup,
    openPopup,
    closePopup
}