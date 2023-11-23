// Importálás
import { request } from '../../../helper_vue'
import { ref } from 'vue'

// Definiálás
let list = ref({});
let unfiltered = ref(null);
let filtered = [];
let selected = {
    shop: 0,
    size: 0,
    gender: 0,
    age: 0
};

// Termékek listájának lekérdezése
const getList = async () => {

    try {
        // GET kérés küldése a szervernek
        unfiltered = await request('get', '/api/list');

    } catch (error) {
        console.log(error);
    }
}

// Termékek listájának szűrése
const filterList = (value) => {

    // Alapesetben mutassa a terméket 
    let show = true;

    // Ha nem a megadott nem van megadva, akkor szűrés
    if ((selected.gender!=0) && (selected.gender!=value.gender_id)) {
        show = false;
    }

    // Ha nem a megadott méret van megadva, akkor szűrés
    if ((selected.size!=0) && (!value.sizes.includes(selected.size))) {
        show = false;
    }

    // Ha nem a megadott korosztály van megadva, akkor szűrés
    if ((selected.age!=0) && (selected.age!=value.age_id)) {
        show = false;
    }

    // Ha nem a megadott bolt van megadva, akkor szűrés
    if ((selected.shop!=0) && (selected.shop!=value.shop_id)) {
        show = false;
    }

    // Visszatérés azzal, hogy meg kell-e jeleníteni a terméket
    return show;
}

// Szűrt lista megjelenítése
const showList = () => {

    // Szűrés elvégzése
    filtered = unfiltered.data.filter(filterList);

    // Adatok megjelenítése
    list.value = filtered;
}

// Exportálás
export {
    list,
    selected,
    getList,
    showList
}