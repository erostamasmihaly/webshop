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
const getImages = async (id) => {
            
    try {
        // GET kérés küldése a szervernek
        response = await request('get', '/api/rating/' + id + '/images');
                
        // Adatok lekérdezése és megjelenítése
        return response.data;
    }
    catch (error) {
        return null;
    }
}

// Értékelések lekérdezése
const getRating = async () => {
    
    try {
        // GET kérés küldése a szervernek
        response = await request('get', '/api/rating/' + router.currentRoute.value.params.id);

        // Végigmenni minden egyes értékelésen és betölteni a hozzá kapcsolódó képeket
        [...response.data.items].forEach(element => {
            getImages(element.id);
        });

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
    getRating,
    getImages
}