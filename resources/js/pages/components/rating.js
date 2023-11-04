import { request } from "../../helper_vue";
import { ref } from 'vue'
import router from '../../route'

let response = ref(null);

let ratings = ref({
    items: {},
    total: null,
    stars: null
});

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

export {
    ratings,
    getRating
}