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
        <tbody v-for="(item, index) in cart">
            <tr>
                <td>{{ item.product_name }}</td>
                <td>{{ item.size_name }}</td>
                <td>{{ item.quantity }} {{ item.unit_name  }}</td>
                <td>{{ item.discount_ft }}</td>
                <td>
                    <button class="btn btn-success m-1 fw-bold" @click="addItem(item.id)">+1</button>
                    <button class="btn btn-warning m-1 fw-bold" @click="removeItem(item.id)">-1</button>
                    <button class="btn btn-danger m-1 fw-bold" @click="deleteItem(item.id)">Törlés</button>
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
                cart.value = response.data.cart.carts;

                // Összár megjelenítése
                total.value = response.data.cart.total_ft;
                
            } catch (error) {
                console.log(error);
            }
        }

        // Hozzáadás a kosár elemhez
        const addItem = async(id) => {
            try {

                // Mezők értékeinek lekérdezése
                const data = {
                    id: id,
                }

                // Kérés küldése a szerver felé
                const response = await request('post', '/api/vue/cart/add', data);

                console.log(response);

            } catch (error) {
                console.log(error);
            }
        }

        // Elvétel a kosár elemből
        const removeItem = async(id) => {
            try {

                // Mezők értékeinek lekérdezése
                const data = {
                    id: id,
                }

                // Kérés küldése a szerver felé
                const response = await request('post', '/api/vue/cart/remove', data);

                console.log(response);

            } catch (error) {
                console.log(error);
            }
        }

        // Kosár elem törlése
        const deleteItem = async(id) => {
            try {

                // Mezők értékeinek lekérdezése
                const data = {
                    id: id,
                }

                // Kérés küldése a szerver felé
                const response = await request('post', '/api/vue/cart/delete', data);

                console.log(response);

            } catch (error) {
                console.log(error);
            }
        }

        // Visszatérés
        return {
            cart,
            total,
            getCart,
            addItem,
            removeItem,
            deleteItem
        }
    }
}
</script> 