<template>
    <h1>Kosár tartalma</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Név</th>
                <th scope="col">Méret</th>
                <th scope="col">Mennyiség</th>
                <th scope="col">Egységár</th>
                <th scope="col">Művelet</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in cart">
                <td>{{ item.product_name }}</td>
                <td>{{ item.size_name }}</td>
                <td>{{ item.quantity }} {{ item.unit_name  }}</td>
                <td>{{ item.discount_ft }}</td>
                <td>
                    <button class="btn btn-success m-1 fw-bold" @click="changeItem(item.product_id, item.size_id, 1)">+1</button>
                    <button class="btn btn-warning m-1 fw-bold" @click="changeItem(item.product_id, item.size_id, -1)">-1</button>
                    <button class="btn btn-danger m-1 fw-bold" @click="changeItem(item.product_id, item.size_id, -1 * item.quantity)">Törlés</button>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="bg-dark text-light p-2 fw-bold">Összesen: {{  total }}</div>
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
        let cart = ref([]);
        let total = ref(null);

        // Amikor betöltődött az oldal
        onMounted(() => {
            getCart();
        });

        // Kosár tartalmának lekérdezése
        const getCart = async () => {
            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/vue/cart');

                // Lista feltöltése a válaszból
                cart.value = response.data.carts;

                // Összár megjelenítése
                total.value = response.data.total_ft;
                
            } catch (error) {
                console.log(error);
            }
        }

        // Kosár elem módosítása
        const changeItem = async(product_id, size_id, quantity) => {
            try {

                // Mezők értékeinek lekérdezése
                const data = {
                    product_id: product_id,
                    size_id: size_id,
                    quantity: quantity
                }

                // Kérés küldése a szerver felé
                const response = await request('post', '/api/vue/cart', data);

                // Ha minden rendben volt
                if (response.data.OK == 1) {

                    // Lista frissítése
                    getCart();
                }

            } catch (error) {
                console.log(error);
            }
        }

        // Visszatérés
        return {
            cart,
            total,
            getCart,
            changeItem
        }
    }
}
</script> 