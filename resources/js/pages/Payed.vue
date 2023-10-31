<template>
    <h1>Eddigi vásárlások</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Név</th>
                <th scope="col">Méret</th>
                <th scope="col">Mennyiség</th>
                <th scope="col">Tranzakció</th>
                <th scope="col">Egységár</th>
                <th scope="col">Művelet</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in payed">
                <td>{{ item.product_name }}</td>
                <td>{{ item.size_name }}</td>
                <td>{{ item.quantity }} {{ item.unit_name  }}</td>
                <td>{{ item.transaction_id }}</td>
                <td>{{ item.price_ft }}</td>
                <td>
                    <button class="btn btn-primary" @click="openProduct(item.product_id)">Megtekintés</button>
                </td>
            </tr>
        </tbody>
    </table>
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
        let payed = ref({});

        // Amikor betöltődött az oldal
        onMounted(() => {
            getPayed();
        });

        // Felhasználó adatainak lekérdezése
        const getPayed = async () => {
            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/payed');

                // Lista feltöltése a válaszból
                payed.value = response.data;  

            } catch (error) {
                console.log(error);
            }
        }

        // Termék oldal megnyitása
        const openProduct = async(id) => {
            router.push('/vue/product/'+id);
        }

        // Visszatérés
        return {
            payed,
            getPayed,
            openProduct
        }
    }
}
</script> 