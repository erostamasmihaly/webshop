<template>
    <h1>Termékek listája</h1>
    <div class="row gallery">
        <div v-for="item in list" class="col-sm-2 text-center" @click="openProduct(item.id)">
            <p class="fw-bold">{{ item.name }}</p>
            <img :src="item.image" class="img-thumbnail"/>
            <p>
                {{ item.discount_price }}<br>
                <button class="btn btn-primary">Megtekintés</button>
            </p>
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
        let list = ref({});
        let response = ref(null);

        // Amikor betöltődött az oldal
        onMounted(() => {
            getList();
        });

        // Termékek listájának lekérdezése
        const getList = async () => {

            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/vue/list');

                // Adatok lekérdezése és megjelenítése
                list.value = response.data;

            } catch (error) {
                console.log(error);
            }
        }

        // Termék oldal megnyitása
        const openProduct = async(id) => {
            router.push('/vue/product/'+id);
        }

        return {
            getList,
            openProduct,
            list
        }
    }
}
</script>