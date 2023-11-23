<template>
    <h1>Értesítések ({{ notifications.total }} db)</h1>
    <NotificationUnread :notifications="notifications" />
    <NotificationRead :notifications="notifications" />
</template>
<script>
// Importálás
import {request} from '../helper_vue'
import {ref, onMounted} from 'vue'
import NotificationUnread from './components/Notification/NotificationUnread.vue';
import NotificationRead from './components/Notification/NotificationRead.vue';

// Exportálás
export default {
    setup() {
        let notifications = ref({
            total: 0,
            unread: {
                items: {},
                total: 0
            },
            read: {
                items: {},
                total: 0
            }
        });
        let response = ref(null);
        // Amikor betöltődött az oldal
        onMounted(() => {
            getNotification();
        });
        // Értesítések lekérdezése
        const getNotification = async () => {
            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/notification');
                // Adatok lekérdezése és megjelenítése
                notifications.value = response.data;
            }
            catch (error) {
                console.log(error);
            }
        };
        // Olvasottnak jelölés - Összes
        const postNotificationAll = async () => {
            try {
                // GET kérés küldése a szervernek
                response = await request('post', '/api/notification/all');
                // Ha minden rendben volt
                if (response.data.OK == 1) {
                    // Értesítések újratöltése
                    getNotification();
                }
            }
            catch (error) {
                console.log(error);
            }
        };
        return {
            getNotification,
            postNotificationAll,
            notifications
        };
    },
    components: { NotificationUnread, NotificationRead }
}
</script>