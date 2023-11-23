<template>
    <h1>Termékek listája</h1>
    <div class="bg-primary text-light p-2 fw-bold">Szűrés</div>
    <ListFilter/>
    <div class="bg-primary text-light p-2 fw-bold">Termékek</div>
    <div class="row gallery">
        <ListItem v-for="item in list" :item="item"/>
    </div>
</template>
<script>
// Importálás
import { list, getList, showList } from './components/List/list';
import { onMounted } from 'vue'
import ListItem from './components/List/ListItem.vue';
import ListFilter from './components/List/ListFilter.vue'

// Exportálás
export default {
    components: { 
        ListItem,
        ListFilter 
    },
    setup() {

        // Amikor betöltődött az oldal
        onMounted(async () => {
            await getList();
            showList();
        });

        return {
            getList,
            showList,
            list
        }
    }
}
</script>