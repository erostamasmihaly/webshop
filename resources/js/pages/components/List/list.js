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
const filterList = (value, index, arr) => {
    if (value.gender_id!=11) {
        return false;
    }
    return true;
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