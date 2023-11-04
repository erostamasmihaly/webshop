<template>
    <h1>Termékek listája</h1>
    <div class="row gallery">
        <ListItem v-for="item in list" :item="item"/>
    </div>
</template>
<script>
// Importálás
import {request} from '../helper_vue'
import {ref, onMounted} from 'vue'
import ListItem from './ListItem.vue';

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
                response = await request('get', '/api/list');

                // Adatok lekérdezése és megjelenítése
                list.value = response.data;

            } catch (error) {
                console.log(error);
            }
        }

        return {
            getList,
            list
        }
    },
    components: { ListItem }
}
</script>