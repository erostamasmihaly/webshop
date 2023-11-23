// Importálás
import { request } from '../../../helper_vue'
import { ref } from 'vue'

// Definiálás
let list = ref({});
let unfiltered = ref(null);
let filtered = [];

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

    // Ha nem a megadott nemek vannak megadva, akkor szűrés
    if (value.gender_id!=11) {
        show = false;
    }

    // Visszatérés azzal, hogy meg kell-e jeleníteni a terméket
    return show;
}

// Szűrt lista megjelenítése
const showList = () => {

    // Szűrés elvégzése
    filtered = unfiltered.data.filter(filterList);
    console.log(filtered);

    // Adatok megjelenítése
    list.value = filtered;
}

// Exportálás
export {
    list,
    getList,
    showList
}