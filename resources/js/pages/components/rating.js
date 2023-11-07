// Importálás
import { request } from "../../helper_vue";
import { ref } from 'vue'
import router from '../../route'

// Definiálás
let response = ref(null);

let ratings = ref({
    items: {},
    total: null,
    stars: null,
    images: null
});


// Értékelések lekérdezése
const getRating = async () => {
    
    try {
        // GET kérés küldése a szervernek
        response = await request('get', '/api/rating/' + router.currentRoute.value.params.id);

        // Adatok lekérdezése és megjelenítése
        ratings.value = response.data;

    }
    catch (error) {
        console.log(error);
    }
}



// Exportálás
export {
    ratings,
    getRating
}