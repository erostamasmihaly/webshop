<template>
    <h1>VUE.JS által készített alkalmazások</h1>
    <div class="row">
        <div class="col-sm-3" v-for="(item, index) in list" @click="openPage(index)">
            <button class="btn btn-primary w-100 m-1">{{ item }}</button>
        </div>
    </div>
</template>
<script>
// Importálás
import {ref} from 'vue'
import router from '../route'

// Exportálás
export default {
    setup() {

        // Menüpontok definiálása
        let list = ref({
            "list": "Termékek listája",
            "user": "Felhasználó adatai",
            "payed": "Eddigi vásárlások",
            "cart": "Kosár tartalma",
            "notification": "Értesítések",
        });

        // Termék oldal megnyitása
        const openPage = async(page) => {
            router.push('/vue/'+page);
        }

        return {
            openPage,
            list
        }
    }
}
</script>