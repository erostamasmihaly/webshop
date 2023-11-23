<template>
    <h1>Felhasználó</h1>
    <div>
        <button class="btn m-1" :class="(activeTab==0) ? 'btn-primary' : 'btn-secondary'" @click="showTab(0)">Adatok</button>
        <button class="btn m-1" :class="(activeTab==1) ? 'btn-primary' : 'btn-secondary'" @click="showTab(1)">Kosár</button>
        <button class="btn m-1" :class="(activeTab==2) ? 'btn-primary' : 'btn-secondary'" @click="showTab(2)">Vásárlások</button>
        <button class="btn m-1" :class="(activeTab==3) ? 'btn-primary' : 'btn-secondary'" @click="showTab(3)">Értesítések</button>
    </div>
    <div class="card-body">
        <div v-show="activeTab==0">
            <UserData />
        </div>
        <div v-show="activeTab==1">
            <UserCart />
        </div>
        <div v-show="activeTab==2">
            <UserPayed />
        </div>
        <div v-show="activeTab==3">
            <UserNotification />
        </div>
    </div>
</template>
<script>
// Importálás
import UserData from './components/User/UserData.vue'
import UserCart from './components/User/UserCart.vue'
import UserPayed from './components/User/UserPayed.vue'
import UserNotification from './components/User/UserNotification.vue'
import { ref, onMounted } from 'vue';

// Exportálás
export default {

    // Komponensek
    components: {
        UserData,
        UserCart,
        UserPayed,
        UserNotification
    },

    // Beállítás
    setup() {

        // Definiálás
        let activeTab = ref(0);
        let tabs = ref({});

        // Amikor betöltődött az oldal
        onMounted(() => {
            showTab(0);
        });

        // Megadott fül mutatása
        const showTab = (tab) => {

            // Megadott fül legyen aktív
            activeTab.value = tab;

        }

        // Visszatérés
        return {
            activeTab,
            showTab,
            tabs
        }
        
    }
}
</script>