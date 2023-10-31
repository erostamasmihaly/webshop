<template>
    <h1>Értesítések ({{ notifications.total }} db)</h1>
    <div class="bg-primary text-light p-2 fw-bold">
        Új értesítések ({{ notifications.unread.total }} db)
        <button v-if="notifications.unread.items.length > 0" class=" btn btn-primary" @click="postNotificationAll()">Összes olvasottnak jelölése</button>
    </div>
    <div v-if="notifications.unread.items.length == 0" class="alert alert-warning mt-2" role="alert">
        Még nincsenek új értesítések!
    </div>  
    <table class="table table-hover" v-else>
        <thead>
            <tr>
                <th scope="col">Termék</th>
                <th scope="col">Üzenet</th>
                <th scope="col">Létrehozva</th>
                <th scope="col">Művelet</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in notifications.unread.items">
                <td>{{ item.data.product_name }}</td>
                <td>{{ item.data.subject }}</td>
                <td>{{ item.created_formatted }}</td>
                <td>
                    <button type="button" class="btn btn-primary" @click="postNotificationOne(item.id)">Olvasottnak jelöl</button>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="bg-primary text-light p-2 fw-bold">Olvasott értesítések ({{ notifications.read.total }} db)</div>
    <div v-if="notifications.read.items.length == 0" class="alert alert-warning mt-2" role="alert">
        Még nincsenek olvasott értesítések!
    </div>   
    <table class="table table-hover" v-else>
        <thead>
            <tr>
                <th scope="col">Termék</th>
                <th scope="col">Üzenet</th>
                <th scope="col">Létrehozva</th>
                <th scope="col">Olvasva</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in notifications.read.items">
                <td>{{ item.data.product_name }}</td>
                <td>{{ item.data.subject }}</td>
                <td>{{ item.created_formatted }}</td>
                <td>{{ item.read_formatted }}</td>
            </tr>
        </tbody>
    </table>
</template>
<script>
// Importálás
import {request} from '../helper_vue'
import {ref, onMounted} from 'vue'
import router from '../route'

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

            } catch (error) {
                console.log(error);
            }
        }

        // Olvasottnak jelölés - Egy megadott
        const postNotificationOne = async (id) => {
            
            // Adat lekérdezése
            const data = {
                id: id
            }
            
            try {
                // GET kérés küldése a szervernek
                response = await request('post', '/api/notification/one', data);

                // Ha minden rendben volt
                if (response.data.OK == 1) {

                    // Értesítések újratöltése
                    getNotification();
                }

            } catch (error) {
                console.log(error);
            }
        }

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

            } catch (error) {
                console.log(error);
            }
        }

        return {
            getNotification,
            postNotificationOne,
            postNotificationAll,
            notifications
        }
    }
}
</script>