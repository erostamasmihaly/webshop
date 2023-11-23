<template>
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
// Exportálás
export default {
    
    // Változó definiálása
    props: ['notifications']

}
</script>