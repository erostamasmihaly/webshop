<template>
    <div class="row p-2">
        <div class="col-sm-2">
            Bolt
            <select class="form-control">
                <option>Összes</option>
                <option :value="item.id" v-for="item in filters.shops">{{ item.name }}</option>
            </select>
        </div>
        <div class="col-sm-2">
            Méret
            <select class="form-control">
                <option>Összes</option>
                <option :value="item.id" v-for="item in filters.sizes">{{ item.name }}</option>
            </select>
        </div>
        <div class="col-sm-2">
            Nem
            <select class="form-control">
                <option>Összes</option>
                <option :value="item.id" v-for="item in filters.genders">{{ item.name }}</option>
            </select>
        </div>
        <div class="col-sm-2">
            Korosztály
            <select class="form-control">
                <option>Összes</option>
                <option :value="item.id" v-for="item in filters.ages">{{ item.name }}</option>
            </select>
        </div>
    </div>
</template>
<script>
// Importálás
import { request } from '../../../helper_vue'
import { ref, onMounted } from 'vue'

// Exportálás
export default {

    // Beállítás
    setup() {

        // Definiálás
        let response = ref(null);
        let filters = ref({
            shops: {},
            ages: {},
            gender: {},
            sizes: {}
        });

        // Amikor betöltődött az oldal
        onMounted(() => {
            getCategories();
        });

        // Termékek listájának lekérdezése
        const getCategories = async () => {

            try {
                
                // GET kérés küldése a szervernek
                response = await request('get', '/api/categories');

                // Szűrők megjelenítése
                filters.value = response.data;

            } catch (error) {
                console.log(error);
            }
        }

        // Visszatérés
        return {
            filters
        }
    }

}
</script>