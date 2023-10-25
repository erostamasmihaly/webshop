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
        <tbody v-for="(item, index) in payed">
            <tr>
                <td>{{ item.product_name }}</td>
                <td>{{ item.size_name }}</td>
                <td>{{ item.quantity }} {{ item.unit_name  }}</td>
                <td>{{ item.transaction_id }}</td>
                <td>{{ item.price_ft }}</td>
                <td>
                    <a href="" class="btn btn-primary">Megtekintés</a>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
// Importálás
import {request} from '../helper'
import {ref, onMounted} from 'vue'

// Exportálás
export default {
    setup() {

        // Elemekre történő hivatkozások megadása
        let response = ref(null);
        let payed = ref([]);

        // Amikor betöltődött az oldal
        onMounted(() => {
            getPayed();
        });

        // Felhasználó adatainak lekérdezése
        const getPayed = async () => {
            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/vue/payed');

                // Lista feltöltése a válaszból
                payed.value = response.data.payed;
                

            } catch (error) {
                console.log(error);
            }
        }

        // Visszatérés
        return {
            payed,
            getPayed
        }
    }
}
</script> 