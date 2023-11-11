<template>
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
</template>
<script>
// Exportálás
export default {

    // Attribútum definiálása
    props: ['notifications'],

    // Beállítás
    setup() {

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

        // Visszatérés
        return {
            postNotificationOne
        }
    }
}
</script>