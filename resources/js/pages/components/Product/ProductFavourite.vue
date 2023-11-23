<template>
    <div class="bg-primary text-light p-2 fw-bold">Kedvelés</div>
    <div>
        Eddigi kedvelések száma: {{  favourite.number }} db
        <span class="float-end">
            <div v-if="favourite.state==0" @click="postFavourite(1)">
                <i class="fa-regular fa-thumbs-up"></i>
            </div>
            <div v-else @click="postFavourite(0)">
                <i class="fa-solid fa-thumbs-up"></i>
            </div>
        </span>
    </div>
</template>
<script>
// Importálás
import { request } from "../../../helper_vue";
import { ref, onMounted } from 'vue'
import router from '../../../route'

// Exportálás
export default {

    // Beállítás
    setup() {

        // Definiálás
        let favourite = ref({
            number: 0,
            state: 1
        });

        let product_id = router.currentRoute.value.params.id;

        // Amikor betöltődött az oldal
        onMounted(() => {
            getFavourite();
        });

        // Kedvelés lekérdezése
        const getFavourite = async () => {
            try {
                
                // GET kérés küldése a szervernek
                const response = await request('get', '/api/favourite/'+product_id);

                // Eredmény megjelenítése
                favourite.value = response.data;


            } catch (error) {
                console.log(error);
            }
        }

        // Kedvelés átküldése
        const postFavourite = async (state) => {
            try {

                // Termék azonosító felvitele
                let data = {
                    product_id: product_id,
                    state: state
                }

                // GET kérés küldése a szervernek
                const response = await request('post', '/api/favourite', data);

                // Ha minden rendben volt
                if (response.data.OK == 1) {

                    // Frissítés
                    getFavourite();
                }

            } catch (error) {
                console.log(error);
            }

        }

        // Visszatérés
        return {
            postFavourite,
            favourite
        }
    }
}
</script>