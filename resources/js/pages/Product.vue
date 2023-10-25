<template>
    <h1>{{ name }}</h1>
    <div class="row">
        <div class="col-sm-8">
            <div class="fw-bold">{{ summary }}</div>
            <div><span v-html="body"></span></div>
        </div>
        <div class="col-sm-4">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Méret</th>
                        <th scope="col">Mennyiség</th>
                        <th scope="col">Egységár</th>
                    </tr>
                </thead>
                <tbody v-for="(item, index) in prices">
                    <tr>
                        <td>{{ item.size.name }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
// Importálás
import {request} from '../helper'
import {ref, onMounted} from 'vue'
import router from '../route'

// Exportálás
export default {
    setup() {

        // Elemekre történő hivatkozások megadása
        let response = ref(null);
        let name = ref(null);
        let summary = ref(null);
        let body = ref(null);
        let prices = ref([]);

        // Amikor betöltődött az oldal
        onMounted(() => {
            getProduct();
        });

        // Termék adatainak lekérdezése
        const getProduct = async () => {

            let id = router.currentRoute.value.params.id;

            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/vue/product/'+id);

                // Adatok lekérdezése és megjelenítése
                name.value = response.data.product.name;
                summary.value = response.data.product.summary;
                body.value = response.data.product.body;
                prices.value = response.data.product.prices;

                // Lista feltöltése a válaszból
                //payed.value = response.data.payed;   

            } catch (error) {
                console.log(error);
            }
        }

        return {
            getProduct,
            name,
            summary,
            body,
            prices
        }
    }
}
</script>